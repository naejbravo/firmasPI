<?php
session_start();
// Si la variable de sesion id, contiene algo entonces creara una nueva instancia de la clase File() y utilzara el metodo Upload pasandole como parametro la variable de FILES llamada "file"
if (isset($_SESSION['id'])) {
	require_once '../config/database.php';
	$connect = new Connect();
	$sql = "select * from horarios";
	$result = mysqli_query($connect->connection(), $sql);
	if (mysqli_num_rows($result) == 0) {
		require_once '../models/ModelFile.php';
		$fileUpload = new File();
		$fileUpload->Upload($_FILES['file']);
		if (isset($_SESSION['id'])) {
			require_once './ControllerXml.php';
			require_once '../config/database.php';
			if (isset($_POST['fechaInicio']) && isset($_POST['fechaFin'])) {
				$connect = new Connect();
				$sql = "CALL FillCalendar('" . $_POST['fechaInicio'] . "', '" . $_POST['fechaFin'] . "')";
				mysqli_query($connect->connection(), $sql);
				require_once '../models/calendario.php';
			} else {
				unlink("../uploads/horario.xml");
				echo ("<script>alert('No ha seleccionado las fechas para el curso escolar.');window.location.href='../index.php';</script>");
			}
		} else {
			header("location: ../index.php");
		}
	} else {
		echo ("<script>alert('Debe borrar los datos actuales, antes de importar nuevos datos.');window.location.href='../index.php';</script>");
	}
	//header("location: ../index.php");
} else {
	//header("location: ../index.php");
}
