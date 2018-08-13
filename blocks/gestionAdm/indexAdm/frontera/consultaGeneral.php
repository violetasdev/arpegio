<?php
namespace gestionAdm\indexAdm\frontera;

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

        $valorDispositivo='';
        $valorPlataforma='';
        //Conexion a Base de Datos
        $conexion = "arpegiodata";
        $esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

        $_REQUEST['tiempo']=time();


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
            $atributos['leyenda'] = "Bienvenido a Administración";
            echo $this->miFormulario->agrupacion('inicio', $atributos);
            unset($atributos);
            {

var_dump($_SESSION);
                // ------------------Division para los botones-------------------------
                $atributos['id'] = 'divMensaje';
                $atributos['estilo'] = 'marcoBotones';
                echo $this->miFormulario->division("inicio", $atributos);
                unset($atributos);
                {

                }
                // ------------------Fin Division para los botones-------------------------
                echo $this->miFormulario->division("fin");
                unset($atributos);

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

}

$miSeleccionador = new Registrador($this->lenguaje, $this->miFormulario, $this->sql);

$miSeleccionador->seleccionarForm();
