<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Promociones de Poleras</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }

        .oferta-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .oferta-card {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 16px;
            width: 300px;
            transition: transform 0.2s ease-in-out;
        }

        .oferta-card:hover {
            transform: scale(1.02);
        }

        .oferta-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 6px;
        }

        .oferta-card h3 {
            font-size: 18px;
            margin: 10px 0 6px;
            color: #222;
        }

        .oferta-card p {
            margin: 4px 0;
        }

        .descuento {
            color: #0a8754;
            font-weight: bold;
        }

        .descripcion {
            color: #555;
            font-size: 14px;
        }
    </style>
</head>
<body>

    <h1>Poleras en Promoción</h1>

    <div class="oferta-container">
        @foreach($ofertas as $oferta)
            <div class="oferta-card">
                <img src="{{ asset($oferta->imagen) }}" alt="{{ $oferta->nombre }}">
                <h3>{{ $oferta->nombre }}</h3>
                <p class="descuento">Descuento: {{ $oferta->descuento }}%</p>
                @if(!empty($oferta->descripcion))
                    <p class="descripcion">{{ $oferta->descripcion }}</p>
                @endif
            </div>
        @endforeach
    </div>

</body>
</html>
