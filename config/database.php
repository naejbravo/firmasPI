<?php
//Crea la clase Connect, con una funcion llamada connection() la cual tiene la variable con la informacion de la base de datos y retorna el resutlado.
class Connect
{
	public static function connection()
	{
		$connection = new mysqli("localhost", "root", "", "centro");
		return $connection;
	}
}
