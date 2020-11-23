<?php

require_once "../../../controladores/ventas.controlador.php";
require_once "../../../modelos/ventas.modelo.php";

require_once "../../../controladores/clientes.controlador.php";
require_once "../../../modelos/clientes.modelo.php";

require_once "../../../controladores/usuarios.controlador.php";
require_once "../../../modelos/usuarios.modelo.php";

require_once "../../../controladores/productos.controlador.php";
require_once "../../../modelos/productos.modelo.php";

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

$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

$pdf->AddPage('P', 'A7');

//---------------------------------------------------------

$bloque1 = <<<EOF

<table style="font-size:7px; text-align:center">

	<tr>
		
		<td style="width:160px;">
	
			<div>
			
				
				REDSTORES IMPORTACIONES PERU
				
				
				<br>
				Dirección: Jr.Ayacucho 277

                <br>
                
                Celular: +51 995982889

                <br>

                Correo: redstore@gmail.com

                <br>
                -----------------------------------------
                <br>

                TICKET N.-$valorVenta
                
                <br>

                Fecha: $fecha

                <br>	
                				
                Cliente: $respuestaCliente[nombre]

                <br>

                Direccion:$respuestaCliente[direccion]

                <br>

                DNI:$respuestaCliente[documento]

                <br>
                
				Vendedor: $respuestaVendedor[nombre]

                <br>
                --------------------------------------
                

			</div>

		</td>

	</tr>


</table>

EOF;

$pdf->writeHTML($bloque1, false, false, false, false, '');

// ---------------------------------------------------------
$bloque2 = <<<EOF
		<table style="font-size:7px; padding:5px 10px;">
		<tr>
		<td style=" width:50px; text-align:center">Producto</td>
		<td style=" width:35px; text-align:center">Cant</td>
		<td style=" width:35px; text-align:center">Unit</td>
		<td style=" width:40px; text-align:center">Total</td>
		
        
		</tr>
		

	
		</table>
EOF;

$pdf->writeHTML($bloque2, false, false, false, false, '');

// ---------------------------------------------------------

foreach ($productos as $key => $item) {

//if(is_array($respuestaProducto)){

$valorUnitario = number_format($item["precio"], 2);
//}
$precioTotal = number_format($item["total"], 2);

$bloque3 = <<<EOF

<table style="font-size:6px;">

	<tr>
	
        <td style="width:50px;text-align:left">
        
        $item[descripcion] 
        
		</td>
		<td style="width:25px;text-align:center">
        
		$item[cantidad] 
        
		</td>

		<td style="width:40px;text-align:right">
        
        S/. $valorUnitario 
        
                
		</td>

		<td style="width:45px;text-align:right">
        
        S/. $precioTotal
        
		</td>
		<br>

	</tr>

	

</table>

EOF;

$pdf->writeHTML($bloque3, false, false, false, false, '');
	

}

// ---------------------------------------------------------

$bloque4 = <<<EOF

<table style="font-size:6px; text-align:right">
	<tr>
	
		<td style="width:160px;">
			 ------------------
		</td>

	</tr>
	<tr>
		
		<td style="width:100px;">
			 SubTotal: 
		</td>

		<td style="width:60px;">
			S/. $neto
		</td>

	</tr>

	<tr>
	
		<td style="width:100px;">
			 I.G.V: 
		</td>

		<td style="width:60px;">
			S/. $impuesto
		</td>

	</tr>

	<tr>
	
		<td style="width:160px;">
			 ------------------
		</td>

	</tr>

	<tr>
	
		<td style="width:100px;">
			 TOTAL: 
		</td>

		<td style="width:60px;">
			S/. $total
		</td>

	</tr>

	

</table>



EOF;

$pdf->writeHTML($bloque4, false, false, false, false, '');

// ---------------------------------------------------------
$bloque5 = <<<EOF
	<table style="font-size:7px; text-align:center">
	<tr>
	
		<td style="width:160px;">
			<br>
			<br>
			Muchas gracias por su compra
		</td>

	</tr>

	</table>
EOF;

$pdf->writeHTML($bloque5, false, false, false, false, '');

//SALIDA DEL ARCHIVO 

//$pdf->Output('factura.pdf', 'D');
$pdf->Output('ticket.pdf','D');

}

}

$factura = new imprimirFactura();
$factura -> codigo = $_GET["codigo"];
$factura -> traerImpresionFactura();

?>