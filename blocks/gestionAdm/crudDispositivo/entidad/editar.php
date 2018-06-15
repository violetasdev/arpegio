<?php
namespace gestionAdm\crudDispositivo\entidad;

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
                'nombre_dispositivo'=>$_REQUEST['nombre_dispositivo'],
                'id_plataforma'=>$_REQUEST['id_plataforma'],
                'fecha_creacion'=> date("Y/m/d"),
                'id_dispositivo'=>$_REQUEST['id_dispositivo'],
                'estado_dispositivo'=>$_REQUEST['estado_dispositivo']
              );

              $cadenaSql = $this->miSql->getCadenaSql('actualizarDispositivo', $this->archivo_datos_cargar);
              $this->proceso = $this->esteRecursoDB->ejecutarAcceso($cadenaSql, "acceso");


              if (isset($this->proceso) && $this->proceso != false) {
                  Redireccionador::redireccionar("ExitoActualizacion");    exit();
              } else {
                  Redireccionador::redireccionar("ErrorActualizacion");    exit();
              }
    }


    public function validarDatos() {
            $validar=array(
              'validarPlataforma'=>$_REQUEST['id_plataforma'],
              'validarDispositivo'=>$_REQUEST['nombre_dispositivo'],

            );

            foreach ($validar as $key => $value) {
              $cadenaSql = $this->miSql->getCadenaSql('validarPlataforma',$_REQUEST['id_plataforma']);
              $plataforma = $this->esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");

              if($plataforma==false)
              {
                Redireccionador::redireccionar("ErrorDatos");
                exit();
              }

              if($_REQUEST['nombre_dispositivo_inicial']!=$_REQUEST['nombre_dispositivo']){
                $cadenaSqlD = $this->miSql->getCadenaSql('validarDispositivo',$_REQUEST['nombre_dispositivo']);
                $dispositivo = $this->esteRecursoDB->ejecutarAcceso($cadenaSqlD, "busqueda");

                if($dispositivo!=false)
                {
                  Redireccionador::redireccionar("ErrorDispositivo");
                  exit();
                }}
            }
    }
}
$miProcesador = new FormProcessor($this->lenguaje, $this->sql);
