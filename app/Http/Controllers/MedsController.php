<?php

namespace App\Http\Controllers;

use App\Models\Dosage;
use App\Models\Med;
use App\Models\Taken;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class MedsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render("Meds/CreateEdit");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {


        $validated = $request->validate([
            'name' => ['required'],
            'dosage' => ['required'],
            'startDate' => ['bail', 'required', 'date'],
            'endDate' => [Rule::requiredIf(!$request->noEndDate), 'date'],
            'multiplier' => ['required', 'numeric'],
            'interval' => ['required', Rule::in(['daily', 'weekly', 'monthly'])],
            'dotw' => [Rule::requiredIf($request->interval === 'weekly')],
            'dotw.*' => ['min:0', 'max:6']
        ]);
        if (!$request->get('noEndDate')){
            $request->validate([
                'startDate' => 'before:endDate',
                'endDate' => 'after:startDate'
            ]);
        }
        DB::beginTransaction();
        $medication = Med::firstOrCreate(['name'=>$request->get('name')]);
        $dosage = new Dosage();
        $dosage->med_id = $medication->id;
        $dosage->user_id = Auth::id();
        $dosage->start = $request->get('startDate');
        if (!$request->get('noEndDate')){
            $dosage->end = $request->get('endDate');
        }
        $dosage->interval = $request->get('interval');
        if ($dosage->interval === 'weekly'){
            $dosage->dotw = implode($request->get('dotw'));
        }
        $dosage->multiplier = $request->get('multiplier');
        $dosage->amount = $request->get('dosage');
        $dosage->instructions = $request->get('instructions');
        $dosage->save();
        DB::commit();

        return redirect()->to('dashboard');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
