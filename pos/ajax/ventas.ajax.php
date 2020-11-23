<?php
require_once "../controladores/ventas.controlador.php";
require_once "../modelos/ventas.modelo.php";

class AjaxVentas{

     /*=============================================
  GENERAR CÓDIGO A PARTIR DE Comprobante
  =============================================*/
  public $idTipoComprobante;

  public function ajaxCrearCodigoVenta(){

  	$item = "id_tipoComprobante";
  	$valor = $this->idTipoComprobante;
    

  	$respuesta = ControladorVentas::ctrMostrarVentas($item, $valor);

  	echo json_encode($respuesta);

  }
}

/*=============================================
GENERAR CÓDIGO A PARTIR DE Ventas
=============================================*/	

if(isset($_POST["idTipoComprobante"])){

	$codigoVentas = new AjaxVentas();
	$codigoVentas -> idTipoComprobante = $_POST["idTipoComprobante"];
	$codigoVentas -> ajaxCrearCodigoVenta();

}
?>