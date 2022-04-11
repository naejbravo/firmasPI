<?php
require_once '../config/database.php';
/* 
	*Clase Delete con metodo borrar(), la cual crear una variable $sql que contiene toda la consulta, primero desactiva el chequeo de llaves foraneas y luego hace truncate table de las tablas en cuestion
	*Si obtenemos algun resultado de esa consulta, el mensaje es positivo y retorna a index.php
	*Si no hay resultado, entonces el mensaje es negativo y retorna a index.php
*/
class Delete
{
	public function borrar()
	{
		$connect = new Connect();
		$sql = "SET FOREIGN_KEY_CHECKS = 0;";
		$sql .= "truncate table asignaturas;";
		$sql .= "truncate table aulas;";
		$sql .= "truncate table grupos;";
		$sql .= "truncate table horarios;";
		$sql .= "truncate table profesores;";
		$sql .= "truncate table tramos;";
		$sql .= "truncate table calendar;";
		$sql .= "truncate table horarios_firmados;";
		$sql .= "truncate table firmas;";
		$sql .= "SET FOREIGN_KEY_CHECKS = 1";
		$result = mysqli_multi_query($connect->connection(), $sql);
		if ($result) {
			echo ("<script>alert('Se han borrado los datos correctamente y se ha creado una copia en el directorio backups.');window.location.href='../index.php';</script>");
		} else {
			echo ("<script>alert('Ha ocurrido un error al borrar los datos.');window.location.href='../index.php';</script>");
		}
	}
}
