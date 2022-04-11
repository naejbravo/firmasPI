<?php
require_once '../config/database.php';
/* 
	*Si la variable POST llamada nombre y la de POST llamada date, contienen algo, entonces creara variables $nombre y $fecha
	*Se hara una consulta la cual obtenga los horarios que no esten firmados evaluando el tramo con la fecha pasada por POST y la fecha del horario no corresponda con la pasada por la variable POST de acuerdo con el nombre del profesor.
	*Si esta consulta retorna alguna fila, la guardaremos en un array llamado $json.lo encapsulamos en un json y lo mostramos.

*/
if (isset($_POST['nombre']) && isset($_POST['date'])) {
	$nombre = $_POST['nombre'];
	$fecha = $_POST['date'];
	$connect = new Connect();
	$sql = "SELECT centro.horarios.id, centro.profesores.nombre, centro.profesores.id_profesor, centro.asignaturas.nombre as asignatura, centro.aulas.nombre as aula from centro.profesores inner join centro.horarios on centro.profesores.id_profesor = centro.horarios.profesor inner join centro.tramos on centro.horarios.tramo = centro.tramos.id_tramo inner join centro.asignaturas on centro.horarios.asignatura = centro.asignaturas.id_asignatura inner join centro.aulas on centro.horarios.aula = centro.aulas.id_aula where centro.tramos.dia = (SELECT dayofweek('" . $fecha . "')-1) AND centro.horarios.id not in (select centro.horarios_firmados.id_horario from centro.horarios_firmados where centro.horarios_firmados.fecha = '" . $fecha . "' AND (horarios_firmados.id_firma IS NOT NULL AND horarios_firmados.fecha_firma IS NOT NULL)) AND centro.profesores.nombre = '" . $nombre . "' GROUP BY centro.horarios.id";
	$result = mysqli_query($connect->connection(), $sql);
	if (!$result) {
		die('Query Failed' . mysqli_error($connect->connection()));
	}
	$json = array();
	while ($row = mysqli_fetch_array($result)) {
		$json[] = array(
			'id' => $row['id'],
			'profesor' => $row['nombre'],
			'asignatura' => $row['asignatura']
		);
	}
	$jsonstring = json_encode($json);
	echo $jsonstring;
}
