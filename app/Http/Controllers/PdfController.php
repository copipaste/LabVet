<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
// use PDF; // Asegúrate de tener la librería PDF instalada, como Dompdf
use Barryvdh\DomPDF\Facade\Pdf;
use Inertia\Inertia;
use App\Models\Paciente as Mascota; // Asumiendo que Paciente es el modelo de Mascota
use App\Models\Servicio;
use App\Models\Promocion;
use App\Models\Insumo;
use App\Models\Pago;


class PdfController extends Controller
{
    
    public function index()
    {
        return Inertia::render('reporte/Index');
    }


    public function generar(Request $request)
    {
        $entidad = $request->query('entidad');
        // $columnas = explode(',', $request->query('columnas'));
        $columnas = $request->query('columnas', []);

        

        $data = [];
        $titulo = ucfirst($entidad);

        switch ($entidad) {
            case 'usuarios':
                $data = User::with('roles')->get()->map(fn($user) =>
                    $this->mapRegistro($user, $columnas, function ($col, $user) {
                        return $col === 'rol' ? $user->roles->first()?->name ?? 'Sin rol' : $user->$col;
                    })
                );
            
                break;

            case 'mascotas':
                $data = Mascota::with('cliente')->get()->map(function ($mascota) use ($columnas) {
                    return collect($columnas)->mapWithKeys(function ($col) use ($mascota) {
                        return [$col => $col === 'cliente' ? ($mascota->cliente->nombre ?? 'Sin dueño') : $mascota->$col];
                    });
                });
                break;

            case 'servicios':
                $data = Servicio::all($columnas);
                break;

            case 'promociones':
                $data = Promocion::all($columnas);
                break;

            case 'insumos':
                $data = Insumo::with('categoria')->get()->map(function ($insumo) use ($columnas) {
                    return collect($columnas)->mapWithKeys(function ($col) use ($insumo) {
                        return [$col => $col === 'categoria' ? ($insumo->categoria->nombre ?? 'Sin categoría') : $insumo->$col];
                    });
                });
                break;

            case 'pagos':
                $data = Pago::with('orden.mascota.cliente')->get()->map(function ($pago) use ($columnas) {
                    return collect($columnas)->mapWithKeys(function ($col) use ($pago) {
                        if ($col === 'cliente') {
                            return [$col => optional($pago->orden->mascota->cliente)->nombre ?? 'No disponible'];
                        }
                        return [$col => $pago->$col];
                    });
                });
                break;

            default:
                abort(400, 'Entidad no válida');
        }

        $pdf = Pdf::loadView('reportes.reporte', [
            'titulo' => $titulo,
            'columnas' => $columnas,
            'registros' => $data
        ]);

        return $pdf->stream("Reporte-{$entidad}.pdf");
    }


    private function mapRegistro($item, $columnas, $customHandler = null)
    {
        $data = [];

        foreach ($columnas as $col) {
            if ($customHandler && is_callable($customHandler)) {
                $data[$col] = $customHandler($col, $item);
            } else {
                $data[$col] = $item->$col ?? '-';
            }
        }

        return $data;
    }





}
