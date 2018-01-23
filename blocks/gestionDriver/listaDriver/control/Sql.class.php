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

            case 'consultaParticular':
              $cadenaSql = " SELECT id_driver, nombredriver,descripcion,nombre_dispositivo, nombre_plataforma, fecha_publicacion,nombre_categoria ";
              $cadenaSql.= "FROM `arpegiodata_driver` JOIN arpegiodata_categoria on arpegiodata_categoria.id_categoria=arpegiodata_driver.categoria JOIN arpegiodata_dispositivo on arpegiodata_dispositivo.id_dispositivo=arpegiodata_driver.dispositivo JOIN arpegiodata_plataforma on arpegiodata_plataforma.id_plataforma=arpegiodata_driver.plataforma JOIN arpegiodata_sistemaoperativo on arpegiodata_sistemaoperativo.id_sistema=arpegiodata_driver.sistema_operativo ";
              $cadenaSql.= " WHERE estado_driver=1;";
              break;

            case 'consultaParticularDispositivo':
                $cadenaSql = " SELECT id_driver, nombredriver,descripcion,nombre_dispositivo, nombre_plataforma, fecha_publicacion,nombre_categoria ";
                $cadenaSql.= "FROM `arpegiodata_driver` JOIN arpegiodata_categoria on arpegiodata_categoria.id_categoria=arpegiodata_driver.categoria JOIN arpegiodata_dispositivo on arpegiodata_dispositivo.id_dispositivo=arpegiodata_driver.dispositivo JOIN arpegiodata_plataforma on arpegiodata_plataforma.id_plataforma=arpegiodata_driver.plataforma JOIN arpegiodata_sistemaoperativo on arpegiodata_sistemaoperativo.id_sistema=arpegiodata_driver.sistema_operativo ";
                $cadenaSql.= " WHERE estado_driver=1 ";
                $cadenaSql.= " AND dispositivo=".$variable.";";
                break;

            case 'consultaFiltroPlataforma':
              $cadenaSql = " SELECT id_driver,plataforma, nombredriver,descripcion,nombre_dispositivo, nombre_plataforma,fecha_publicacion,nombre_categoria ";
              $cadenaSql.= "FROM `arpegiodata_driver` JOIN arpegiodata_categoria on arpegiodata_categoria.id_categoria=arpegiodata_driver.categoria JOIN arpegiodata_dispositivo on arpegiodata_dispositivo.id_dispositivo=arpegiodata_driver.dispositivo JOIN arpegiodata_plataforma on arpegiodata_plataforma.id_plataforma=arpegiodata_driver.plataforma JOIN arpegiodata_sistemaoperativo on arpegiodata_sistemaoperativo.id_sistema=arpegiodata_driver.sistema_operativo ";
              $cadenaSql.= " WHERE estado_driver=1 ";
              $cadenaSql .= str_replace("\\","",$variable);
              break;

            case 'consultarPlataforma':
              $cadenaSql = " SELECT value , data ";
              $cadenaSql .= "FROM ";
              $cadenaSql.= " (SELECT id_plataforma as data, nombre_plataforma as value ";
              $cadenaSql.= "FROM `arpegiodata_plataforma` ";
              $cadenaSql.= " WHERE estado_plataforma=1) as data ";
              $cadenaSql .= "WHERE value LIKE '%" . $_GET ['query'] . "%' ";
              break;

            case 'consultarDispositivo':
              $cadenaSql = " SELECT value , data ";
              $cadenaSql .= "FROM ";
              $cadenaSql.= " (SELECT id_dispositivo as data, nombre_dispositivo as value ";
              $cadenaSql.= "FROM `arpegiodata_dispositivo` ";
              $cadenaSql.= " WHERE estado_dispositivo=1) as data ";
              $cadenaSql .= "WHERE value LIKE '%" . $_GET ['query'] . "%' ";
              break;

            case 'consultaDetalle':
              $cadenaSql = " SELECT id_driver, nombre_sistema, version,nombredriver,descripcion,nombre_dispositivo, nombre_plataforma, fecha_publicacion,nombre_categoria ";
              $cadenaSql.= "FROM `arpegiodata_driver` JOIN arpegiodata_categoria on arpegiodata_categoria.id_categoria=arpegiodata_driver.categoria JOIN arpegiodata_dispositivo on arpegiodata_dispositivo.id_dispositivo=arpegiodata_driver.dispositivo JOIN arpegiodata_plataforma on arpegiodata_plataforma.id_plataforma=arpegiodata_driver.plataforma JOIN arpegiodata_sistemaoperativo on arpegiodata_sistemaoperativo.id_sistema=arpegiodata_driver.sistema_operativo ";
              $cadenaSql.= " WHERE estado_driver=1 ";
              $cadenaSql.=" AND id_driver='".$variable."'";
              break;
        }

        return $cadenaSql;
    }
}
