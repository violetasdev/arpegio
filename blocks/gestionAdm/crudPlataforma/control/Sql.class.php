<?php
namespace gestionAdm\crudPlataforma;

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
              $cadenaSql = "SELECT id_plataforma,nombre_plataforma, estado_plataforma ";
              $cadenaSql.= "FROM `arpegiodata_plataforma`";
              $cadenaSql.= " WHERE 1=1 ";
              //estado_dispositivo=1;";
              break;


              case 'consultaDetalle':
              $cadenaSql = "SELECT id_plataforma,nombre_plataforma, estado_plataforma ";
              $cadenaSql.= "FROM `arpegiodata_plataforma`";
              $cadenaSql.= " WHERE 1=1";
                //estado_dispositivo=1 ";
              $cadenaSql.= " AND id_plataforma=".$variable.";";
              break;


            case 'registrarPlataforma':
              $cadenaSql=" INSERT INTO `arpegiodata_plataforma` ";
              $cadenaSql.= " (";
              $cadenaSql.= " `nombre_plataforma`,  ";
              $cadenaSql.= " `fecha_creacion`,  ";
              $cadenaSql.= " `estado_plataforma`)  ";
              $cadenaSql.= " VALUES ( ";
              $cadenaSql.= " '".$variable['nombre_plataforma']."', ";
              $cadenaSql.= " '".$variable['fecha_creacion']."', ";
              $cadenaSql.= " '".$variable['estado_plataforma']."'); ";
              break;

            case 'validarPlataforma':
              $cadenaSql = " SELECT id_plataforma as data, nombre_plataforma as value ";
              $cadenaSql.= "FROM `arpegiodata_plataforma` ";
              $cadenaSql.= " WHERE nombre_plataforma='".$variable."' ";
              break;

          /**Edicion**/

            case 'actualizarPlataforma':
              $cadenaSql=" UPDATE arpegiodata_plataforma SET ";
              $cadenaSql.= " nombre_plataforma='".$variable['nombre_plataforma']."', ";;
              $cadenaSql.= " fecha_creacion='".$variable['fecha_creacion']."', ";
              $cadenaSql.= " estado_plataforma='".$variable['estado_plataforma']."' ";
              $cadenaSql.= " WHERE ";
              $cadenaSql.= " id_plataforma='".$variable['id_plataforma']."'; ";
              break;

            case 'inhabilitar':
              $cadenaSql=" UPDATE arpegiodata_plataforma SET ";
              $cadenaSql.= " estado_dispositivo=0";
              $cadenaSql.= " WHERE ";
              $cadenaSql.= " id_plataforma='".$variable."'; ";
              break;
            }

        return $cadenaSql;
}    }
