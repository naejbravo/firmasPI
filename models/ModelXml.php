<?php

require_once '../config/database.php';
/*
    *Crea la clase Xml, a su vez esta contiene una funcion llamada Import(), la cual se le pasa un parametro $xml que es la direccion del xml. 
    *Si el fichero xml no existe, muestra un alert diciendo que no existe en el directorio y retorna a index.php
    *En caso de que exista el fichero, se usara la funcion simplexml_load_files con el parametro de la ruta de nuestro xml, esto es para poder recorrer el fichero xml y sustraer los datos que nos interese
    *Al recorrer cada nodo, se va insertando los datos sustraidos en la base de datos
    *Si el resultado es correcto y no hay ningun tipo de error mostrara un mensaje, si hay algun error mostrara mensaje correspondiente. Sea cual sea el resultado luego del mensaje retornara a index.php

*/

class Xml
{
    public function Import($xml)
    {
        $connect = new Connect();

        if (!file_exists($xml)) {
            //echo ("<script>alert('El fichero xml no existe en el directorio uploads.');window.location.href='../index.php';</script>");
        } else {
            $xmldata = simplexml_load_file($xml);

            foreach ($xmldata->children() as $data) {

                foreach ($data->ASIGNATURAS as $asignatura) {
                    foreach ($asignatura->ASIGNATURA as $num_int_as) {
                        $num = $num_int_as['num_int_as'];
                        $nombre = $num_int_as['nombre'];
                        $sql = "INSERT INTO asignaturas(id_asignatura, nombre) VALUES ('" . $num . "','" . $nombre . "')";
                        $result = mysqli_query($connect->connection(), $sql);
                    }
                }
                foreach ($data->GRUPOS as $grupo) {
                    foreach ($grupo->GRUPO as $num_int_gr) {
                        $num = $num_int_gr['num_int_gr'];
                        $nombre = $num_int_gr['nombre'];
                        $sql = "INSERT INTO grupos(id_grupo, nombre) VALUES ('" . $num . "','" . $nombre . "')";
                        $result = mysqli_query($connect->connection(), $sql);
                    }
                }
                foreach ($data->AULAS as $aula) {
                    foreach ($aula->AULA as $num_int_au) {
                        $num = $num_int_au['num_int_au'];
                        $nombre = $num_int_au['nombre'];
                        $sql = "INSERT INTO aulas(id_aula, nombre) VALUES ('" . $num . "','" . $nombre . "')";
                        $result = mysqli_query($connect->connection(), $sql);
                    }
                }
                foreach ($data->PROFESORES as $profesor) {
                    foreach ($profesor->PROFESOR as $num_int_pr) {
                        $num = $num_int_pr['num_int_pr'];
                        $nombre = $num_int_pr['nombre'];
                        $sql = "INSERT INTO profesores(id_profesor, nombre) VALUES ('" . $num . "','" . $nombre . "')";
                        $result = mysqli_query($connect->connection(), $sql);
                    }
                }
                foreach ($data->TRAMOS_HORARIOS as $tramo) {
                    foreach ($tramo->TRAMO as $num_int_tr) {
                        $num = $num_int_tr['num_tr'];
                        $num_dia = $num_int_tr['numero_dia'];
                        $hor_ini = $num_int_tr['hora_inicio'];
                        $hor_fin = $num_int_tr['hora_final'];
                        $sql = "INSERT INTO tramos(id_tramo, dia, hora_inicio, hora_final) VALUES ('" . $num . "','" . $num_dia . "', '" . $hor_ini . "', '" . $hor_fin . "')";
                        $result = mysqli_query($connect->connection(), $sql);
                    }
                }
                $c = 0;
                foreach ($data->HORARIOS_PROFESORES as $horario_profesor) {
                    foreach ($horario_profesor->HORARIO_PROF as $horario_prof) {
                        foreach ($horario_prof->ACTIVIDAD as $actividad) {
                            $num = $horario_prof['hor_num_int_pr'];
                            $aula = $actividad['aula'];
                            $asignatura = $actividad['asignatura'];
                            $tramo = $actividad['tramo'];
                            $grupo1 = $actividad->GRUPOS_ACTIVIDAD['grupo_1'];
                            $grupo2 = $actividad->GRUPOS_ACTIVIDAD['grupo_2'];
                            $grupo3 = $actividad->GRUPOS_ACTIVIDAD['grupo_3'];
                            $grupo4 = $actividad->GRUPOS_ACTIVIDAD['grupo_4'];
                            $grupo5 = $actividad->GRUPOS_ACTIVIDAD['grupo_5'];
                            $grupo6 = $actividad->GRUPOS_ACTIVIDAD['grupo_6'];
                            $c++;

                            $sql = "INSERT INTO horarios(id, profesor, aula, asignatura, tramo, grupo1, grupo2, grupo3, grupo4, grupo5, grupo6) VALUES ('" . $c . "','" . $num . "','" . $aula . "','" . $asignatura . "','" . $tramo . "','" . $grupo1 . "','" . $grupo2 . "','" . $grupo3 . "','" . $grupo4 . "','" . $grupo5 . "','" . $grupo6 . "')";
                            $result = mysqli_query($connect->connection(), $sql);
                        }
                    }
                }
            }
            if (isset($result) && mysqli_errno($connect->connection()) == 0) {
                //echo ("<script>alert('Se han importado los datos correctamente.');window.location.href='../index.php';</script>");
            } else {
                unlink("../uploads/horario.xml");
                echo ("<script>alert('Ha ocurrido un error al importar los datos.');window.location.href='../index.php';</script>");
            }
        }
    }
}
