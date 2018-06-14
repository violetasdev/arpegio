<?php
namespace gestionAdm\crudDispositivo\entidad;

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
        $this->archivo=false;
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

        /**0. Validar campos */
              $this->validarDatos();
              /* * 1.
               * CargarArchivos en el Directorio
               */

               foreach ($_FILES as $key => $archivo) {

                   if ($_FILES[$key]['size'] != 0 && $_FILES[$key]['error'] == 0) {
                     $this->archivo=true;
                     $this->cargarArchivos();
                   }
               }


              /**
               * 3.
               * Registrar Documentos
               */

               if($this->cargarArchivos()==true){
                 $this->baseDatos();
               }


    }

    public function cargarArchivos() {

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
                Redireccionador::redireccionar("ErrorNoValido");
                exit();
            }

            if (isset($exten['extension']) == false) {
                $exten['extension'] = 'txt';
            }

            $tamano = $archivo['size'];
            $tipo = $archivo['type'];
            $nombre_archivo = $_REQUEST['nombre_archivo'];
            $doc = $nombre_archivo . "_" . $this->prefijo . '.' . $exten['extension'];

            /*
             * guardamos el fichero en el Directorio

             Generar tabla con los directorios configurables
             */

             $cadenaSql = $this->miSql->getCadenaSql('consultarCarpeta', $_REQUEST['id_plataforma']);
             $directorio = $this->esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");

             $directorio=$directorio[0][0];

             $ruta_absoluta = $this->miConfigurador->configuracion['raizDocumento'] . $directorio . $doc;
             $ruta_relativa = $this->miConfigurador->configuracion['host'] . $this->miConfigurador->configuracion['site'] . $directorio. $doc;

             $ubicacion=$directorio.$doc;

            $archivo['rutaDirectorio'] = $ruta_absoluta;
            if (!copy($archivo['tmp_name'], $ruta_absoluta)) {
                Redireccionador::redireccionar("ErrorCargarFicheroDirectorio");
                exit();
            }

            $this->archivo_cargar = array(
                'nombre_archivo' => $_REQUEST['nombre_archivo'],
                'ruta_archivo' => $ruta_relativa,
                'rutaabsoluta' => $ruta_absoluta,
                'nombredriver' => $doc,
                'tamanio' => $tamano,
                'extension'=>$exten['extension'],
                'ubicacion'=>$ubicacion,
                'ruta_relativa'=>$ruta_relativa,
                'fecha_creacion'=> date("Y/m/d"),
                'id_driver'=>$_REQUEST['id_driver'],
              );
        }
        return true;
  }
}

public function baseDatos(){

          $cadenaSql = $this->miSql->getCadenaSql('actualizarDriver', $this->datos_cargar);
          $insertar = $this->esteRecursoDB->ejecutarAcceso($cadenaSql, "acceso");

          if($this->archivo==true){

         $cadenaSql2 = $this->miSql->getCadenaSql('actualizarArchivo', $this->archivo_cargar);
          $this->proceso2 = $this->esteRecursoDB->ejecutarAcceso($cadenaSql2, "acceso");

          if (isset($this->proceso2) && $this->proceso2!= false) {
            Redireccionador::redireccionar("ExitoActualizarArchivo");    exit();
          } else {
            Redireccionador::redireccionar("ErrorActualizarArchivo");    exit();
          }
        }else{
          if (isset($insertar) && $insertar!=false) {
            Redireccionador::redireccionar("ExitoActualizarInfo");    exit();
          } else {
            Redireccionador::redireccionar("ErrorActualizarInfo");    exit();
          }
        }
}

    public function validarDatos() {

      $validar=array(
        'validarDispositivo'=>$_REQUEST['id_dispositivo'],
        'validarPlataforma'=>$_REQUEST['id_plataforma'],
        'validarCategoria'=>$_REQUEST['id_categoria'],
        'validarSistema'=>$_REQUEST['id_sistema'],
      );

      foreach ($validar as $key => $value) {
        $cadenaSql = $this->miSql->getCadenaSql($key,$value);
        $plataforma = $this->esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");
        if($plataforma==false)
        {
          Redireccionador::redireccionar("ErrorDatos");
          exit();
        }
      }

      $this->datos_cargar = array(
          'id_driver'=>$_REQUEST['id_driver'],
          'nombre_archivo' => $_REQUEST['nombre_archivo'],
          'plataforma' => $_REQUEST['id_plataforma'],
          'categoria' => $_REQUEST['id_categoria'],
          'dispositivo' => $_REQUEST['id_dispositivo'],
          'descripcion' => utf8_encode($_REQUEST['descripcion']),
          'version' => $_REQUEST['version'],
          'sistema_operativo' => $_REQUEST['id_sistema'],
          'fecha_publicacion'=>$_REQUEST['fechaPublicacion'],
        );
    }
}
$miProcesador = new FormProcessor($this->lenguaje, $this->sql);
