<?php
require_once '../models/ModelXml.php';
//Crea una nueva instancia de la clase Xml(), siguiente ejecuta el metodo Import() con un parametro que es la direccion donde se almacena el fichero xml
$import = new Xml();
$import->Import('../uploads/horario.xml');
