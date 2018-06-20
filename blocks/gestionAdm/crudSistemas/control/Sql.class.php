<?php
namespace gestionAdm\crudSistemas;

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
              $cadenaSql = "SELECT id_sistema,nombre_sistema, estado_sistema ";
              $cadenaSql.= "FROM `arpegiodata_sistemaoperativo`";
              $cadenaSql.= " WHERE 1=1 ";
              //estado_dispositivo=1;";
              break;


              case 'consultaDetalle':
              $cadenaSql = "SELECT id_sistema,nombre_sistema, estado_sistema ";
              $cadenaSql.= "FROM `arpegiodata_sistemaoperativo`";
              $cadenaSql.= " WHERE 1=1";
                //estado_dispositivo=1 ";
              $cadenaSql.= " AND id_sistema=".$variable.";";
              break;


            case 'registrarSistemas':
              $cadenaSql=" INSERT INTO `arpegiodata_sistemaoperativo` ";
              $cadenaSql.= " (";
              $cadenaSql.= " `nombre_sistema`,  ";
              $cadenaSql.= " `fecha_creacion`,  ";
              $cadenaSql.= " `estado_sistema`)  ";
              $cadenaSql.= " VALUES ( ";
              $cadenaSql.= " '".$variable['nombre_sistema']."', ";
              $cadenaSql.= " '".$variable['fecha_creacion']."', ";
              $cadenaSql.= " '".$variable['estado_sistema']."'); ";
              break;

            case 'validarSistemas':
              $cadenaSql = " SELECT id_sistema as data, nombre_sistema as value ";
              $cadenaSql.= "FROM `arpegiodata_sistemaoperativo` ";
              $cadenaSql.= " WHERE nombre_sistema='".$variable."' ";
              break;

          /**Edicion**/

            case 'actualizarSistemas':
              $cadenaSql=" UPDATE arpegiodata_sistemaoperativo SET ";
              $cadenaSql.= " nombre_sistema='".$variable['nombre_sistema']."', ";;
              $cadenaSql.= " fecha_creacion='".$variable['fecha_creacion']."', ";
              $cadenaSql.= " estado_sistema='".$variable['estado_sistema']."' ";
              $cadenaSql.= " WHERE ";
              $cadenaSql.= " id_sistema='".$variable['id_sistema']."'; ";
              break;

            case 'inhabilitar':
              $cadenaSql=" UPDATE arpegiodata_sistemaoperativo SET ";
              $cadenaSql.= " estado_dispositivo=0";
              $cadenaSql.= " WHERE ";
              $cadenaSql.= " id_sistema='".$variable."'; ";
              break;
            }

        return $cadenaSql;
}    }
