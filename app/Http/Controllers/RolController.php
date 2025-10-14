<?php

namespace App\Http\Controllers;

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

            foreach ($request->input('order') as $order) {
                $query->orderBy($order['column_name'], $order['dir']);
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

            $data = ($request->length == -1) ? $query->paginate( $query->count() ) : $query->paginate($request->length);

            return response()->json($data);
        }

        return view('cruds.roles.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::select(['id', 'description'])->get();

        return view('cruds.roles.create', compact('permissions'));
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
                'type' => 'toastr',
                'action' => 'success',
                'message' => 'Rol creado Correctamente'
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
                    'type' => 'toastr',
                    'action' => 'warning',
                    'message' => 'Rol No Encontrado'
                ]
            ]);
        }

        $permissions = Permission::select(['id', 'description'])->get();

        $current_permissions = [];

        foreach ($rol->permissions as $permission) {
            $current_permissions[] = $permission->id;
        }

        return view('cruds.roles.edit', compact('rol', 'current_permissions', 'permissions'));
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
                'type' => 'toastr',
                'action' => 'success',
                'message' => 'Rol actualizado Correctamente'
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
                'type' => 'toastr',
                'action' => 'success',
                'message' => 'Rol eliminado Correctamente'
            ]
        ]);
    }

    private function prepareRequest(Request $request)
    {
        $request->request->remove('permissions');
        
        return $request;
    }
}
