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
            case 'consultaParticular':
                $cadenaSql = $this->sql->getCadenaSql('consultaParticular');
                $drivers = $this->esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");

                if ($drivers) {
                    foreach ($drivers as $key => $valor) {
                      {
                      $valorCodificado = "pagina=" . $this->miConfigurador->getVariableConfiguracion('pagina');
                      $valorCodificado .= "&opcion=detalleDriver";
                      $valorCodificado .= "&id_driver=" . $valor['id_driver'];
                      }

                      $enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
                      $cadena = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($valorCodificado, $enlace);
                      $urlDetalle = $url . $cadena;

                        $resultadoFinal[] = array(
                            'nombre' => '<a href="'.$urlDetalle.'">'.$valor['nombredriver'].'</a><br><br>'.$valor['descripcion'],
                            'descripcion' => $valor['descripcion'],
                            'categoria' => $valor['nombre_categoria'],
                            'sistema' => $valor['nombre_sistema'],
                            'fecha' => $valor['fecha_publicacion'],
                            'version' =>$valor['version']
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

    public function colorCelda($valor)
    {

        if ($valor >= 0 && $valor <= 20) {
            $color = "#F08080";
        } elseif ($valor >= 21 && $valor <= 50) {
            $color = "#f3aa51";
        } elseif ($valor >= 51 && $valor <= 80) {
            $color = "#f0ed80";
        } elseif ($valor >= 81 && $valor <= 99) {
            $color = "#b0e6c8";
        } elseif ($valor >= 100) {
            $color = "#0d7b3e";
        }

        return $color;
    }
}
$miProcesarAjax = new procesarAjax($this->sql);
exit();
