<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use App\Models\appointment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return DB::table('appointments')->whereNull('deleted_at')->get();
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
            $appointments = new appointment();
            columnSetter($appointments, $request);
            $id = IdGenerator::generate(['table' => 'appointments', 'field' => 'id', 'length' => 10, 'prefix' => 'A' . date('mdy')]);
            $appointments -> id = $id;
            $appointments->save();

            DB::commit(); // Commit the transaction
            return Redirect::back()->with('success', 'Appointment added successfully. Name: ');
        } catch (\Exception $e) {
            DB::rollback(); // Rollback the transaction if an error occurred
            throw $e;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\appointment  $appointment
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
     * @param  \App\Models\appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        $appointments = appointment::find($id);
        $appointments->update($req->all());
        return $appointments;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $appointment = appointment::find($id);
    
        if (!$appointment) {
            return response()->json([
                'error' => 'appointment not found',
            ], 404);
        }
    
        $appointment->delete();
    
        return response()->json([
            'message' => 'appointment deleted successfully',
        ]);
    }
    
    
}
