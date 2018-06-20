<?php
namespace gestionAdm\crudCategoria\entidad;

if (!isset($GLOBALS["autorizado"])) {
    include "../index.php";
    exit();
}

require_once 'Redireccionador.php';

class FormProcessor
{

    public $miConfigurador;
    public $lenguaje;
    public $miFormulario;
    public $miSql;
    public $conexion;
    public $archivos_datos;
    public $esteRecursoDB;

    public function __construct($lenguaje, $sql)
    {

        $this->miConfigurador = \Configurador::singleton();
        $this->miConfigurador->fabricaConexiones->setRecursoDB('principal');
        $this->lenguaje = $lenguaje;
        $this->miSql = $sql;
        $this->archivo=false;
        $this->rutaURL = $this->miConfigurador->getVariableConfiguracion("host") . $this->miConfigurador->getVariableConfiguracion("site");

        $this->rutaAbsoluta = $this->miConfigurador->getVariableConfiguracion("raizDocumento");

        if (!isset($_REQUEST["bloqueGrupo"]) || $_REQUEST["bloqueGrupo"] == "") {
            $this->rutaURL .= "/blocks/" . $_REQUEST["bloque"] . "/";
            $this->rutaAbsoluta .= "/blocks/" . $_REQUEST["bloque"] . "/";
        } else {
            $this->rutaURL .= "/blocks/" . $_REQUEST["bloqueGrupo"] . "/" . $_REQUEST["bloque"] . "/";
            $this->rutaAbsoluta .= "/blocks/" . $_REQUEST["bloqueGrupo"] . "/" . $_REQUEST["bloque"] . "/";
        }
        //Conexion a Base de Datos
        $conexion = "arpegiodata";
        $this->esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

          /**0. Validar campos */

          $this->validarDatos();

          /*** 1.Registrar*/

          $this->baseDatos();
    }


    public function baseDatos(){

            $this->archivo_datos_cargar=array(
                'nombre_categoria'=>$_REQUEST['nombre_categoria'],
                'fecha_creacion'=> date("Y/m/d"),
                'id_categoria'=>$_REQUEST['id_categoria'],
                'estado_categoria'=>$_REQUEST['estado_categoria']
              );

              $cadenaSql = $this->miSql->getCadenaSql('actualizarCategoria', $this->archivo_datos_cargar);
              $this->proceso = $this->esteRecursoDB->ejecutarAcceso($cadenaSql, "acceso");


              if (isset($this->proceso) && $this->proceso != false) {
                  Redireccionador::redireccionar("ExitoActualizacion");    exit();
              } else {
                  Redireccionador::redireccionar("ErrorActualizacion");    exit();
              }
    }


    public function validarDatos() {

              if($_REQUEST['nombre_categoria_inicial']!=$_REQUEST['nombre_categoria']){
                $cadenaSqlD = $this->miSql->getCadenaSql('validarCategoria',$_REQUEST['nombre_categoria']);
                $categoria = $this->esteRecursoDB->ejecutarAcceso($cadenaSqlD, "busqueda");

                if($categoria!=false)
                {
                  Redireccionador::redireccionar("ErrorCategoria");
                  exit();
                }}
    }
}
$miProcesador = new FormProcessor($this->lenguaje, $this->sql);
