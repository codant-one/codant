<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\Client;
use App\Models\Country;

use Carbon\Carbon;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Client::query();

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

            $clients = ($request->length == -1) ? $query->paginate( $query->count() ) : $query->paginate($request->length);

            return response()->json($clients, 200);
        }

        return view('cruds.clients.index');
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
        return view('cruds.clients.create', compact('countries', 'countriesDetails', 'countriesPhoneCodes'));
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
            if ($country) {
                $request->merge([
                    "phone" => '+' . $country->phonecode . $request->phone
                ]);
            }
        }

        $request->validate([
            'country_id' => 'required|exists:countries,id',
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email',
            'phone' => 'nullable|string|max:20',
            'document' => 'nullable|string|max:50',
            'year' => 'required|integer|min:1900|max:' . date('Y'),
            'company' => 'required|string|max:255',
            'url' => 'nullable|url|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $client = new Client;
        $client->fill($request->all());

        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('clients/avatars', 'public');
            $client->avatar = $avatarPath;
        }

        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('clients/logos', 'public');
            $client->logo = $logoPath;
        }

        $client->save();

        return redirect()->route('clients.index')->with([
            'feedback' => [
                'type' => 'toastr',
                'action' => 'success',
                'message' => 'Cliente creado exitosamente'
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
        $client = Client::find($id);
        $countries = Country::pluck('name', 'id');
        $countriesDetails = Country::select('id', 'phonecode', 'phone_digits')->get();
        $countriesPhoneCodes = Country::pluck('phonecode', 'id');
        
        if (!$client)
            return redirect()->route('clients.index')->with([
                'feedback' => [
                    'type' => 'toastr',
                    'action' => 'error',
                    'message' => 'No se encontró el cliente'
                ]
            ]);

        return view('cruds.clients.edit', compact('client', 'countries', 'countriesDetails', 'countriesPhoneCodes'));
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
        $client = Client::find($id);

        if (!$client)
            return redirect()->route('clients.index')->with([
                'feedback' => [
                    'type' => 'toastr',
                    'action' => 'error',
                    'message' => 'No se encontró el cliente'
                ]
            ]);

        if ($request->has("country_id")){
            $country = Country::find($request->country_id);
            if ($country) {
                $request->merge([
                    "phone" => '+' . $country->phonecode . $request->phone
                ]);
            }
        }

        $request->validate([
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email,'.$client->id,
            'phone' => 'nullable|string|max:20',
            'document' => 'nullable|string|max:50',
            'year' => 'nullable|integer',
            'company' => 'nullable|string|max:255',
        ]);

        $client->fill($request->all());

        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('clients/avatars', 'public');
            $client->avatar = $avatarPath;
        }

        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('clients/logos', 'public');
            $client->logo = $logoPath;
        }

        $client->save();
        
        return redirect()->route('clients.index')->with([
            'feedback' => [
                'type' => 'toastr',
                'action' => 'success',
                'message' => 'Cliente actualizado exitosamente'
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
        $client = Client::find($id);
        
        if (!$client)
            return redirect()->route('clients.index')->with([
                'feedback' => [
                    'type' => 'toastr',
                    'action' => 'error',
                    'message' => 'No se encontró el usuario'
                ]
            ]);

        $client->delete();

        return redirect()->route('clients.index')->with([
            'feedback' => [
                'type' => 'toastr',
                'action' => 'warning',
                'message' => 'Usuario eliminado'
            ]
        ]);
    }
}
