<?php
require_once '../config/database.php';

/* 
	*Si la variable POST llamada idProfesor existe, entonces creamos una consulta en la cual seleccionamos los horarios que no esten firmados de es profesor.
	*Si retorna alguna fila la guardamos en un array y la encapsulamos en json. Posteriormente la mostramos.

*/

if (isset($_POST['idProfesor'])) {
	$id = $_POST['idProfesor'];
	$connect = new Connect();
	$sql = "select centro.horarios.id, centro.asignaturas.nombre as asignatura, centro.aulas.nombre as aula, centro.tramos.hora_inicio as inicio, centro.tramos.hora_final as final from centro.profesores inner join centro.horarios on centro.profesores.id_profesor = centro.horarios.profesor inner join centro.tramos on centro.horarios.tramo = centro.tramos.id_tramo inner join centro.asignaturas on centro.horarios.asignatura = centro.asignaturas.id_asignatura inner join centro.aulas on centro.horarios.aula = centro.aulas.id_aula  where centro.profesores.id_profesor = " . $id . " AND centro.tramos.dia = (SELECT dayofweek(curdate())-1) AND centro.horarios.id not in (select centro.horarios_firmados.id_horario from centro.horarios_firmados where centro.horarios_firmados.fecha = curdate() AND (horarios_firmados.id_firma IS NOT NULL AND horarios_firmados.fecha_firma IS NOT NULL)) GROUP BY centro.horarios.id";
	$result = mysqli_query($connect->connection(), $sql);
	if (!$result) {
		die('Query Failed' . mysqli_error($connect->connection()));
	}
	$json = array();
	while ($row = mysqli_fetch_array($result)) {
		$json[] = array(
			'id' => $row['id'],
			'asignatura' => $row['asignatura'],
			'aula' => $row['aula'],
			'inicio' => $row['inicio'],
			'final' => $row['final']
		);
	}
	$jsonstring = json_encode($json);
	echo $jsonstring;
}
