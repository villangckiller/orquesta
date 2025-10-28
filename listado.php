<?php
include 'db_connect.php';

$pdo = new PDO("mysql:host=localhost;dbname=orquesta_db;charset=utf8", "root", "");
$stmt = $pdo->query("SELECT * FROM archivos WHERE activo = 1 ORDER BY fecha_carga DESC");
$archivos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Catálogo musical</title>
</head>
<body>
    <h1>Catálogo musical</h1>
    <ul>
        <?php foreach ($archivos as $a): ?>
            <li>
                <strong><?php echo htmlspecialchars($a['titulo']); ?></strong><br>
                Autor: <?php echo htmlspecialchars($a['autor']); ?><br>
                Género: <?php echo htmlspecialchars($a['genero']); ?><br>
                Instrumentación: <?php echo htmlspecialchars($a['instrumentacion']); ?><br>
                <a href="<?php echo htmlspecialchars($a['ruta_archivo']); ?>" target="_blank">Descargar PDF</a>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>