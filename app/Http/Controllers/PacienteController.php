<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;

class PacienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mascotas = Paciente::with('cliente')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return Inertia::render('paciente/Index', [
            'mascotas' => $mascotas
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clientes = User::select('id', 'nombre')->get();

        return Inertia::render('paciente/Create', [
            'clientes' => $clientes,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
            $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'especie' => 'required|string|max:100',
            'raza' => 'required|string|max:100',
            'edad' => 'required|integer|min:0',
            'sexo' => 'required|in:Macho,Hembra',
            'cliente_id' => 'required|exists:users,id',
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'especie.required' => 'La especie es obligatoria.',
            'raza.required' => 'La raza es obligatoria.',
            'edad.required' => 'La edad es obligatoria.',
            'sexo.required' => 'El sexo es obligatorio.',
            'cliente_id.required' => 'Debe seleccionar un cliente.',
        ]);

        Paciente::create($validated);

        return redirect()->route('mascotas.index')->with('success', 'Mascota registrada correctamente.');
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
        $mascota = Paciente::findOrFail($id);
        $clientes = User::select('id', 'nombre')->get();

        return Inertia::render('paciente/Edit', [
            'mascota' => $mascota,
            'clientes' => $clientes,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $mascota = Paciente::findOrFail($id);
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'especie' => 'required|string|max:100',
            'raza' => 'required|string|max:100',
            'edad' => 'required|integer|min:0',
            'sexo' => 'required|in:Macho,Hembra',
            'cliente_id' => 'required|exists:users,id',
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'especie.required' => 'La especie es obligatoria.',
            'raza.required' => 'La raza es obligatoria.',
            'edad.required' => 'La edad es obligatoria.',
            'sexo.required' => 'El sexo es obligatorio.',
            'cliente_id.required' => 'Debe seleccionar un cliente.',
        ]);

        $mascota->update($validated);

        return redirect()->route('mascotas.index')->with('success', 'Mascota actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $mascota = Paciente::findOrFail($id);
        $mascota->delete();

        return redirect()
            ->route('mascotas.index')
            ->with('success', 'Mascota eliminada correctamente.');
    }
}
