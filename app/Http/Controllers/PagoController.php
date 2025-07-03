<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Pago;
use App\Models\OrdenAnalisis;
use App\Models\Visita; // Agrega esta línea arriba del archivo

class PagoController extends Controller
{
    /*-------------------------------------- INDEX -----------------------------------------------------*/
    public function index()
    {
        $visita = Visita::firstOrCreate(
            ['page' => 'pagos.index'],
            ['count' => 0]
        );
        $visita->increment('count');

        // 3. Enviar datos a la vista
        return Inertia::render('pago/Index', [
            'pagos' => Pago::with('orden.mascota.cliente')->latest()->paginate(10),
            'visitas' => $visita, 
        ]);
    }

    /*-------------------------------------- CREATE -----------------------------------------------------*/
    public function create()
    {
        $visita = Visita::firstOrCreate(
            ['page' => 'pagos.create'],
            ['count' => 0]
        );
        $visita->increment('count');

        // No pongas select si estás usando with() anidado.
        $ordenes = OrdenAnalisis::with('mascota.cliente')
            ->where('estado', 'pendiente')
            ->get(['id', 'mascota_id', 'total']);



        return Inertia::render('pago/Create', [
            'ordenes' => $ordenes,
            'visitas' => $visita, 
        ]);
    }

    /*-------------------------------------- STORE -----------------------------------------------------*/
    public function store(Request $request)
    {
        $validated = $request->validate([
            'orden_id' => 'required|exists:ordenesanalisis,id',
            'metodo_pago' => 'required|string|in:efectivo,transferencia',
        ]);

        $orden = OrdenAnalisis::findOrFail($validated['orden_id']);

        // Crear el pago
        Pago::create([
            'orden_id'    => $orden->id,
            'fecha_pago'  => now(),
            'monto'       => $orden->total,
            'metodo_pago' => $validated['metodo_pago'],
            'estado'      => 'completado',
        ]);

        // Cambiar estado de la orden
        $orden->update(['estado' => 'pagado']);

        return redirect()->route('pagos.index')->with('success', 'Pago registrado y orden actualizada.');
    }
    /*-------------------------------------- EDIT -----------------------------------------------------*/
    public function edit(string $id)
    {
        $pago = Pago::with('orden.mascota.cliente')->findOrFail($id);

        // Cargar órdenes pendientes + la orden actual del pago
        $ordenes = OrdenAnalisis::with('mascota.cliente')
            ->where(function ($query) use ($pago) {
                $query->where('estado', 'pendiente')
                    ->orWhere('id', $pago->orden_id); // Incluir la orden actual aunque ya no sea pendiente
            })
            ->get(['id', 'mascota_id', 'total']);

        return Inertia::render('pago/Edit', [
            'pago' => $pago,
            'ordenes' => $ordenes,
        ]);
    }

    /*-------------------------------------- UPDATE -----------------------------------------------------*/
    public function update(Request $request, string $id)
    {
        $pago = Pago::findOrFail($id);

        $validated = $request->validate([
            'metodo_pago' => 'required|string|in:efectivo,transferencia',
        ]);

        $pago->update([
            'metodo_pago' => $validated['metodo_pago'],
        ]);

        return redirect()->route('pagos.index')->with('success', 'Método de pago actualizado correctamente.');
    }

    /*-------------------------------------- DESTROY -----------------------------------------------------*/
    public function destroy(string $id)
    {
        $pago = Pago::findOrFail($id);

        // Cambiar estado de la orden a "pendiente"
        $orden = $pago->orden;
        if ($orden) {
            $orden->update(['estado' => 'pendiente']);
        }

        $pago->delete();

        return redirect()->route('pagos.index')->with('success', 'Pago eliminado y estado de la orden actualizado.');
    }
}
