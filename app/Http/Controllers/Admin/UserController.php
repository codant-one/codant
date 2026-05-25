<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

use App\Models\Role;

use Carbon\Carbon;

use App\Models\User;
use App\Models\UserRegisterToken;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = User::with(['roles']);

            // Ordenamiento
            if ($request->has('order') && is_array($request->input('order'))) {
                foreach ($request->input('order') as $order) {
                    if (isset($order['column_name']) && isset($order['dir'])) {
                        $query->orderBy($order['column_name'], $order['dir']);
                    }
                }
            } else {
                // Orden por defecto
                $query->orderBy('id', 'desc');
            }

            // Filtros por columnas
            if ($request->has('columns') && is_array($request->input('columns'))) {
                foreach ($request->input('columns') as $key => $column) {
                    if (!$request->filled("columns.$key.search.value")) continue;

                    $column_name = $request->input("columns.$key.data");
                    $search_value = $request->input("columns.$key.search.value");
                    $date_columns = ['created_at'];

                    // Búsqueda global en firstname (que el frontend usa para búsqueda general)
                    if ($column_name == 'firstname' && !empty($search_value)) {
                        $query->where(function($q) use ($search_value) {
                            $q->where('id', 'LIKE', "%$search_value%")
                              ->orWhere('firstname', 'LIKE', "%$search_value%")
                              ->orWhere('secondname', 'LIKE', "%$search_value%")
                              ->orWhere('lastname', 'LIKE', "%$search_value%")
                              ->orWhere('secondsurname', 'LIKE', "%$search_value%")
                              ->orWhere('email', 'LIKE', "%$search_value%");
                        });
                    } elseif ($column_name == 'roles') { 
                        $query->whereHas('roles', function ($q) use ($search_value) {
                            $q->where('id', $search_value);
                        });
                    } elseif($column_name == 'is_2fa'){
                        ($search_value == 'Si') ? $query->where('is_2fa', 1) : $query->where('is_2fa', 0);
                    } elseif (!in_array($column_name, $date_columns) && $column_name != 'firstname') {
                        $query->where($column_name, 'LIKE', "%$search_value%");
                    } elseif (in_array($column_name, $date_columns)) {
                        $query->whereDate($column_name, Carbon::parse($search_value)->format('Y-m-d'));
                    }
                }
            }

            // Excluir SuperAdmin
            $query->whereHas('roles', function ($q){
                $q->where('name','!=','SuperAdmin');
            });

            // Paginación
            $length = $request->input('length', 10);
            $users = ($length == -1) ? $query->paginate($query->count()) : $query->paginate($length);

            // Transformar los datos para agregar la columna actions
            $users->getCollection()->transform(function ($user) {
                // No necesitamos generar HTML aquí, solo indicar que la columna existe
                $user->actions = null; // Se generará en el frontend
                return $user;
            });

            return response()->json($users, 200);
        }

        $roles = Role::select(['name', 'id'])->where('name', '!=', 'SuperAdmin')->pluck('name', 'id');
        $roles_ = Role::where('name', '!=', 'SuperAdmin')->get();

        return view('admin.cruds.users.index', compact('roles', 'roles_'));
    }

    /**
     * Show the form for creating a new resource.
     * 
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $role = Role::find($request->role);

        $password = Str::random(8);
        $request->merge(['password' => $password]);

        $request = $this->prepareRequest($request);

        $user = new User;
        $user->fill($request->all());
        $user->save();
        $user->assignRole($role->name);

        UserRegisterToken::updateOrCreate(
            ['user_id' => $user->id],
            ['token' => Str::random(60)]
        );

        $email = $user->email;
        $subject = 'Bienvenido a '.env('APP_NAME');

        $data = [
            'title' => 'Cuenta creada satisfactoriamente!!!',
            'user' => $user->name . ' ' . $user->last_name,
            'email'=> $email,
            'password' => $password
        ];

        try {
            \Mail::send(
                'emails.auth.client_created'
                , ['data' => $data , 'type' => 1, 'logo' => 1]
                , function ($message) use ($email, $subject) {
                    $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                    $message->to($email)->subject($subject);
            });

            $responseMail = 'Correo electrónico enviado al usuario satisfactoriamente.';
        } catch (\Exception $e) {
            $responseMail = 'No se pudo enviar el correo electrónico al usuario';

            Log::info($e);
        } 

        return redirect()->route('users.index')->with([
            'feedback' => [
                'type' => 'toastify',
                'action' => 'success',
                'message' => 'Usuario creado exitosamente. <br>' . $responseMail
            ]
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $user = User::with('roles')->find($id);
        $roles = Role::select('name', 'id')->where('name','!=','SuperAdmin')->get()->toArray();
        
        if (!$user) {
            if($request->ajax()) {
                return response()->json([
                    'error' => 'Usuario no encontrado'
                ], 404);
            }
            
            return redirect()->route('users.index')->with([
                'feedback' => [
                    'type' => 'toastify',
                    'action' => 'warning',
                    'message' => 'Usuario no encontrado'
                ]
            ]);
        }

        // Si es una petición AJAX, devolver JSON
        if($request->ajax()) {
            return response()->json([
                'user' => $user,
                'roles' => $roles
            ]);
        }

        return view('admin.cruds.users.edit', 
            compact(
                'user', 
                'roles'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $role = Role::find($request->role);

        if (!$user) {
            if($request->ajax()) {
                return response()->json([
                    'error' => 'Usuario no encontrado'
                ], 404);
            }
            
            return redirect()->route('users.index')->with([
                'feedback' => [
                    'type' => 'toastify',
                    'action' => 'warning',
                    'message' => 'Usuario no encontrado'
                ]
            ]);
        }

        $user->fill($request->all());
        $user->update();
        $user->roles()->detach();
        $user->assignRole($role->name);

        return redirect()->route('users.index')->with([
            'feedback' => [
                'type' => 'toastify',
                'action' => 'success',
                'message' => 'Usuario actualizado exitosamente'
            ]
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $user = User::withTrashed()->find($id);
        
        if (!$user) {
            if($request->ajax()) {
                return response()->json([
                    'error' => 'Usuario no encontrado'
                ], 404);
            }
            
            return redirect()->route('users.index')->with([
                'feedback' => [
                    'type' => 'toastify',
                    'action' => 'warning',
                    'message' => 'Usuario no encontrado'
                ]
            ]);
        }

        // Eliminar permanentemente de la base de datos
        $user->forceDelete();

        return redirect()->route('users.index')->with([
            'feedback' => [
                'type' => 'toastify',
                'action' => 'success',
                'message' => 'Usuario eliminado exitosamente'
            ]
        ]);
    }

    private function prepareRequest(Request $request)
    {
        $request->password_hash = Hash::make($request->password);
        $request->request->remove('password');
        $request->request->add(['password' => $request->password_hash]);
        $request->request->remove('password_hash');
        
        $request->merge([
            'email' => strtolower($request->email)
        ]);
        
        return $request;
    }
}
