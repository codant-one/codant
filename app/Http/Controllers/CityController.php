<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Models\Tenant\City as TenantCity;

use App\Models\City;
use App\Models\Country;
use App\Models\State;
use App\Models\Province;

use Carbon\Carbon;
use Validator;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query =  City::with(['province.country']);

            foreach ($request->input('order') as $order) {
                $query->orderBy($order['column_name'], $order['dir']);
            }

            foreach ($request->input('columns') as $key => $column) {
                if (!$request->filled("columns.$key.search.value")) continue;

                $column_name = $request->input("columns.$key.data");
                $search_value = $request->input("columns.$key.search.value");
                $date_columns = ['created_at'];

                if ($column_name == 'province.name') { 
                    $query->whereHas('province', function ($q) use ($search_value) {
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

        $provinces = Province::forDropdown();  

        return view('admin.cruds.cities.index', compact('countries','countriesActives','states', 'provinces'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $provinces = Province::forDropdown();  
        $states = State::select(['id', 'name' ])
                       ->whereIn('id',['1','2'])
                       ->get()->pluck('name','id'); 

        return view('admin.cruds.cities.create', compact('states','provinces'));
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
            [ 'name'        =>  'unique:cities,name' ],
            [ 'name.unique' =>  'El Nombre coincide con el de otra Ciudad' ]
        ); 

        if($validate->fails()){
            return redirect()->route('admin.cities.index')->with([
                'feedback' => [
                    'type' => 'toastr',
                    'action' => 'error',
                    'message' => implode (', ', $validate->errors()->all())
                ]
            ]);
        } 
  
        $request = $this->prepareRequest($request);

        $city = new City;
        $city->fill($request->all());
        $city->save();

        TenantCity::createOrUpdateCity($city);

        return redirect()->route('admin.cities.index')->with([
            'feedback' => [
                'type' => 'toastr',
                'action' => 'success',
                'message' => 'Ciudad creada exitosamente'
            ]
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function show(City $city)
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
        $city = City::with(['province'])->find($id);
        $provinces = Province::forDropdown();  
        $states = State::select(['id', 'name' ])
                       ->whereIn('id',['1','2'])
                       ->get()->pluck('name','id'); 

        if (!$city)
            return redirect()->route('admin.cities.index')->with([
                'feedback' => [
                    'type' => 'toastr',
                    'action' => 'error',
                    'message' => 'No se encontró la ciudad'
                ]
            ]);

        $city->state_id = ($city->state_id == 1) ? 0 : 1;

        return view('admin.cruds.cities.edit', compact('city','provinces','states'));
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
        $city = City::find($id);

        $validate = Validator::make($request->all(),
            [ 'name'        =>  Rule::unique('cities')->ignore($city->name, 'name') ],
            [ 'name.unique' =>  'El Nombre coincide con el de otra Ciudad' ]
        ); 

        if($validate->fails()){
            return redirect()->route('admin.cities.index')->with([
                'feedback' => [
                    'type' => 'toastr',
                    'action' => 'error',
                    'message' => implode (', ', $validate->errors()->all())
                ]
            ]);
        } 
        
        if (!$city){
            return redirect()->route('admin.cities.index')->with([
                'feedback' => [
                    'type' => 'toastr',
                    'action' => 'error',
                    'message' => 'No se encontró la ciudad'
                ]
            ]);
        }
        
        $request = $this->prepareRequest($request);
        $city->fill($request->all());
        $city->update();

        TenantCity::createOrUpdateCity($city);

        return redirect()->route('admin.cities.index')->with([
            'feedback' => [
                'type' => 'toastr',
                'action' => 'success',
                'message' => 'Ciudad actualizada exitosamente '
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
        $city = City::find($id);
        
        if (!$city)
            return redirect()->route('admin.cities.index')->with([
                'feedback' => [
                    'type' => 'toastr',
                    'action' => 'error',
                    'message' => 'No se encontró la ciudad'
                ]
            ]);

        $city->delete();

        TenantCity::deleteCity($city);

        return redirect()->route('admin.cities.index')->with([
            'feedback' => [
                'type' => 'toastr',
                'action' => 'warning',
                'message' => 'Ciudad eliminada exitosamente'
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
     * Show cities by provinceId.
     *
     * @param  int  $id Province Id
     * @param Array $states Cities States to Show. Defaul 2: Actives
     * @return \Illuminate\Http\Response
     */
    public function citiesByProvinceId($id, $states=array('2'))
    {
        $cities = City::select(['id','name'])
                     ->where('province_id', $id)
                     ->whereIn('state_id',$states)
                     ->orderBy('name')
                     ->get()->pluck('name','id');
                       
        return response()->json($cities, 200);
    }
}
