<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilo.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"> 
    <title>inicio sin usuarios</title>

</head>

<body>

    <div class="container"> <!-- Contenedor principal de la página -->
    <header class="header"> <!-- Cabecera de la página -->
    <div class="logo">
        <img src="imagenes/Mi marca de agua.jpeg" alt=""> <!-- Imagen de logo -->
    </div>

    <nav class="main-nav"> <!-- Menú de navegación -->
        <ul class="Nav-links responsive-links">
            <li><a href="{{ url('/productos') }}">PRODUCTOS</a></li>
            <li><a href="pedidos.php">PEDIDOS</a></li>
            <li><a href="como llegar.php">COMO LLEGAR</a></li>
        </ul>

        @if (Route::has('login'))
        <div class="auth-links">
            @auth
                <a href="{{ url('/dashboard') }}">Dashboard</a>
            @else
                <a href="{{ route('login') }}">Log in</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}">Register</a>
                @endif
            @endauth
        </div>
        @endif
    </nav>
</header>

        <div class="objetos"> <!-- Contenedor de objetos -->
            <img src="imagenes/blommin.jpg" alt=""> <!-- Imagen -->
            <img src="imagenes/oriente.jpg" alt=""> <!-- Otra imagen -->
        </div>

        <div class="slider">
            <ul>
                <li><img src="imagenes/blommin.jpg" alt=""></li>
                <li><img src="imagenes/oriente.jpg"></li>
                <li><img src="imagenes/PUMA.png" alt=""></li>
                <li><img src="imagenes/NIKE.jpg" alt=""></li>
                <li><img src="imagenes/NIKEEEE.jpg" alt=""></li>
                <li><img src="imagenes/Bolivar.jpg" alt=""></li>
            </ul>
        </div>
    </div>

    <main> <!-- Contenido principal de la página -->
        <div class="columna"> <!-- Contenedor de la columna de productos -->

            <!-- Primer producto: Poleras sublimables -->
            <div class="producto">
                <a href="{{ url('/nikecliente') }}"> <!-- Enlace a la página de tazas -->
                    <h2>POLERAS NIKE</h2> <!-- Título del producto -->
                    <img src="imagenes/NIKE7.png" alt=""> <!-- Imagen del producto -->
                    <p><strong> OFERTAS</strong></p> <!-- Descripción del producto -->
                </a>
            </div>

            <!-- Segundo producto: Tazas sublimables -->
            <div class="producto">
                <a href="{{ url('/adidascliente') }}"> <!-- Enlace a la página de tazas -->
                    <h2>POLERAS ADIDAS</h2> <!-- Título del producto -->
                    <img src="imagenes/adidas1.png" alt=""> <!-- Imagen del producto -->
                    <p><strong>OFERTAS</strong></p> <!-- Descripción del producto -->
                </a>
            </div>

            <!-- Tercer producto: Rompecabezas sublimables -->
            <div class="producto">
                <a href="{{ url('/marathoncliente') }}"> <!-- Enlace a la página de tazas -->
                    <h2>POLERAS MARATHON</h2> <!-- Título del producto -->
                    <img src="imagenes/marathon.png" alt=""> <!-- Imagen del producto -->
                    <p><strong>OFERTAS</strong></p> <!-- Descripción del producto -->
                </a>
            </div>

            <!-- Cuarto producto: Llaveros sublimables -->
            <div class="producto">
                <a href="{{ url('/marcamaracli') }}"> <!-- Enlace a la página de tazas -->
                    <h2>MARCA MARATHON</h2> <!-- Título del producto -->
                    <img src="imagenes/marathon.logo.jpg" alt=""> <!-- Imagen del producto -->
                    <p><strong>OFERTAS</strong></p> <!-- Descripción del producto -->
                </a>
            </div>

            <!-- Quinto producto: Decorativos sublimables -->
            <div class="producto">
                <a href="{{ url('/marcanikecli') }}"> <!-- Enlace a la página de tazas -->
                    <h2>MARCA NIKE</h2> <!-- Título del producto -->
                    <img src="imagenes/logo nike.png" alt=""> <!-- Imagen del producto -->
                    <p><strong>OFERTAS</strong></p> <!-- Descripción del producto -->
                </a>
            </div>

            <!-- Sexto producto: Gorras sublimables -->
            <div class="producto">
                <a href="{{ url('/otrasmarcas') }}"> <!-- Enlace a la página de tazas -->
                    <h2>OTRAS MARCAS </h2> <!-- Título del producto -->
                    <img src="imagenes/marcas.jpg" alt=""> <!-- Imagen del producto -->
                    <p><strong>OFERTAS</strong></p> <!-- Descripción del producto -->
                </a>
            </div>

            <!-- (Puedes seguir repitiendo esta estructura para más productos si es necesario) -->
        </div>
    </main>
    <!-- Crea una sección de botones de redes sociales con enlaces a diferentes sitios web -->

    <footer>
        <div class="footer"> <!-- Contenedor del pie de página -->
            <div class="conteiner"> <!-- Contenedor del pie de página -->
                <div class="footer-row"> <!-- Fila de enlaces en el pie de página -->

                    <!-- Enlaces de la Compañía -->
                    <div class="footer-links">
                        <h3>Compañía</h3>
                        <ul>
                            <li><a href="">Nosotros</a></li> <!-- Enlace a "nosotros.html" -->
                            <li><a href="">Nuestro servicio</a></li> <!-- Enlace a "servicio.html" -->
                            <li><a href="">Política de privacidad</a></li> <!-- Enlace a "compañia.html" -->
                        </ul>
                    </div>

                    <!-- Enlaces de Pedidos -->
                    <div class="footer-links">
                        <h3>Pedidos</h3>
                        <ul>
                            <li><a href="">Pedidos</a></li> <!-- Enlace a "tipo_producto.html" -->
                            <li><a href="">Productos</a></li> <!-- Enlace a "Productos.html" -->
                            <li><a href="">Envíos</a></li> <!-- Enlace a una sección de envíos (no especificado) -->
                        </ul>
                    </div>

                    <!-- Enlaces de la Tienda -->
                    <div class="footer-links">
                        <h3>Tienda</h3>
                        <ul>
                            <li><a href="nikecliente.php">Poleras Nike</a></li>
                            <li><a href="marathoncliente.php">Poleras Marathon</a></li>
                            <li><a href="adidascliente.php">poleras Adidas</a></li>
                            <li><a href="otrasmarcas.php">Otras Marcas</a></li>
                        </ul>
                    </div>

                    <!-- Enlaces de redes sociales -->
                    <div class="footer-links">
                        <h3>Síguenos</h3>
                        <div class="social-link">
                            <a href="https://www.facebook.com/leonardofidel.aranaisita.9"><i class="fab fa-facebook-f"></i></a> <!-- Enlace a Facebook -->
                            <a href="https://web.whatsapp.com/"><i class="fab fa-whatsapp"></i></a> <!-- Enlace a WhatsApp -->
                            <a href="https://www.tiktok.com/@luis_criss_11?_t=8fUcL8VZY9t&_r=1"><i class="fab fa-tiktok"></i></a> <!-- Enlace a TikTok -->
                            <a href="https://web.telegram.org/k/"><i class="fab fa-telegram"></i></a> <!-- Enlace a Telegram -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Marca de agua abajo del footer y sello de copiright -->
            <div class="agua">
                <img src="imagenes/Mi marca de agua.jpeg" alt=""> <!-- Imagen de la marca de agua -->
            </div>
            <span class="copiright">&copy;Dicaprio 2024</span> <!-- Derechos de autor -->
        </div>
    </footer>

    @if (Route::has('login'))
    <div class="h-14.5 hidden lg:block"></div>
    @endif
</body>

</html>