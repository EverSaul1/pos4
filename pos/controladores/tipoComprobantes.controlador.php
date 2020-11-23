<?php

class ControladorComprobantes{

	
	/*=============================================
	MOSTRAR 
	=============================================*/

	static public function ctrMostrarComprobantes($item, $valor){

		$tabla = "tipoComprobante";

		$respuesta = ModeloComprobantes::mdlMostrarComprobantes($tabla, $item, $valor);

		return $respuesta;
	
	}

}