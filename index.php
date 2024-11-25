<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hardware Store Nuts and Bolts - Inicio</title>
    <!-- Enlace a CSS -->
    <link rel="stylesheet" href="styles/styles.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <!-- Font Awesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnH1z4FfK1j3H/8w8/wR4+ODsP/dxtZtC8vXPGkNexuN5N5P9Vn9pBm7EMJEuXvblPFVgIAw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-D5QT1C9G4D"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-D5QT1C9G4D');
</script>

</head>
<body>
    <!-- Header -->
    <header>
        <div class="container">
            <div class="logo">
                <h1>Hardware Store</h1>
            </div>
            <nav>
                <ul class="nav-links">
                    <li><a href="index.html">Inicio</a></li>
                    <li><a href="cotizaciones.html">Cotizaciones</a></li>
                    <li><a href="ventas.html">Ventas en Línea</a></li>
                    <li><a href="#contacto">Contacto</a></li>
                </ul>
            </nav>
            <div class="header-icons">
                <a href="ventas.html" class="cart"><i class="fas fa-shopping-cart"></i></a>
                <a href="#" class="search-icon"><i class="fas fa-search"></i></a>
            </div>
        </div>
    </header>

    
    <section class="hero">
        <div class="hero-content">
            <h2>Todo para Ornamentación y Talleres de Latonería y Pintura</h2>
            <p>28 años proporcionando los mejores productos para tus proyectos</p>
            <div class="hero-buttons">
                <a href="ventas.html" class="btn btn-primary">Comprar Ahora</a>
                <a href="cotizaciones.html" class="btn btn-secondary">Solicitar Cotización</a>
            </div>
        </div>
    </section>

    
    <section id="productos" class="productos">
        <div class="container">
            <h2>Productos Destacados</h2>
            <div class="productos-grid">
                <?php
                include 'conexion.php'; // Conexión a la base de datos
    
                // Consulta para obtener los productos
                $sql = "SELECT id, nombre, precio, imagen FROM productos";
                $result = $conn->query($sql);
    
                if ($result->num_rows > 0) {
                    // Mostrar cada producto
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="producto-card">';
                        echo '<img src="images/' . $row["imagen"] . '" alt="' . $row["nombre"] . '">';
                        echo '<h3>' . $row["nombre"] . '</h3>';
                        echo '<p class="precio">$' . number_format($row["precio"], 2) . '</p>';
                        echo '<div class="producto-actions">';
                        echo '<a href="ventas.html" class="btn btn-primary">Comprar</a>';
                        echo '<a href="cotizaciones.html" class="btn btn-secondary">Cotizar</a>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo '<p>No hay productos disponibles en este momento.</p>';
                }
    
                $conn->close(); // Cerrar la conexión
                ?>
            </div>
        </div>
    </section>

   
    <footer id="contacto">
        <div class="container">
            <div class="footer-info">
                <p><strong>Dirección:</strong> Calle 31D sur 13-87, Bogotá, Colombia</p>
                <p><strong>Teléfono:</strong> +52 350 747 5930</p>
                <p><strong>Correo:</strong> contacto@wclarounadhardwarestore.com</p>
            </div>
            <div class="footer-social">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                
            </div>
            <div class="footer-links">
                <a href="#">Términos y Condiciones</a>
                <a href="#">Política de Privacidad</a>
                <a href="#">FAQ</a>
            </div>
            <div class="footer-subscripcion">
                <form id="subscripcion-form">
                    <label for="email-subscripcion">Suscríbete a nuestro boletín:</label>
                    <input type="email" id="email-subscripcion" name="email-subscripcion" placeholder="Tu correo electrónico" required>
                    <button type="submit" class="btn btn-primary">Suscribirse</button>
                </form>
                <div id="subscripcion-mensaje" class="form-mensaje"></div>
            </div>
        </div>
    </footer>

    
    <script src="scripts/scripts.js"></script>
</body>
</html>
