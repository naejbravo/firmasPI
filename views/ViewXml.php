<?php
session_start();
if (isset($_SESSION['id'])) {
	require_once '../controllers/ControllerXml.php';
} else {
	header("location: ../index.php");
}
