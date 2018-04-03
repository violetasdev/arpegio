<?php
namespace gestionDriver\listaDriver;

if (!isset($GLOBALS["autorizado"])) {
    include "../index.php";
    exit();
}

require_once "core/manager/Configurador.class.php";
class Frontera
{
    public $ruta;
    public $sql;
    public $miEntidad;
    public $lenguaje;
    public $miFormulario;
    public $miConfigurador;

    public function __construct()
    {
        $this->miConfigurador = \Configurador::singleton();
    }
    public function setRuta($unaRuta)
    {
        $this->ruta = $unaRuta;
    }
    public function setLenguaje($lenguaje)
    {
        $this->lenguaje = $lenguaje;
    }
    public function setFormulario($formulario)
    {
        $this->miFormulario = $formulario;
    }
    public function frontera()
    {
        $this->html();
    }
    public function setSql($a)
    {
        $this->sql = $a;
    }
    public function setEntidad($entidad)
    {
        $this->miEntidad = $entidad;
    }
    public function html()
    {
        include_once "core/builder/FormularioHtml.class.php";

        $this->ruta = $this->miConfigurador->getVariableConfiguracion("rutaBloque");
        $this->miFormulario = new \FormularioHtml();

        $miBloque = $this->miConfigurador->getVariableConfiguracion('esteBloque');
        $resultado = $this->miConfigurador->getVariableConfiguracion('errorFormulario');

        if (isset($_REQUEST['opcion'])) {
            switch ($_REQUEST['opcion']) {
              case 'detalleDriver':

              if (isset($_REQUEST['id_cadenaBusquedaLan']) && $_REQUEST['id_cadenaBusquedaLan']!=''){
                $_REQUEST['buscarLista']=$_REQUEST['id_cadenaBusquedaLan'];
                include_once $this->ruta . "frontera/detalleDriver.php";
              }elseif (isset($_REQUEST['id_driver']) && $_REQUEST['id_driver']!=''){
                $_REQUEST['buscarLista']=$_REQUEST['id_driver'];
                include_once $this->ruta . "frontera/detalleDriver.php";
              }elseif ($_REQUEST['id_cadenaBusquedaLan']==''){
                include_once $this->ruta . "frontera/consultaGeneral.php";
              }else{
                include_once $this->ruta . "frontera/consultaGeneral.php";
              }

                    break;

                default:
                    include_once $this->ruta . "frontera/consultaGeneral.php";
                    break;
            }
        } else {
            include_once $this->ruta . "frontera/consultaGeneral.php";
        }
    }
}
