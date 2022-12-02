<?php

namespace App\Http\Controllers;

use App\Models\Label;
use App\Http\Requests\LabelRequest;
use App\Http\Resources\LabelResource;
use Symfony\Component\HttpFoundation\Response;
use SebastianBergmann\CodeCoverage\ReportAlreadyFinalizedException;

class LabelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return LabelResource::collection(auth()->user()->labels);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\LabelRequest  $request
     * @return \App\Http\Resources\LabelResource
     */
    public function store(LabelRequest $request)
    {
        return new LabelResource(auth()->user()
            ->labels()
            ->create($request->validated()));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\LabelRequest  $request
     * @param  \App\Models\Label  $label
     * @return \App\Http\Resources\LabelResource
     */
    public function update(LabelRequest $request, Label $label)
    {
        $label->update($request->validated());
        return new LabelResource($label);
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
