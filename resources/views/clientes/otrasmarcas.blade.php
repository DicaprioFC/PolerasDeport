<!DOCTYPE html> <!-- Declaración del tipo de documento HTML -->
<html lang="es"> <!-- Etiqueta raíz del documento con el atributo "lang" que especifica el idioma -->

<head>
    <meta charset="UTF-8"> <!-- Configuración de la codificación de caracteres -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Configuración de la vista en dispositivos móviles -->
    <link rel="stylesheet" href="estilo.css"> <!-- Enlaza una hoja de estilo CSS llamada "estilo.css" -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"> <!-- Enlaza una hoja de estilo CSS de Font Awesome -->
    <title>Ropa deportiva de la marca nike</title> <!-- Establece el título de la página como "inicio" -->

    <style>
        .titulo {
            text-align: center;
            font-size: 32px;
            margin-top: 20px;
            color: #333;
        }

        .contenedor-productos {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            margin: 40px auto;
            width: 90%;
        }

        .producto {
            width: calc(22% - 20px);
            margin: 10px;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            transition: background-color 0.3s ease;
        }

        .producto:hover {
            transform: scale(1.05);
        }

        .producto img {
            width: 250px;
            height: 200px;
            margin-bottom: 10px;
            margin-top: 50px;
        }

        .producto h2 {
            font-size: 18px;
            margin-bottom: 8px;
            color: white;
        }

        .producto p {
            background-color: black;
            color: white;
            padding: 5px;
            border-radius: 5px;
            font-weight: bold;
        }

        @media (max-width: 992px) {
            .producto {
                width: calc(33.33% - 20px);
                /* 3 por fila */
            }
        }

        @media (max-width: 768px) {
            .producto {
                width: calc(50% - 20px);
                /* 2 por fila */
            }
        }

        @media (max-width: 480px) {
            .producto {
                width: 100%;
                /* 1 por fila */
            }
        }
    </style>
</head>

<body>
    <div class="container"> <!-- Contenedor principal de la página -->
        <header class="header"> <!-- Cabecera de la página -->
            <div class="logo"> <!-- Elemento de logo -->
                <img src="imagenes/Mi marca de agua.jpeg" alt=""> <!-- Imagen de logo -->
            </div>
            <nav class="main-nav"> <!-- Menú de navegación -->
                <ul class="Nav-links responsive-links"> <!-- Lista de enlaces de navegación con la clase "responsive-links" -->
                    <li><a href="{{ route('dashboard') }}">INICIO</a></li>
                    <li><a href="{{ url('/productos') }}">PRODUCTOS</a></li>
                    <li><a href="pedidos.php">PEDIDOS</a></li> <!-- Enlace a "tipo_producto.html" -->
                    <li><a href="como llegar.php">COMO LLEGAR</a></li> <!-- Enlace a "ubicacion.html" -->
                </ul>
            </nav>


            <a href="{{ url('/') }}" class="logout-link"><i class="fas fa-sign-out-alt"></i></a>

        </header>

        <h1 class="titulo">Productos deportivos de otras marcas</h1>
        <div class="contenedor-productos">
            @foreach ($productos as $producto)
            <div class="producto">
                <img src="/{{ $producto->imagen }}" alt="Imagen del producto">
                <h2>{{ $producto->nombre }}</h2>
                <p>Precio: Bs {{ number_format($producto->precio, 2) }}</p>
            </div>
            @endforeach
        </div>


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
                                <li><a href="pedidos.php">Pedidos</a></li> <!-- Enlace a "tipo_producto.html" -->
                                <li><a href="Productos.php">Productos</a></li> <!-- Enlace a "Productos.html" -->
                                <li><a href="#">Envíos</a></li> <!-- Enlace a una sección de envíos (no especificado) -->
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

</body>

</html>