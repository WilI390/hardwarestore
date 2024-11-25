<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hardware Store Nuts and Bolts - Cotizaciones</title>
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

    
    <section class="cotizacion">
        <div class="container">
            <h2>Solicitar Cotización</h2>
            <form method="POST" action="cotizaciones.php">
    <div class="form-group">
        <label for="nombre">Nombre Completo:</label>
        <input type="text" id="nombre" name="nombre" required>
    </div>
    <div class="form-group">
        <label for="correo">Correo Electrónico:</label>
        <input type="email" id="correo" name="correo" required>
    </div>
    <div class="form-group">
        <label for="comentarios">Comentarios Adicionales:</label>
        <textarea id="comentarios" name="comentarios" rows="3"></textarea>
    </div>

    <h3>Selecciona los productos:</h3>
    <div class="form-group">
        <?php
        include 'conexion.php';
        $sql = "SELECT id, nombre, precio FROM productos";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<label>';
                echo '<input type="checkbox" name="productos[]" value="' . $row['id'] . '">';
                echo $row['nombre'] . ' - $' . number_format($row['precio'], 2) . '<br>';
                echo '</label>';
            }
        } else {
            echo '<p>No hay productos disponibles para cotizar.</p>';
        }
        ?>
    </div>

    <h3>Selecciona el tipo de cliente:</h3>
    <div class="form-group">
        <select name="tipo_cliente" required>
            <option value="nuevo">Nuevo</option>
            <option value="casual">Casual</option>
            <option value="periodico">Periódico</option>
            <option value="permanente">Permanente</option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Calcular Cotización</button>
</form>

    
<!-- Mostrar el resumen de la cotización -->
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capturar datos del formulario
    $nombre = $_POST['nombre'] ?? null;
    $correo = $_POST['correo'] ?? null;
    $comentarios = $_POST['comentarios'] ?? '';
    $productosSeleccionados = $_POST['productos'] ?? [];
    $tipoCliente = $_POST['tipo_cliente'] ?? null;

    // Verificar que los campos obligatorios no estén vacíos
    if (empty($nombre) || empty($correo) || empty($productosSeleccionados) || empty($tipoCliente)) {
        echo "<p>Error: Por favor, completa todos los campos obligatorios.</p>";
        exit;
    }

    // Inicializar variables
    $subtotal = 0;
    $descuento = 0;

    // Calcular el subtotal
    foreach ($productosSeleccionados as $idProducto) {
        $sql = "SELECT precio FROM productos WHERE id = $idProducto";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $subtotal += $row['precio'];
        }
    }

    // Calcular descuentos según el tipo de cliente
    switch ($tipoCliente) {
        case 'permanente':
            $descuento = $subtotal * 0.10;
            break;
        case 'periodico':
            $descuento = $subtotal * 0.05;
            break;
        case 'casual':
            $descuento = $subtotal * 0.02;
            break;
        default:
            $descuento = 0; // Nuevo cliente no tiene descuento
    }

    // Descuento adicional por compras mayores a $100,000
    if ($subtotal > 100000) {
        $descuento += $subtotal * 0.02;
    }

    // Total final
    $total = $subtotal - $descuento;

    // Guardar en la base de datos
    $productosLista = implode(',', $productosSeleccionados);
    $sqlInsert = "INSERT INTO cotizaciones_no_registrados 
        (nombre, correo, tipo_cliente, productos, subtotal, descuento, total, comentarios) 
        VALUES 
        ('$nombre', '$correo', '$tipoCliente', '$productosLista', $subtotal, $descuento, $total, '$comentarios')";

    if ($conn->query($sqlInsert) === TRUE) {
        echo "<div id='cotizacion-resumen'>";
        echo "<h3>Resumen de Cotización:</h3>";
        echo "<p>Nombre: $nombre</p>";
        echo "<p>Correo: $correo</p>";
        echo "<p>Subtotal: $" . number_format($subtotal, 2) . "</p>";
        echo "<p>Descuento: $" . number_format($descuento, 2) . "</p>";
        echo "<p>Total a pagar: $" . number_format($total, 2) . "</p>";
        echo "<p>Comentarios: $comentarios</p>";
        echo "</div>";
    } else {
        echo "<p>Error al registrar la cotización: " . $conn->error . "</p>";
    }
}
?>


        </div>
    </section>
    

    
    <footer id="contacto">
        <div class="container">
            <div class="footer-info">
                <p><strong>Dirección:</strong> Calle Falsa 123, Ciudad, País</p>
                <p><strong>Teléfono:</strong> +123 456 7890</p>
                <p><strong>Correo:</strong> contacto@hardwarestore.com</p>
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
