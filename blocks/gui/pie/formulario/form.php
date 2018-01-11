<?php

namespace gui\pie\formulario;

if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}
class FormularioMenuUsuario {
	var $miConfigurador;
	var $lenguaje;
	var $miFormulario;
	var $miSql;
	var $atributosMenu;
	function __construct($lenguaje, $formulario, $sql) {
		$this->miConfigurador = \Configurador::singleton ();

		$this->miConfigurador->fabricaConexiones->setRecursoDB ( 'principal' );

		$this->lenguaje = $lenguaje;

		$this->miFormulario = $formulario;

		$this->miSql = $sql;
	}
	function formulario() {

		// Rescatar los datos de este bloque
		$esteBloque = $this->miConfigurador->getVariableConfiguracion ( "esteBloque" );
		$miPaginaActual = $this->miConfigurador->getVariableConfiguracion ( 'pagina' );

		$directorio = $this->miConfigurador->getVariableConfiguracion ( "host" );
		$directorio .= $this->miConfigurador->getVariableConfiguracion ( "site" ) . "/index.php?";
		$directorio .= $this->miConfigurador->getVariableConfiguracion ( "enlace" );

		$rutaBloque = $this->miConfigurador->getVariableConfiguracion ( "host" );
		$rutaBloque .= $this->miConfigurador->getVariableConfiguracion ( "site" ) . "/blocks/";
		$rutaBloque .= $esteBloque ['grupo'] . '/' . $esteBloque ['nombre'];
		/**
		 * IMPORTANTE: Este formulario está utilizando jquery.
		 * Por tanto en el archivo ready.php se delaran algunas funciones js
		 * que lo complementan.
		 */

		// Rescatar los datos de este bloque
		$esteBloque = $this->miConfigurador->getVariableConfiguracion ( "esteBloque" );

		// ---------------- SECCION: Parámetros Globales del Formulario ----------------------------------
		/**
		 * Atributos que deben ser aplicados a todos los controles de este formulario.
		 * Se utiliza un arreglo
		 * independiente debido a que los atributos individuales se reinician cada vez que se declara un campo.
		 *
		 * Si se utiliza esta técnica es necesario realizar un mezcla entre este arreglo y el específico en cada control:
		 * $atributos= array_merge($atributos,$atributosGlobales);
		 */
		$atributosGlobales ['campoSeguro'] = 'true';
		$_REQUEST ['tiempo'] = time ();

		// -------------------------------------------------------------------------------------------------

		// ---------------- SECCION: Parámetros Generales del Formulario ----------------------------------
		$esteCampo = $esteBloque ['nombre'];
		$atributos ['id'] = $esteCampo;
		$atributos ['nombre'] = $esteCampo;
		/**
		 * Nuevo a partir de la versión 1.0.0.2, se utiliza para crear de manera rápida el js asociado a
		 * validationEngine.
		 */
		// Si no se coloca, entonces toma el valor predeterminado 'application/x-www-form-urlencoded'
		$atributos ['tipoFormulario'] = 'multipart/form-data';

		// Si no se coloca, entonces toma el valor predeterminado 'POST'
		$atributos ['metodo'] = 'POST';

		// Si no se coloca, entonces toma el valor predeterminado 'index.php' (Recomendado)
		$atributos ['action'] = 'index.php';
		$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo );

		// Si no se coloca, entonces toma el valor predeterminado.
		$atributos ['estilo'] = '';
		$atributos ['marco'] = true;
		$tab = 1;
		// ---------------- FIN SECCION: de Parámetros Generales del Formulario ----------------------------

		$conexion = "estructura";
		$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );

		// ----------------INICIAR EL FORMULARIO ------------------------------------------------------------
		$atributos ['tipoEtiqueta'] = 'inicio';
		// $atributos = array_merge ( $atributos, $atributosGlobales );
		echo $this->miFormulario->formulario ( $atributos );
		unset ( $atributos );
		// ---------------- SECCION: Controles del Formulario -----------------------------------------------


		$url = $this->miConfigurador->configuracion ['host'] . $this->miConfigurador->configuracion ['site'];
		echo '

		<div class="footer">

      <div class="contactar">
					<h4>¿No encontraste lo que buscabas?</h4>
       		<h3>Contactar un agente</h3>

     					<ul class="contacto-list">
							<i class="fa fa-handshake-o" aria-hidden="true"></i>

							<li class="red-item"> <a target="_blank" href="https://es-la.facebook.com/LanixColombia/"><i class="fa fa-handshake-o fa-lg" aria-hidden="true"></i></a></li>
							<li class="contacto-item"> <a target="_blank" href="https://soporte.lanix.co/hc/es/requests/new"><i class="fa fa-handshake fa-lg" aria-hidden="true"></i></a></li>
							</ul>

    	</div>

				<div class="nav-redes">
						<ul class="red-list">
								<li class="red-item"> <a target="_blank" href="https://es-la.facebook.com/LanixColombia/"><i class="fa fa-facebook fa-lg" aria-hidden="true"></i></a></li>
			 					<li class="red-item"><a target="_blank" href="https://twitter.com/lanixcolombia"> <i class="fa fa-twitter  fa-lg" aria-hidden="true"></i></a></li>
			 					<li class="red-item"><a target="_blank" href="https://www.youtube.com/LanixColombia"> <i class="fa fa-youtube-play  fa-lg" aria-hidden="true"></i></a></li>
								</ul>
					</div>
				<div class="footer-inner">
					<div class="nav-img">
							<img height="50px" src="'.$url.'/blocks/gui/pie/css/imagenes/pie.png">
					</div>
			 	</div>
		</div>';

		// ------------------- SECCION: Paso de variables ------------------------------------------------

		/**
		 * En algunas ocasiones es útil pasar variables entre las diferentes páginas.
		 * SARA permite realizar esto a través de tres
		 * mecanismos:
		 * (a). Registrando las variables como variables de sesión. Estarán disponibles durante toda la sesión de usuario. Requiere acceso a
		 * la base de datos.
		 * (b). Incluirlas de manera codificada como campos de los formularios. Para ello se utiliza un campo especial denominado
		 * formsara, cuyo valor será una cadena codificada que contiene las variables.
		 * (c) a través de campos ocultos en los formularios. (deprecated)
		 */

		// En este formulario se utiliza el mecanismo (b) para pasar las siguientes variables:

		// Paso 1: crear el listado de variables

		$valorCodificado = "actionBloque=" . $esteBloque ["nombre"];
		$valorCodificado .= "&pagina=" . $this->miConfigurador->getVariableConfiguracion ( 'pagina' );
		$valorCodificado .= "&bloque=" . $esteBloque ['nombre'];
		$valorCodificado .= "&bloqueGrupo=" . $esteBloque ["grupo"];
		$valorCodificado .= "&opcion=registrarBloque";
		/**
		 * SARA permite que los nombres de los campos sean dinámicos.
		 * Para ello utiliza la hora en que es creado el formulario para
		 * codificar el nombre de cada campo.
		 */
		$valorCodificado .= "&campoSeguro=" . $_REQUEST ['tiempo'];
		$valorCodificado .= "&tiempo=" . time ();
		// Paso 2: codificar la cadena resultante
		$valorCodificado = $this->miConfigurador->fabricaConexiones->crypto->codificar ( $valorCodificado );

		$atributos ["id"] = "formSaraData"; // No cambiar este nombre
		$atributos ["tipo"] = "hidden";
		$atributos ['estilo'] = '';
		$atributos ["obligatorio"] = false;
		$atributos ['marco'] = true;
		$atributos ["etiqueta"] = "";
		$atributos ["valor"] = $valorCodificado;
		echo $this->miFormulario->campoCuadroTexto ( $atributos );
		unset ( $atributos );

		// ----------------FIN SECCION: Paso de variables -------------------------------------------------

		// ---------------- FIN SECCION: Controles del Formulario -------------------------------------------

		// ----------------FINALIZAR EL FORMULARIO ----------------------------------------------------------
		// Se debe declarar el mismo atributo de marco con que se inició el formulario.
		$atributos ['marco'] = true;
		$atributos ['tipoEtiqueta'] = 'fin';
		echo $this->miFormulario->formulario ( $atributos );
	}
		}

$miFormulario = new FormularioMenuUsuario ( $this->lenguaje, $this->miFormulario, $this->sql );

$miFormulario->formulario ();

?>
