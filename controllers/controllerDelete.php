<?php
require_once '../models/ModelDelete.php';
// Si existe la variable de sesion id, entonces creara una nueva instancia de la clase Delete y utilzara su metodo borrar()
session_start();
if (isset($_SESSION['id'])) {
	require_once '../config/database.php';
	$connect = new Connect();
	$sql = "select * from horarios";
	$result = mysqli_query($connect->connection(), $sql);
	if (mysqli_num_rows($result) > 0) {
		$db_host = "localhost";
		$db_name = "centro";
		$db_user = "root";
		$db_pass = "";
		$fecha = date("Ymd-His");
		$salida_sql = "../backups/" . $db_name . "_" . $fecha . ".sql";
		$dump = 'c:\xampp\mysql\bin\mysqldump --user=' . $db_user . ' --password=' . $db_pass . ' -h ' . $db_host . ' ' . $db_name . ' --routines > ' . $salida_sql . '';
		exec($dump, $output);
		$borrar = new Delete();
		$borrar->borrar();
	} else {
		echo ("<script>alert('No hay datos para ser borrados.');window.location.href='../index.php';</script>");
	}
} else {
	header("location: ../index.php");
}
