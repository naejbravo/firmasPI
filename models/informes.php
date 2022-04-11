<?php
require_once('../fpdf/fpdf.php');

class PDF extends FPDF
{

    // Cabecera de página
    function Header()
    {

        // Logo
        //$this->Image('logo.png',10,8,33);
        // Arial bold 15
        $this->SetFont('Arial', 'B', 15);
        // Movernos a la derecha
        //$this->Cell(210);
        // Título
        $this->Cell(170, 10, $_POST['fecha'] . ' ' . utf8_decode($_POST['profesor']), 0, 0, 'C');
        // Salto de línea
        $this->Ln(20);
    }

    // Pie de página
    function Footer()
    {
        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Número de página
        $this->Cell(0, 10, 'Pagina ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}


require_once "../config/database.php";
/*
    *La siguiente consulta selecciona los horarios firmados y no firmados de un profesor y un dia en especifico.
    *Uno de los siguientes problemas que tengo con esta consulta, es que si muestro un horario que este firmado un dia lunes por ejemplo, lunes 2021-02-01 la consulta tambien me devuelve firmados todos los lunes de ese mes
*/

/*$sql = "SELECT centro.horarios.id, centro.profesores.nombre, centro.profesores.id_profesor, centro.asignaturas.nombre as asignatura, horarios_firmados.fecha_firma, centro.firmas.firma
    from centro.profesores inner join centro.horarios 
    on centro.profesores.id_profesor = centro.horarios.profesor inner join centro.tramos 
    on centro.horarios.tramo = centro.tramos.id_tramo inner join centro.asignaturas 
    on centro.horarios.asignatura = centro.asignaturas.id_asignatura LEFT join centro.horarios_firmados
    on centro.horarios.id = centro.horarios_firmados.id_horario INNER JOIN centro.firmas
    on centro.horarios_firmados.id_firma = centro.firmas.id_firma
    where centro.tramos.dia = (SELECT dayofweek('" . $_POST['fecha'] . "')-1) 
    AND centro.profesores.nombre = '" . $_POST['profesor'] . "'
    AND centro.horarios_firmados.fecha = '" . $_POST['fecha'] . "'
    GROUP BY centro.horarios.id";
$connect = new Connect();
$result = mysqli_query($connect->connection(), $sql);*/

$pdf = new PDF('P', 'mm', 'A4');
$pdf->SetLeftMargin(20);
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(60, 10, 'Fecha firma', 1, 0, 'C', 0);
$pdf->Cell(20, 10, "Firma", 1, 0, 'C', 0);
$pdf->Cell(90, 10, 'Asignatura', 1, 1, 'C', 0);
$pdf->SetFont('Arial', '', 10);
/*while ($row = $result->fetch_assoc()) {

    $pdf->Cell(60, 10, $row['fecha_firma'], 1, 0, 'C', 0);
    $pdf->Cell(90, 10, utf8_decode($row['asignatura']), 1, 0, 'C', 0);
    //$pdf->Cell(60,20, utf8_decode($row['profesor']),1, 0, 'C',0);
    $firmaBin = $row['firma'];
    $firmaEx = explode(',', $firmaBin, 2);
    if (!isset($firmaEx[1])) {
        $firma = null;
    } else {
        $firma = 'data://text/plain;base64,' . $firmaEx[1];
    }
    //var_dump($firmaEx);

    if ($firma == null) {
        $pdf->Cell(20, 10, "", 1, 1, 'C', 0);
    } else {
        $pdf->Cell(20, 10, $pdf->Image($firma, $pdf->GetX() + 3, $pdf->GetY(), 20, 10, 'png'), 1, 1, 'C', 0);
    }
}*/
/*$sql2 = "SELECT centro.horarios.id, centro.profesores.nombre, centro.profesores.id_profesor, centro.asignaturas.nombre as asignatura, horarios_firmados.fecha_firma, centro.firmas.firma, centro.horarios_firmados.fecha
    from centro.profesores inner join centro.horarios 
    on centro.profesores.id_profesor = centro.horarios.profesor inner join centro.tramos 
    on centro.horarios.tramo = centro.tramos.id_tramo inner join centro.asignaturas 
    on centro.horarios.asignatura = centro.asignaturas.id_asignatura LEFT join centro.horarios_firmados
    on centro.horarios.id = centro.horarios_firmados.id_horario left JOIN centro.firmas
    on centro.horarios_firmados.id_firma = centro.firmas.id_firma
    where centro.tramos.dia = (SELECT dayofweek('" . $_POST['fecha'] . "')-1) 
    AND centro.profesores.nombre = '" . $_POST['profesor'] . "'
    AND (centro.horarios_firmados.fecha_firma IS NULL or centro.horarios_firmados.fecha_firma != '" . $_POST['fecha'] . "')
    GROUP BY centro.horarios.id";*/
$sql2 = "SELECT horarios_firmados.id, horarios_firmados.fecha, horarios_firmados.id_horario, horarios_firmados.id_firma, horarios_firmados.fecha_firma, asignaturas.nombre as asignatura, profesores.nombre profesor, firmas.id_firma, firmas.firma 
FROM horarios_firmados 
LEFT JOIN horarios ON horarios_firmados.id_horario = horarios.id 
INNER JOIN asignaturas ON horarios.asignatura = asignaturas.id_asignatura 
INNER JOIN tramos ON horarios.tramo = tramos.id_tramo 
INNER JOIN profesores ON horarios.profesor = profesores.id_profesor 
LEFT JOIN firmas ON horarios_firmados.id_firma = firmas.id_firma 
WHERE fecha = '" . $_POST['fecha'] . "' 
AND profesores.nombre = '" . $_POST['profesor'] . "' 
ORDER BY tramos.id_tramo DESC";
##ORDER BY `fecha`  ASC";
$connect2 = new Connect();
$result2 = mysqli_query($connect2->connection(), $sql2);
while ($row2 = $result2->fetch_assoc()) {
    if ($row2['fecha'] == $_POST['fecha']) {
        $pdf->Cell(60, 10, $row2['fecha_firma'], 1, 0, 'C', 0);

        //$pdf->Cell(60,20, utf8_decode($row['profesor']),1, 0, 'C',0);
        $firmaBin = $row2['firma'];
        $firmaEx = explode(',', $firmaBin, 2);
        if (!isset($firmaEx[1])) {
            $firma = null;
        } else {
            $firma = 'data://text/plain;base64,' . $firmaEx[1];
        }
        //var_dump($firmaEx);

        if ($firma == null) {
            $pdf->Cell(20, 10, "", 1, 0, 'C', 0);
        } else {
            $pdf->Cell(20, 10, $pdf->Image($firma, $pdf->GetX() + 3, $pdf->GetY(), 20, 10, 'png'), 1, 0, 'C', 0);
        }
        $pdf->Cell(90, 10, utf8_decode($row2['asignatura']), 1, 1, 'C', 0);
    } else {
        $pdf->Cell(60, 10, '', 1, 0, 'C', 0);
        $pdf->Cell(20, 10, "", 1, 0, 'C', 0);
        $pdf->Cell(90, 10, utf8_decode($row2['asignatura']), 1, 1, 'C', 0);
    }
}

$pdf->Output('file.pdf', 'I');
$pdf->Output();
