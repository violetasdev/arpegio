<?php
namespace gestionAdm\crudDispositivo\frontera;

/**
 * IMPORTANTE: Este formulario está utilizando jquery.
 * Por tanto en el archivo ready.php se declaran algunas funciones js
 * que lo complementan.
 */
class Registrador
{
    public $miConfigurador;
    public $lenguaje;
    public $miFormulario;
    public $miSql;
    public function __construct($lenguaje, $formulario, $sql)
    {
        $this->miConfigurador = \Configurador::singleton();

        $this->miConfigurador->fabricaConexiones->setRecursoDB('principal');

        $this->lenguaje = $lenguaje;

        $this->miFormulario = $formulario;

        $this->miSql = $sql;
    }
    public function seleccionarForm()
    {

        // Rescatar los datos de este bloque
        $esteBloque = $this->miConfigurador->getVariableConfiguracion("esteBloque");

        // ---------------- SECCION: Parámetros Globales del Formulario ----------------------------------

        //Conexion a Base de Datos
        $conexion = "arpegiodata";
        $esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

        // ---------------- SECCION: Parámetros Generales del Formulario ----------------------------------
        $esteCampo = $esteBloque['nombre'];
        $atributos['id'] = $esteCampo;
        $atributos['nombre'] = $esteCampo;
        // Si no se coloca, entonces toma el valor predeterminado 'application/x-www-form-urlencoded'
        $atributos['tipoFormulario'] = '';
        // Si no se coloca, entonces toma el valor predeterminado 'POST'
        $atributos['metodo'] = 'POST';
        // Si no se coloca, entonces toma el valor predeterminado 'index.php' (Recomendado)
        $atributos['action'] = 'index.php';
        //$atributos['titulo'] = $this->lenguaje->getCadena($esteCampo);
        // Si no se coloca, entonces toma el valor predeterminado.
        $atributos['estilo'] = '';
        $atributos['marco'] = true;
        $tab = 1;
        // ---------------- FIN SECCION: de Parámetros Generales del Formulario ----------------------------


if(isset($_REQUEST['id_cadenaBusquedaLan'])){
  $_REQUEST['id_driver']=$_REQUEST['id_cadenaBusquedaLan'];
}

if ($_REQUEST['id_driver']==''){
  $url =   $this->miConfigurador->configuracion["host"] .  $this->miConfigurador->configuracion["site"] . "/index.php";
  echo "<script>location.replace('" . $url . "')</script>";
}
        $cadenaSql = $this->miSql->getCadenaSql('consultaDetalle',$_REQUEST['id_driver']);
        $driver = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");

        $atributosGlobales['campoSeguro'] = 'true';

        // ----------------INICIAR EL FORMULARIO ------------------------------------------------------------
        $atributos['tipoEtiqueta'] = 'inicio';
        echo $this->miFormulario->formulario($atributos);
        {
            /**
             * Código Formulario
             */

            $esteCampo = 'Agrupacion';
            $atributos['id'] = $esteCampo;
            $atributos['leyenda'] = "Vista Administrador Detalle ".$driver[0]['nombre_archivo'];
            echo $this->miFormulario->agrupacion('inicio', $atributos);
            unset($atributos);
            {
              $esteCampo = 'nombre_plataforma';
              $atributos ['nombre'] = $esteCampo;
              $atributos ['tipo'] = "text";
              $atributos ['id'] = $esteCampo;
              $atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
              $atributos ["etiquetaObligatorio"] = true;
              $atributos ['tab'] = $tab ++;
              $atributos ['anchoEtiqueta'] = 1;
              $atributos ['estilo'] = "bootstrap";
              $atributos ['evento'] = '';
              $atributos ['deshabilitado'] = false;
              $atributos ['readonly'] = true;
              $atributos ['columnas'] = 1;
              $atributos ['tamanno'] = 1;
              $atributos ['texto'] =$driver [0]['nombre_plataforma'];
              $atributos ['ajax_function'] = "";
              $atributos ['ajax_control'] = $esteCampo;
              $atributos ['limitar'] = false;
              $atributos ['anchoCaja'] = 1;
              $atributos ['miEvento'] = '';
              $atributos ['validar'] = '';
              // Aplica atributos globales al control
              $atributos = array_merge ( $atributos, $atributosGlobales );
              echo $this->miFormulario->campoTexto ( $atributos );
              unset ( $atributos );

              $esteCampo = 'dispositivo';
              $atributos ['nombre'] = $esteCampo;
              $atributos ['tipo'] = "text";
              $atributos ['id'] = $esteCampo;
              $atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
              $atributos ["etiquetaObligatorio"] = true;
              $atributos ['tab'] = $tab ++;
              $atributos ['anchoEtiqueta'] = 2;
              $atributos ['estilo'] = "bootstrap";
              $atributos ['evento'] = '';
              $atributos ['deshabilitado'] = false;
              $atributos ['readonly'] = true;
              $atributos ['columnas'] = 1;
              $atributos ['tamanno'] = 1;
              $atributos ['texto'] = $driver [0]['nombre_dispositivo'];
              $atributos ['ajax_function'] = "";
              $atributos ['ajax_control'] = $esteCampo;
              $atributos ['limitar'] = false;
              $atributos ['anchoCaja'] = 1;
              $atributos ['miEvento'] = '';
              $atributos ['validar'] = 'required';
              // Aplica atributos globales al control
              $atributos = array_merge ( $atributos, $atributosGlobales );
              echo $this->miFormulario->campoTexto ( $atributos );
              unset ( $atributos );

              $esteCampo = 'nombre_categoria';
              $atributos ['nombre'] = $esteCampo;
              $atributos ['tipo'] = "text";
              $atributos ['id'] = $esteCampo;
              $atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
              $atributos ["etiquetaObligatorio"] = true;
              $atributos ['tab'] = $tab ++;
              $atributos ['anchoEtiqueta'] = 1;
              $atributos ['estilo'] = "bootstrap";
              $atributos ['evento'] = '';
              $atributos ['deshabilitado'] = false;
              $atributos ['readonly'] = true;
              $atributos ['columnas'] = 1;
              $atributos ['tamanno'] = 1;
              $atributos ['texto'] = $driver [0]['nombre_categoria'];
              $atributos ['ajax_function'] = "";
              $atributos ['ajax_control'] = $esteCampo;
              $atributos ['limitar'] = false;
              $atributos ['anchoCaja'] = 1;
              $atributos ['miEvento'] = '';
              $atributos ['validar'] = 'required';
              // Aplica atributos globales al control
              $atributos = array_merge ( $atributos, $atributosGlobales );
              echo $this->miFormulario->campoTexto ( $atributos );
              unset ( $atributos );

              $esteCampo = 'nombre_sistema';
              $atributos ['nombre'] = $esteCampo;
              $atributos ['tipo'] = "text";
              $atributos ['id'] = $esteCampo;
              $atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
              $atributos ["etiquetaObligatorio"] = true;
              $atributos ['tab'] = $tab ++;
              $atributos ['anchoEtiqueta'] = 2;
              $atributos ['estilo'] = "bootstrap";
              $atributos ['evento'] = '';
              $atributos ['deshabilitado'] = false;
              $atributos ['readonly'] = true;
              $atributos ['columnas'] = 1;
              $atributos ['tamanno'] = 1;
              $atributos ['texto'] = $driver [0]['nombre_sistema'];
              $atributos ['ajax_function'] = "";
              $atributos ['ajax_control'] = $esteCampo;
              $atributos ['limitar'] = false;
              $atributos ['anchoCaja'] = 1;
              $atributos ['miEvento'] = '';
              $atributos ['validar'] = '';
              // Aplica atributos globales al control
              $atributos = array_merge ( $atributos, $atributosGlobales );
              echo $this->miFormulario->campoTexto ( $atributos );
              unset ( $atributos );

              $esteCampo = 'version';
          		$atributos ['nombre'] = $esteCampo;
          		$atributos ['tipo'] = "text";
          		$atributos ['id'] = $esteCampo;
          		$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
          		$atributos ["etiquetaObligatorio"] = true;
          		$atributos ['tab'] = $tab ++;
          		$atributos ['anchoEtiqueta'] = 2;
          		$atributos ['estilo'] = "bootstrap";
          		$atributos ['evento'] = '';
          		$atributos ['deshabilitado'] = false;
          		$atributos ['readonly'] = true;
          		$atributos ['columnas'] = 1;
          		$atributos ['tamanno'] = 1;
          		$atributos ['texto'] = $driver [0]['version'];
          		$atributos ['ajax_function'] = "";
          		$atributos ['ajax_control'] = $esteCampo;
          		$atributos ['limitar'] = false;
          		$atributos ['anchoCaja'] = 1;
          		$atributos ['miEvento'] = '';
          		$atributos ['validar'] = '';
          		// Aplica atributos globales al control
          		$atributos = array_merge ( $atributos, $atributosGlobales );
          		echo $this->miFormulario->campoTexto ( $atributos );
          		unset ( $atributos );

              $esteCampo = 'fechaPublicacion';
              $atributos ['nombre'] = $esteCampo;
              $atributos ['tipo'] = "text";
              $atributos ['id'] = $esteCampo;
              $atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
              $atributos ["etiquetaObligatorio"] = true;
              $atributos ['tab'] = $tab ++;
              $atributos ['anchoEtiqueta'] = 2;
              $atributos ['estilo'] = "bootstrap";
              $atributos ['evento'] = '';
              $atributos ['deshabilitado'] = false;
              $atributos ['readonly'] = true;
              $atributos ['columnas'] = 1;
              $atributos ['tamanno'] = 1;
              $atributos ['texto'] = $driver [0]['fechaPublicacion'];
              $atributos ['ajax_function'] = "";
              $atributos ['ajax_control'] = $esteCampo;
              $atributos ['limitar'] = false;
              $atributos ['anchoCaja'] = 1;
              $atributos ['miEvento'] = '';
              $atributos ['validar'] = '';
              // Aplica atributos globales al control
              $atributos = array_merge ( $atributos, $atributosGlobales );
              echo $this->miFormulario->campoTexto ( $atributos );
              unset ( $atributos );



            }

            echo $this->miFormulario->agrupacion('fin');
            unset($atributos);

            // ------------------Division para los botones-------------------------
              $atributos ["id"] = "botones";
              $atributos ["estilo"] = "marcoBotones";
              $atributos ["estiloEnLinea"] = "";
              echo $this->miFormulario->division ( "inicio", $atributos );
              unset ( $atributos );

              // -----------------CONTROL: Botón ----------------------------------------------------------------
                        $esteCampo = 'botonDescarga';
                        $atributos['id']=$esteCampo;
                        $atributos['enlace']= $driver[0]['ruta_relativa'];
                        $atributos['enlaceCodificar']= true;
                        $atributos['tabIndex']=$tab++;
                        $atributos['blank']=true;
                        $atributos['estilo']='btn btn-primary';
                        $atributos['enlaceTexto']= $this->lenguaje->getCadena ( $esteCampo );
                        $tab++;

                        // Aplica atributos globales al control
                        $atributos = array_merge($atributos);
                        echo $this->miFormulario->enlace($atributos);
                        unset($atributos);

              // -----------------FIN CONTROL: Botón -----------------------------------------------------------

              // ------------------Fin Division para los botones-------------------------
              echo $this->miFormulario->division ( "fin" );
              unset ( $atributos );

            $esteCampo = 'Agrupacion';
            $atributos['id'] = $esteCampo;
            $atributos['leyenda'] = "Descripción";
            echo $this->miFormulario->agrupacion('inicio', $atributos);
            unset($atributos);
            {
              echo $driver[0]['descripcion'];
            }

            echo $this->miFormulario->agrupacion('fin');
            unset($atributos);
        }
        {

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

              // $valorCodificado = "action=" . $esteBloque["nombre"];

              $valorCodificado = "actionBloque=" . $esteBloque["nombre"];
              $valorCodificado .= "&pagina=" . $this->miConfigurador->getVariableConfiguracion('pagina');
              $valorCodificado .= "&bloque=" . $esteBloque['nombre'];
              $valorCodificado .= "&bloqueGrupo=" . $esteBloque["grupo"];
              $valorCodificado .= "&opcion=registrarRegla";

              /**
             * SARA permite que los nombres de los campos sean dinámicos.
             * Para ello utiliza la hora en que es creado el formulario para
             * codificar el nombre de cada campo.
             */
              $valorCodificado .= "&campoSeguro=" . $_REQUEST['tiempo'];
              // Paso 2: codificar la cadena resultante
              $valorCodificado = $this->miConfigurador->fabricaConexiones->crypto->codificar($valorCodificado);

              $atributos["id"] = "formSaraData"; // No cambiar este nombre
              $atributos["tipo"] = "hidden";
              $atributos['estilo'] = '';
              $atributos["obligatorio"] = false;
              $atributos['marco'] = true;
              $atributos["etiqueta"] = "";
              $atributos["valor"] = $valorCodificado;
              echo $this->miFormulario->campoCuadroTexto($atributos);
              unset($atributos);



        }

        // ----------------FINALIZAR EL FORMULARIO ----------------------------------------------------------
        // Se debe declarar el mismo atributo de marco con que se inició el formulario.
        $atributos['marco'] = true;
        $atributos['tipoEtiqueta'] = 'fin';
        echo $this->miFormulario->formulario($atributos);
        if (isset($_REQUEST['mensaje'])) {
              $this->mensajeModal();
        }
    }


    public function mensajeModal()
    {

        switch ($_REQUEST['mensaje']) {
            case 'exitoRegistro':
                $mensaje = "Exito<br>Regla Registrada";
                $atributos['estiloLinea'] = 'success';     //success,error,information,warning
                break;

            case 'errorRegistro':
                $mensaje = "Error<br>Registro de la Regla";
                $atributos['estiloLinea'] = 'error';     //success,error,information,warning
                break;

            case 'exitoActualizacion':
                $mensaje = "Exito<br>Regla Actualizada";
                $atributos['estiloLinea'] = 'success';     //success,error,information,warning
                break;

            case 'errorActualizacion':
                $mensaje = "Error<br>Actualización de la Regla";
                $atributos['estiloLinea'] = 'error';     //success,error,information,warning
                break;

            case 'exitoEliminar':
                $mensaje = "Exito<br>Regla Eliminada";
                $atributos['estiloLinea'] = 'success';     //success,error,information,warning
                break;

            case 'errorEliminar':
                $mensaje = "Error<br>Eliminar Regla";
                $atributos['estiloLinea'] = 'error';     //success,error,information,warning
                break;
        }

        // ----------------INICIO CONTROL: Ventana Modal Beneficiario Eliminado---------------------------------

        $atributos['tipoEtiqueta'] = 'inicio';
        $atributos['titulo'] = 'Mensaje';
        $atributos['id'] = 'mensajeModal';
        echo $this->miFormulario->modal($atributos);
        unset($atributos);

        // ----------------INICIO CONTROL: Mapa--------------------------------------------------------
        echo '<div style="text-align:center;">';

        echo '<p><h5>' . $mensaje . '</h5></p>';

        echo '</div>';

        // ----------------FIN CONTROL: Mapa--------------------------------------------------------

        echo '<div style="text-align:center;">';

        echo '</div>';

        $atributos['tipoEtiqueta'] = 'fin';
        echo $this->miFormulario->modal($atributos);
        unset($atributos);
    }
}

$miSeleccionador = new Registrador($this->lenguaje, $this->miFormulario, $this->sql);

$miSeleccionador->seleccionarForm();
