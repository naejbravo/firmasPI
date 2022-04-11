<?php
require_once '../models/ModelLogout.php';
//Crea instancia de la clase Logout() y ejecuta su metodo logout(), ademas al final enseña un alert indicando que se ha cerrado la sesion
$salir = new Logout();
$salir->logout();
echo ("<script>window.location.href='../index.php';</script>");
