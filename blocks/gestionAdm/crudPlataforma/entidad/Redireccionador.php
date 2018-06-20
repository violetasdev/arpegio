<?php

namespace gestionAdm\crudPlataforma\entidad;

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
              $variable = 'pagina=crudPlataforma';
                $variable .= '&mensaje=exitoRegistro';
                break;

            case "ErrorRegistro":
                $variable = 'pagina=crudPlataforma';
                $variable .= '&mensaje=errorRegistro';
                break;

            case "ErrorDatos":
                $variable = 'pagina=crudPlataforma';
                $variable .= '&mensaje=errorDatos';
                break;

            case "ErrorPlataforma":
                $variable = 'pagina=crudPlataforma';
                $variable .= '&mensaje=ErrorPlataforma';
                break;


            case "ErrorNoValido":
                $variable = 'pagina=crudPlataforma';
                $variable .= '&mensaje=errorValido';
                break;

            case 'ExitoActualizarInfo':
                $variable = 'pagina=crudPlataforma';
                $variable .= '&mensaje=exitoInfo';
                break;

            case "ErrorActualizacion":
                $variable = 'pagina=crudPlataforma';
                $variable .= '&mensaje=errorUpdate';
                break;

            case 'ExitoActualizacion':
                $variable = 'pagina=crudPlataforma';
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
