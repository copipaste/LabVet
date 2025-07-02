<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Servicio;
use Inertia\Inertia;

class ServicioController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $servicios = Servicio::orderBy('id', 'desc')->paginate(10);

        return Inertia::render('servicio/Index', [
            'servicios' => $servicios,
        ]);
    
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

            return Inertia::render('servicio/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
                'nombre' => 'required|string|max:255',
                'descripcion' => 'required|string',
                'tipo_muestra' => 'required|string|max:100',
                'precio' => 'required|numeric|min:0',
            ], [
                'nombre.required' => 'El nombre es obligatorio.',
                'descripcion.required' => 'La descripción es obligatoria.',
                'tipo_muestra.required' => 'El tipo de muestra es obligatorio.',
                'precio.required' => 'El precio es obligatorio.',
            ]);

            Servicio::create($validated);

            return redirect()->route('servicios.index')->with('success', 'Servicio registrado correctamente.');
    
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $servicio = Servicio::findOrFail($id);
        return Inertia::render('servicio/Edit', [
            'servicio' => $servicio,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'tipo_muestra' => 'nullable|string|max:255',
            'precio' => 'required|numeric|min:0',
        ]);

        $servicio = Servicio::findOrFail($id);
        $servicio->update($validated);

        return redirect()->route('servicios.index')->with('success', 'Servicio actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $servicio = Servicio::findOrFail($id);
        $servicio->delete();

        return redirect()->route('servicios.index')->with('success', 'Servicio eliminado correctamente.');
    }
}
