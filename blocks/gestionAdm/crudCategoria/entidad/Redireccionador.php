<?php

namespace gestionAdm\crudCategoria\entidad;

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
              $variable = 'pagina=crudCategoria';
                $variable .= '&mensaje=exitoRegistro';
                break;

            case "ErrorRegistro":
                $variable = 'pagina=crudCategoria';
                $variable .= '&mensaje=errorRegistro';
                break;

            case "ErrorDatos":
                $variable = 'pagina=crudCategoria';
                $variable .= '&mensaje=errorDatos';
                break;

            case "ErrorCategoria":
                $variable = 'pagina=crudCategoria';
                $variable .= '&mensaje=ErrorCategoria';
                break;


            case "ErrorNoValido":
                $variable = 'pagina=crudCategoria';
                $variable .= '&mensaje=errorValido';
                break;

            case 'ExitoActualizarInfo':
                $variable = 'pagina=crudCategoria';
                $variable .= '&mensaje=exitoInfo';
                break;

            case "ErrorActualizacion":
                $variable = 'pagina=crudCategoria';
                $variable .= '&mensaje=errorUpdate';
                break;

            case 'ExitoActualizacion':
                $variable = 'pagina=crudCategoria';
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
