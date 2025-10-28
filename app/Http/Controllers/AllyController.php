<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Ally;
use App\Models\Country;

use Carbon\Carbon;

class AllyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Ally::query();

            foreach ($request->input('order') as $order) {
                $query->orderBy($order['column_name'], $order['dir']);
            }

            foreach ($request->input('columns') as $key => $column) {
                if (!$request->filled("columns.$key.search.value")) continue;

                $column_name = $request->input("columns.$key.data");
                $search_value = $request->input("columns.$key.search.value");
                $date_columns = ['created_at'];

                if (!in_array($column_name, $date_columns)) {
                    $query->where($column_name, 'LIKE', "%$search_value%");
                } elseif (in_array($column_name, $date_columns)) {
                    $query->whereDate($column_name, Carbon::parse($search_value)->format('Y-m-d'));
                }
            }

            $allies = ($request->length == -1) ? $query->paginate( $query->count() ) : $query->paginate($request->length);

            return response()->json($allies, 200);
        }

        return view('cruds.allies.index');
    }

    /**
     * Show the form for creating a new resource.
     * 
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $countries = Country::pluck('name', 'id');
        $countriesDetails = Country::select('id', 'phonecode', 'phone_digits')->get();
        $countriesPhoneCodes = Country::pluck('phonecode', 'id');
        return view('cruds.allies.create', compact('countries', 'countriesDetails', 'countriesPhoneCodes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->has("country_id")){
            $country = Country::find($request->country_id);
            if ($country && $request->filled("phone")) {
                $request->merge([
                    "phone" => '+' . $country->phonecode . $request->phone
                ]);
            }
        }

        $request->validate([
            'country_id' => 'required|exists:countries,id',
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|unique:allies,email',
            'phone' => 'nullable|string|max:20',
            'document' => 'nullable|string|max:50',
            'year' => 'required|integer|min:1900|max:' . date('Y'),
            'company' => 'required|string|max:255',
            'url' => 'nullable|url|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $ally = new Ally;
        $ally->fill($request->all());

        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('allies/avatars', 'public');
            $ally->avatar = $avatarPath;
        }

        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('allies/logos', 'public');
            $ally->logo = $logoPath;
        }

        $ally->save();

        return redirect()->route('allies.index')->with([
            'feedback' => [
                'type' => 'toastr',
                'action' => 'success',
                'message' => 'Aliado creado exitosamente'
            ]
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ally = Ally::find($id);
        $countries = Country::pluck('name', 'id');
        $countriesDetails = Country::select('id', 'phonecode', 'phone_digits')->get();
        $countriesPhoneCodes = Country::pluck('phonecode', 'id');
        
        if (!$ally)
            return redirect()->route('allies.index')->with([
                'feedback' => [
                    'type' => 'toastr',
                    'action' => 'error',
                    'message' => 'No se encontró el aliado'
                ]
            ]);

        return view('cruds.allies.edit', compact('ally', 'countries', 'countriesDetails', 'countriesPhoneCodes'));
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
        $ally = Ally::find($id);

        if (!$ally)
            return redirect()->route('allies.index')->with([
                'feedback' => [
                    'type' => 'toastr',
                    'action' => 'error',
                    'message' => 'No se encontró el aliado'
                ]
            ]);

        if ($request->has("country_id")){
            $country = Country::find($request->country_id);
            if ($country && $request->filled("phone")) {
                $request->merge([
                    "phone" => '+' . $country->phonecode . $request->phone
                ]);
            }
        }

        $request->validate([
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|unique:allies,email,'.$ally->id,
            'phone' => 'nullable|string|max:20',
            'document' => 'nullable|string|max:50',
            'year' => 'nullable|integer',
            'company' => 'nullable|string|max:255',
        ]);

        $ally->fill($request->all());

        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('allies/avatars', 'public');
            $ally->avatar = $avatarPath;
        }

        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('allies/logos', 'public');
            $ally->logo = $logoPath;
        }

        $ally->save();
        
        return redirect()->route('allies.index')->with([
            'feedback' => [
                'type' => 'toastr',
                'action' => 'success',
                'message' => 'Aliado actualizado exitosamente'
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
        $ally = Ally::find($id);
        
        if (!$ally)
            return redirect()->route('allies.index')->with([
                'feedback' => [
                    'type' => 'toastr',
                    'action' => 'error',
                    'message' => 'No se encontró el aliado'
                ]
            ]);

        $ally->delete();

        return redirect()->route('allies.index')->with([
            'feedback' => [
                'type' => 'toastr',
                'action' => 'warning',
                'message' => 'Aliado eliminado'
            ]
        ]);
    }
}
