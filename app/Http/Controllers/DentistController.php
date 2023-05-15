<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use App\Models\dentist;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class DentistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return DB::table('dentists')->whereNull('deleted_at')->get();
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
            $dentists = new dentist();
            columnSetter($dentists, $request);
            $id = IdGenerator::generate(['table' => 'dentists', 'field' => 'id', 'length' => 10, 'prefix' => 'D' . date('mdy')]);
            $dentists -> id = $id;
            $dentists->save();

            DB::commit(); // Commit the transaction
            return Redirect::back()->with('success', 'Dentist added successfully. Name: ' . $request->input('name'));
        } catch (\Exception $e) {
            DB::rollback(); // Rollback the transaction if an error occurred
            throw $e;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\dentist  $dentist
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\dentist  $dentist
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
     * @param  \App\Models\dentist  $dentist
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        $dentists = dentist::find($id);
        $dentists->update($req->all());
        return $dentists;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\dentist  $dentist
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dentist = Dentist::find($id);
    
        if (!$dentist) {
            return response()->json([
                'error' => 'Dentist not found',
            ], 404);
        }
    
        $dentist->delete();
    
        return response()->json([
            'message' => 'Dentist deleted successfully',
        ]);
    }
    
    
}
