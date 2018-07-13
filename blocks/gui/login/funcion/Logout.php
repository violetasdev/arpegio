<?php

include_once ("core/auth/SesionOneLogin.class.php");

class Logout {

	var $miSesionSso;

	function __construct() {
		$this->miSesionSso = \SesionOneLogin::singleton ();
	}
	function procesarFormulario() {
		return $this->miSesionSso->terminarSesion();
	}
}

$miProcesador = new Logout ();
$miProcesador->procesarFormulario();
?>
