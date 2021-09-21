<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSupplierRequest;
use App\Http\Resources\SupplierResource;
use App\Models\Person;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $suppliers = Supplier::all();
        return SupplierResource::collection($suppliers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateSupplierRequest $request)
    {
        try {
            DB::beginTransaction();

            $person = new Person();
            $person->first_name = $request->input('first_name');
            $person->middle_name = $request->input('middle_name');
            $person->last_name = $request->input('last_name');
            $person->phone_number = $request->input('phone_number');
            $person->birthday = $request->input('birthday');

            $person->save();

            $supplier = new Supplier();
            $supplier->company_name = $request->input('company_name');
            $supplier->phone_number = $request->input('phone_number_supplier');
            $supplier->person_id = $person->id;

            $supplier->save();

            DB::commit();

            return (new SupplierResource($supplier))->additional([
                'message' => 'Supplier added Successfully'
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
    public function show(Supplier $supplier)
    {
        return new SupplierResource($supplier);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Supplier $supplier)
    {
        $person = Person::find($supplier->person_id);

        $person->update($request->only(
            'first_name',
            'middle_name', 
            'last_name', 
            'phone_number', 
            'birthday'
        ));
        
        $supplier->update($request->only(
            'company_name',
            'phone_number'
        ));

        return (new SupplierResource($supplier))->additional([
            'message' => 'Supplier updated Successfully'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        return (new SupplierResource($supplier))->additional([
            'message' => 'Supplier removed Successfully'
        ]);
    }
}
