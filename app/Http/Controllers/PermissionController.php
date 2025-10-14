<?php

namespace App\Http\Controllers;
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

        return view('cruds.permission.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cruds.permission.create');
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
                    'type' => 'toastr',
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
                'type' => 'toastr',
                'action' => 'success',
                'message' => 'Permiso creado Correctamente'
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

        $permission = Permission::findOrFail($id);

        if($permission->custom == 0){
            return redirect()->route('permissions.index')->with([
                'feedback' => [
                    'type' => 'toastr',
                    'action' => 'error',
                    'message' => 'No tiene permiso para esta acción.'
                ]
            ]);
        }

        return view('cruds.permission.edit', compact('permission'));
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

        if (!$permission)
            return redirect()->route('permissions.index')->with([
                'feedback' => [
                    'type' => 'toastr',
                    'action' => 'error',
                    'message' => 'No se encontró el permiso'
                ]
            ]);

        $request = $this->prepareRequest($request);
        
        $permission->fill($request->all());
        $permission->update(); 

        return redirect()->route('permissions.index')->with([
            'feedback' => [
                'type' => 'toastr',
                'action' => 'success',
                'message' => 'Permiso actualizado Correctamente'
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
        $permission = Permission::find($id);

        if($permission->custom == 0){
            return redirect()->route('permissions.index')->with([
                'feedback' => [
                    'type' => 'toastr',
                    'action' => 'error',
                    'message' => 'No tiene permiso para esta acción.'
                ]
            ]);
        }

        $permission->delete();

        return redirect()->back()->with([
            'feedback' => [
                'type' => 'toastr',
                'action' => 'success',
                'message' => 'Permiso eliminado Correctamente'
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
