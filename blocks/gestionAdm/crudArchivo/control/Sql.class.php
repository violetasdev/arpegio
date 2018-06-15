<?php
namespace gestionAdm\crudArchivo;

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

              case 'consultarCategoria':
                $cadenaSql = " SELECT value , data ";
                $cadenaSql .= "FROM ";
                $cadenaSql.= " (SELECT id_categoria as data, nombre_categoria as value ";
                $cadenaSql.= "FROM `arpegiodata_categoria` ";
                $cadenaSql.= " WHERE estado_categoria=1) as data ";
                $cadenaSql .= "WHERE value LIKE '%" . $_GET ['query'] . "%' ";
                break;

            case 'consultarSistema':
                  $cadenaSql = " SELECT value , data ";
                  $cadenaSql .= "FROM ";
                  $cadenaSql.= " (SELECT id_sistema as data, nombre_sistema as value ";
                  $cadenaSql.= "FROM `arpegiodata_sistemaoperativo` ";
                  $cadenaSql.= " WHERE estado_sistema=1) as data ";
                  $cadenaSql .= "WHERE value LIKE '%" . $_GET ['query'] . "%' ";
                  break;

            case 'consultaDetalle':
              $cadenaSql = " SELECT arpegiodata_driver.id_driver, nombre_sistema, arpegiodata_driver.sistema_operativo as id_sistema, version,nombredriver as nombre_archivo,descripcion,nombre_dispositivo, arpegiodata_driver.dispositivo as id_dispositivo, nombre_plataforma, arpegiodata_driver.plataforma as id_plataforma,fecha_publicacion as fechaPublicacion,nombre_categoria,arpegiodata_driver.categoria as id_categoria, ruta_relativa ";
              $cadenaSql.= "FROM `arpegiodata_driver` JOIN arpegiodata_categoria on arpegiodata_categoria.id_categoria=arpegiodata_driver.categoria JOIN arpegiodata_dispositivo on arpegiodata_dispositivo.id_dispositivo=arpegiodata_driver.dispositivo JOIN arpegiodata_plataforma on arpegiodata_plataforma.id_plataforma=arpegiodata_driver.plataforma JOIN arpegiodata_sistemaoperativo on arpegiodata_sistemaoperativo.id_sistema=arpegiodata_driver.sistema_operativo
              JOIN arpegiodata_archivo ON arpegiodata_archivo.id_driver=arpegiodata_driver.id_driver";
              $cadenaSql.= " WHERE estado_driver=1 ";
              $cadenaSql.=" AND arpegiodata_driver.id_driver='".$variable."'";
              break;

              case 'consultaParticularCadena':
              $cadenaSql = " SELECT id_driver, nombredriver,descripcion,nombre_dispositivo, nombre_plataforma, fecha_publicacion,nombre_categoria ";
              $cadenaSql.= "FROM `arpegiodata_driver` JOIN arpegiodata_categoria on arpegiodata_categoria.id_categoria=arpegiodata_driver.categoria JOIN arpegiodata_dispositivo on arpegiodata_dispositivo.id_dispositivo=arpegiodata_driver.dispositivo JOIN arpegiodata_plataforma on arpegiodata_plataforma.id_plataforma=arpegiodata_driver.plataforma JOIN arpegiodata_sistemaoperativo on arpegiodata_sistemaoperativo.id_sistema=arpegiodata_driver.sistema_operativo ";
              $cadenaSql.= " WHERE estado_driver=1 ";
              $cadenaSql .= " AND descripcion LIKE '%" . $variable . "%' ";
              break;

              case 'consultarCarpeta':
              $cadenaSql = " SELECT folder ";
              $cadenaSql.= "FROM `arpegiodata_folder` JOIN arpegiodata_plataforma on arpegiodata_plataforma.id_plataforma=arpegiodata_folder.id_plataforma ";
              $cadenaSql.= " WHERE `arpegiodata_folder`.estado=1 ";
              $cadenaSql.= " AND arpegiodata_folder.id_plataforma=". $variable . "; ";
              break;

              case 'registrarDriver':
              $cadenaSql=" INSERT INTO arpegiodata_driver ";
              $cadenaSql.= " (nombredriver, ";
              $cadenaSql.= " plataforma, ";
              $cadenaSql.= " categoria, ";
              $cadenaSql.= " dispositivo, ";
              $cadenaSql.= " descripcion, ";
              $cadenaSql.= " version, ";
              $cadenaSql.= " sistema_operativo, ";
              $cadenaSql.= " fecha_publicacion, ";
              $cadenaSql.= " fecha_creacion, ";
              $cadenaSql.= " estado_driver) VALUES (";
              $cadenaSql.= " '".$variable['nombre_archivo']."', ";
              $cadenaSql.= " '".$variable['plataforma']."', ";
              $cadenaSql.= " '".$variable['categoria']."', ";
              $cadenaSql.= " '".$variable['dispositivo']."', ";
              $cadenaSql.= " '".$variable['descripcion']."', ";
              $cadenaSql.= " '".$variable['version']."', ";
              $cadenaSql.= " '".$variable['sistema_operativo' ]."', ";
              $cadenaSql.= " '".$variable['fecha_publicacion']."', ";
              $cadenaSql.= " '".$variable['fecha_creacion']."', ";
              $cadenaSql.= " '".$variable['estado']."' ";
              $cadenaSql.= "); ";
              break;

              case 'idDriver':
              $cadenaSql= " SELECT LAST_INSERT_ID(); ";
              break;

              case 'registrarArchivo':
              $cadenaSql=" INSERT INTO `arpegiodata_archivo` ";
              $cadenaSql.= " (";
              $cadenaSql.= " `id_driver`,  ";
              $cadenaSql.= " `ruta_relativa`,  ";
              $cadenaSql.= " `tipo_archivo`, ";
              $cadenaSql.= " `tamannio`,  ";
              $cadenaSql.= " `fecha_subida`,  ";
              $cadenaSql.= " `estado_archivo`)  ";
              $cadenaSql.= " VALUES ( ";
              $cadenaSql.= " '".$variable['id_driver']."', ";
              $cadenaSql.= " '".$variable['ruta_relativa']."', ";
              $cadenaSql.= " '".$variable['extension']."', ";
              $cadenaSql.= " '".$variable['tamanio']."', ";
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
                $cadenaSql.= " WHERE estado_dispositivo=1 AND id_dispositivo='".$variable."'";
                break;

                case 'validarCategoria':
                  $cadenaSql = " SELECT id_categoria as data, nombre_categoria as value ";
                  $cadenaSql.= "FROM `arpegiodata_categoria` ";
                  $cadenaSql.= " WHERE estado_categoria=1 AND id_categoria='".$variable."'";
                  break;

              case 'validarSistema':
                    $cadenaSql = " SELECT id_sistema as data, nombre_sistema as value ";
                    $cadenaSql.= "FROM `arpegiodata_sistemaoperativo` ";
                    $cadenaSql.= " WHERE estado_sistema=1 AND id_sistema='".$variable."'";
                    break;

                    /**Edicion de archivos**/

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

                    case 'actualizarArchivo':
                    $cadenaSql=" UPDATE `arpegiodata_archivo` SET";
                    $cadenaSql.= " `ruta_relativa`='".$variable['ruta_relativa']."', ";
                    $cadenaSql.= " `tipo_archivo`='".$variable['extension']."', ";
                    $cadenaSql.= " `tamannio`='".$variable['tamanio']."', ";
                    $cadenaSql.= " `fecha_subida`='".$variable['fecha_creacion']."' ";
                    $cadenaSql.= " WHERE ";
                    $cadenaSql.= " id_driver='".$variable['id_driver']."'; ";
                    break;
            }

        return $cadenaSql;
}    }