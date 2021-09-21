<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCustomerRequest;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use App\Models\Person;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::all();
        return CustomerResource::collection($customers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCustomerRequest $request)
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

            $customer = new Customer();
            $customer->company_name = $request->input('company_name');
            $customer->job_title = $request->input('job_title');
            $customer->departament = $request->input('departament');
            $customer->limit_credit = $request->input('limit_credit');
            $customer->person_id = $person->id;

            $customer->save();

            DB::commit();

            return (new CustomerResource($customer))->additional([
                'message' => 'Customer added Successfully'
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
    public function show(Customer $customer)
    {
        return new CustomerResource($customer);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        $person = Person::find($customer->person_id);

        $person->update($request->only(
            'first_name',
            'middle_name', 
            'last_name', 
            'phone_number', 
            'birthday'
        ));
        
        $customer->update($request->only(
            'company_name',
            'job_title',
            'departament',
            'limit_credit'
        ));

        return (new CustomerResource($customer))->additional([
            'message' => 'Customer updated Successfully'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();
        return (new CustomerResource($customer))->additional([
            'message' => 'Customer removed Successfully'
        ]);
    }
}
