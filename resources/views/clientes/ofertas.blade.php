<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="poleras.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <title>Ofertas De Ropa Deportiva</title>
</head>

<body>
    <div class="container">
        <header class="header">
            <div class="logo">
                <img src="imagenes/Mi marca de agua.jpeg" alt="Logo" />
            </div>
            <nav class="main-nav">
                <ul class="Nav-links responsive-links">
                    <li><a href="{{ route('dashboard') }}">INICIO</a></li>
                    <li><a href="{{ url('/productos') }}">PRODUCTOS</a></li>
                    <li><a href="como llegar.php">COMO LLEGAR</a></li>
                    <div class="carrito-icono">
                        <a href="{{ route('carrito.mostrar') }}">
                            <i class="fas fa-shopping-cart"></i>
                            <span class="contador-carrito">{{ session('carrito_cantidad', 0) }}</span>
                        </a>
                    </div>
                </ul>
            </nav>
        </header>

        <h1 class="titulo">Ofertas</h1>
        <div class="contenedor-productos">
            @foreach ($productos as $producto)
            <div class="producto">
                <div class="imagen-con-descuento" style="position: relative;">
                    <img src="{{ filter_var($producto->imagen, FILTER_VALIDATE_URL) ? $producto->imagen : asset($producto->imagen) }}" alt="Imagen del producto" />


                    @php
                    $descuento = $producto->descuento ?? 0;
                    $precioOriginal = $producto->precio / (1 - $descuento / 100);
                    @endphp
                    <span class="etiqueta-descuento" style="position: absolute; top: 10px; left: 10px; background: red; color: white; padding: 4px 8px; border-radius: 4px;">
                        -{{ number_format($descuento, 0) }}%
                    </span>
                </div>

                <h2>{{ $producto->nombre }}</h2>
                <p>
                    <span class="precio-anterior" style="text-decoration: line-through; color: gray;">
                        Bs {{ number_format($precioOriginal, 2) }}
                    </span>
                    <span class="precio-descuento" style="color: green; font-weight: bold; margin-left: 10px;">
                        Bs {{ number_format($producto->precio, 2) }}
                    </span>
                </p>
                <a href="{{ route('carrito.agregar', $producto->id) }}" class="btn-agregar-carrito">Agregar al carrito</a>
            </div>
            @endforeach
        </div>

        <footer>
            <div class="footer">
                <div class="conteiner">
                    <div class="footer-row">
                        <div class="footer-links">
                            <h3>Compañía</h3>
                            <ul>
                                <li><a href="">Nosotros</a></li>
                                <li><a href="">Nuestro servicio</a></li>
                                <li><a href="">Política de privacidad</a></li>
                            </ul>
                        </div>
                        <div class="footer-links">
                            <h3>Pedidos</h3>
                            <ul>
                                <li><a href="pedidos.php">Pedidos</a></li>
                                <li><a href="Productos.php">Productos</a></li>
                                <li><a href="#">Envíos</a></li>
                            </ul>
                        </div>
                        <div class="footer-links">
                            <h3>Tienda</h3>
                            <ul>
                                <li><a href="nikecliente.php">Poleras Nike</a></li>
                                <li><a href="marathoncliente.php">Poleras Marathon</a></li>
                                <li><a href="adidascliente.php">poleras Adidas</a></li>
                                <li><a href="otrasmarcas.php">Otras Marcas</a></li>
                            </ul>
                        </div>
                        <div class="footer-links">
                            <h3>Síguenos</h3>
                            <div class="social-link">
                                <a href="https://www.facebook.com/leonardofidel.aranaisita.9"><i class="fab fa-facebook-f"></i></a>
                                <a href="https://web.whatsapp.com/"><i class="fab fa-whatsapp"></i></a>
                                <a href="https://www.tiktok.com/@luis_criss_11?_t=8fUcL8VZY9t&_r=1"><i class="fab fa-tiktok"></i></a>
                                <a href="https://web.telegram.org/k/"><i class="fab fa-telegram"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="agua">
                    <img src="imagenes/Mi marca de agua.jpeg" alt="" />
                </div>
                <span class="copiright">&copy;Dicaprio 2025</span>
            </div>
        </footer>
    </div>
</body>

</html>