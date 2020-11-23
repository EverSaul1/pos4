(function($){
    $.ajaxblock    = function(){
       $("body").prepend("<div id='ajax-overlay'><div id='ajax-overlay-body' class='center'><i class='fa fa-spinner fa-pulse fa-3x fa-fw'></i><span class='sr-only'>Loading...</span></div></div>");
       $("#ajax-overlay").css({
          position: 'absolute',
          color: '#FFFFFF',
          top: '0',
          left: '0',
          width: '100%',
          height: '100%',
          position: 'fixed',
          background: 'rgba(39, 38, 46, 0.67)',
          'text-align': 'center',
          'z-index': '9999'
       });
       $("#ajax-overlay-body").css({
          position: 'absolute',
          top: '40%',
          left: '50%',
          width: '120px',
          height: '48px',
          'margin-top': '-12px',
          'margin-left': '-60px',
          //background: 'rgba(39, 38, 46, 0.1)',
          '-webkit-border-radius':   '10px',
          '-moz-border-radius':      '10px',
          'border-radius':        '10px'
       });
       $("#ajax-overlay").fadeIn(50);
    };
    $.ajaxunblock  = function(){
       $("#ajax-overlay").fadeOut(100, function()
       {
          $("#ajax-overlay").remove();
       });
    };
 })(jQuery);
         function busqueda(){
                //$this.button('loading');
                $.ajaxblock();
                $.ajax({
                   data: { "nruc" : $("#nroDocumento").val() },
                   type: "POST",
                   dataType: "json",
                   url: "vistas/modulos/sunat/consulta.php",
                }).done(function( data, textStatus, jqXHR ){
                   if(data['success']!="false" && data['success']!=false)
                   {
                      $("#json_code").text(JSON.stringify(data, null, '\t'));
 
                      var res = JSON.stringify(data['result']['RUC']);
                     // alert(data['result']['RUC']);
                               //console.log(JSON.stringify(respuesta));
                      $('#nuevaDireccion').val(data['result']['Direccion']);
                      $('#nuevoCliente').val(data['result']['RazonSocial']);
                      $('#tipo').val(data['result']['Tipo']);
                      if(typeof(data['result'])!='undefined')
                      {
 
                         //$("#tbody").html("");
                         $.each(data['result'], function(i, v)
                         {
                            //$("#tbody").append('<tr><td>'+i+'<\/td><td>'+v+'<\/td><\/tr>');
                            
                         });
                      }
 
                      $.ajaxunblock();
                   }else{
                      if(typeof(data['msg'])!='undefined')
                      {
                         alert(data['msg']);
                         
                         $('#nuevaDireccion').val('');
                         $('#tipo').val('');
                         $('#nuevoCliente').val('');
                      }
                      //$this.button('reset');
                      $.ajaxunblock();
                   }
                }).fail(function( jqXHR, textStatus, errorThrown ){
                   alert( "Solicitud fallida:" + textStatus );
                   $.ajaxunblock();
                });
    }