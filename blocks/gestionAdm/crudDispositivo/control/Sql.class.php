<?php
namespace gestionAdm\crudDispositivo;

if (!isset($GLOBALS["autorizado"])) {
    include "../index.php";
    exit();
}

require_once "core/manager/Configurador.class.php";
require_once "core/connection/Sql.class.php";

// Para evitar redefiniciones de clases el nombre de la clase del archivo sqle debe corresponder al nombre del bloque
// en camel case precedida por la palabra sql
class Sql extends \Sql
{
    public $miConfigurador;
    public function getCadenaSql($tipo, $variable = '')
    {

        /**
         * 1.
         * Revisar las variables para evitar SQL Injection
         */
        $prefijo = $this->miConfigurador->getVariableConfiguracion("prefijo");
        $idSesion = $this->miConfigurador->getVariableConfiguracion("id_sesion");

        switch ($tipo) {

            case 'consultaParticular':
              $cadenaSql = "SELECT id_dispositivo,nombre_dispositivo, nombre_plataforma, `arpegiodata_dispositivo`.fecha_creacion,estado_dispositivo ";
              $cadenaSql.= "FROM `arpegiodata_dispositivo` JOIN arpegiodata_plataforma on arpegiodata_plataforma.id_plataforma=arpegiodata_dispositivo.id_plataforma ";
              $cadenaSql.= " WHERE estado_dispositivo=1;";
              break;

            case 'consultaFiltroPlataforma':
              $cadenaSql = "SELECT id_dispositivo,nombre_dispositivo, nombre_plataforma, `arpegiodata_dispositivo`.fecha_creacion,estado_dispositivo ";
              $cadenaSql.= "FROM `arpegiodata_dispositivo` JOIN arpegiodata_plataforma on arpegiodata_plataforma.id_plataforma=arpegiodata_dispositivo.id_plataforma ";
              $cadenaSql.= " WHERE estado_dispositivo=1 ";
              $cadenaSql .= str_replace("\\","",$variable) .";";
              break;

            case 'consultarPlataforma':
              $cadenaSql = " SELECT value , data ";
              $cadenaSql .= "FROM ";
              $cadenaSql.= " (SELECT id_plataforma as data, nombre_plataforma as value ";
              $cadenaSql.= "FROM `arpegiodata_plataforma` ";
              $cadenaSql.= " WHERE estado_plataforma=1) as data ";
              $cadenaSql .= "WHERE value LIKE '%" . $_GET ['query'] . "%' ";
              break;

              case 'registrarDispositivo':
              $cadenaSql=" INSERT INTO `arpegiodata_dispositivo` ";
              $cadenaSql.= " (";
              $cadenaSql.= " `nombre_dispositivo`,  ";
              $cadenaSql.= " `id_plataforma`,  ";
              $cadenaSql.= " `fecha_creacion`,  ";
              $cadenaSql.= " `estado_dispositivo`)  ";
              $cadenaSql.= " VALUES ( ";
              $cadenaSql.= " '".$variable['nombre_dispositivo']."', ";
              $cadenaSql.= " '".$variable['id_plataforma']."', ";
              $cadenaSql.= " '".$variable['fecha_creacion']."', ";
              $cadenaSql.= " 1); ";
              break;


              case 'validarPlataforma':
                $cadenaSql = " SELECT id_plataforma as data, nombre_plataforma as value ";
                $cadenaSql.= "FROM `arpegiodata_plataforma` ";
                $cadenaSql.= " WHERE estado_plataforma=1 AND id_plataforma='".$variable."' ";
                break;

                case 'validarDispositivo':
                  $cadenaSql = " SELECT id_dispositivo as data, nombre_dispositivo as value ";
                  $cadenaSql.= "FROM `arpegiodata_dispositivo` ";
                  $cadenaSql.= " WHERE estado_dispositivo=1 AND nombre_dispositivo='".$variable."'";
                  break;

          /**Edicion**/

                    case 'actualizarDriver':
                    $cadenaSql=" UPDATE arpegiodata_driver SET ";
                    $cadenaSql.= " nombredriver='".$variable['nombre_archivo']."', ";
                    $cadenaSql.= " plataforma='".$variable['plataforma']."', ";
                    $cadenaSql.= " categoria='".$variable['categoria']."', ";
                    $cadenaSql.= " dispositivo='".$variable['dispositivo']."', ";;
                    $cadenaSql.= " descripcion='".$variable['descripcion']."', ";
                    $cadenaSql.= " version='".$variable['version']."', ";
                    $cadenaSql.= " sistema_operativo='".$variable['sistema_operativo' ]."', ";
                    $cadenaSql.= " fecha_publicacion='".$variable['fecha_publicacion']."' ";
                    $cadenaSql.= " WHERE ";
                    $cadenaSql.= " id_driver='".$variable['id_driver']."'; ";
                    break;
            }

        return $cadenaSql;
}    }
