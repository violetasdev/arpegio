<?php
namespace gestionAdm\crudSistemas\entidad;

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
            'nombre_sistema'=>$_REQUEST['nombre_sistema'],
            'fecha_creacion'=> date("Y/m/d"),
            'estado_sistema'=>$_REQUEST['estado_sistema']
          );

          $cadenaSql = $this->miSql->getCadenaSql('registrarSistemas', $this->archivo_datos_cargar);
          $this->proceso = $this->esteRecursoDB->ejecutarAcceso($cadenaSql, "acceso");

          if (isset($this->proceso) && $this->proceso != false) {
              Redireccionador::redireccionar("ExitoRegistro");    exit();
          } else {
              Redireccionador::redireccionar("ErrorRegistro");    exit();
          }

}

    public function validarDatos() {

      $validar=array(
        'validarDispositivo'=>$_REQUEST['nombre_sistema'],

      );

      foreach ($validar as $key => $value) {
        $cadenaSqlD = $this->miSql->getCadenaSql('validarSistemas',$_REQUEST['nombre_sistema']);
        $sistema = $this->esteRecursoDB->ejecutarAcceso($cadenaSqlD, "busqueda");

        if($sistema!=false)
        {
          Redireccionador::redireccionar("ErrorSistemas");
          exit();
        }
      }
    }
}
$miProcesador = new FormProcessor($this->lenguaje, $this->sql);
