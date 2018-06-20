<?php
namespace gestionAdm\crudCategoria;

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
              $cadenaSql = "SELECT id_categoria,nombre_categoria, estado_categoria ";
              $cadenaSql.= "FROM `arpegiodata_categoria`";
              $cadenaSql.= " WHERE 1=1 ";
              //estado_dispositivo=1;";
              break;


              case 'consultaDetalle':
              $cadenaSql = "SELECT id_categoria,nombre_categoria, estado_categoria ";
              $cadenaSql.= "FROM `arpegiodata_categoria`";
              $cadenaSql.= " WHERE 1=1";
                //estado_dispositivo=1 ";
              $cadenaSql.= " AND id_categoria=".$variable.";";
              break;


            case 'registrarCategoria':
              $cadenaSql=" INSERT INTO `arpegiodata_categoria` ";
              $cadenaSql.= " (";
              $cadenaSql.= " `nombre_categoria`,  ";
              $cadenaSql.= " `fecha_creacion`,  ";
              $cadenaSql.= " `estado_categoria`)  ";
              $cadenaSql.= " VALUES ( ";
              $cadenaSql.= " '".$variable['nombre_categoria']."', ";
              $cadenaSql.= " '".$variable['fecha_creacion']."', ";
              $cadenaSql.= " '".$variable['estado_categoria']."'); ";
              break;

            case 'validarCategoria':
              $cadenaSql = " SELECT id_categoria as data, nombre_categoria as value ";
              $cadenaSql.= "FROM `arpegiodata_categoria` ";
              $cadenaSql.= " WHERE nombre_categoria='".$variable."' ";
              break;

          /**Edicion**/

            case 'actualizarCategoria':
              $cadenaSql=" UPDATE arpegiodata_categoria SET ";
              $cadenaSql.= " nombre_categoria='".$variable['nombre_categoria']."', ";;
              $cadenaSql.= " fecha_creacion='".$variable['fecha_creacion']."', ";
              $cadenaSql.= " estado_categoria='".$variable['estado_categoria']."' ";
              $cadenaSql.= " WHERE ";
              $cadenaSql.= " id_categoria='".$variable['id_categoria']."'; ";
              break;

            case 'inhabilitar':
              $cadenaSql=" UPDATE arpegiodata_categoria SET ";
              $cadenaSql.= " estado_dispositivo=0";
              $cadenaSql.= " WHERE ";
              $cadenaSql.= " id_categoria='".$variable."'; ";
              break;
            }

        return $cadenaSql;
}    }
