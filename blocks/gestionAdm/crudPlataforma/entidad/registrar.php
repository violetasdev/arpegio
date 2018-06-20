<?php
namespace gestionAdm\crudPlataforma\entidad;

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
            'nombre_plataforma'=>$_REQUEST['nombre_plataforma'],
            'fecha_creacion'=> date("Y/m/d"),
            'estado_plataforma'=>$_REQUEST['estado_plataforma']
          );

          $cadenaSql = $this->miSql->getCadenaSql('registrarPlataforma', $this->archivo_datos_cargar);
          $this->proceso = $this->esteRecursoDB->ejecutarAcceso($cadenaSql, "acceso");

exit;

          if (isset($this->proceso) && $this->proceso != false) {
              Redireccionador::redireccionar("ExitoRegistro");    exit();
          } else {
              Redireccionador::redireccionar("ErrorRegistro");    exit();
          }

}

    public function validarDatos() {

      $validar=array(
        'validarDispositivo'=>$_REQUEST['nombre_plataforma'],

      );

      foreach ($validar as $key => $value) {
        $cadenaSqlD = $this->miSql->getCadenaSql('validarPlataforma',$_REQUEST['nombre_plataforma']);
        $plataforma = $this->esteRecursoDB->ejecutarAcceso($cadenaSqlD, "busqueda");

        if($plataforma!=false)
        {
          Redireccionador::redireccionar("ErrorPlataforma");
          exit();
        }
      }
    }
}
$miProcesador = new FormProcessor($this->lenguaje, $this->sql);
