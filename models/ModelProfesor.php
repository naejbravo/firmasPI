<?php
require_once '../config/database.php';
$connect = new Connect();
// Consulta que selecciona todos los profesores que tienen horarios en el tramo actual
$sql = "select centro.horarios.id, centro.profesores.nombre, centro.profesores.id_profesor from centro.profesores inner join centro.horarios on centro.profesores.id_profesor = centro.horarios.profesor inner join centro.tramos on centro.horarios.tramo = centro.tramos.id_tramo where centro.tramos.dia = (SELECT dayofweek(curdate())-1) GROUP BY centro.profesores.nombre order by centro.profesores.nombre";
$result = mysqli_query($connect->connection(), $sql);
if (!$result) {
	die('Query Failed' . mysqli_error($connect->connection()));
}
// Creacion de un array para almacenar los datos de la consulta anterior
$json = array();
while ($row = mysqli_fetch_array($result)) {
	$json[] = array(
		'nombre' => $row['nombre'],
		'id' => $row['id'],
		'id_profesor' => $row['id_profesor']
	);
}
// Encapsulamos los datos en un json y los mostramos
$jsonstring = json_encode($json);
echo $jsonstring;
