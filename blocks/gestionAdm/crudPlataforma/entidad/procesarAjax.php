<?php
namespace gestionAdm\crudPlataforma\entidad;

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
            case 'consultaParticular':

              $cadenaSql = $this->sql->getCadenaSql('consultaParticular');
              $drivers = $this->esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");

                if ($drivers) {

                  $valorCodificado = "pagina=" . $this->miConfigurador->getVariableConfiguracion('pagina');
                  $valorCodificado .= "&opcion=edicionDriver";

                    foreach ($drivers as $key => $valor) {
                      {
                      $valorCodificado .= "&id_plataforma=" . $valor['id_plataforma'];
                      }

                      $enlace = $this->miConfigurador->getVariableConfiguracion("enlace");

                      $cadena = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($valorCodificado, $enlace);

                      $urlEdit = $url . $cadena;

                        $resultadoFinal[] = array(
                          'plataforma' => $valor['nombre_plataforma'],
                          'estado' => $valor['estado_plataforma']==1 ? "Activo":"Inactivo",
                          'editar' => '<a href="'.$urlEdit.'">Editar</a><br>',
                          );


                    $total = count($resultadoFinal);

                    $resultadoF = json_encode($resultadoFinal);
                    $resultado = '{
                                "recordsTotal":'     . $total . ',
                                "recordsFiltered":'     . $total . ',
                                "data":'     . $resultadoF . '}';
            }  } else {
                    $resultado = '{
                                "recordsTotal":0 ,
                                "recordsFiltered":0 ,
                                "data": 0 }'    ;
                }
                echo $resultado;
                break;
        }
    }

}
$miProcesarAjax = new procesarAjax($this->sql);
exit();
