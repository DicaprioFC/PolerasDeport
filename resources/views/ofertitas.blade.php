<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Promociones de Juegos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f2f2f2;
            padding: 20px;
        }
        .grid {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }
        .card {
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            width: 300px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            position: relative;
        }
        .card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .card-content {
            padding: 15px;
        }
        .card h3 {
            margin: 0 0 10px;
        }
        .promocion-badge {
            position: absolute;
            bottom: 10px;
            right: 10px;
            background-color: #ff5722;
            color: white;
            padding: 5px 10px;
            font-weight: bold;
            border-radius: 5px;
        }
    </style>
</head>
<body>

    <h1>Juegos en Promoción</h1>

    <div class="grid">
        @foreach ($promociones as $promo)
            <div class="card">
                <img src="{{ $promo['portada_url'] }}" alt="Portada de {{ $promo['juego_nombre'] }}">
                <div class="card-content">
                    <h3>{{ $promo['juego_nombre'] }}</h3>
                    <p><strong>Promoción:</strong> {{ $promo['promocion_titulo'] }}</p>
                    <p><strong>Tipo:</strong> {{ $promo['promocion_tipo'] }}</p>
                    <p><strong>Inicio:</strong> {{ $promo['fecha_inicio'] }}</p>
                    <p><strong>Fin:</strong> {{ $promo['fecha_fin'] }}</p>
                </div>
                <div class="promocion-badge">
                    -{{ $promo['promocion_valor'] }}%
                </div>
            </div>
        @endforeach
    </div>

</body>
</html>