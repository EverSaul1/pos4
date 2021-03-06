<?php

require_once "../../../controladores/ventas.controlador.php";
require_once "../../../modelos/ventas.modelo.php";

require_once "../../../controladores/clientes.controlador.php";
require_once "../../../modelos/clientes.modelo.php";

require_once "../../../controladores/usuarios.controlador.php";
require_once "../../../modelos/usuarios.modelo.php";

require_once "../../../controladores/productos.controlador.php";
require_once "../../../modelos/productos.modelo.php";

require_once "../../tcpdf/CifrasEnLetras.php";



class imprimirFactura{

public $codigo;

public function traerImpresionFactura(){



//TRAEMOS LA INFORMACIÓN DE LA VENTA


$itemVenta = "codigo";
$valorVenta = $this->codigo;

$respuestaVenta = ControladorVentas::ctrMostrarVentas($itemVenta, $valorVenta);

$fecha = substr($respuestaVenta["fecha"],0,-8);
$productos = json_decode($respuestaVenta["productos"], true);
$neto = number_format($respuestaVenta["neto"],2);
$impuesto = number_format($respuestaVenta["impuesto"],2);
$total = number_format($respuestaVenta["total"],2);

//TRAEMOS LA INFORMACIÓN DEL CLIENTE

$itemCliente = "id";
$valorCliente = $respuestaVenta["id_cliente"];

$respuestaCliente = ControladorClientes::ctrMostrarClientes($itemCliente, $valorCliente);

//TRAEMOS LA INFORMACIÓN DEL VENDEDOR

$itemVendedor = "id";
$valorVendedor = $respuestaVenta["id_vendedor"];

$respuestaVendedor = ControladorUsuarios::ctrMostrarUsuarios($itemVendedor, $valorVendedor);

//REQUERIMOS LA CLASE TCPDF

require_once('tcpdf_include.php');

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->startPageGroup();

$pdf->AddPage();

// ---------------------------------------------------------

$bloque1 = <<<EOF

	<table>
		
		<tr>
			
			<td style="width:150px"><img src="images/logotipo2.png"></td>

			<td style="background-color:white; width:140px">
				<br>

				<h6 style="text-align:center;">REDSTORE IMPORTACIONES PERÚ</h6>
				
				<div style="font-size:7.5px; text-align:center; line-height:15px;">

				<br>

				Dirección: Jr.Ayacucho 277

				<br>

				Celular: +51 995982889
				
				<br>
				
				redstore@gmail.com
					
				</div>

			</td>

			<td style="background-color:white; width:140px"></td>
			

			<td style="border: 1px solid #666; background-color:white; width:110px; text-align:center; color:red"><br><br>R.U.C:1002448624<br>FACTURA N.<br>F001-$valorVenta</td>

		</tr>

	</table>

EOF;

$pdf->writeHTML($bloque1, false, false, false, false, '');

// ---------------------------------------------------------

$bloque2 = <<<EOF

	<table>
		
		<tr>
			
			<td style="width:540px"><img src="images/back.jpg"></td>
		
		</tr>

	</table>

	<table style="font-size:10px; padding:5px 10px;">
		<tr>
		
			<td style="border: 1px solid #666; background-color:white; width:380px">Vendedor: $respuestaVendedor[nombre]</td>

			<td style="border: 1px solid #666; background-color:white; width:160px; text-align:left">
			
				Fecha de venta: $fecha

			</td>

		</tr>
	
		<tr>
		
			<td style="border: 1px solid #666; background-color:white; width:380px" >

				Cliente: $respuestaCliente[nombre]

			</td>
			
			<td style="border: 1px solid #666; background-color:white; width:160px; text-align:left">

			RUC: $respuestaCliente[documento]

			</td>
			

		</tr>
		<tr>
			<td style="border: 1px solid #666; background-color:white; width:540px">

				Direccion: $respuestaCliente[direccion]

			</td>
			
		</tr>

		

		<tr>
		
		<td style="border-bottom: 1px solid #666; background-color:white; width:540px"></td>

		</tr>

	</table>

EOF;

$pdf->writeHTML($bloque2, false, false, false, false, '');

// ---------------------------------------------------------

$bloque3 = <<<EOF

	<table style="font-size:10px; padding:5px 10px;">

		<tr>
		
		<td style="border: 1px solid #666; background-color:white; width:260px; text-align:center">Producto</td>
		<td style="border: 1px solid #666; background-color:white; width:80px; text-align:center">Cantidad</td>
		<td style="border: 1px solid #666; background-color:white; width:100px; text-align:center">Valor Unit.</td>
		<td style="border: 1px solid #666; background-color:white; width:100px; text-align:center">Valor Total</td>

		</tr>

	</table>

EOF;

$pdf->writeHTML($bloque3, false, false, false, false, '');

// ---------------------------------------------------------



foreach ($productos as $key => $item) {

$itemProducto = "descripcion";
$valorProducto = $item["descripcion"];
$orden = null;

$respuestaProducto = ControladorProductos::ctrMostrarProductos($itemProducto, $valorProducto, $orden);

if(is_array($respuestaProducto)){

	$valorUnitario = number_format($respuestaProducto["precio_venta"],2);
}
	$precioTotal = number_format($item["total"], 2);







$bloque4 = <<<EOF

	<table style="font-size:10px; padding:5px 10px;">

		<tr>
			
			<td style="border: 1px solid #666; color:#333; background-color:white; width:260px; text-align:center">
				$item[descripcion]
			</td>

			<td style="border: 1px solid #666; color:#333; background-color:white; width:80px; text-align:center">
				$item[cantidad]
			</td>

			<td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:left">S/.
				$valorUnitario
			</td>

			<td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:left">S/.
				$precioTotal
			</td>


		</tr>
		

	</table>


EOF;

$pdf->writeHTML($bloque4, false, false, false, false, '');

}


// ---------------------------------------------------------



$bloque5 = <<<EOF

	<table style="font-size:10px; padding:5px 10px;">

		<tr>

			<td style="color:#333; background-color:white; width:340px; text-align:center"></td>

			<td style="border-bottom: 1px solid #666; background-color:white; width:100px; text-align:center"></td>

			<td style="border-bottom: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center"></td>

		</tr>
		
		<tr>
			
		
			<td style="border-right: 1px solid #666; color:#333; background-color:white; width:340px; text-align:center"></td>

			<td style="border: 1px solid #666;  background-color:white; width:100px; text-align:center">
				SubTotal:
			</td>

			<td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:left">
				S/. $neto
			</td>

		</tr>

		<tr>

			<td style="border-right: 1px solid #666; color:#333; background-color:white; width:340px; text-align:center"></td>

			<td style="border: 1px solid #666; background-color:white; width:100px; text-align:center">
				I.G.V:
			</td>
		
			<td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:left">
			S/. $impuesto
			</td>

		</tr>

		<tr>
		
			<td style="border-right: 1px solid #666; color:#333; background-color:white; width:340px; text-align:center"></td>

			<td style="border: 1px solid #666; background-color:white; width:100px; text-align:center">
				Total:
			</td>
			
			<td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:left">
				S/. $total
			</td>

		</tr>

	</table>

EOF;

$pdf->writeHTML($bloque5, false, false, false, false, '');

//-----------------------------------------------------------

$c=new CifrasEnLetras();

$letra = ($c->convertirEurosEnLetras($total));

$bloque6 = <<<EOF
<table style="font-size:10px; padding:5px 10px;">
<tr>
			
			<td style="width:540px"><img src="images/back.jpg"></td>
		
		</tr>
		
		<tr>
			<td style="border: 1px solid #666; background-color:white; width:320px">

				SON: $letra

			</td>
			
		</tr>

		
	</table>

EOF;
$pdf->writeHTML($bloque6, false, false, false, false, '');

// ---------------------------------------------------------
//SALIDA DEL ARCHIVO 

$pdf->Output('factura.pdf', 'D');

}

}

$factura = new imprimirFactura();
$factura -> codigo = $_GET["codigo"];
$factura -> traerImpresionFactura();

?>