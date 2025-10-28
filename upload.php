<?php
include 'db_connect.php';

// ==================== PROCESAMIENTO DEL FORMULARIO ====================
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $genero = $_POST['genero'];
    $instrumentacion = $_POST['instrumentacion'];

    if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] === 0) {
        $nombreArchivo = $_FILES['archivo']['name'];
        $rutaTemporal = $_FILES['archivo']['tmp_name'];
        $carpetaDestino = "uploads/";

        if (!file_exists($carpetaDestino)) {
            mkdir($carpetaDestino, 0777, true);
        }

        $rutaFinal = $carpetaDestino . basename($nombreArchivo);

        if (move_uploaded_file($rutaTemporal, $rutaFinal)) {
            $sql = "INSERT INTO archivos (titulo, autor, genero, instrumentacion, archivo)
                    VALUES (:titulo, :autor, :genero, :instrumentacion, :archivo)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':titulo' => $titulo,
                ':autor' => $autor,
                ':genero' => $genero,
                ':instrumentacion' => $instrumentacion,
                ':archivo' => $rutaFinal
            ]);

            echo "<script>alert('Archivo subido correctamente.');</script>";
        } else {
            echo "<script>alert('Error al subir el archivo.');</script>";
        }
    } else {
        echo "<script>alert('No se seleccionó ningún archivo.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Subir archivo - Orquesta del Chaco</title>
    <link rel="stylesheet" href="css.css">
    <style>
        /* ===== layout header/footer + formulario ===== */
        body {
            margin:0;
            font-family:"Segoe UI", Arial, sans-serif;
            background:#fff;
            color:#333;
        }
        .site-header {
            background:#fff;
            border-bottom:1px solid #e6e2de;
        }
        .header-inner {
            max-width:1100px;
            margin:0 auto;
            display:flex;
            align-items:center;
            justify-content:space-between;
            padding:28px 18px;
        }
        .logo {
            font-weight:700;
            text-decoration:none;
            color:#2a2a72;
            display:flex;
            align-items:center;
            gap:8px;
            font-size:20px;
        }
        .main-nav ul {
            list-style:none;
            margin:0;
            padding:0;
            display:flex;
            gap:18px;
            align-items:center;
        }
        .main-nav ul li a {
            text-decoration:none;
            color:#333;
            font-size:15px;
            padding:6px 8px;
        }
        .main-nav ul li a.active {
            color:#2a2a72;
            font-weight:700;
        }

        /* page layout with sidebar + content */
        .page-wrap {
            max-width:1100px;
            margin:36px auto;
            display:grid;
            grid-template-columns:260px 1fr;
            gap:36px;
            padding:0 18px;
        }
        .filters {
            background:transparent;
            padding:6px 0;
            font-size:14px;
        }
        .filters h3 { margin:0 0 12px; color:#444; }
        .filters .filter-block { margin-bottom:18px; }
        .filters ul { list-style:disc; margin-left:18px; color:#333; }

        /* content area / upload card */
        .upload-card {
            background:#f6f3f0;
            border-radius:6px;
            padding:28px;
            box-shadow:0 1px 0 rgba(0,0,0,0.03);
        }
        .upload-card h2 { margin-top:0; margin-bottom:18px; color:#222; font-size:22px; }

        .upload-form {
            display:flex;
            flex-direction:column;
            gap:12px;
            max-width:640px;
        }
        .upload-form label { font-weight:600; font-size:13px; color:#333; }
        .upload-form input[type="text"],
        .upload-form input[type="file"],
        .upload-form input[type="email"],
        .upload-form textarea {
            padding:10px 12px;
            border:1px solid #ddd;
            border-radius:4px;
            font-size:15px;
            background:#fff;
        }
        .btn-primary {
            margin-top:8px;
            padding:10px 14px;
            border:none;
            border-radius:5px;
            cursor:pointer;
            font-weight:700;
            background:#2a2a72;
            color:#fff;
            width:fit-content;
        }

        /* footer */
        .site-footer {
            margin-top:36px;
            border-top:1px solid #e6e2de;
            background:#faf8f6;
            padding:22px 0 8px;
        }
        .footer-inner {
            max-width:1100px;
            margin:0 auto;
            display:flex;
            gap:36px;
            padding:0 18px;
            justify-content:space-between;
        }
        .footer-inner h4 { margin:0 0 8px; font-size:15px; color:#333; }
        .footer-nav ul { list-style:none; padding:0; margin:0; }
        .footer-nav ul li { margin-bottom:6px; }
        .footer-contact p { margin:0 0 6px; font-size:14px; color:#444; }
        .footer-bottom { text-align:center; padding:12px 18px; color:#777; font-size:13px; background:transparent; margin-top:14px; }

        @media (max-width:900px) {
            .header-inner { flex-direction:column; gap:12px; align-items:flex-start; }
            .page-wrap { grid-template-columns:1fr; }
            .main-nav ul { flex-wrap:wrap; gap:10px; }
            .footer-inner { flex-direction:column; gap:12px; align-items:flex-start; }
        }
    </style>
</head>
<body>

<!-- ================= HEADER ================= -->
<header class="site-header">
    <div class="header-inner">
        <a class="logo" href="index.html">🎵 <span class="site-title">Orquesta</span></a>
        <nav class="main-nav">
            <ul>
                <li><a href="index.html">Inicio</a></li>
                <li><a href="aboutus.html">Nosotros</a></li>
                <li><a href="contactus.html">Contacto</a></li>
                <li><a href="listado.php">Listado</a></li>
                <li><a href="upload.php" class="active">Subir archivo</a></li>
                <li><a href="logout.php">Cerrar sesión</a></li>
            </ul>
        </nav>
    </div>
</header>

<!-- ================= CONTENIDO ================= -->
<main class="site-main">
    <div class="page-wrap">
        <aside class="filters">
            <h3>Filtros</h3>
            <div class="filter-block">
                <strong>Género</strong>
                <ul>
                    <li>Clásico</li>
                    <li>Tango</li>
                    <li>Folclore</li>
                    <li>Contemporáneo</li>
                </ul>
            </div>

            <div class="filter-block">
                <strong>Instrumentación</strong>
                <ul>
                    <li>Violín</li>
                    <li>Piano</li>
                    <li>Banda completa</li>
                    <li>Cuerdas</li>
                    <li>Coro</li>
                </ul>
            </div>
        </aside>

        <section class="content-area">
            <div class="upload-card">
                <h2>Subir nuevo archivo PDF</h2>
                <form method="post" enctype="multipart/form-data" class="upload-form">
                    <label for="titulo">Título:</label>
                    <input type="text" id="titulo" name="titulo" required>

                    <label for="autor">Autor:</label>
                    <input type="text" id="autor" name="autor" required>

                    <label for="genero">Género:</label>
                    <input type="text" id="genero" name="genero">

                    <label for="instrumentacion">Instrumentación:</label>
                    <input type="text" id="instrumentacion" name="instrumentacion">

                    <label for="archivo">Archivo (PDF):</label>
                    <input type="file" id="archivo" name="archivo" accept="application/pdf" required>

                    <button type="submit" class="btn-primary">Subir archivo</button>
                </form>
            </div>
        </section>
    </div>
</main>

<!-- ================= FOOTER ================= -->
<footer class="site-footer">
    <div class="footer-inner">
        <div class="footer-nav">
            <h4>Navegación rápida</h4>
            <ul>
                <li><a href="index.html">Inicio</a></li>
                <li><a href="aboutus.html">Nosotros</a></li>
                <li><a href="contactus.html">Contacto</a></li>
                <li><a href="upload.php">Cargar Archivo</a></li>
            </ul>
        </div>

        <div class="footer-contact">
            <h4>Información de contacto</h4>
            <p>Archivo Orquesta Sinfónica del Chaco</p>
            <p>Email: archivo@orquestadelchaco.org</p>
        </div>
    </div>

    <div class="footer-bottom">
        <p>© 2025. Todos los derechos reservados.</p>
    </div>
</footer>

</body>
</html>