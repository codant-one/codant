<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Models\Tenant\Province as TenantProvince;

use App\Models\Province;
use App\Models\Country;
use App\Models\State;

use Carbon\Carbon;
use Validator;

class ProvinceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Province::with(['country']);

            foreach ($request->input('order') as $order) {
                $query->orderBy($order['column_name'], $order['dir']);
            }

            foreach ($request->input('columns') as $key => $column) {
                if (!$request->filled("columns.$key.search.value")) continue;

                $column_name = $request->input("columns.$key.data");
                $search_value = $request->input("columns.$key.search.value");
                $date_columns = ['created_at'];

                if ($column_name == 'country.name') { 
                    $query->whereHas('country', function ($q) use ($search_value) {
                        $q->where('id', $search_value);
                    });
                } elseif ($column_name == 'state_label') { 
                    $query->whereHas('state', function ($query) use ($search_value) {
                        $query->where('id',$search_value);
                    });
                } elseif (!in_array($column_name, $date_columns)) {
                    $query->where($column_name, 'LIKE', "%$search_value%");
                } elseif (in_array($column_name, $date_columns)) {
                    $query->whereDate($column_name, Carbon::parse($search_value)->format('Y-m-d'));
                }
            }

            $data = ($request->length == -1) ? $query->paginate( $query->count() ) : $query->paginate($request->length);
            $data->append(['state_label']);

            return response()->json($data);
        }

        $countries = Country::forDropdown();  
        $countriesActives = Country::forDropdownByStates(['2']);
        $states = State::select(['id', 'name' ])
                       ->whereIn('id',['1','2'])
                       ->get()->pluck('name','id'); 

        return view('admin.cruds.provinces.index', compact('countries','countriesActives','states'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::forDropdown();  
        $countriesActives = Country::forDropdownByStates(['2']);
        $states = State::select(['id', 'name' ])
                       ->whereIn('id',['1','2'])
                       ->get()->pluck('name','id'); 

        return view('admin.cruds.provinces.create', compact('countries','countriesActives','states'));
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
            [ 'name'        =>  'unique:provinces,name' ],
            [ 'name.unique' =>  'El nombre coincide con el de otra provincia' ]
        ); 

        if($validate->fails()){
            return redirect()->route('admin.provinces.index')->with([
                'feedback' => [
                    'type' => 'toastr',
                    'action' => 'error',
                    'message' => implode (', ', $validate->errors()->all())
                ]
            ]);
        } 

        $request = $this->prepareRequest($request);

        $province = new Province;
        $province->fill($request->all());
        $province->save();

        TenantProvince::createOrUpdateProvince($province);
        
        return redirect()->route('admin.provinces.index')->with([
            'feedback' => [
                'type' => 'toastr',
                'action' => 'success',
                'message' => 'Provincia creada exitosamente'
            ]
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Province  $province
     * @return \Illuminate\Http\Response
     */
    public function show(Province $province)
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
        $province = Province::with(['country'])->find($id);
        $countries = Country::forDropdownByStates(['2']); 
        $states = State::select(['id', 'name' ])
                       ->whereIn('id',['1','2'])
                       ->get()->pluck('name','id'); 

        if (!$province)
            return redirect()->route('admin.provinces.index')->with([
                'feedback' => [
                    'type' => 'toastr',
                    'action' => 'error',
                    'message' => 'No se encontró la provincia'
                ]
            ]);

        $province->state_id = ($province->state_id == 1) ? 0 : 1;

        return view('admin.cruds.provinces.edit', compact('province','countries','states'));
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
        $province = Province::find($id);

        $validate = Validator::make($request->all(),
            [ 'name'        =>  Rule::unique('provinces')->ignore($province->name, 'name') ],
            [ 'name.unique' =>  'El nombre coincide con el de otra provincia' ]
        ); 

        if($validate->fails()){
            return redirect()->route('admin.provinces.index')->with([
                'feedback' => [
                    'type' => 'toastr',
                    'action' => 'error',
                    'message' => implode (', ', $validate->errors()->all())
                ]
            ]);
        } 
        
        if (!$province){
            return redirect()->route('admin.provinces.index')->with([
                'feedback' => [
                    'type' => 'toastr',
                    'action' => 'error',
                    'message' => 'No se encontró la provincia'
                ]
            ]);
        }
        
        $request = $this->prepareRequest($request);
        $province->fill($request->all());
        $province->update();

        TenantProvince::createOrUpdateProvince($province);

        return redirect()->route('admin.provinces.index')->with([
            'feedback' => [
                'type' => 'toastr',
                'action' => 'success',
                'message' => 'Provincia actualizada exitosamente '
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
        $province = Province::find($id);
        
        if (!$province)
            return redirect()->route('admin.provinces.index')->with([
                'feedback' => [
                    'type' => 'toastr',
                    'action' => 'error',
                    'message' => 'No se encontró la provincia'
                ]
            ]);

        $province->delete();

        TenantProvince::deleteProvince($province);

        return redirect()->route('admin.provinces.index')->with([
            'feedback' => [
                'type' => 'toastr',
                'action' => 'warning',
                'message' => 'Provincia eliminada exitosamente'
            ]
        ]);
    }

    private function prepareRequest(Request $request)
    {
        $state_id = ($request->state == "on") ? 2 : 1;

        $request->request->add(['state_id' => $state_id]);
        $request->request->remove('state');

        return $request;
    }

    /**
     * Show provinces by countryId.
     *
     * @param  int  $id Country Id
     * @param Array $states Province States to Show. Defaul 2: Actives
     * @return \Illuminate\Http\Response
     */
    public function provincesByCountryId($id, $states=array('2'))
    {
        $provinces = Province::select(['id','name'])
                     ->where('country_id', $id)
                     ->whereIn('state_id',$states)
                     ->orderBy('name')
                     ->get()->pluck('name','id');
                       
        return response()->json($provinces, 200);
    }
}
