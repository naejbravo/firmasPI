<?php
require_once "../config/database.php";
$sql = "SELECT profesores.nombre, profesores.id_profesor as profesorId, (
	SELECT GROUP_CONCAT(horarios_firmados.fecha SEPARATOR '\n') 
    FROM profesores 
    INNER JOIN horarios ON profesores.id_profesor = horarios.profesor 
    INNER JOIN horarios_firmados ON horarios.id = horarios_firmados.id_horario 
    INNER JOIN asignaturas ON horarios.asignatura = asignaturas.id_asignatura 
    WHERE month(horarios_firmados.fecha) = " . date('m', strtotime($_POST['mes2'])) . " 
    AND (horarios_firmados.id_firma IS NULL AND horarios_firmados.fecha_firma IS NULL) 
    AND profesores.id_profesor = profesorId
) as fecha
FROM profesores";
$connect = new Connect();
$result = mysqli_query($connect->connection(), $sql);
while ($row = $result->fetch_assoc()) {
    echo  $row['nombre'] . " - " . $row['fecha'] . "<br>";
}
