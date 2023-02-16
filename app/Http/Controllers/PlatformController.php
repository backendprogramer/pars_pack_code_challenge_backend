<?php

namespace App\Http\Controllers;

use App\Models\platform;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PlatformController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(platform $platform): Response
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(platform $platform): Response
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, platform $platform): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(platform $platform): RedirectResponse
    {
        //
    }
}
