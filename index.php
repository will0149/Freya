<!DOCTYPE html>

<?php

    ob_start();
    require_once("controles/proyectos.php");
    require_once("controles/etapas.php");
	require_once("controles/tarea.php");
	require_once("controles/asignaciones.php");
	require_once("controles/usuario.php");
    require_once("controles/excel.php");
    require_once "controladores/NavController.php";
    require_once("controladores/controlador_usuario.php");
    require_once "Models/Model.php";
    session_start();
    NavController::plantilla();
    ob_end_flush();