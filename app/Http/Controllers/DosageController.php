<?php

namespace App\Http\Controllers;

use App\Models\Dosage;
use App\Models\Med;
use App\Models\Taken;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DosageController extends Controller
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
        //
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
        $dosage = Dosage::find($id);
        if ($dosage->user_id != Auth::id()){
            abort(403);
        }
        /** @var Med $med */
        $med = Med::find($dosage->med_id);
        $med->setRelation('dosage', $dosage);
        return Inertia::render('Meds/CreateEdit', [
            'medication' => $med
        ]);
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
        $dosage = Dosage::find($id);
        if ($dosage->user_id != Auth::id()){
            abort(403);
        }
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
        return redirect()->to('dashboard');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dosage = Dosage::find($id);
        if ($dosage->user_id != Auth::id()){
            abort(403);
        }

        $dosage->delete();
        return redirect()->to(route('dashboard'));
    }



    public function takeDose($id){
        $dose = Dosage::find($id);
        if ($dose->user_id != Auth::id()){
            abort(403);
        }

        $take = new Taken();
        $take->taken_at = Carbon::now();
        $take->dosage_id = $dose->id;
        $take->save();
        return redirect()->back();
    }

    public function untakeDose($id){
        $taken = Taken::find($id);
        if ($taken == null){
            abort(404);
        }
        if ($taken->dosage->user_id != Auth::id()){
            abort(403);
        }

        $taken->delete();
        return redirect()->back();

    }
}
