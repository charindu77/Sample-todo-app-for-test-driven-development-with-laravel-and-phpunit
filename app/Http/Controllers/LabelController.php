<?php

namespace App\Http\Controllers;

use App\Models\Label;
use App\Http\Requests\LabelRequest;
use SebastianBergmann\CodeCoverage\ReportAlreadyFinalizedException;
use Symfony\Component\HttpFoundation\Response;

class LabelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return auth()->user()->labels;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\LabelRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LabelRequest $request)
    {
        return auth()->user()
            ->labels()
            ->create($request->validated());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\LabelRequest  $request
     * @param  \App\Models\Label  $label
     * @return \Illuminate\Http\Response
     */
    public function update(LabelRequest $request, Label $label)
    {
        $label->update($request->validated());
        return response($label);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Label  $label
     * @return \Illuminate\Http\Response
     */
    public function destroy(Label $label)
    {
        $label->delete();
        return response([],Response::HTTP_NO_CONTENT);
    }
}
