<?php
require_once '../config/database.php';
/*
	*Crea una variable con el POST de nombre valor
	*Crea una consulta que selecciona los profesores con nombre que comienze o termine por la variable $valor
	*Crea la variable $html y en ella va escribiendo un option, el cual trae el value que es el nombre del profesor y el texto sera el id del profesor
	*Por ultimo mostramos esa variable $html
*/
$valor = $_POST['valor'];
$connect = new Connect();
$sql = "SELECT * FROM profesores where nombre LIKE '%" . $valor . "%'";
$result = mysqli_query($connect->connection(), $sql);
if (!$result) {
	die('Query Failed' . mysqli_error($connect->connection()));
}
$html = "";
while ($row = mysqli_fetch_array($result)) {
	$html .= "<option id='' value='" . $row['nombre'] . "'>" . $row['id_profesor'] . "</option>";
}

echo $html;
