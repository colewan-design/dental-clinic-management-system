<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use App\Models\patient;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return DB::table('patients')->whereNull('deleted_at')->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
    
        try {
            // Insert a new record into the parents table
            $patients = new patient();
            columnSetter($patients, $request);
            $id = IdGenerator::generate(['table' => 'patients', 'field' => 'id', 'length' => 10, 'prefix' => 'P' . date('mdy')]);
            $patients -> id = $id;
            $patients->save();

            DB::commit(); // Commit the transaction
            return Redirect::back()->with('success', 'Patient added successfully. Name: ' . $request->input('name'));
        } catch (\Exception $e) {
            DB::rollback(); // Rollback the transaction if an error occurred
            throw $e;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        $patients = patient::find($id);
        $patients->update($req->all());
        return $patients;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $patient = Patient::find($id);
    
        if (!$patient) {
            return response()->json([
                'error' => 'Patient not found',
            ], 404);
        }
    
        $patient->delete();
    
        return response()->json([
            'message' => 'Patient deleted successfully',
        ]);
    }
    
    
}
