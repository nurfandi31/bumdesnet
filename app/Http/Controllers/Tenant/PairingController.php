<?php

namespace App\Http\Controllers\Tenant;

use App\Models\Tenant\Pairing;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PairingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Daftar Pemasangan Baru';
        return view('pairing.index')->with(compact('title'));
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Pairing $pairing)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pairing $pairing)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pairing $pairing)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pairing $pairing)
    {
        //
    }
}
