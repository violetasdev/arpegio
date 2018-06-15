<?php

namespace gestionAdm\crudDispositivo\entidad;

if (!isset($GLOBALS["autorizado"])) {
    include "index.php";
    exit();
}
class Redireccionador
{

    public static function redireccionar($opcion, $valor = "")
    {
        $miConfigurador = \Configurador::singleton();

        switch ($opcion) {
            case 'ExitoRegistro':
              $variable = 'pagina=crudDispositivo';
                $variable .= '&mensaje=exitoRegistro';
                break;

            case "ErrorRegistro":
                $variable = 'pagina=crudDispositivo';
                $variable .= '&mensaje=errorRegistro';
                break;

            case "ErrorDatos":
                $variable = 'pagina=crudDispositivo';
                $variable .= '&mensaje=errorDatos';
                break;

            case "ErrorDispositivo":
                $variable = 'pagina=crudDispositivo';
                $variable .= '&mensaje=errorDispositivo';
                break;


            case "ErrorNoValido":
                $variable = 'pagina=crudDispositivo';
                $variable .= '&mensaje=errorValido';
                break;

            case 'ExitoActualizarInfo':
                $variable = 'pagina=crudDispositivo';
                $variable .= '&mensaje=exitoInfo';
                break;

            case "ErrorActualizacion":
                $variable = 'pagina=crudDispositivo';
                $variable .= '&mensaje=errorUpdate';
                break;

            case 'ExitoActualizacion':
                $variable = 'pagina=crudDispositivo';
                $variable .= '&mensaje=exitoUpdate';
                break;

            default:
                $variable = '';
        }
        foreach ($_REQUEST as $clave => $valor) {
            unset($_REQUEST[$clave]);
        }

        $url = $miConfigurador->configuracion["host"] . $miConfigurador->configuracion["site"] . "/index.php?";
        $enlace = $miConfigurador->configuracion['enlace'];
        $variable = $miConfigurador->fabricaConexiones->crypto->codificar($variable);
        $_REQUEST[$enlace] = $enlace . '=' . $variable;
        $redireccion = $url . $_REQUEST[$enlace];

        echo "<script>location.replace('" . $redireccion . "')</script>";

        exit();
    }
}
