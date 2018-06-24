<?php
namespace gestionAdm\crudArchivo\entidad;

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

        $_REQUEST['tiempo'] = time();


        if($_REQUEST['estado_driver']==0){
            $datos=array(
              'id_driver'=>$_REQUEST['id_driver'],
              'estado_driver'=>1
            );
          }else{
            $datos=array(
              'id_driver'=>$_REQUEST['id_driver'],
              'estado_driver'=>0
            );
          }

        $cadenaSql = $this->miSql->getCadenaSql('inhabilitarDriver', $datos);
        $this->proceso = $this->esteRecursoDB->ejecutarAcceso($cadenaSql, "acceso");

        if (isset($this->proceso) && $this->proceso != null) {
            Redireccionador::redireccionar("ExitoInhabilitar", $this->proceso);
        } else {
            Redireccionador::redireccionar("ErrorInhabilitar");
        }
    }
}

$miProcesador = new FormProcessor($this->lenguaje, $this->sql);
