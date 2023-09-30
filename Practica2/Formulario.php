<!DOCTYPE html>
<html>
<head>
    <title>Formulario</title>
    <link rel="stylesheet" type="text/css" href="assets\css\styles.css">
</head>
<body>
    <h1>Formulario de Estudiantes</h1>
    <form action="procesar.php" method="post">
        <label for="id">Cedula:</label>
        <input type="text" name="id[]" required><br>
        
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre[]" required><br>
        
        <label for="matematicas">Nota de Matemática:</label>
        <input type="number" name="matematicas[]" min="0" max="20" required><br>
        
        <label for="fisica">Nota de Física:</label>
        <input type="number" name="fisica[]" min="0" max="20" required><br>
        
        <label for="programacion">Nota de Programación:</label>
        <input type="number" name="programacion[]" min="0" max="20" required><br>

        <hr>
        
        <input type="submit" value="Agregar Estudiante">
    </form>
</body>
</html>
