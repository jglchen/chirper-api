<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ChirpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        /*
        return ['chirps' => Chirp::with('user:id,name')->latest()->get(),
        ];*/
        return Chirp::with('user:id,name')->latest()->paginate(env('COUNT_PER_PAGE', 50));
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
    public function store(Request $request): Response
    {
        $validated = $request->validate([
            'message' => 'required|string|max:255',
        ]);
 
        $request->user()->chirps()->create($validated);
 
        return response()->noContent();
    }

    /**
     * Display the specified resource.
     */
    public function show(Chirp $chirp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chirp $chirp)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chirp $chirp)
    {
        $this->authorize('update', $chirp);
 
        $validated = $request->validate([
            'message' => 'required|string|max:255',
        ]);
 
        $chirp->update($validated);
 
        //return response()->noContent();
        return response()->json($chirp);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chirp $chirp): Response
    {
        $this->authorize('delete', $chirp);
 
        $chirp->delete();
 
        return response()->noContent();        
    }
}
