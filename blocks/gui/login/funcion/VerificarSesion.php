<?php

include_once ("core/auth/SesionOneLogin.class.php");

class VerificarSesion {
	var $miSesionSso;

	function __construct() {
		$this->miSesionSso = \SesionOneLogin::singleton();
	}

	function procesarFormulario() {
		echo "verificando sesion abierta";
		exit;
		$respuesta = $this->miSesionSso->verificarSesionAbierta();
		return $respuesta;
	}
}

$miProcesador = new VerificarSesion ();
$respuesta = $miProcesador->procesarFormulario();
?>
