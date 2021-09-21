<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateWarehouseRequest;
use App\Http\Resources\WarehouseResource;
use App\Models\Location;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $warehouses = Warehouse::all();
        return WarehouseResource::collection($warehouses);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateWarehouseRequest $request)
    {
        try {
            DB::beginTransaction();

            $location = new Location();
            $location->country = $request->input('country');
            $location->city = $request->input('city');
            $location->state = $request->input('state');
            $location->postal_code = $request->input('postal_code');
            $location->address = $request->input('address');

            $location->save();

            $warehouse = new Warehouse();
            $warehouse->name = $request->input('name');
            $warehouse->location_id = $location->id;

            $warehouse->save();

            DB::commit();

            return (new WarehouseResource($warehouse))->additional([
                'message' => 'Warehouse added Successfully'
            ]);

        } catch (\Throwable $e) {
            DB::rollBack();

            return response([
                'error' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Warehouse $warehouse)
    {
        return new WarehouseResource($warehouse);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Warehouse $warehouse)
    {
        $location = Location::find($warehouse->location_id);

        $location->update($request->only(
            'country',
            'city',
            'state',
            'postal_code',
            'address'
        ));

        $warehouse->update($request->only('name'));

        return (new WarehouseResource($warehouse))->additional([
            'message' => 'Warehouse updated Successfully'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Warehouse $warehouse)
    {
        $warehouse->delete();
        return (new WarehouseResource($warehouse))->additional([
            'message' => 'Warehouse removed Successfully'
        ]);
    }
}
