<?php
session_start();

require_once ('plugin/onelogin/_toolkit_loader.php');

//require_once ('plugin/onelogin/demo1/index.php');


class SesionOneLogin {

	private static $instancia;

	var $miSql;
	var $site;
	var $configurador;
	var $authnRequest;
	var $sesionUsuario;
	var $sesionUsuarioId;

	/**
	*
	* @name sesiones
	*       constructor
	*/
	//private
	function __construct() {


		$this->sesionUsuario = Sesion::singleton ();
		$this->configurador = \Configurador::singleton ();
		$this->site = $this->configurador->getVariableConfiguracion( 'site' );

		$this->spBaseUrl=$this->configurador->getVariableConfiguracion('spBaseUrl');
		$this->spEntityId=$this->configurador->getVariableConfiguracion('spEntityId');
		$this->spAssertionConsumerService=$this->configurador->getVariableConfiguracion('spAssertionConsumerService');
		$this->spSingleLogoutService=$this->configurador->getVariableConfiguracion('spSingleLogoutService');

		$this->idpEntityId=$this->configurador->getVariableConfiguracion('idpEntityId');
		$this->idpSingleSingOnService=$this->configurador->getVariableConfiguracion('idpSingleSingOnService');
		$this->idpSingleLogoutService=$this->configurador->getVariableConfiguracion('idpSingleLogoutService');
		$this->idpx509cert=$this->configurador->getVariableConfiguracion('idpx509cert');

		$settingsInfo=array (
			'sp' => array (
				'entityId' => $this->spBaseUrl.	$this->spEntityId,
				'assertionConsumerService' => array (
					'url' => $this->spBaseUrl.$this->spAssertionConsumerService,
				),
				'singleLogoutService' => array (
					'url' => $this->spBaseUrl.	$this->spSingleLogoutService,
				),
				'NameIDFormat' => 'urn:oasis:names:tc:SAML:1.1:nameid-format:emailAddress',
			),
			'idp' => array (
				'entityId' => $this->idpEntityId,
				'singleSignOnService' => array (
					'url' =>$this->idpSingleSingOnService,
				),
				'singleLogoutService' => array (
					'url' => $this->idpSingleLogoutService,
				),
				'x509cert' =>$this->idpx509cert));
				$this->authnRequest = new OneLogin_Saml2_Auth($settingsInfo);
			}

			public static function singleton() {

				if (!isset(self::$instancia)) {
					$className = __CLASS__;
					self::$instancia = new $className ();
				}
				return self::$instancia;
			}

			/**
			*
			* @name sesiones Verifica la existencia de una sesion válida en la máquina del cliente
			* @param
			*            string nombre_db
			* @return void
			* @access public
			*/
			function verificarSesion($pagina) {

				$resultado = true;
				// Se eliminan las sesiones expiradas
				//$this->borrarSesionExpirada();
				if($this->verificarSesionAbierta()){

					echo "estamos en verificar sesion abierta";
					exit;
					$resultado = $this->getParametrosSesionAbierta();
				} else {

					$resultado = $this->crearSesion();

				}
				$resultado = $this->verificarRolesPagina($resultado['perfil'],$pagina);//Se verifica que la página pertenezca al perfil
				// Si no tiene acceso a alguna página, se desloguea de OneLogin
				if($resultado==false){
					$this->terminarSesion();
				}
				return $resultado;
			}

			/* Fin de la función numero_sesion */


			function verificarSesionAbierta() {
				$respuesta = true;
				//La sesión SP está abierta
				if($this->authnRequest->isAuthenticated()){
					//La sesión SP abierta pero usuario no ha iniciado sesión SP en SARA
					if($this->sesionUsuario->numeroSesion()==''){
						$this->crearSesion();
					}
				} else {
					$respuesta = false;
				}
				return $respuesta;
			}

			function getParametrosSesionAbierta() {
				return $this->authnRequest->getAttributes();
			}

			/**
			* @METHOD crear_sesion
			*
			* Crea una nueva sesión en la base de datos.
			* @PARAM usuario_aplicativo
			* @PARAM nivel_acceso
			* @PARAM expiracion
			* @PARAM conexion_id
			*
			* @return boolean
			* @access public
			*/
			function crearSesion() {

				$url = $this->configurador->getVariableConfiguracion("host");
				$url .= $this->configurador->getVariableConfiguracion("site");
				$url .= "/index.php?";

				$valorCodificado = "pagina=indexAdm";
				$valorCodificado.="&AuthNRequestID=".$this->authnRequest->getLastRequestID();

				$enlace = $this->configurador->getVariableConfiguracion("enlace");
				$cadena = $this->configurador->fabricaConexiones->crypto->codificar_url($valorCodificado, $enlace);
				$urlFinal = $url . $cadena;

				$aplication_base_url =$urlFinal;

				//En este caso se va al index, podría irse a la página desde donde lo solicitaron.
				$login_params = array (
					'ReturnTo' => $aplication_base_url
				);

				$this->authnRequest->login($aplication_base_url);
				$_REQUEST['AuthNRequestID'] = 	$this->authnRequest->getLastRequestID();
   			$_SESSION['AuthNRequestID'] = 	$this->authnRequest->getLastRequestID();


/*				$ssoBuiltUrl = 	$this->authnRequest->login(null, array(), false, false, true);
				echo 	$this->authnRequest->getLastRequestID();
				$_REQUEST['AuthNRequestID'] = 	$this->authnRequest->getLastRequestID();

				$_SESSION['AuthNRequestID'] = 	$this->authnRequest->getLastRequestID();

		     header('Pragma: no-cache');
		     header('Cache-Control: no-cache, must-revalidate');
		     header('Location: ' . $ssoBuiltUrl);
		     exit();

*/

				$atributos = $this->authnRequest->getAttributes();

				return $atributos;
			}

			// Fin del método crear_sesion

			/**
			* @METHOD registrar_sesion
			*
			* Registrar una sesión en la base de datos.
			* @PARAM usuario_aplicativo
			* @PARAM nivel_acceso
			* @PARAM expiracion
			* @PARAM conexion_id
			*
			* @return boolean
			* @access public
			*/
			function registrarSesion() {
				//Obtener datos de la sesion de OneLogin
				$usuarioId=$_SESSION['samlNameId'];

				echo "<<<". $this->authnRequest->getLastRequestID();
				exit;

					// 1. Identificador de sesion
				$this->fecha = explode(" ", microtime());
				$this->sesionId = $_SESSION['samlSessionIndex'];


				    if (!$this->authnRequest->isAuthenticated()) {
				        echo "<p>Not authenticated</p>";
				        exit();
				    }

var_dump($_SESSION);
				if (!empty($this->sesionId)) {
echo "valido";
					exit;
						/**
						 * Borra todas las sesiones que existan con el id del computador
						 */
						/* Actualizar la cookie, la sesión tiene un tiempo de 1 hora */

						$this->sesionExpiracion = time() + $this->tiempoExpiracion * 60;
						setcookie(self::APLICATIVO, $this->sesionId, $this->sesionExpiracion, "/");

						// Insertar id_usuario
						$this->resultado = $this->guardarValorSesion('idUsuario', $usuarioId, $this->sesionId, $this->sesionExpiracion);
						if ($this->resultado) {
								return $this->sesionId;
						}
				}
				echo "no valido";
									exit;

				return $atributos;

echo "termina crear sesion";
				exit;
			}

			// Fin del método crear_sesion

			/**
	     * @METHOD guardarValorSesion
	     * @PARAM variable
	     * @PARAM valor
	     *
	     * @return boolean
	     * @access public
	     */
	    function guardarValorSesion($variable, $valor, $sesion = '', $expiracion = '') {

	        $totalArgumentos = func_num_args();
	        if ($totalArgumentos == 0) {
	            return FALSE;
	        } else {
	            if (strlen($sesion) != 32) {
	                if (isset($_COOKIE [self::APLICATIVO])) {
	                    $this->sesionId = $_COOKIE [self::APLICATIVO];
	                } else {
	                    return FALSE;
	                }
	            } else {
	                $this->sesionId = $sesion;
	            }

	            // Si el valor de sesión existe entonces se actualiza, si no se crea un registro con el valor.

	            $parametro [self::SESIONID] = $this->sesionId;
	            $parametro ["variable"] = $variable;
	            $parametro ["valor"] = $valor;
	            $parametro [self::EXPIRACION] = $expiracion;
	            $cadenaSql = $this->miSql->getCadenaSql("buscarValorSesion", $parametro);

	            $resultado = $this->miConexion->ejecutarAcceso($cadenaSql, self::BUSCAR);

	            if ($resultado) {

	                $cadenaSql = $this->miSql->getCadenaSql("actualizarValorSesion", $parametro);
	            } else {
	                $cadenaSql = $this->miSql->getCadenaSql("insertarValorSesion", $parametro);
	            }

	            return $this->miConexion->ejecutarAcceso($cadenaSql, self::ACCEDER);
	        }
	    }

	    // Fin del método guardar_valor_sesion
	    function setValorSesion($variable, $valor) {

	        return $this->guardarValorSesion($variable, $valor);
	    }

			// Fin del método guardar_valor_sesion

	    /**
	     * @METHOD borrarValorSesion
	     * @PARAM variable
	     * @PARAM valor
	     *
	     * @return boolean
	     * @access public
	     */
	    function borrarValorSesion($variable, $sesion = "") {

	        if (strlen($sesion) != 32) {
	            if (isset($_COOKIE [self::APLICATIVO])) {
	                $sesion = $_COOKIE [self::APLICATIVO];
	            } else {
	                return false;
	            }
	        }

	        $parametro [self::SESIONID] = $sesion;
	        $parametro ["dato"] = $variable;

	        if ($variable != 'TODOS') {
	            $cadenaSql = $this->miSql->getCadenaSql("borrarVariableSesion", $parametro);
	        } else {
	            $cadenaSql = $this->miSql->getCadenaSql("borrarSesion", $parametro);
	        }

	        return !$this->miConexion->ejecutarAcceso($cadenaSql);
	    }

	    // Fin del método borrar_valor_sesion

	    /**
	     *
	     * @name borrar_sesion_expirada
	     * @return void
	     * @access public
	     */
	    function borrarSesionExpirada() {

	        $cadenaSql = $cadenaSql = $this->miSql->getCadenaSql("borrarSesionesExpiradas");

	        return !$this->miConexion->ejecutarAcceso($cadenaSql);
	    }

	    // Fin del método borrar_sesion_expirada
			/**
			*
			* @name terminar_sesion_expirada
			* @return void
			* @access public
			*/
			function terminarSesionExpirada() {
				/*
				* No USADA
				*/
				$cadenaSql = $cadenaSql = $this->miSql->getCadenaSql('borrarSesionesExpiradas');

				return !$this->miConexion->ejecutarAcceso($cadenaSql);
			}

			// Fin del método terminar_sesion_expirada

			/**
			*
			* @name terminar_sesion
			* @return boolean
			* @access public
			*/
			function terminarSesion() {
				$sesionUsuarioId = $this->sesionUsuario->numeroSesion();
				$this->sesionUsuario->terminarSesion($sesionUsuarioId);
				$aplication_base_url = $this->hostOneLogin.$this->site.'/';

				$respuesta = $this->authnRequest->logout ( $aplication_base_url);
				//Cerrar la sesión de SARA al salir.
				return $respuesta;
			}

			// Fin del método terminar_sesion

			function verificarRolesPagina($perfiles,$pagina){
				$cadenaSql = $this->sesionUsuario->miSql->getCadenaSql('verificarEnlaceUsuario', $pagina);
				//Se busca en la tabla _menu_rol_enlace si la página pertenece al perfil.
				$roles = $this->sesionUsuario->miConexion->ejecutarAcceso($cadenaSql,'busqueda');
				if($roles){//Si la página tiene roles en el menú
					foreach ($perfiles as $perfil){
						foreach ($roles as $rol){
							if($rol[0]==$perfil){
								return true;
							}
						}
					}
				}
				return false;
			}
		}

		?>
