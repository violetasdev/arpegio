<?php
namespace gestionDriver\listaDriver\frontera;

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

        $atributosGlobales['campoSeguro'] = 'true';

        // ----------------INICIAR EL FORMULARIO ------------------------------------------------------------
        $atributos['tipoEtiqueta'] = 'inicio';
        echo $this->miFormulario->formulario($atributos);
        {
            /**
             * Código Formulario
             */

             $esteCampo = 'Agrupacionfiltros';
             $atributos ['id'] = $esteCampo;
             echo $this->miFormulario->agrupacion ( 'inicio', $atributos );
             unset ( $atributos );

               // ----------------INICIO CONTROL: Lista Proyectos---------------------------

               $esteCampo = 'cadenaBusquedaLan';
               $atributos ['nombre'] = $esteCampo;
               $atributos ['tipo'] = "text";
               $atributos ['id'] = $esteCampo;
               $atributos ['etiqueta'] = '';
               $atributos ["etiquetaObligatorio"] = false;
               $atributos ['tab'] = $tab ++;
               $atributos ['anchoEtiqueta'] = 1;
               $atributos ['estilo'] = "cadenaBusquedaLan";
               $atributos ['evento'] = '';
               $atributos ['deshabilitado'] = false;
               $atributos ['readonly'] = false;
               $atributos ['columnas'] = 1;
               $atributos ['tamanno'] =100;
               $atributos ['TEXTOFONDO'] = "Ingrese los criterios de busqueda";
               $atributos ['placeholder'] = "Ingrese los criterios de busqueda";
               $atributos ['valor'] = "";
               $atributos ['ajax_function'] = "";
               $atributos ['ajax_control'] = $esteCampo;
               $atributos ['limitar'] = false;
               $atributos ['anchoCaja'] =7;
               $atributos ['miEvento'] = '';
               // $atributos ['validar'] = 'required';
               // Aplica atributos globales al control
               $atributos = array_merge ( $atributos, $atributosGlobales );
               echo $this->miFormulario->campoCuadroTexto( $atributos );
               unset ( $atributos );

               $esteCampo = 'id_cadenaBusquedaLan';
               $atributos ["id"] = $esteCampo; // No cambiar este nombre
               $atributos ["tipo"] = "hidden";
               $atributos ['estilo'] = '';
               $atributos ["obligatorio"] = false;
               $atributos ['marco'] = true;
               $atributos ["etiqueta"] = "";
               if (isset ( $_REQUEST [$esteCampo] )) {
                 $atributos ['valor'] = $_REQUEST [$esteCampo];
               } else {
                 $atributos ['valor'] = '';
               }
               $atributos = array_merge ( $atributos, $atributosGlobales );
               echo $this->miFormulario->campoCuadroTexto ( $atributos );
               unset ( $atributos );

             // ----------------FIN CONTROL: Fecha de Agendamiento--------------------------------------------------------
             // ------------------- SECCION: Paso de variables ------------------------------------------------

             echo $this->miFormulario->agrupacion ( 'fin' );
             unset ( $atributos );

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
    }

}

$miSeleccionador = new Registrador($this->lenguaje, $this->miFormulario, $this->sql);

$miSeleccionador->seleccionarForm();
