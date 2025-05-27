<x-layouts.app :title="__('Dashboard')">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="dasboard.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <title>inicio con usuarios</title>

    </head>

    <body>

        <div class="container"> <!-- Contenedor principal de la página -->
            <header class="header"> <!-- Cabecera de la página -->
                <div class="logo">
                    <img src="imagenes/Mi marca de agua.jpeg" alt=""> <!-- Imagen de logo -->
                </div>

                <nav class="main-nav"> <!-- Menú de navegación -->
                    <ul class="Nav-links">
                        <li><a href="{{ url('/productos') }}">PRODUCTOS</a></li>
                        <li><a href="{{ url('/ofertas') }}">OFERTAS</a></li>
                        <li><a href="COMOLLEGAR.php">COMO LLEGAR</a></li>
                    </ul>
                </nav>
            </header>

            <div class="objetos"> <!-- Contenedor de objetos -->
                <img src="imagenes/banermara.jpg" alt=""> <!-- Imagen -->
                <img src="imagenes/banermara2.jpg" alt=""> <!-- Otra imagen -->
            </div>

            <div class="slider">
                <ul>
                    <li><img src="imagenes/banermara4.jpg" alt=""></li>
                    <li><img src="imagenes/banermara3.jpg"></li>
                    <li><img src="imagenes/banermara.jpg" alt=""></li>
                    <li><img src="imagenes/banermara2.jpg" alt=""></li>
                    <li><img src="imagenes/NIKEEEE.jpg" alt=""></li>
                    <li><img src="imagenes/Bolivar.jpg" alt=""></li>
                </ul>
            </div>
        </div>

        <main> <!-- Contenido principal de la página -->
            <div class="columna"> <!-- Contenedor de la columna de productos -->
                <div class="producto">
                    <a href="{{ url('/nikecliente') }}"> <!-- Enlace a la página de tazas -->
                        <h2>POLERAS NIKE</h2> <!-- Título del producto -->
                        <img src="imagenes/NIKE7.png" alt=""> <!-- Imagen del producto -->
                    </a>
                </div>

                <div class="producto">
                    <a href="{{ url('/adidascliente') }}"> <!-- Enlace a la página de tazas -->
                        <h2>POLERAS ADIDAS</h2> <!-- Título del producto -->
                        <img src="imagenes/adidas1.png" alt=""> <!-- Imagen del producto -->
                    </a>
                </div>

                <div class="producto">
                    <a href="{{ url('/marathoncliente') }}"> <!-- Enlace a la página de tazas -->
                        <h2>POLERAS MARATHON</h2> <!-- Título del producto -->
                        <img src="imagenes/marathon.png" alt=""> <!-- Imagen del producto -->
                    </a>
                </div>

                <div class="producto">
                    <a href="{{ url('/marcamaracli') }}"> <!-- Enlace a la página de tazas -->
                        <h2>MARCA MARATHON</h2> <!-- Título del producto -->
                        <img src="imagenes/marathon.logo.jpg" alt=""> <!-- Imagen del producto -->
                    </a>
                </div>

                <div class="producto">
                    <a href="{{ url('/marcanikecli') }}"> <!-- Enlace a la página de tazas -->
                        <h2>MARCA NIKE</h2> <!-- Título del producto -->
                        <img src="imagenes/logo nike.png" alt=""> <!-- Imagen del producto -->
                    </a>
                </div>

                <div class="producto">
                    <a href="{{ url('/otrasmarcas') }}"> <!-- Enlace a la página de tazas -->
                        <h2>OTRAS MARCAS </h2> <!-- Título del producto -->
                        <img src="imagenes/marcas.jpg" alt=""> <!-- Imagen del producto -->
                    </a>
                </div>
            </div>
        </main>



        <div class="grid-galeria">
            <div class="card">
                <img src="imagenes/seleccion1.png" alt="Nike Running">
                <div class="overlay">
                    <h4>Centenario Boliviano</h4>
                    <p>Polera de la selccion Boliviana edicion limitada</p>
                    <a href="{{ url('/marathoncliente') }}">Comprar</a>
                </div>
            </div>

            <div class="card">
                <img src="imagenes/sele2.jpg" alt="Nike Moda">
                <div class="overlay">
                    <h4>BolivarMania</h4>
                    <p>Polera centenario edicion Limitada</p>
                    <a href="{{ url('/otrasmarcas') }}">Comprar</a>
                </div>
            </div>

            <div class="card">
                <img src="imagenes/sele3.jpg" alt="Nike Street">
                <div class="overlay">
                    <h4>BolivarMania</h4>
                    <p>Polera centenario edicion Limitada</p>
                    <a href="{{ url('/otrasmarcas') }}">Comprar</a>
                </div>
            </div>

            <div class="card">
                <img src="imagenes/sele4.png" alt="Nike Training">
                <div class="overlay">
                    <h4>Polera del Al-Nassr</h4>
                    <p>Edicion Limitada</p>
                    <a href="{{ url('/nikecliente') }}">Comprar</a>
                </div>
            </div>
        </div>


        <footer>
            <div class="footer"> <!-- Contenedor del pie de página -->
                <div class="conteiner"> <!-- Contenedor del pie de página -->
                    <div class="footer-row"> <!-- Fila de enlaces en el pie de página -->
                        <div class="footer-links">
                            <h3>Compañía</h3>
                            <ul>
                                <li><a href="">Nosotros</a></li> <!-- Enlace a "nosotros.html" -->
                                <li><a href="">Nuestro servicio</a></li> <!-- Enlace a "servicio.html" -->
                                <li><a href="">Política de privacidad</a></li> <!-- Enlace a "compañia.html" -->
                            </ul>
                        </div>
                        <div class="footer-links">
                            <h3>Pedidos</h3>
                            <ul>
                                <li><a href="">Pedidos</a></li> <!-- Enlace a "tipo_producto.html" -->
                                <li><a href="">Productos</a></li> <!-- Enlace a "Productos.html" -->
                                <li><a href="">Envíos</a></li> <!-- Enlace a una sección de envíos (no especificado) -->
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
                                <a href="https://www.facebook.com/leonardofidel.aranaisita.9"><i class="fab fa-facebook-f"></i></a> <!-- Enlace a Facebook -->
                                <a href="https://web.whatsapp.com/"><i class="fab fa-whatsapp"></i></a> <!-- Enlace a WhatsApp -->
                                <a href="https://www.tiktok.com/@luis_criss_11?_t=8fUcL8VZY9t&_r=1"><i class="fab fa-tiktok"></i></a> <!-- Enlace a TikTok -->
                                <a href="https://web.telegram.org/k/"><i class="fab fa-telegram"></i></a> <!-- Enlace a Telegram -->
                            </div>
                        </div>
                    </div>
                </div>

                <div class="agua">
                    <img src="imagenes/Mi marca de agua.jpeg" alt=""> <!-- Imagen de la marca de agua -->
                </div>
                <span class="copiright">&copy;Dicaprio 2025</span> <!-- Derechos de autor -->
            </div>
        </footer>

        @if (Route::has('login'))
        <div class="h-14.5 hidden lg:block"></div>
        @endif
    </body>

</x-layouts.app>