<?php
session_start();
include('conexion.php');

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $email = mysqli_real_escape_string($conexion, $_POST['email']);
    $password = mysqli_real_escape_string($conexion, $_POST['password']);

    $verificar = $conexion->query("SELECT * FROM usuarios WHERE email = '$email'");
    if ($verificar && $verificar->num_rows > 0) {
        $mensaje = "El correo ya está registrado.";
    } else {
        $sql = "INSERT INTO usuarios (nombre, email, password) VALUES ('$nombre', '$email', '$password')";
        if ($conexion->query($sql) === TRUE) {
            header("Location: login.php");
            exit();
        } else {
            $mensaje = "Error al registrar usuario.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>SEPHORA - Registro</title>
    <style>
        body { background-color: white; color: black; font-family: "Times New Roman", serif; margin: 0; padding: 0; }
        .formulario { width: 300px; margin: 50px auto; border: 1px solid black; padding: 20px; text-align: center; }
        input { width: 90%; padding: 8px; margin: 8px 0; border: 1px solid black; }
        button { background-color: black; color: white; border: none; padding: 10px; width: 100%; cursor: pointer; font-family: "Times New Roman", serif; }
        a { color: black; text-decoration: underline; }
    </style>
</head>
<body>
    <div class="formulario">
        <h2>Crear Cuenta</h2>
        <?php if($mensaje != "") echo "<p style='color:red;'>$mensaje</p>"; ?>
        <form method="POST" action="registro.php">
            <input type="text" name="nombre" placeholder="Nombre completo" required>
            <input type="email" name="email" placeholder="Correo electrónico" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <button type="submit">Registrarse</button>
        </form>
        <br>
        <a href="login.php">¿Ya tienes cuenta? Inicia sesión</a>
    </div>
</body>
</html>