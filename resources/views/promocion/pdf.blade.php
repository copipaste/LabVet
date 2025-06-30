<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Promociones</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
        th { background-color: #f3f3f3; }
    </style>
</head>
<body>
    <h2>Listado de Promociones</h2>
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Descuento</th>
                <th>Inicio</th>
                <th>Fin</th>
                <th>Activa</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($promociones as $promo)
                <tr>
                    <td>{{ $promo->nombre }}</td>
                    <td>{{ $promo->descripcion }}</td>
                    <td>{{ $promo->descuento }}%</td>
                    <td>{{ $promo->fecha_inicio }}</td>
                    <td>{{ $promo->fecha_fin }}</td>
                    <td>{{ $promo->activa ? 'Sí' : 'No' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>

<script>
    console.log('PDF generado correctamente');
</script>
