<?php

if($_SESSION["perfil"] == "Especial"){

  echo '<script>

    window.location = "inicio";

  </script>';

  return;

}

?>

<div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      
      Crear venta
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Crear venta</li>
    
    </ol>

  </section>

  <section class="content">

    <div class="row">

      <!--=====================================
      EL FORMULARIO
      ======================================-->
      
      <div class="col-lg-5 col-xs-12">
        
        <div class="box box-success">
          
          <div class="box-header with-border"></div>

          <form role="form" method="post" class="formularioVenta">

            <div class="box-body">
  
              <div class="box">

                <!--=====================================
                ENTRADA DEL VENDEDOR
                ======================================-->
            
                <div class="form-group">
                
                
                  <div class="input-group">
                    
                    <span class="input-group-addon"><i class="fa fa-user"></i></span> 

                    <input type="text" class="form-control" id="nuevoVendedor" value="<?php echo $_SESSION["nombre"]; ?>" readonly>

                    <input type="hidden" name="idVendedor" value="<?php echo $_SESSION["id"]; ?>">

                  </div>

                </div> 
                <!--=====================================
                ENTRADA DEL COMPROBANTE
                ======================================--> 
                <div class="form-group row">
                  
                <div class="col-xs-4" >

                    <div class="input-group ">
                    
                      <span class="input-group-addon"><i class="fa fa-file"></i></span>

                     <select class="form-control" id="nuevoComprobante" name="nuevoComprobante" required>

                        <option value="">Tipo de comprobante </option>

                        <?php

                          $item = null;
                          $valor = null;

                          $comprobante = ControladorComprobantes::ctrMostrarComprobantes($item, $valor);

                          foreach ($comprobante as $key => $value) {
                            
                            echo '<option value="'.$value["id"].'">'.$value["nombre"].'</option>';
                          }

                        ?>
                      
                                    
                      </select>    

                     </div>
                     
                  </div>
                       

                        <div class="cajasComprobantes"></div>                           
                        
                        <input type="hidden" id="listaComprobantes" name="listaComprobantes">
                  <!--=====================================
                  ENTRADA DEL Moneda
                  ======================================--> 
                  <div class="col-xs-4" >

                    <div class="input-group ">

                      <span class="input-group-addon"><i class="fa fa-file"></i></span> 
                      <select class="form-control" id="nuevaMoneda" name="nuevaMoneda" required>

                        <option value="">Selecione la Moneda</option>

                        <option value="PEN">Soles</option>

                        <option value="USD">Dolares</option>
                      
                                    
                      </select>    

                    </div>

                  </div>        

                  <!--=====================================
                  ENTRADA DEL CÓDIGO
                 ======================================--> 
                 <div class="col-xs-4">
                    <div class="input-group" >
                    
                    <span class="input-group-addon"><i class="fa fa-key"></i></span>
                    <input type="text" class="form-control" id="nuevaVenta" name="nuevaVenta"  readonly>
                   <?php

                    //$item = null;
                    //$valor = null;
                    

                   // $ventas = ControladorVentas::ctrMostrarVentas($item, $valor);

                    //if(!$ventas){

                      //echo '';
                  

                    //}else{

                      //foreach ($ventas as $key => $value) {
                        
                        
                      
                      //}
                   
                      //$codigo = $value["codigo" ]+ 1 ;



                      //echo '<input type="text" class="form-control" id="nuevaVenta" name="nuevaVenta"  value="'.$codigo.'" readonly>';
                  

                   // }

                    ?>
                    
                    
                  </div>
                  </div> 
                  
                  
                 
                </div>


                <!--=====================================
                ENTRADA DEL CLIENTE
                ======================================--> 

                <div class="form-group row">
                
                <div class="col-xs-10">
                  
                  <div class="input-group ">
                    
                    <span class="input-group-addon"><i class="fa fa-users"></i></span>
                    
                    <select class="form-control select2" id="seleccionarCliente" name="seleccionarCliente" required>
                    
                    <option value="">Seleccionar cliente</option>
                                       
                    
                    <?php

                      $item = null;
                      $valor = null;

                      $categorias = ControladorClientes::ctrMostrarClientes($item, $valor);

                       foreach ($categorias as $key => $value) {

                         echo '<option value="'.$value["id"].'">'.$value["nombre"].'-'.$value["tipoDocu"].':'.$value["documento"].'</option>';
                         

                        }
                        ?>
                    </select>

                    

                    
                   <span class="input-group-addon">

                    <button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#modalAgregarCliente" data-dismiss="modal">Agregar cliente</button>

                    </span>
                  

                  
                  </div>
                
                  </div>
                <!--=====================================
                ENTRADA PARA DNI
                ======================================--> 
               
                
                
              </div>
                
                
                <!--=====================================
                ENTRADA PARA AGREGAR PRODUCTO
                ======================================--> 

                <div class="form-group row nuevoProducto">

                

                </div>

                <input type="hidden" id="listaProductos" name="listaProductos">

                


                <!--=====================================
                BOTÓN PARA AGREGAR PRODUCTO
                ======================================-->

                <button type="button" class="btn btn-default hidden-lg btnAgregarProducto">Agregar producto</button>

                <hr>

                  
                
                </br>
                

                <div class="row">
                

                  <!--=====================================
                  ENTRADA IMPUESTOS Y TOTAL
                  ======================================-->
                  
                  <div class="col-xs-6 pull-right">
                    <table class="table">
                      <thead>
                        <tr>
                          <th>Total</th>      
                        </tr>
                      </thead>
                      <tbody>
                          <tr>

                            <td class="col-xs-2">
                            
                            <div class="input-group">
                           
                              <span class="input-group-addon">S/.</span>

                              <input type="text" class="form-control input-lg" id="nuevoTotalVenta" name="nuevoTotalVenta" total="" placeholder="00000" readonly required>

                              <input type="hidden" name="totalVenta" id="totalVenta">
                                                     
                            </div>

                            </td>
                          

                          </tr>

                      </tbody>

                    </table>

                  </div>
                
                  </div>
                 

               
                
                

                <hr>
               

                <!--=====================================
                ENTRADA MÉTODO DE PAGO
                ======================================-->

                <div class="form-group row">
                  
                  <div class="col-xs-6" style="padding-right:0px">
                    
                     <div class="input-group">
                  
                      <select class="form-control" id="nuevoMetodoPago" name="nuevoMetodoPago" required>
                        <option value="">Seleccione método de pago</option>
                        <option value="Efectivo">Efectivo</option>
                        <option value="TC">Tarjeta Crédito</option>
                        <option value="TD">Tarjeta Débito</option>    
                                        
                      </select>    

                      </div>

                  </div>

                  <div class="cajasMetodoPago"></div>

                  <input type="hidden" id="listaMetodoPago" name="listaMetodoPago">

                </div>

                <br>
      
              </div>

          </div>

          <div class="box-footer">

            <button type="submit" class="btn btn-primary pull-right">Guardar venta</button>

          </div>

          </form>

        <?php

          $guardarVenta = new ControladorVentas();
          $guardarVenta -> ctrCrearVenta();
          
        ?>

        </div>
      </div>

      <!--=====================================
      LA TABLA DE PRODUCTOS
      ======================================-->

      <div class="col-lg-7 hidden-md hidden-sm hidden-xs">
        
        <div class="box box-warning">

          <div class="box-header with-border"></div>

          <div class="box-body">
            
            <table class="table table-bordered table-striped dt-responsive tablaVentas">
              
               <thead>

                 <tr>
                  <th style="width: 10px">#</th>
                  <th>Imagen</th>
                  <th>Código</th>
                  <th>Descripcion</th>
                  <th>Stock</th>
                  <th>Acciones</th>
                </tr>

              </thead>

            </table>

          </div>

        </div>
        




      </div>

    </div>
   
  </section>

</div>

<!--=====================================
MODAL AGREGAR CLIENTE
======================================-->

<div id="modalAgregarCliente" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Agregar cliente</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="box-body">

           <!-- ENTRADA PARA SELECCIONAR DOcuemnto -->

           <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-th"></i></span> 

                <select class="form-control input-lg " id="tipoDocumento" name="tipoDocumento" required>
                  
                  <option value="">Tipo Documento</option>
                  <option value="RUC">RUC</option>
                  <option value="DNI">DNI</option>

                 
  
                </select>

              </div>

            </div>

          <!-- ENTRADA PARA EL DOCUMENTO ID -->
            
          <div class="form-group ">

          <div class="form-group row">

              <div class="input-group  ">
              
               

                <input type="text" min="0" class="form-control input-lg" name="nuevoDocumentoId" placeholder="ingrese documento" id="nroDocumento" required>

                  <span class="input-group-addon"><button class="btn btn-primary hidden-sm " type="submit" onclick="busqueda(); return false">

                <span class=" glyphicon glyphicon-search"></span>

                </button></span> 

              </div>
              
             </div>

            </div>
            
            
          
          
            

            <!-- ENTRADA PARA EL NOMBRE -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-user"></i></span> 
                       
                
                <input type="text" class="form-control input-lg" name="nuevoCliente" id="nuevoCliente" placeholder="nombre"  required>

              </div>

            </div>

           

            <!-- ENTRADA PARA EL Direccion -->
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-car"></i></span> 
                       
                
                <input type="text" class="form-control input-lg" name="nuevaDireccion" id="nuevaDireccion" placeholder="Direccion"  required>

              </div>

            </div>
            

            
           
            

           
             
  
          </div>
          

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary">Guardar cliente</button>

        </div>

      </form>

      <?php

        $crearCliente = new ControladorClientes();
        $crearCliente -> ctrCrearCliente();

      ?>

    </div>

  </div>

</div>


