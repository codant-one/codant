<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\Permission; 

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Validator;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $query = Permission::query();

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


            foreach ($request->input('columns') as $key => $column) {
                if (!$request->filled("columns.$key.search.value")) continue;

                $column_name = $request->input("columns.$key.data");
                $search_value = $request->input("columns.$key.search.value");
                $date_columns = ['created_at'];

                if (in_array($column_name, $date_columns)) {
                    $query->whereDate($column_name, Carbon::parse($search_value)->format('Y-m-d'));
                } else {
                    $query->where($column_name, 'LIKE', "%$search_value%");
                }
            }  

             // Paginación
            $length = $request->input('length', 10);
            $permissions = ($length == -1) ? $query->paginate($query->count()) : $query->paginate($length);

            // Transformar los datos para agregar la columna actions
            $permissions->getCollection()->transform(function ($permission ) {
                // No necesitamos generar HTML aquí, solo indicar que la columna existe
                $permission->actions = null; // Se generará en el frontend
                return $permission;
            });

            return response()->json($permissions, 200);
        }

        return view('admin.cruds.permission.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.cruds.permission.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(),
            [ 'description'       =>  'required|unique:permissions,description'],
            [ 'description.required'  =>  'La descripción es requerida',
              'description.unique'    =>  'Ya existe esta descripción' ]
        ); 

        if($validate->fails()){
            return redirect()->route('permissions.index')->with([
                'feedback' => [
                    'type' => 'toastify',
                    'action' => 'error',
                    'message' => implode (', ', $validate->errors()->all())
                ]
            ]);
        } 
    
        $request = $this->prepareRequest($request);

        $permission = new Permission;
        $permission->fill($request->all());
        $permission->save();

        return redirect()->route('permissions.index')->with([
            'feedback' => [
                'type' => 'toastify',
                'action' => 'success',
                'message' => 'Permiso creado correctamente'
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

        $permission = Permission::findOrFail($id);

        if($permission->custom == 0){
            if($request->ajax()) {
                return response()->json([
                    'error' => 'No tiene permiso para esta acción.'
                ], 403);
            }
            
            return redirect()->route('permissions.index')->with([
                'feedback' => [
                    'type' => 'toastify',
                    'action' => 'error',
                    'message' => 'No tiene permiso para esta acción.'
                ]
            ]);
        }

        // Si es una petición AJAX, devolver JSON
        if($request->ajax()) {
            return response()->json($permission);
        }

        return view('admin.cruds.permission.edit', compact('permission'));
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
        $permission = Permission::find($id);

        if (!$permission) {
            if($request->ajax()) {
                return response()->json([
                    'error' => 'No se encontró el permiso'
                ], 404);
            }
            
            return redirect()->route('permissions.index')->with([
                'feedback' => [
                    'type' => 'toastify',
                    'action' => 'error',
                    'message' => 'No se encontró el permiso'
                ]
            ]);
        }

        $request = $this->prepareRequest($request);
        
        $permission->fill($request->all());
        $permission->update(); 

        if($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Permiso actualizado correctamente'
            ]);
        }

        return redirect()->route('permissions.index')->with([
            'feedback' => [
                'type' => 'toastify',
                'action' => 'success',
                'message' => 'Permiso actualizado correctamente'
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
        $permission = Permission::find($id);

        if($permission->custom == 0){
            if($request->ajax()) {
                return response()->json([
                    'error' => 'No tiene permiso para esta acción.'
                ], 403);
            }
            
            return redirect()->route('permissions.index')->with([
                'feedback' => [
                    'type' => 'toastify',
                    'action' => 'error',
                    'message' => 'No tiene permiso para esta acción.'
                ]
            ]);
        }

        $permission->delete();

        return redirect()->back()->with([
            'feedback' => [
                'type' => 'toastify',
                'action' => 'success',
                'message' => 'Permiso eliminado correctamente'
            ]
        ]);
    }

    public function prepareRequest(Request $request)
    {
        $name =  Str::lower(str_replace(' ', '_', $request->description));
     
        $request->request->add(['name' => $name]);
        $request->request->add(['guard_name' => 'web']);
        
        return $request;
    }
}
