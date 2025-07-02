<?php

namespace App\Http\Controllers;

use App\Models\Insumo;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Categoria;

class InsumoController extends Controller
{
    public function index()
    {
        $insumos = Insumo::with('categoria')->orderBy('id', 'desc')->get();

        return Inertia::render('Insumos/Index', [
            'insumos' => $insumos
        ]);
    }

    public function create()
    {
        $categorias = Categoria::all();

        return Inertia::render('Insumos/Create', [
            'categorias' => $categorias
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'cantidad_disponible' => 'required|integer|min:0',
            'unidad_medida' => 'required|string|max:50',
            'fecha_caducidad' => 'required|date',
            'tipo' => 'required|string|max:100',
            'categoria_id' => 'required|exists:categorias,id',
        ]);

        Insumo::create($request->all());

        return redirect()->route('insumos.index')->with('success', 'Insumo registrado exitosamente.');
    }

    public function show(Insumo $insumo)
    {
        //
    }

    public function edit(Insumo $insumo)
    {
        $categorias = Categoria::all();

        return Inertia::render('Insumos/Edit', [
            'insumo' => $insumo,
            'categorias' => $categorias
        ]);
    }

    public function update(Request $request, Insumo $insumo)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'cantidad_disponible' => 'required|integer|min:0',
            'unidad_medida' => 'required|string|max:50',
            'fecha_caducidad' => 'required|date',
            'tipo' => 'required|string|max:100',
            'categoria_id' => 'required|exists:categorias,id',
        ]);

        $insumo->update($request->all());

        return redirect()->route('insumos.index')->with('success', 'Insumo actualizado.');
    }

    public function destroy(Insumo $insumo)
    {
        $insumo->delete();

        return redirect()->route('insumos.index')->with('success', 'Insumo eliminado.');
    }
}
