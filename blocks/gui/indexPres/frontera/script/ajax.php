<?php
/**
 * Código Correspondiente a las Url de la peticiones Ajax.
 */

// URL base
$url = $this->miConfigurador->getVariableConfiguracion("host");
$url .= $this->miConfigurador->getVariableConfiguracion("site");
$url .= "/index.php?";

// Variables para Con
$cadenaACodificar = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificar .= "&procesarAjax=true";
$cadenaACodificar .= "&action=index.php";
$cadenaACodificar .= "&bloqueNombre=" . $esteBloque["nombre"];
$cadenaACodificar .= "&bloqueGrupo=" . $esteBloque["grupo"];
$cadenaACodificar .= "&funcion=consultaPlataforma";

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadena = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificar, $enlace);

// URL Consultar Proyectos
$urlConsultarPlataforma = $url . $cadena;

//Armando para redireccionar
$valorCodificado = "pagina=listaDriver";
$valorCodificado .= "&opcion=detalleDriver";

$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadena = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($valorCodificado, $enlace);
$urlDetalle = $url . $cadena;// Codificar las variables

?>
<script type='text/javascript'>
var plat= "";


$("#<?php echo $this->campoSeguro('cadenaBusquedaLan');?>").autocomplete({

 minChars: 3,
 maxResults: 10,
 serviceUrl: '<?php echo $urlConsultarPlataforma;?>',
 onSelect: function (suggestion) {
     $("#<?php echo $this->campoSeguro('id_cadenaBusquedaLan');?>").val(suggestion.data);
     //Activar únicamente si se requiere una redireccion al seleccionar un item de la lista
  //     location.href = "<?php echo $urlDetalle?>";
     }
});
</script>
