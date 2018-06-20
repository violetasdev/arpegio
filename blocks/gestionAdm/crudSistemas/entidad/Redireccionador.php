<?php

namespace gestionAdm\crudSistemas\entidad;

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
              $variable = 'pagina=crudSistemas';
                $variable .= '&mensaje=exitoRegistro';
                break;

            case "ErrorRegistro":
                $variable = 'pagina=crudSistemas';
                $variable .= '&mensaje=errorRegistro';
                break;

            case "ErrorDatos":
                $variable = 'pagina=crudSistemas';
                $variable .= '&mensaje=errorDatos';
                break;

            case "ErrorSistemas":
                $variable = 'pagina=crudSistemas';
                $variable .= '&mensaje=ErrorSistemas';
                break;


            case "ErrorNoValido":
                $variable = 'pagina=crudSistemas';
                $variable .= '&mensaje=errorValido';
                break;

            case 'ExitoActualizarInfo':
                $variable = 'pagina=crudSistemas';
                $variable .= '&mensaje=exitoInfo';
                break;

            case "ErrorActualizacion":
                $variable = 'pagina=crudSistemas';
                $variable .= '&mensaje=errorUpdate';
                break;

            case 'ExitoActualizacion':
                $variable = 'pagina=crudSistemas';
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
