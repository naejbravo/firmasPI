<?php
require_once '../config/database.php';

/*
	*Guardamos en variables los resultados de POST
	*Se hace un json_decode con los que necesitemos.
	*Creamos una consulta la cual inserta en la tabla firmas, la imagen de la firma
	*Luego hacemos un bucle el cual vaya recorriendo y por cada vuelta haga un insert en la tabla horarios_firmados, en el cual insertara la fecha, id del horario, id de la firma y hora y fecha en la que se firmo

*/
$connect = new Connect();
$data = $_POST['result'];
$data2 = $_POST['result2'];
$data3 = $_POST['result3'];
$data = json_decode("$data", true);
$data2 = json_decode("$data2", true);

$sql = "INSERT INTO firmas (firma) VALUES ('" . $data2 . "')";
$result = mysqli_query($connect->connection(), $sql);

foreach ($data as $dato) {
	/*$sql = "INSERT INTO horarios_firmados (fecha, id_horario, id_firma, fecha_firma) VALUES ('" . $data3 . "', " . $dato['id'] . ", (SELECT id_firma FROM firmas where firma = '" . $data2 . "'), current_timestamp)";*/
	$sql = "UPDATE horarios_firmados SET id_firma = (SELECT id_firma FROM firmas WHERE firma = '" . $data2 . "'), fecha_firma = current_timestamp WHERE fecha = '" . $data3 . "' AND id_horario = " . $dato['id'] . "";
	mysqli_multi_query($connect->connection(), $sql);
	var_dump(mysqli_error($connect->connection()));
}
