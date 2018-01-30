<?php
namespace gestionDriver\listaDriver\entidad;

class procesarAjax
{
    public $miConfigurador;
    public $sql;
    public function __construct($sql)
    {
        $this->miConfigurador = \Configurador::singleton();

        $this->ruta = $this->miConfigurador->getVariableConfiguracion("rutaBloque");

        $this->sql = $sql;

        $conexion = "arpegiodata";

        $this->esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
        // URL base
        $url = $this->miConfigurador->getVariableConfiguracion("host");
        $url .= $this->miConfigurador->getVariableConfiguracion("site");
        $url .= "/index.php?";

        $esteBloque = $this->miConfigurador->configuracion['esteBloque'];

        switch ($_REQUEST['funcion']) {
                  case 'consultaPlataforma':
                  $cadenaSql = $this->sql->getCadenaSql('consultarPlataforma');
                   $resultadoItems =  $this->esteRecursoDB->ejecutarAcceso ( $cadenaSql, "busqueda" );

                   foreach ( $resultadoItems as $key => $values ) {
                     $keys = array (
                         'value',
                         'data'
                     );

                     $resultadoItems[$key]['value']=utf8_encode($resultadoItems[$key]['value']);

                     $resultado [$key] = array_intersect_key ( $resultadoItems [$key], array_flip ( $keys ) );
                   }

                   echo '{"suggestions":' . json_encode ( $resultado ) . '}';
                    break;
      }
    }

}
$miProcesarAjax = new procesarAjax($this->sql);
exit();
