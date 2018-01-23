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
$cadenaACodificar .= "&funcion=consultaParticular";
if(isset($_REQUEST['id_dispositivo'])){
$cadenaACodificar .= "&id_dispositivo=".$_REQUEST['id_dispositivo'];
}


// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadena = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificar, $enlace);

// URL Consultar Proyectos
$urlConsultaParticular = $url . $cadena;

// Variables para Con
$cadenaACodificar = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificar .= "&procesarAjax=true";
$cadenaACodificar .= "&action=index.php";
$cadenaACodificar .= "&bloqueNombre=" . $esteBloque["nombre"];
$cadenaACodificar .= "&bloqueGrupo=" . $esteBloque["grupo"];
$cadenaACodificar .= "&funcion=consultaFiltroPlataforma";

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadena = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificar, $enlace);

// URL Consultar Proyectos
$urlConsultaFiltroPlataforma= $url . $cadena;

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


// Variables para Con
$cadenaACodificar = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificar .= "&procesarAjax=true";
$cadenaACodificar .= "&action=index.php";
$cadenaACodificar .= "&bloqueNombre=" . $esteBloque["nombre"];
$cadenaACodificar .= "&bloqueGrupo=" . $esteBloque["grupo"];
$cadenaACodificar .= "&funcion=consultaDispositivo";

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadena = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificar, $enlace);

// URL Consultar Proyectos
$urlConsultarDispositivo = $url . $cadena;

?>
<script type='text/javascript'>
var plat= "";
var dis= "";
var valor="";


$("#<?php echo $this->campoSeguro('plataforma');?>").autocomplete({
 minChars: 0,
 serviceUrl: '<?php echo $urlConsultarPlataforma;?>',
 onSelect: function (suggestion) {
     $("#<?php echo $this->campoSeguro('id_plataforma');?>").val(suggestion.data);
     plat =  $("#<?php echo $this->campoSeguro('id_plataforma');?>").val();
     $("#<?php echo $this->campoSeguro('dispositivo');?>").val('');
     $("#<?php echo $this->campoSeguro('id_dispositivo');?>").val('');
          actualizarTabla();
     }

}).focus(function() {
            $(this).autocomplete("search", "");
        });


$("#<?php echo $this->campoSeguro('dispositivo');?>").autocomplete({
 minChars: 0,
 serviceUrl: '<?php echo $urlConsultarDispositivo;?>',
 onSelect: function (suggestion) {
     $("#<?php echo $this->campoSeguro('id_dispositivo');?>").val(suggestion.data);
     dis =  $("#<?php echo $this->campoSeguro('id_dispositivo');?>").val();
     $("#<?php echo $this->campoSeguro('plataforma');?>").val('');
     $("#<?php echo $this->campoSeguro('id_plataforma');?>").val('');
          actualizarTabla();
     }
}).focus(function() {
            $(this).autocomplete("search", "");
        });


$("#<?php echo $this->campoSeguro('dispositivo');?>").change(function() {
   if($("#<?php echo $this->campoSeguro('dispositivo');?>").val()==''){
     $("#<?php echo $this->campoSeguro('plataforma');?>").val()='';
     $("#<?php echo $this->campoSeguro('id_plataforma');?>").val()='';
      dis = '';
      actualizarTabla();
   }
});

$("#<?php echo $this->campoSeguro('plataforma');?>").change(function() {
   if($("#<?php echo $this->campoSeguro('plataforma');?>").val()==''){
     $("#<?php echo $this->campoSeguro('dispositivo');?>").val('')='';
     $("#<?php echo $this->campoSeguro('id_dispositivo');?>").val('')='';
      plat = '';
      actualizarTabla();
   }
});

/**
 * Código JavaScript Correspondiente a la utilización de las Peticiones Ajax(Aprobación Contrato).
 */

 $(document).ready(function() {

  $('#example').DataTable( {
    "processing": true,
      "searching": true,
      "info":false,
      "paging": false,
      "scrollY":"300px",
      "scrollX": true,
      "scrollCollapse": true,
      "responsive": true,
      "columnDefs": [
        {"className": "dt-center", "targets": "_all"}
      ],
    "orderCellsTop": true,
        language: {
            "sProcessing":     "Procesando...",
            "sLengthMenu":     "Mostrar _MENU_ registros",
            "sZeroRecords":    "No se encontraron resultados",
            "sEmptyTable":     "Ningún dato disponible en esta tabla",
            "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix":    "",
            "sSearch":         "Buscar:",
            "sUrl":            "",
            "sInfoThousands":  ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst":    "Primero",
                "sLast":     "Último",
                "sNext":     "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }

              },
              responsive: true,
                   ajax:{
                      url:"<?php echo $urlConsultaParticular;?>",
                      dataSrc:"data"
                  },
                  columns: [
                    { data :"plataforma" },
                    { data :"dispositivo" },
                    { data :"nombre" },
                      { data :"categoria" },
                    { data :"fecha" },
                  ]
    } );
} );



function actualizarTabla(){

$('#example').DataTable().destroy();
	    var table = $('#example').DataTable( {
	    	"processing": true,
	        "searching": true,
	        "info":false,
	        "paging": false,
	        "scrollY":"300px",
	        "scrollX": true,
	        "scrollCollapse": true,
	        "responsive": true,
	       	"columnDefs": [
	        	{"className": "dt-center", "targets": "_all"}
	        ],
	    	"orderCellsTop": true,
	    	"language": {
	            "sProcessing":     "Procesando...",
			    "sLengthMenu":     "Mostrar _MENU_ registros",
			    "sZeroRecords":    "No se encontraron resultados",
			    "sEmptyTable":     "Ningún dato disponible en esta tabla",
			    "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
			    "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
			    "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
			    "sInfoPostFix":    "",
			    "sSearch":         "Buscar:",
			    "sUrl":            "",
			    "sInfoThousands":  ",",
			    "sLoadingRecords": "Cargando...",
			    "oPaginate": {
			        "sFirst":    "Primero",
			        "sLast":     "Último",
			        "sNext":     "Siguiente",
			        "sPrevious": "Anterior"
			    },
			    "oAria": {
			        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
			        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
			    }
	        },
          ajax:{
             url:"<?php echo $urlConsultaFiltroPlataforma;?>",
              data: { plat:plat, dis:dis },
             dataSrc:"data"
         },
         columns: [
           { data :"plataforma" },
           { data :"dispositivo" },
           { data :"nombre" },
           { data :"categoria" },
           { data :"fecha" },
         ]
	    } );

	    setInterval( function () {
    		table.fnReloadAjax();
		}, 30000 );
}
</script>
