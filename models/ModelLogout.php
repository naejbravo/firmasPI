<?php
// Crea la clase Logout, con una funcion llamada logout() en la cual inicia la sesion y luego la destruye.
class Logout
{
	public function logout()
	{
		session_start();
		session_destroy();
	}
}
