<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar si las claves del formulario están presentes antes de usarlas
    if (isset($_POST['id'], $_POST['nombre'], $_POST['matematicas'], $_POST['fisica'], $_POST['programacion'])) {
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $matematicas = $_POST['matematicas'];
        $fisica = $_POST['fisica'];
        $programacion = $_POST['programacion'];

        // Agregar los datos del estudiante a la sesión
        for ($i = 0; $i < count($id); $i++) {
            $_SESSION['estudiantes'][] = array(
                'id' => $id[$i],
                'nombre' => $nombre[$i],
                'matematicas' => $matematicas[$i],
                'fisica' => $fisica[$i],
                'programacion' => $programacion[$i]
            );
        }
    }
}

// Calcula los resultados aquí
$total_estudiantes = isset($_SESSION['estudiantes']) ? count($_SESSION['estudiantes']) : 0;
$promedio_matematicas = $total_estudiantes > 0 ? array_sum(array_column($_SESSION['estudiantes'], 'matematicas')) / $total_estudiantes : 0;
$promedio_fisica = $total_estudiantes > 0 ? array_sum(array_column($_SESSION['estudiantes'], 'fisica')) / $total_estudiantes : 0;
$promedio_programacion = $total_estudiantes > 0 ? array_sum(array_column($_SESSION['estudiantes'], 'programacion')) / $total_estudiantes : 0;

$aprobados_matematicas = $total_estudiantes > 0 ? array_filter($_SESSION['estudiantes'], function($estudiante) {
    return $estudiante['matematicas'] >= 11;
}) : array();

$reprobados_matematicas = $total_estudiantes > 0 ? array_filter($_SESSION['estudiantes'], function($estudiante) {
    return $estudiante['matematicas'] <= 10;
}) : array();

$aprobados_fisica = $total_estudiantes > 0 ? array_filter($_SESSION['estudiantes'], function($estudiante) {
    return $estudiante['fisica'] >= 11;
}) : array();

$reprobados_fisica = $total_estudiantes > 0 ? array_filter($_SESSION['estudiantes'], function($estudiante) {
    return $estudiante['fisica'] <= 10;
}) : array();

$aprobados_programacion = $total_estudiantes > 0 ? array_filter($_SESSION['estudiantes'], function($estudiante) {
    return $estudiante['programacion'] >= 11;
}) : array();

$reprobados_programacion = $total_estudiantes > 0 ? array_filter($_SESSION['estudiantes'], function($estudiante) {
    return $estudiante['programacion'] <= 10;
}) : array();

$aprobados_todas = $total_estudiantes > 0 ? array_filter($_SESSION['estudiantes'], function($estudiante) {
    return $estudiante['matematicas'] >= 11 &&
           $estudiante['fisica'] >= 11 &&
           $estudiante['programacion'] >= 11;
}) : array();

$aprobados_una_materia = $total_estudiantes > 0 ? array_filter($_SESSION['estudiantes'], function($estudiante) {
    $aprobadas = 0;
    if ($estudiante['matematicas'] >= 11) $aprobadas++;
    if ($estudiante['fisica'] >= 11) $aprobadas++;
    if ($estudiante['programacion'] >= 11) $aprobadas++;
    return $aprobadas == 1;
}) : array();

$aprobados_dos_materias = $total_estudiantes > 0 ? array_filter($_SESSION['estudiantes'], function($estudiante) {
    $aprobadas = 0;
    if ($estudiante['matematicas'] >= 11) $aprobadas++;
    if ($estudiante['fisica'] >= 11) $aprobadas++;
    if ($estudiante['programacion'] >= 11) $aprobadas++;
    return $aprobadas == 2;
}) : array();

$maxima_calificacion_matematicas = $total_estudiantes > 0 ? max(array_column($_SESSION['estudiantes'], 'matematicas')) : 0;
$maxima_calificacion_fisica = $total_estudiantes > 0 ? max(array_column($_SESSION['estudiantes'], 'fisica')) : 0;
$maxima_calificacion_programacion = $total_estudiantes > 0 ? max(array_column($_SESSION['estudiantes'], 'programacion')) : 0;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Resultados</title>
</head>
<body>
    <h1>Datos Generales</h1>
    <p>Total de estudiantes: <?php echo $total_estudiantes; ?></p>
    <p>Promedio en Matemáticas: <?php echo $promedio_matematicas; ?></p>
    <p>Promedio en Física: <?php echo $promedio_fisica; ?></p>
    <p>Promedio en Programación: <?php echo $promedio_programacion; ?></p>
    <hr>
    <h2>Matemáticas</h2>
    <p>Estudiantes que aprobaron: <?php echo count($aprobados_matematicas); ?></p>
    <p>Estudiantes que reprobaron: <?php echo count($reprobados_matematicas); ?></p>
    <p>Nota máxima: <?php echo $maxima_calificacion_matematicas; ?></p>
    <hr>
    <h2>Física</h2>
    <p>Estudiantes que aprobaron: <?php echo count($aprobados_fisica); ?></p>
    <p>Estudiantes que reprobaron: <?php echo count($reprobados_fisica); ?></p>
    <p>Nota máxima: <?php echo $maxima_calificacion_fisica; ?></p>
    <hr>
    <h2>Programación</h2>
    <p>Estudiantes que aprobaron: <?php echo count($aprobados_programacion); ?></p>
    <p>Estudiantes que reprobaron: <?php echo count($reprobados_programacion); ?></p>
    <p>Nota máxima: <?php echo $maxima_calificacion_programacion; ?></p>
    <hr>
    <h2>Estudiantes que aprobaron todas las materias</h2>
    <p><?php echo count($aprobados_todas); ?> estudiantes</p>
    <hr>
    <h2>Estudiantes que aprobaron una sola materia</h2>
    <p><?php echo count($aprobados_una_materia); ?> estudiantes</p>
    <hr>
    <h2>Estudiantes que aprobaron dos materias</h2>
    <p><?php echo count($aprobados_dos_materias); ?> estudiantes</p>
    <hr>
    <form action="formulario.php">
        <input type="submit" value="Atras">
    </form>
    <form method="post">
        <input type="submit" name="destroy" value="Destruir Sesión">
    </form>
    
</body>
</html>
