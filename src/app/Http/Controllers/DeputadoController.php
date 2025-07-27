<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDeputadoRequest;
use App\Http\Requests\UpdateDeputadoRequest;
use App\Models\Deputado;

class DeputadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return 'deputados';
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDeputadoRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Deputado $deputado)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Deputado $deputado)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDeputadoRequest $request, Deputado $deputado)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Deputado $deputado)
    {
        //
    }
}
