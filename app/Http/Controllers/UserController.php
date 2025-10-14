<?php

namespace App\Http\Controllers;

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

            foreach ($request->input('order') as $order) {
                $query->orderBy($order['column_name'], $order['dir']);
            }

            foreach ($request->input('columns') as $key => $column) {
                if (!$request->filled("columns.$key.search.value")) continue;

                $column_name = $request->input("columns.$key.data");
                $search_value = $request->input("columns.$key.search.value");
                $date_columns = ['created_at'];

                if ($column_name == 'roles') { 
                    $query->whereHas('roles', function ($q) use ($search_value) {
                        $q->where('id', $search_value);
                    });
                } elseif($column_name == 'is_2fa'){
                    ($search_value == 'Si') ? $query->where('is_2fa', 1) : $query->where('is_2fa', 0);
                } elseif (!in_array($column_name, $date_columns)) {
                    $query->where($column_name, 'LIKE', "%$search_value%");
                } elseif (in_array($column_name, $date_columns)) {
                    $query->whereDate($column_name, Carbon::parse($search_value)->format('Y-m-d'));
                }
            }

            $query->whereHas('roles', function ($q){
                $q->where('name','!=','SuperAdmin');
            });

            $users = ($request->length == -1) ? $query->paginate( $query->count() ) : $query->paginate($request->length);

            return response()->json($users, 200);
        }

        $roles = Role::select(['name', 'id'])->where('name', '!=', 'SuperAdmin')->pluck('name', 'id');

        return view('cruds.users.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     * 
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $roles_ = Role::where('name','!=','SuperAdmin')->get();
        $roles = Role::select(['name', 'id'])->where('name','!=','SuperAdmin')->pluck('name', 'id');

        return view('cruds.users.create', compact('roles','roles_'));
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
        $subject = 'Bienvenido a CODANT';

        $data = [
            'title' => 'Cuenta creada satisfactoriamente!!!',
            'user' => $user->firstname . ' ' . $user->lastname,
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
                'type' => 'toastr',
                'action' => 'success',
                'message' => 'Usuario creado exitosamente'
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
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::select('name', 'id')->where('name','!=','SuperAdmin')->get()->toArray();
        
        if (!$user)
            return redirect()->route('users.index')->with([
                'feedback' => [
                    'type' => 'toastr',
                    'action' => 'error',
                    'message' => 'No se encontró el usuario'
                ]
            ]);

        return view('cruds.users.edit', compact('user', 'roles'));
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

        if (!$user)
            return redirect()->route('users.index')->with([
                'feedback' => [
                    'type' => 'toastr',
                    'action' => 'error',
                    'message' => 'No se encontró el usuario'
                ]
            ]);

        $user->fill($request->all());
        $user->update();
        $user->roles()->detach();
        $user->assignRole($role->name);

        return redirect()->route('users.index')->with([
            'feedback' => [
                'type' => 'toastr',
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
    public function destroy($id)
    {
        $user = User::find($id);
        
        if (!$user)
            return redirect()->route('users.index')->with([
                'feedback' => [
                    'type' => 'toastr',
                    'action' => 'error',
                    'message' => 'No se encontró el usuario'
                ]
            ]);

        $user->delete();

        return redirect()->route('users.index')->with([
            'feedback' => [
                'type' => 'toastr',
                'action' => 'warning',
                'message' => 'Usuario eliminado'
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
