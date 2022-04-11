<?php
session_start();
require_once '../config/database.php';
/*
	*Crea la clase Login, y una funcion Log(), la cual si la variable $_POST['login'] contiene algo, creara una variable usuario y contraseña
	*Lo siguiente que hara es hacer una consulta a la base de datos, verificando que usuario corresponde con esas dos variables obtenidas a travez de $_POST
	*Si el resultado es correcto, creara una variable de sesion llamada id, la cual tiene el id del usuario. mostrara un mensaje positivo y retornara a index.php
	*En caso de que no coincida o no devuelva nada la consulta retornara un mensaje negativo y retornara a index.php
*/
class Login
{
	public function Log()
	{
		$connect = new Connect();
		if (isset($_POST['login'])) {
			$usuario = $_POST['username'];
			$contraseña = $_POST['password'];
			$sql = "SELECT * FROM usuarios WHERE usuario = '" . $usuario . "' and contrasena = '" . $contraseña . "'";
			$result = mysqli_query($connect->connection(), $sql);
			$row = mysqli_num_rows($result);
			$assoc = mysqli_fetch_assoc($result);
			if ($row == 1) {
				$_SESSION['id'] = $assoc['id'];
				echo ("<script>window.location.href='../index.php';</script>");
			} else {
				$_SESSION['error'] = "Intento fallido";
				echo ("<script>alert('Credenciales incorrectas.');window.location.href='../index.php';</script>");
			}
		}
	}
}
