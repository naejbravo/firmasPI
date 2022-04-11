<?php
require_once '../config/database.php';
$connect = new Connect();

$sql = "select centro.horarios.id, centro.profesores.nombre, centro.profesores.id_profesor, centro.asignaturas.nombre as asignatura, centro.aulas.nombre as aula from centro.profesores inner join centro.horarios on centro.profesores.id_profesor = centro.horarios.profesor inner join centro.tramos on centro.horarios.tramo = centro.tramos.id_tramo inner join centro.asignaturas on centro.horarios.asignatura = centro.asignaturas.id_asignatura inner join centro.aulas on centro.horarios.aula = centro.aulas.id_aula where centro.tramos.dia = (SELECT dayofweek(curdate())-1) AND centro.horarios.id not in (select centro.horarios_firmados.id_horario from centro.horarios_firmados where centro.horarios_firmados.fecha = curdate()) GROUP BY centro.horarios.id";
$result = mysqli_query($connect->connection(), $sql);
if (!$result) {
	die('Query Failed' . mysqli_error($connect->connection()));
}
$SinFirmar = array();
while ($row = mysqli_fetch_array($result)) {
	$SinFirmar[] = array(
		'id' => $row['id'],
		'nombre' => $row['nombre'],
		'asignatura' => $row['asignatura'],
		'aula' => $row['aula']
	);
}
$sql2 = "DELETE FROM horarios_no_firmados WHERE fecha = curdate()";
mysqli_query($connect->connection(), $sql2);


foreach ($SinFirmar as $dato) {
	$sql = "INSERT INTO horarios_no_firmados (id_horario, fecha, nombre_profesor, asignatura) VALUES (" . $dato['id'] . ", curdate(), '" . $dato['nombre'] . "', '" . $dato['asignatura'] . "')";
	mysqli_query($connect->connection(), $sql);
}
