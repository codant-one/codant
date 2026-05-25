<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Carbon\Carbon;

use App\Models\Role; 
use App\Models\Permission;

class RolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Role::query();

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

            // Filtros
            if ($request->has('columns') && is_array($request->input('columns'))) {
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
            }

            // Paginación
            $length = $request->input('length', 10);
            $roles = ($length == -1) ? $query->paginate($query->count()) : $query->paginate($length);

            // Transformar los datos para agregar la columna actions
            $roles->getCollection()->transform(function ($role) {
                // No necesitamos generar HTML aquí, solo indicar que la columna existe
                $role->actions = null; // Se generará en el frontend
                return $role;
            });

            return response()->json($roles, 200);
        }

        return view('admin.cruds.roles.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::select(['id', 'description'])->get();

        return view('admin.cruds.roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'permissions' => 'required|array|min:1',
        ], 
        [
            'permissions.required' => 'Debe seleccionar al menos un permiso.',
            'permissions.min' => 'Debe seleccionar al menos un permiso.',
        ]);

        $permissionIds = $request->input('permissions');

        $permissions = Permission::whereIn('id', $permissionIds)->pluck('name')->toArray();

        $request = $this->prepareRequest($request);

        $role = Role::create($request->all());
        $role->syncPermissions($permissions);

        return redirect()->route('roles.index')->with([
            'feedback' => [
                'type' => 'toastify',
                'action' => 'success',
                'message' => 'Rol creado correctamente'
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

        $rol = Role::findOrFail($id);

        if (!$rol) {
            return redirect()->route('admin.roles.index')->with([
                'feedback' => [
                    'type' => 'toastify',
                    'action' => 'warning',
                    'message' => 'Rol no encontrado'
                ]
            ]);
        }

        $permissions = Permission::select(['id', 'description'])->get();

        $current_permissions = [];

        foreach ($rol->permissions as $permission) {
            $current_permissions[] = $permission->id;
        }

        return view('admin.cruds.roles.edit', 
            compact(
                'rol', 
                'current_permissions', 
                'permissions'
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

        $request->validate([
            'permissions' => 'required|array|min:1',
        ], 
        [
            'permissions.required' => 'Debe seleccionar al menos un permiso.',
            'permissions.min' => 'Debe seleccionar al menos un permiso.',
        ]);

        $rol = Role::findOrFail($id);
        
        $permissionIds = $request->input('permissions');

        $permissions = Permission::whereIn('id', $permissionIds)->pluck('name')->toArray();

        $request = $this->prepareRequest($request);

        $rol->fill($request->all());
        $rol->syncPermissions($permissions);
        $rol->update();

        return redirect()->route('roles.index')->with([
            'feedback' => [
                'type' => 'toastify',
                'action' => 'success',
                'message' => 'Rol actualizado correctamente'
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
        $rol = Role::findOrFail($id);
        $rol->delete();

        return redirect()->back()->with([
            'feedback' => [
                'type' => 'toastify',
                'action' => 'success',
                'message' => 'Rol eliminado correctamente'
            ]
        ]);
    }

    private function prepareRequest(Request $request)
    {
        $request->request->remove('permissions');
        
        return $request;
    }
}
