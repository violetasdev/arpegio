<?php
namespace gestionAdm\crudArchivo\entidad;

if (!isset($GLOBALS["autorizado"])) {
    include "../index.php";
    exit();
}

require_once 'Redireccionador.php';

class FormProcessor
{

    public $miConfigurador;
    public $lenguaje;
    public $miFormulario;
    public $miSql;
    public $conexion;
    public $archivos_datos;
    public $esteRecursoDB;

    public function __construct($lenguaje, $sql)
    {

        $this->miConfigurador = \Configurador::singleton();
        $this->miConfigurador->fabricaConexiones->setRecursoDB('principal');
        $this->lenguaje = $lenguaje;
        $this->miSql = $sql;

        $this->rutaURL = $this->miConfigurador->getVariableConfiguracion("host") . $this->miConfigurador->getVariableConfiguracion("site");

        $this->rutaAbsoluta = $this->miConfigurador->getVariableConfiguracion("raizDocumento");

        if (!isset($_REQUEST["bloqueGrupo"]) || $_REQUEST["bloqueGrupo"] == "") {
            $this->rutaURL .= "/blocks/" . $_REQUEST["bloque"] . "/";
            $this->rutaAbsoluta .= "/blocks/" . $_REQUEST["bloque"] . "/";
        } else {
            $this->rutaURL .= "/blocks/" . $_REQUEST["bloqueGrupo"] . "/" . $_REQUEST["bloque"] . "/";
            $this->rutaAbsoluta .= "/blocks/" . $_REQUEST["bloqueGrupo"] . "/" . $_REQUEST["bloque"] . "/";
        }
        //Conexion a Base de Datos
        $conexion = "arpegiodata";
        $this->esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

        /**
               * 1.
               * CargarArchivos en el Directorio
               */

              $this->cargarArchivos();

              /**
               * 3.
               * Registrar Documentos
               */
              $this->baseDatos();

    }

    public function cargarArchivos() {

var_dump($_REQUEST);
      echo "cargando archivos";
      exit;
    foreach ($_FILES as $key => $archivo) {

        if ($_FILES[$key]['size'] != 0 && $_FILES[$key]['error'] == 0) {

            $this->prefijo = substr(md5(uniqid(time())), 0, 6);
            $exten = pathinfo($archivo['name']);

            $allowed = array(
                'text/plain',
                'application/x-rar-compressed',
                'application/zip',
                'application/pdf',
            );

            if (!in_array($_FILES[$key]['type'], $allowed)) {
                Redireccionador::redireccionar("ErrorCargarFicheroDirectorio");
                exit();
            }

            if (isset($exten['extension']) == false) {
                $exten['extension'] = 'txt';
            }

            $tamano = $archivo['size'];
            $tipo = $archivo['type'];
            $nombre_archivo = $_REQUEST['nombreArchivo'];
            $doc = $nombre_archivo . "_" . $this->prefijo . '.' . $exten['extension'];

            /*
             * guardamos el fichero en el Directorio

             Generar tabla con los directorios configurables
             */

             $cadenaSql = $this->miSql->getCadenaSql('consultarCarpeta', $_REQUEST['id_plataforma']);
             $directorio = $this->esteRecursoDB->ejecutarAcceso($cadenaSql, "acceso");
             $directorio=$directorio[0][0];

             $ruta_absoluta = $this->miConfigurador->configuracion['raizDocumento'] . $directorio . $doc;
             $ruta_relativa = $this->miConfigurador->configuracion['host'] . $this->miConfigurador->configuracion['site'] . $directorio. $doc;

            $archivo['rutaDirectorio'] = $ruta_absoluta;
            if (!copy($archivo['tmp_name'], $ruta_absoluta)) {
                Redireccionador::redireccionar("ErrorCargarFicheroDirectorio");
                exit();
            }

            $this->archivo_datos_cargar[] = array(
                'ruta_archivo' => $ruta_relativa,
                'rutaabsoluta' => $ruta_absoluta,
                'nombre_archivo' => $doc,
                'nombredriver' => $doc,
                'plataforma' => $_REQUEST['id_plataforma'],
                'categoria' => $_REQUEST['id_categoria'],
                'dispositivo' => $_REQUEST['id_dispositivo'],
                'descripcion' => $archivo['descripcion'],
                'version' => $_REQUEST['version'],
                'tamanio' => $tamano,
                'extension'=>$exten['extension'],
                'sistema_operativo' => $_REQUEST['id_sistema'],
                'fecha_publicacion'=>$_REQUEST['fechaPublicacion'],
                'fecha_creacion'=> date("Y/m/d"); ,
                'estado'=>1
              );

        }

    }
    //$this->archivos_datos = $archivo_datos;
    //var_dump($this->archivo_datos);
    //exit;
}

public function baseDatos(){
  $_REQUEST['tiempo'] = time();
echo "llegamos a registrar.php";
var_dump($_FILES);
exit;
  switch ($_REQUEST['opcion']) {
      case 'registrarReglaParticular':
          $arreglo = array(
              'descricion' => $_REQUEST['descripcion'],
              'formula' => $_REQUEST['formula'],
              'identificador' => $_REQUEST['identificador_formula'],
          );

          $cadenaSql = $this->miSql->getCadenaSql('registrarRegla', $arreglo);

          $this->proceso = $this->esteRecursoDB->ejecutarAcceso($cadenaSql, "acceso");

          if (isset($this->proceso) && $this->proceso != null) {
              Redireccionador::redireccionar("ExitoRegistro", $this->proceso);
          } else {
              Redireccionador::redireccionar("ErrorRegistro");
          }

          break;
}
}
}

$miProcesador = new FormProcessor($this->lenguaje, $this->sql);
