//combo para la busqueda de producto
$('#idproducto').select2({
    placeholder: 'Seleccione una opción',
    ajax: {
    url: '/buscar-producto',
    dataType: 'json',
    delay: 250,
    processResults: function (data) {
        return {
        results:  $.map(data, function (item) {
                return {
                    text: item.nombre,
                    id: item.idbod_producto 
                }
            })
        };
    },
    cache: true
    }
});

//combo para la busqueda de proveedor
$('#idproveedor').select2({
    placeholder: 'Seleccione una opción',
    ajax: {
    url: '/buscar-proveedor',
    dataType: 'json',
    delay: 250,
    processResults: function (data) {
        return {
        results:  $.map(data, function (item) {
                return {
                    text: item.ruc+" "+item.nombre,
                    id: item.id_bod_proveedor  
                }
            })
        };
    },
    cache: true
    }
});

function agregarCarrito(){
    let tipo_movi=$('#tipo_movi').val() 
    let cmb_bodega=$('#cmb_bodega').val() 
    let observacion=$('#observacion').val()
    let num_comprobante=$('#num_comprobante').val() 
    let num_fact_proforma=$('#num_fact_proforma').val() 
    let proveedor=$('#idproveedor').val()
    let producto=$('#idproducto').val()
    
    if(tipo_movi == null || tipo_movi==""){
        alertNotificar("Seleccione un tipo movimiento","error")
        return
    } 
    
    if(cmb_bodega == null || cmb_bodega==""){
        alertNotificar("Seleccione una bodega","error")
        return
    } 

    if(observacion == null || observacion==""){
        alertNotificar("Ingrese una observacion","error")
        $('#observacion').focus()
        return
    } 

    if(num_comprobante == null || num_comprobante==""){
        alertNotificar("Ingrese un número de comprobante","error")
        $('#num_comprobante').focus()
        return
    } 

    if(num_fact_proforma == null || num_fact_proforma==""){
        alertNotificar("Ingrese un número de factura/plataforma","error")
        $('#num_fact_proforma').focus()
        return
    } 


    if(proveedor == null || proveedor==""){
        alertNotificar("Seleccione un proveedor","error")
        return
    }              
  
    // if(cantidad == '' || cantidad==undefined){
    //     alertNotificar("Ingrese una cantidad","error")
    //     $('#cantidad').focus()
    //     return                    
    // }else{
    //     if(cantidad<=0){
    //         alertNotificar("La cantidad debe ser mayor a cero", "error")
    //         return
    //     }
    // }
    $.get("info-producto/"+producto, function(data){
        console.log(data)
        if(data.error==true){
            alertNotificar(data.mensaje,"error");
            return;   
        }

        globalThis.idProdSelecc=data.data.idproducto 
        globalThis.ProdSelecc=data.data.producto
        globalThis.cateProdSelecc=data.data.categoria
        globalThis.idCatProdSelecc=data.data.id_categoria
        globalThis.presProdSelecc=data.data.prese
        globalThis.idPreseProdSelecc=data.data.id_presentacion
        // globalThis.cantidad_selecc=cantidad
    
        añadirALista()
       
    }).fail(function(){
       
        alertNotificar("Se produjo un error, por favor intentelo más tarde","error");  
    });
}

function añadirALista(){
    var nueva_fila=idProdSelecc;
    var nfilas=$("#carrito_producto tr").length;
    if(nfilas>0){
        var dato=$('#id_producto_sel'+idProdSelecc).val();
       
        if(nueva_fila==dato){
            alertNotificar("El producto ya está agregado a la lista","error");
            // $('#cmb_mat').val('').change();
            return;
        }
    }
   
    $('#seccion_productos').show();
    $('#btn_cancelar').show();

    $('#btn_registrar').prop('disabled',false); 

    $('#carrito_producto').append(`<tr id="producto_${idProdSelecc}">
        <td width="5%" class="centrado"> 
            <button type="button" style="margin-right:1px !important" data-toggle="tooltip" data-original-title="Eliminar" class="btn btn-xs btn-danger marginB0" onClick="eliminar_producto(${idProdSelecc})">
                <i class="fa fa-trash" >
                    
                </i> 
            </button>
           
        </td>   
        
       
        <td width="20%" class="centrado">
           
            
            <input type="hidden" name="id_producto_sel[]" id="id_producto_sel${idProdSelecc}" value="${idProdSelecc}">
            <input type="hidden" name="producto_sel[]" id="producto_sel${idProdSelecc}" value="${ProdSelecc}">

            <input type="hidden" name="idcategoria_p[]" id="idcategoria_p${idProdSelecc}" value="${idCatProdSelecc}">
            <input type="hidden" name="categoria_p[]" id="categoria_p${idProdSelecc}" value="${cateProdSelecc}">

            <input type="hidden" name="idpresentacion_p[]" id="idpresentacion_p${idProdSelecc}" value="${idPreseProdSelecc}">
            <input type="hidden" name="presentacion_p[]" id="presentacion_p${idProdSelecc}" value="${presProdSelecc}">

            ${ProdSelecc}
           
        </td>   
        <td width="15%" class="centrado">
           
            ${presProdSelecc}
        </td>   
        <td width="15%" class="centrado">
           
           ${cateProdSelecc}
        </td> 
       

        <td width="15%" class="centrado">
           
            <input type="number"id="class_pedido_${idProdSelecc}" style="width:100% !important;text-align:right" name="pedido[]" onkeyup="tecla_pedido(this,'${idProdSelecc}')"  onblur="validar_pedido(this,'${idProdSelecc}')" >
        </td>  

        <td width="15%" class="centrado">
           
            <input type="number" step="0.01" id="class_costo_unit_pedido_${idProdSelecc}" style="width:100% !important;text-align:right" name="costo_unit[]" onkeyup="tecla_calcula_total(this,'${idProdSelecc}')"  onblur="validar_costo_unit(this,'${idProdSelecc}')" >
        </td>  

        <td width="15%" class="centrado" align="right">
                
            <input type="hidden" id="class_total_${idProdSelecc}" style="width:100% !important;text-align:right" name="total[]">

            <span style="text-align:right" id="total_span_id_${idProdSelecc}">0.00</span>
        </td>  
       
       
         
    </tr>`);

    $('#idproducto').val('').trigger('change.select2')
    $('[data-toggle="tooltip"]').tooltip();

   
}

function limpiarCampos(){
    $('#idproducto').val('').trigger('change.select2')

    $('#tipo_movi').val('').trigger('change.select2') 
    $('#cmb_bodega').val('').trigger('change.select2') 
    $('#observacion').val('')
    $('#num_comprobante').val('') 
    $('#num_fact_proforma').val('') 
    $('#idproveedor').val('').trigger('change.select2')

    $("#carrito_producto tr").html('');
    $('#tb_pie_TotalMaterial').html('');
  
    $('#seccion_productos').hide();   
    $('#btn_cancelar').hide();
    $('#btn_registrar').prop('disabled',true);       
    

}

function cancelar(){
    limpiarCampos()
}

function validar_costo_unit(e,id){
    var valor_costo_unit=$('#class_costo_unit_pedido_'+id).val();  
    if(valor_costo_unit<=0){
        alertNotificar("Ingrese un costo unitario mayor a cero","error");
        $('#class_costo_unit_pedido_'+id).val('');
        $('#class_costo_unit_pedido_'+id).focus();
        calculaTotalIngreso();
        return;
    }

    var valor_pedido=$('#class_pedido_'+id).val();
    var total=valor_pedido * valor_costo_unit; 
    $('#class_total_'+id).val(total.toFixed(2));
    $('#total_span_id_'+id).html(total.toFixed(2));

    calculaTotalIngreso();
}

function validar_pedido(e,id){
    var valor_pedido=$('#class_pedido_'+id).val();   
    if(valor_pedido<=0){
        alertNotificar("La cantidad debe ser mayor que cero","error");
        $('#class_pedido_'+id).focus();
        $('#class_pedido_'+id).val('')
        return;
    }

    var valor_costo_unit=$('#class_costo_unit_pedido_'+id).val();
    var total=valor_pedido * valor_costo_unit; 
    $('#class_total_'+id).val(total.toFixed(2));
    $('#total_span_id_'+id).html(total.toFixed(2));

    calculaTotalIngreso();
}

function tecla_calcula_total(e, id){
   
    var valor_costo_unit=$('#class_costo_unit_pedido_'+id).val();   
   
    if(valor_costo_unit==""){
        var total_au=0;
        $('#class_total_'+id).val('');
        $('#total_span_id_'+id).html(total_au.toFixed(2));
        calculaTotalIngreso();

        return;
        
    }
   
    valor_costo_unit=parseFloat(valor_costo_unit);
    if(valor_costo_unit<=0 && valor_costo_unit!=""){
        alertNotificar("El costo unitario debe ser mayor que cero","error");
        $('#class_costo_unit_pedido_'+id).focus();
        $('#class_costo_unit_pedido_'+id).val('')
        return;
    }

    var valor_ped=$('#class_pedido_'+id).val();
    var total=valor_ped * valor_costo_unit; 
    $('#class_total_'+id).val(total.toFixed(2));
    $('#total_span_id_'+id).html(total.toFixed(2));

    calculaTotalIngreso();
   
}

function tecla_pedido(e, id){

    var valor_pedido=$('#class_pedido_'+id).val();
    if(valor_pedido==""){
        $('#class_pendiente_'+id).val('');
    }
   
    if(valor_pedido<=0 && valor_pedido!=""){
        $('#class_pendiente_'+id).val('');
        return;
    
    }

    
    if(valor_pedido!=""){
        
        valor_pedido=parseFloat(valor_pedido);
       
    }
    var valor_costo_unit=$('#class_costo_unit_pedido_'+id).val();
    var total=valor_pedido * valor_costo_unit; 
    $('#class_total_'+id).val(total.toFixed(2));
    $('#total_span_id_'+id).html(total.toFixed(2));

    calculaTotalIngreso();
}

function calculaTotalIngreso(){
    $('#tb_pie_TotalMaterial').html('');
    var array_total_parcial=[];
    var total_final=0;
    console.log("sss");
    $("input[name='total[]']").each(function(indice, elemento) {
        console.log('dd '+$(elemento).val())
        var tot_parcial=$(elemento).val();
        if(tot_parcial==""){
            tot_parcial=0;
        }
        array_total_parcial.push($(elemento).val());
        total_final=parseFloat(total_final)+parseFloat(tot_parcial);
    });
    if(array_total_parcial.length>0){

        $('#tb_pie_TotalMaterial').append(`<tr>
            <td colspan="6" align="right">TOTAL</td>
            <td align="right"><input type="hidden" value="${total_final.toFixed(2)}" readonly id="total_suma"  style="text-align:right" name="total_suma[]">${total_final.toFixed(2)}</td>  
           
        </tr>`);
    }
}

function eliminar_producto(id){
    $('#producto_'+id).remove();
    calculaTotalIngreso();
    comprobar(); 

   
}
function comprobar(){
    var nFilas = $("#carrito_producto tr").length;
    if(nFilas==0){
        $('#seccion_productos').hide();   
        $('#btn_cancelar').hide();
        $('#btn_registrar').prop('disabled',true);       
    }else{
        $('#seccion_productos').show();   
        $('#btn_cancelar').show();
        $('#btn_registrar').prop('disabled',false);   
    }

}

$('.collapse-link').click();
$('.datatable_wrapper').children('.row').css('overflow','inherit !important');

$('.table-responsive').css({'padding-top':'12px','padding-bottom':'12px', 'border':'0', 'overflow-x':'inherit'});



$("#form_ingreso_bod").submit(function(e){
    e.preventDefault();

    let tipo_movi=$('#tipo_movi').val() 
    let cmb_bodega=$('#cmb_bodega').val() 
    let num_comprobante=$('#num_comprobante').val() 
    let num_fact_proforma=$('#num_fact_proforma').val() 
    let proveedor=$('#idproveedor').val()
    let producto=$('#idproducto').val()
    
    if(tipo_movi == null || tipo_movi==""){
        alertNotificar("Seleccione un tipo movimiento","error")
        return
    } 
    
    if(cmb_bodega == null || cmb_bodega==""){
        alertNotificar("Seleccione una bodega","error")
        return
    } 

    if(num_comprobante == null || num_comprobante==""){
        alertNotificar("Ingrese un número de comprobante","error")
        $('#num_comprobante').focus()
        return
    } 

    if(num_fact_proforma == null || num_fact_proforma==""){
        alertNotificar("Ingrese un número de factura/plataforma","error")
        $('#num_fact_proforma').focus()
        return
    } 


    if(proveedor == null || proveedor==""){
        alertNotificar("Seleccione un proveedor","error")
        return
    }              
 
    //validamos que se haya ingresado al menos un producto al carrito
    let carrito= $("#carrito_producto tr").length
    if(carrito==0){
        alertNotificar("Debe ingresar al menos un producto", "error")
        return
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    //comprobamos si es registro o edicion
    let tipo="POST"
    let url_form="guarda-ingreso-bodega"
  
  
    var FrmData=$("#form_ingreso_bod").serialize();
    console.log(FrmData)
    $.ajax({
            
        type: tipo,
        url: url_form,
        method: tipo,             
		data: FrmData,      
		
        processData:false, 

        success: function(data){
            console.log(data)
            // vistacargando("");                
            if(data.error==true){
                alertNotificar(data.mensaje,'error');
                return;                      
            }
            
            alertNotificar(data.mensaje,"success");
            limpiarCampos()
         
        }, error:function (data) {
            console.log(data)

            // vistacargando("");
            alertNotificar('Ocurrió un error','error');
        }
    });
})