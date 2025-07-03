<?php

namespace App\Http\Controllers;

use App\Models\OrdenAnalisis;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Mascota;
use App\Models\Veterinaria;
use App\Models\Promocion;
use App\Models\Servicio;
use PhpParser\Node\Expr\Cast\String_;

class OrdenAnalisisController extends Controller
{
    /*-------------------------------------- INDEX -----------------------------------------------------*/
    public function index()
    {
        $ordenes = OrdenAnalisis::with(['mascota.cliente', 'promocion'])->orderBy('id', 'desc')->get();

        return Inertia::render('ordenanalisis/Index', [
            'ordenes' => $ordenes
        ]);
    }

    /*-------------------------------------- CREATE -----------------------------------------------------*/
    public function create()
    {
        return Inertia::render('ordenanalisis/Create', [
            'mascotas' => Mascota::with('cliente')->get(),
            'veterinarias' => Veterinaria::all(),
            'promociones' => Promocion::all(),
            'servicios' => Servicio::all()
        ]);
    }

    /*-------------------------------------- STORE -----------------------------------------------------*/
    public function store(Request $request)
    {
        $request->validate([
            'mascota_id' => 'required|exists:mascotas,id',
            'veterinaria_id' => 'required|exists:veterinarias,id',
            'observaciones' => 'nullable|string',
            'promocion_id' => 'nullable|exists:promociones,id',
            'servicios_seleccionados' => 'required|array|min:1',
        ]);

        $servicios = Servicio::whereIn('id', $request->servicios_seleccionados)->get();
        $subtotal = $servicios->sum('precio');

        $descuento = 0;
        if ($request->filled('promocion_id')) {
            $promo = Promocion::find($request->promocion_id);
            if ($promo) {
                $descuento = $promo->descuento;
            }
        }

        $total = $subtotal * (1 - $descuento / 100);

        $orden = OrdenAnalisis::create([
            'mascota_id' => $request->mascota_id,
            'veterinaria_id' => $request->veterinaria_id,
            'fecha_solicitud' => now(),
            'estado' => 'pendiente',
            'observaciones' => $request->observaciones,
            'promocion_id' => $request->promocion_id,
            'total' => round($total, 2)
        ]);

        $orden->servicios()->attach($servicios->pluck('id'));

        return redirect()->route('ordenesanalisis.index')->with('success', 'Orden registrada correctamente.');
    }
    /*-------------------------------------- EDIT -----------------------------------------------------*/
    public function edit(String $id)
    {
        $ordenanalisis = OrdenAnalisis::findOrFail($id);
        $ordenanalisis->load(['mascota.cliente', 'servicios', 'veterinaria', 'promocion']);

        return Inertia::render('ordenanalisis/Edit', [
            'orden' => $ordenanalisis,
            'mascotas' => Mascota::with('cliente')->get(),
            'veterinarias' => Veterinaria::all(),
            'promociones' => Promocion::all(),
            'servicios' => Servicio::all()
        ]);
    }

    /*-------------------------------------- UPDATE -----------------------------------------------------*/
    public function update(Request $request, String $id)
    {
        $ordenanalisis = OrdenAnalisis::findOrFail($id);

        $request->validate([
            'mascota_id' => 'required|exists:mascotas,id',
            'veterinaria_id' => 'required|exists:veterinarias,id',
            'estado' => 'required|string|max:100',
            'observaciones' => 'nullable|string',
            'promocion_id' => 'nullable|exists:promociones,id',
            'total' => 'required|numeric|min:0',
            'servicios_seleccionados' => 'required|array|min:1',
        ]);

        $ordenanalisis->update([
            'mascota_id' => $request->mascota_id,
            'veterinaria_id' => $request->veterinaria_id,
            'estado' => $request->estado,
            'observaciones' => $request->observaciones,
            'promocion_id' => $request->promocion_id,
            'total' => round($request->total, 2)
        ]);

        $ordenanalisis->servicios()->sync($request->servicios_seleccionados);

        return redirect()->route('ordenesanalisis.index')->with('success', 'Orden actualizada correctamente.');
    }

    /*-------------------------------------- DESTROY -----------------------------------------------------*/
    public function destroy(String $id)
    {
        $ordenanalisis = OrdenAnalisis::findOrFail($id);

        // Eliminar relaciones en la tabla pivot antes
        $ordenanalisis->servicios()->detach();

        // Luego eliminar la orden
        $ordenanalisis->delete();

        return redirect()->route('ordenesanalisis.index')->with('success', 'Orden eliminada.');
    }
}
