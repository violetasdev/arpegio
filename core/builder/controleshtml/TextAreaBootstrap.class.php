<?php
require_once "core/builder/HtmlBase.class.php";
/**
 *
 * @author paulo
 *
 * $atributos['estilo']
 * $atributos['filas']
 * $atributos['columnas']
 *
 */
class TextAreaBootstrap extends HtmlBase {

    public function campoTextAreaBootstrap($atributos) {

        $this->setAtributos($atributos);

        $this->cadenaHTML = '<div class="form-group">';

        $this->campoSeguro();


                	if (isset($this->atributos[self::ETIQUETA]) && $this->atributos[self::ETIQUETA] != "") {

                		//Manejo de responsiveness
                		$relacion= $this->atributos['anchoEtiqueta']*100/12;
                		$estiloLabel='';
                		$estiloControl='';

                		// Para xs = extra small screens (mobile phones)

            	if($relacion<33){
            		$estiloLabel.='col-xs-12 ';
            		$estiloControl.='col-xs-12 ';
            	}else{
            		$estiloLabel.='col-xs-'.$this->atributos['anchoEtiqueta'].' ';
            		$estiloControl.='col-xs-'.$this->atributos['anchoCaja'].' ';
            	}
            	$estiloLabel.='col-sm-'.$this->atributos['anchoEtiqueta'].' col-md-'.$this->atributos['anchoEtiqueta'].' col-lg-'.$this->atributos['anchoEtiqueta'];
            	$estiloControl.='col-sm-'.$this->atributos['anchoCaja'].' col-md-'.$this->atributos['anchoCaja'].' col-lg-'.$this->atributos['anchoCaja'];

                		//Fin manejo de responsiveness
                		$this->cadenaHTML .= '<div class="form-group row">';
                		$this->cadenaHTML .= '<label for="'. $this->atributos['id'].'" class="'.$estiloLabel.' col-form-label">';
                		$this->cadenaHTML .= $this->atributos['etiqueta'];

                		$this->cadenaHTML .= '</label>';
                		$this->cadenaHTML .= '<div class="'.$estiloControl.'">';
                	}

        $this->cadenaHTML .= ' <textarea class="form-control" rows="' . $atributos['filas'] . '" id="' . $this->atributos['id'] . '"  name="' . $this->atributos['id'] . '"  value="' . $atributos['valor'] . '" ';

        if (isset($atributos['validar']) && $atributos['validar'] = 'required') {
            $this->cadenaHTML .= 'required="true"  ';
        }

        $this->cadenaHTML .= ' >';

        if (isset($atributos['valor'])) {
            $this->cadenaHTML .= $atributos['valor'];
        }
        $this->cadenaHTML .= '</textarea>';

        $this->cadenaHTML .= '</div></div>';

        return $this->cadenaHTML;

    }

}
