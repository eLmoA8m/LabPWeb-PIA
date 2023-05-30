<?php
session_start();

include "../clases/Conexion.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    class Auth extends Conexion {
        public function iniciarSesion($usuario, $password) {
            $conexion = $this->Conectar();
            $sql = "SELECT * FROM usuarios WHERE nombre = ? AND contrasena = ?";
            $query = $conexion->prepare($sql);
            $query->bind_param('ss', $usuario, $password);
            $query->execute();
            $result = $query->get_result();
            $usuarioEncontrado = $result->fetch_assoc();

            if ($usuarioEncontrado) {
                $_SESSION['id'] = $usuarioEncontrado['id'];
                $_SESSION['nombre'] = $usuarioEncontrado['nombre'];
                $_SESSION['rol'] = $usuarioEncontrado['id_rol'];

                // Redirigir según el id_rol
                if ($_SESSION['rol'] == 1) {
                    header("location: ../index.php");
                } elseif ($_SESSION['rol'] == 2) {
                    header("location: ../paginasAdministrativas/agregarEquipo.php");
                } else {
                    echo "Rol de usuario desconocido";
                }
                exit;
            } else {
                echo "Credenciales incorrectas";
            }
        }
    }

    $Auth = new Auth();
    $Auth->iniciarSesion($usuario, $password);
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Formulario de inicio</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
	integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
<link rel="stylesheet" href="./css/estilos.css">
	<link rel="stylesheet" type="text/css" href="../css/login.css">
</head>
<body>
	<div class="container-fluid ps-md-0">
		<div class="row g-0">
		  <div class="d-none d-md-flex col-md-4 col-lg-6 bg-image"></div>
		  <div class="col-md-8 col-lg-6">
			<div class="login d-flex align-items-center py-5">
			  <div class="container">
				<div class="row">
				  <div class="col-md-9 col-lg-8 mx-auto">
					<h2 class="login-heading mb-4 text-center">Iniciar sesión</h2>
					
					<!-- Sign In Form -->
					<form method="POST">
					  <div class="form-floating mb-3">
						<input type="text" class="form-control" id="usuario" name="usuario" placeholder="Ingrese su usuario">
						<label for="usuario">Usuario</label>
					  </div>
					  <div class="form-floating mb-3">
						<input type="password" class="form-control" name="password" id="password" placeholder="Password">
						<label for="password">Contraseña</label>
					  </div>
	  
					  <div class="d-grid">
							<button class="btn btn-lg btn-success btn-login text-uppercase fw-bold mb-2" type="submit">Ingresar</button>
							<div class="text-center">
							  <a class="small" href="registro.php">Registrarse aquí</a>
							</div>
					  </div>
	  
					</form>
				  </div>
				</div>
			  </div>
			</div>
		  </div>
		</div>
	  </div>

	  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
	  integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
	  crossorigin="anonymous"></script>
</body>
</html>
