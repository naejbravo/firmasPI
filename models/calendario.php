<?php
require_once '../config/database.php';
$sql = "SELECT calendar.calendar_date FROM calendar";
$connect = new Connect();
$result = mysqli_query($connect->connection(), $sql);
$array = array();
while ($row = mysqli_fetch_array($result)) {
    $array[] = array(
        'fecha' => $row['calendar_date']
    );
}
$i = 0;

$lunes = 0;
while ($i <= count($array) - 1) {
    //while (){
    //echo implode($array[$i]);
    $weekday = (date('w', strtotime(implode($array[$i]))) + 1) - 1;
    $sql2 = "SELECT horarios.id FROM horarios INNER JOIN tramos ON horarios.tramo = tramos.id_tramo WHERE tramos.dia = $weekday";
    $connect2 = new Connect();
    $result2 = mysqli_query($connect2->connection(), $sql2);
    while ($row2 = mysqli_fetch_assoc($result2)) {
        switch ($weekday) {
            case '1':
                # code..
                $sql3 = "INSERT INTO horarios_firmados (fecha, id_horario) VALUES ('" . implode($array[$i]) . "', " . $row2['id'] . ")";
                mysqli_query($connect->connection(), $sql3);
                //echo $weekday . " - " . implode($array[$i]) . " - " . $row2['id'];
                //echo "<br>";
                $lunes++;


                break;
            case '2':
                # code...


                $sql4 = "INSERT INTO horarios_firmados (fecha, id_horario) VALUES ('" . implode($array[$i]) . "', " . $row2['id'] . ")";
                mysqli_query($connect->connection(), $sql4);
                //echo $weekday . " - " . implode($array[$i]) . " - " . $row2['id'];
                //echo "<br>";
                $lunes++;


                break;
            case '3':
                # code...


                $sql5 = "INSERT INTO horarios_firmados (fecha, id_horario) VALUES ('" . implode($array[$i]) . "', " . $row2['id'] . ")";
                mysqli_query($connect->connection(), $sql5);
                //echo $weekday . " - " . implode($array[$i]) . " - " . $row2['id'];
                //echo "<br>";
                $lunes++;


                break;
            case '4':
                # code...

                $sql6 = "INSERT INTO horarios_firmados (fecha, id_horario) VALUES ('" . implode($array[$i]) . "', " . $row2['id'] . ")";
                mysqli_query($connect->connection(), $sql6);
                //echo $weekday . " - " . implode($array[$i]) . " - " . $row2['id'];
                //echo "<br>";
                $lunes++;


                break;
            case '5':
                # code...

                $sql7 = "INSERT INTO horarios_firmados (fecha, id_horario) VALUES ('" . implode($array[$i]) . "', " . $row2['id'] . ")";
                mysqli_query($connect->connection(), $sql7);
                //echo $weekday . " - " . implode($array[$i]) . " - " . $row2['id'];
                //echo "<br>";
                $lunes++;


                break;
        }
    }



    //}
    $i++;
}
echo ("<script>alert('Datos importados correctamente.');window.location.href='../index.php';</script>");
