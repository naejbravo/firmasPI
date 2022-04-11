<?php
/* 
	*Clase llamada File que contiene un metodo llamado Upload y un parametro $file, la funcion crea dos variables:
		*$dir que contiene el directorio uploads
		*$archivo que contiene $dir y el nombre del fichero horario.xml
	*Luego de esto comprueba si el parametro pasado es un fichero de tipo text/xml, en ese caso se utiliza la funcion move_uploaded_file() si sale positiva entonces mostrara un mensaje positivo, y retornara a index.php
	*Si es negativo mostrara un mensaje diciendo que no se subio el fichero y retorna a index.php
	*Si el fichero no es xml, retorna un mensaje negativo y retorna a index.php

*/
class File
{
	public function Upload($file)
	{
		$dir = "../uploads/";
		$archivo = $dir . "horario.xml";
		//$archivo=$dir.basename($file["name"]);
		if ($file['type'] === "text/xml") {
			if (move_uploaded_file($file["tmp_name"], $archivo)) {
				//echo ("<script>alert('Fichero subido correctamente.');window.location.href='../index.php';</script>");
			} else {
				echo ("<script>alert('No se ha subido el fichero.');window.location.href='../index.php';</script>");
			}
		} else {
			//unlink("../uploads/horario.xml");
			//echo ("<script>alert('El fichero no era un xml.');window.location.href='../index.php';</script>");
		}
	}
}
