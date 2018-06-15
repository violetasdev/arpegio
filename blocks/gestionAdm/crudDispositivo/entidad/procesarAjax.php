<?php
namespace gestionAdm\crudDispositivo\entidad;

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
                      $valorCodificado .= "&id_dispositivo=" . $valor['id_dispositivo'];
                      }

                      $enlace = $this->miConfigurador->getVariableConfiguracion("enlace");

                      $cadena = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($valorCodificado, $enlace);

                      $urlEdit = $url . $cadena;

                        $resultadoFinal[] = array(
                          'dispositivo' => $valor['nombre_dispositivo'],
                          'plataforma' => $valor['nombre_plataforma'],
                          'estado' => $valor['estado_dispositivo']==1 ? "Activo":"Inactivo",
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

                case 'consultaPlataforma':
                   $cadenaSql = $this->sql->getCadenaSql('consultarPlataforma');
                   $resultadoItems =  $this->esteRecursoDB->ejecutarAcceso ( $cadenaSql, "busqueda" );

                   foreach ( $resultadoItems as $key => $values ) {
                     $keys = array (
                         'value',
                         'data'
                     );

                     $resultadoItems[$key]['value']=$resultadoItems[$key]['value'];

                     $resultado [$key] = array_intersect_key ( $resultadoItems [$key], array_flip ( $keys ) );
                   }

                   echo '{"suggestions":' . json_encode ( $resultado ) . '}';
                    break;


                    case 'consultaDispositivo':
                       $cadenaSql = $this->sql->getCadenaSql('consultarDispositivo');
                       $resultadoItems =  $this->esteRecursoDB->ejecutarAcceso ( $cadenaSql, "busqueda" );

                       foreach ( $resultadoItems as $key => $values ) {
                         $keys = array (
                             'value',
                             'data'
                         );
                            $resultadoItems[$key]['value']=$resultadoItems[$key]['value'];

                         $resultado [$key] = array_intersect_key ( $resultadoItems [$key], array_flip ( $keys ) );
                       }
                       echo '{"suggestions":' . json_encode (  $resultado) . '}';
                        break;

                    case 'consultaFiltroPlataforma':

	                  $cadenaSql = "";
                    $plataforma = trim($_REQUEST ['plat']);

                      if (isset ( $plataforma ) && $plataforma != "") {
                  			$cadenaSql.= "AND `arpegiodata_dispositivo`.id_plataforma='" . $plataforma . "' ";
                  		}

                      $cadenaSql = $this->sql->getCadenaSql('consultaFiltroPlataforma', $cadenaSql);

                      $drivers = $this->esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");

                        if ($drivers) {

                            $valorCodificado = "pagina=" . $this->miConfigurador->getVariableConfiguracion('pagina');
                            $valorCodificado .= "&opcion=edicionDriver";

                            foreach ($drivers as $key => $valor) {
                              {
                              $valorCodificado .= "&id_dispositivo=" . $valor['id_dispositivo'];
                            }

                              $enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
                              $cadena = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($valorCodificado, $enlace);

                              $urlEdit = $url . $cadena;

                                $resultadoFinal[] = array(
                                  'dispositivo' => $valor['nombre_dispositivo'],
                                  'plataforma' => $valor['nombre_plataforma'],
                                  'estado' => $valor['estado_dispositivo']==1 ? "Activo":"Inactivo",
                                  'editar' => '<a href="'.$urlEdit.'">Editar</a><br>',
                                  );
                            $total = count($resultadoFinal);


                            $resultadoF = json_encode( $resultadoFinal);
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
