<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use App\Models\Servicio;
use App\Models\OrdenesAnalisis;
use App\Models\User;
use App\Models\Pago;
use Spatie\Permission\Models\Role;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class ReporteController extends Controller
{
    public function dashboard()
    {
        return Inertia::render('Dashboard', [
            'totalMascotas' => Paciente::count(),

            'serviciosMasUsados' => Servicio::select('nombre')
                ->join('ordenes_servicios', 'servicios.id', '=', 'ordenes_servicios.servicio_id')
                ->selectRaw('count(*) as total')
                ->groupBy('servicios.id', 'nombre')
                ->orderByDesc('total')
                ->take(5)
                ->get(),

            'ordenesPorMes' => OrdenesAnalisis::selectRaw("to_char(fecha_solicitud, 'YYYY-MM') as mes, count(*) as total")
                ->groupBy('mes')
                ->orderBy('mes')
                ->get(),

            'usuariosPorRol' => Role::withCount('users')->get()->pluck('users_count', 'name'),

            'pagosPorMes' => Pago::selectRaw("to_char(fecha_pago, 'YYYY-MM') as mes, sum(monto) as total")
                ->groupBy('mes')
                ->orderBy('mes')
                ->get(),
        ]);


    }
}
