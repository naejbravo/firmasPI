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
        $this->Cell(160, 10, "Horarios sin firmar - " . $_POST['mes2'], 0, 0, 'C');
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

//$nombre = $_POST['nombre'];
require_once "../config/database.php";
$nose = date("m", strtotime($_POST["mes2"]));
$i = 0;

//require_once('./ModelVariables.php');
/*$sql = 'SELECT profesores.nombre, profesores.id_profesor as profesorId, (
	SELECT GROUP_CONCAT(concat(horarios_firmados.fecha, " - ", asignaturas.nombre) SEPARATOR "\n")
    FROM profesores 
    INNER JOIN horarios ON profesores.id_profesor = horarios.profesor 
    INNER JOIN horarios_firmados ON horarios.id = horarios_firmados.id_horario 
    INNER JOIN asignaturas ON horarios.asignatura = asignaturas.id_asignatura 
    WHERE month(horarios_firmados.fecha) = ' . $nose . '
    AND (horarios_firmados.id_firma IS NULL AND horarios_firmados.fecha_firma IS NULL) 
    AND profesores.id_profesor = profesorId
    ORDER BY fecha
) as fecha
FROM profesores
WHERE profesores.id_profesor != 1';*/
$sql = 'SELECT DISTINCT profesores.nombre, profesores.id_profesor as profesorId, horarios_firmados.fecha
    FROM profesores 
    INNER JOIN horarios ON profesores.id_profesor = horarios.profesor
    INNER JOIN horarios_firmados ON horarios.id = horarios_firmados.id_horario 
    WHERE month(horarios_firmados.fecha) = ' . $nose . '
    AND (horarios_firmados.id_firma IS NULL AND horarios_firmados.fecha_firma IS NULL) 
    AND horarios.profesor = profesores.id_profesor
    AND profesores.id_profesor != 1
    ORDER BY profesores.nombre, horarios_firmados.fecha';

$connect = new Connect();
$result = mysqli_query($connect->connection(), $sql);


$pdf = new PDF('P', 'mm', 'A4');
$pdf->SetLeftMargin(25);
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 10);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(80, 10, 'Profesor', 1, 0, 'C', 0);
$pdf->Cell(80, 10, 'Fecha - Asignatura', 1, 1, 'C', 0);
$pdf->SetFont('Arial', '', 10);
$profesor = 1;
while ($row = $result->fetch_assoc()) {
    //$pdf->Cell(40,20, $row['id'],1, 0, 'C',0);
    //$pdf->Cell(60,20, $_POST['fecha3'],1, 0, 'C',0);
    $profesor2 = $row['profesorId'];
    if ($profesor != 1 && $profesor != $profesor2) {
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(80, 10, 'Profesor', 1, 0, 'C', 0);
        $pdf->Cell(80, 10, 'Fecha - Asignatura', 1, 1, 'C', 0);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(80, 10, utf8_decode($row['nombre']), 1, 0, 'C');
    } else {
        if ($profesor == 1) {
            $pdf->Cell(80, 10, utf8_decode($row['nombre']), 1, 0, 'C');
        } else {
            $pdf->Cell(80, 10, "", 1, 0, 'C');
        }
    }
    $profesor = $profesor2;
    //$pdf->Cell(80, 10, utf8_decode($row['nombre']), 1, 0, 'C');

    $pdf->MultiCell(80, 10, utf8_decode($row['fecha']), 1, 'C');

    //$pdf->Cell(60,20, utf8_decode($row['profesor']),1, 0, 'C',0);
}



$pdf->Output('file.pdf', 'I');
$pdf->Output();
