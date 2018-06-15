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
              $cadenaSql.= " WHERE 1=1 ";
              //estado_dispositivo=1;";
              break;


              case 'consultaDetalle':
                $cadenaSql = "SELECT id_dispositivo,nombre_dispositivo,`arpegiodata_dispositivo`.id_plataforma, nombre_plataforma, estado_dispositivo ";
                $cadenaSql.= "FROM `arpegiodata_dispositivo` JOIN arpegiodata_plataforma on arpegiodata_plataforma.id_plataforma=arpegiodata_dispositivo.id_plataforma ";
                $cadenaSql.= " WHERE 1=1";
                //estado_dispositivo=1 ";
                $cadenaSql.= " AND id_dispositivo=".$variable.";";
                break;

            case 'consultaFiltroPlataforma':
              $cadenaSql = "SELECT id_dispositivo,nombre_dispositivo, nombre_plataforma, `arpegiodata_dispositivo`.fecha_creacion,estado_dispositivo ";
              $cadenaSql.= "FROM `arpegiodata_dispositivo` JOIN arpegiodata_plataforma on arpegiodata_plataforma.id_plataforma=arpegiodata_dispositivo.id_plataforma ";
              $cadenaSql.= " WHERE ";
              //estado_dispositivo=1 ";
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
              $cadenaSql.= " '".$variable['estado_dispositivo']."'); ";
              break;


            case 'validarPlataforma':
              $cadenaSql = " SELECT id_plataforma as data, nombre_plataforma as value ";
              $cadenaSql.= "FROM `arpegiodata_plataforma` ";
              $cadenaSql.= " WHERE id_plataforma='".$variable."' ";
              break;

            case 'validarDispositivo':
              $cadenaSql = " SELECT id_dispositivo as data, nombre_dispositivo as value ";
              $cadenaSql.= "FROM `arpegiodata_dispositivo` ";
              $cadenaSql.= " WHERE nombre_dispositivo='".$variable."'";
              break;

          /**Edicion**/

            case 'actualizarDispositivo':
              $cadenaSql=" UPDATE arpegiodata_dispositivo SET ";
              $cadenaSql.= " nombre_dispositivo='".$variable['nombre_dispositivo']."', ";;
              $cadenaSql.= " id_plataforma='".$variable['id_plataforma']."', ";
              $cadenaSql.= " fecha_creacion='".$variable['fecha_creacion']."', ";
              $cadenaSql.= " estado_dispositivo='".$variable['estado_dispositivo']."' ";
              $cadenaSql.= " WHERE ";
              $cadenaSql.= " id_dispositivo='".$variable['id_dispositivo']."'; ";
              break;

            case 'inhabilitar':
              $cadenaSql=" UPDATE arpegiodata_dispositivo SET ";
              $cadenaSql.= " estado_dispositivo=0";
              $cadenaSql.= " WHERE ";
              $cadenaSql.= " id_dispositivo='".$variable."'; ";
              break;
            }

        return $cadenaSql;
}    }
