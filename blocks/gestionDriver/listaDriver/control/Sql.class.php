<?php
namespace gestionDriver\listaDriver;

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

            /**
                 * Clausulas específicas
                 */

            case 'consultaParticular':
                $cadenaSql = " SELECT id_driver, nombredriver,descripcion,nombre_categoria, nombre_sistema, nombre_plataforma,version, fecha_publicacion ";
                $cadenaSql.= "FROM `arpegiodata_driver` JOIN arpegiodata_categoria on arpegiodata_categoria.id_categoria=arpegiodata_driver.categoria JOIN arpegiodata_dispositivo on arpegiodata_dispositivo.id_dispositivo=arpegiodata_driver.dispositivo JOIN arpegiodata_plataforma on arpegiodata_plataforma.id_plataforma=arpegiodata_driver.plataforma JOIN arpegiodata_sistemaoperativo on arpegiodata_sistemaoperativo.id_sistema=arpegiodata_driver.sistema_operativo ";
                $cadenaSql.= " WHERE estado_driver=1;";
                break;
        }

        return $cadenaSql;
    }
}
