<?php
namespace gui\indexPres;

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

              case 'consultarPlataforma':
              $cadenaSql = 'SELECT data, value from ( SELECT id_driver as data, CONCAT(nombre_dispositivo," - ", descripcion) as value FROM `arpegiodata_driver`
                            JOIN arpegiodata_dispositivo on arpegiodata_dispositivo.id_dispositivo=arpegiodata_driver.dispositivo WHERE arpegiodata_driver.estado_driver=1) as seleccion
                            WHERE value ';
              $cadenaSql .= " LIKE '%" . $_GET ['query'] . "%' ";
              break;
        }

        return $cadenaSql;
    }
}
