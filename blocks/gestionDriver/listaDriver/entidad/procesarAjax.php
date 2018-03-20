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

            if(isset($_REQUEST['cadenaBusquedaLan'])){
            $cadenaSql = $this->sql->getCadenaSql('consultaParticularCadena',$_REQUEST['cadenaBusquedaLan']);
          }elseif(isset($_REQUEST['id_dispositivo'])){
                   $cadenaSql = $this->sql->getCadenaSql('consultaParticularDispositivo',$_REQUEST['id_dispositivo']);
            }else{
                $cadenaSql = $this->sql->getCadenaSql('consultaParticular');
            }
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
                          'plataforma' => utf8_encode($valor['nombre_plataforma']),
                          'fecha' => $valor['fecha_publicacion'],
                          'dispositivo' =>$valor['nombre_dispositivo'],
                          'categoria' =>utf8_encode($valor['nombre_categoria']),
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

                     $resultadoItems[$key]['value']=utf8_encode($resultadoItems[$key]['value']);

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
                            $resultadoItems[$key]['value']=utf8_encode($resultadoItems[$key]['value']);

                         $resultado [$key] = array_intersect_key ( $resultadoItems [$key], array_flip ( $keys ) );
                       }
                       echo '{"suggestions":' . json_encode (  $resultado) . '}';
                        break;


                    case 'consultaFiltroPlataforma':

	                  $cadenaSql = "";
                    $plataforma = trim($_REQUEST ['plat']);
                    $dispositivo = trim($_REQUEST ['dis']);

                      if (isset ( $plataforma ) && $plataforma != "") {
                  			$cadenaSql.= "AND plataforma='" . $plataforma . "' ";
                  		}

                      if (isset ( $dispositivo ) && $dispositivo != "") {
                        $cadenaSql.= "AND dispositivo='" . $dispositivo . "' ";
                      }

                        $cadenaSql = $this->sql->getCadenaSql('consultaFiltroPlataforma', $cadenaSql);
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
                                  'plataforma' => utf8_encode($valor['nombre_plataforma']),
                                  'fecha' => $valor['fecha_publicacion'],
                                  'dispositivo' =>$valor['nombre_dispositivo'],
                                  'categoria' =>utf8_encode($valor['nombre_categoria']),
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
