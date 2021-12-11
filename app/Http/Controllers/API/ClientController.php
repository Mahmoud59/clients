<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserClient;
use GuzzleHttp\Client;
use App\Http\Requests\CreateClientRequest;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = UserClient::all();
        return response()->json($clients, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateClientRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails())
        {
            return response()->json($request->validator->messages(),  400);
        }

        $client_request = new Client();
        $response = $client_request->request(
            'GET', 
            "https://maps.googleapis.com/maps/api/geocode/json?latlng=" . $request->latitude . "," . 
            $request->longitude . "&key=" . env('GOOGLE_MAP_API_KEY', ''));
        $request['address'] = json_decode($response->getBody())->results[0]->formatted_address;

        $client = UserClient::create($request->all());
        return response()->json($client, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $client = UserClient::findOrFail($id);
        return response()->json($client, 200);
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
        UserClient::where('id', $id)->update($request->all());
        $client = UserClient::findOrFail($id);
        return response()->json($client, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        UserClient::where('id', $id)->delete();
        return response()->json([], 204);
    }
}
