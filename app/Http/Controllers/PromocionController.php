<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Promocion;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\View;
 

class PromocionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('promocion/Index', [
            'promociones' => Promocion::paginate(10), // 10 por página
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('promocion/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required',
            'descripcion' => 'required',
            'descuento' => 'required|numeric',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'activa' => 'required|boolean',
        ]);

        Promocion::create($validated);
        return redirect()->route('promociones.index')->with('success', 'Promoción creada.');
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

        $promocion = Promocion::findOrFail($id);
              return Inertia::render('promocion/Edit', [
               'promocion' => $promocion
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'descuento' => 'required|numeric|min:0|max:100',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'activa' => 'boolean'
        ]);
        $promocion = Promocion::findOrFail($id);
        $promocion->update($request->all());

        return redirect()->route('promociones.index')->with('success', 'Promoción actualizada.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $promocion = Promocion::findOrFail($id);
        $promocion->delete();

        return redirect()->route('promociones.index')->with('success', 'Promoción eliminada.');
    }

    public function exportarPDF()
    {
        $promociones = Promocion::all();

        // Asegúrate que este path coincida con la carpeta y nombre del archivo
        $pdf = Pdf::loadView('promocion.pdf', compact('promociones'));

        return $pdf->download('promociones.pdf');
    }

} 
