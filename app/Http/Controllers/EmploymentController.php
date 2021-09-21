<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateEmploymentRequest;
use App\Http\Resources\EmploymentResource;
use App\Models\Employment;
use App\Models\Person;
//Manejar el status code de la respuesta
//use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmploymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employments = Employment::all();
        return EmploymentResource::collection($employments);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateEmploymentRequest $request)
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

            $employment = new Employment();
            $employment->work_position = $request->input('work_position');
            $employment->job_title = $request->input('job_title');
            $employment->salary = $request->input('salary');
            $employment->person_id = $person->id;

            $employment->save();

            DB::commit();

            return (new EmploymentResource($employment))->additional([
                'message' => 'Employee added successfully'
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
    public function show(Employment $employment)
    {
        return new EmploymentResource($employment);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employment $employment)
    {
        $person = Person::find($employment->person_id);

        $person->update($request->only(
            'first_name',
            'middle_name', 
            'last_name', 
            'phone_number', 
            'birthday'
        ));
        
        $employment->update($request->only(
            'work_position',
            'job_title',
            'salary'
        ));

        return (new EmploymentResource($employment))->additional([
            'message' => 'Employee updated successfully'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employment $employment)
    {
        $employment->delete();
        return (new EmploymentResource($employment))->additional([
            'message' => 'Employee removed successfully'
        ]);
    }
}
