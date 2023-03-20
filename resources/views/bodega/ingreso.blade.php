@extends('layouts.app')

@section('content')

    <link rel="stylesheet" href="{{asset('plugins/sweetalert/sweetalert.css')}}">
    <section class="content-header">
        <h1>
            Gestión Ingreso Bodega
        </h1>

    </section>

    <section class="content" id="content_form">

      
        <div id="form_ing" >
            <form class="form-horizontal" id="form_ingreso_bod" autocomplete="off" method="post"
                action="">
                {{ csrf_field() }}
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title" id="titulo_form"> </h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                                title="Collapse">
                                <i class="fa fa-minus"></i>
                            </button>
                            
                        </div>
                    </div>
                    <div class="box-body">

                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-3 control-label">Tipo Movimiento</label>
                            <div class="col-sm-8">
                                <select data-placeholder="Seleccione Un Tipo Movimiento" style="width: 100%;" class="form-control select2" name="tipo_movi" id="tipo_movi" >
                                    @foreach ($tipoMov as $dato)
                                        <option value=""></option>
                                        <option value="{{ $dato->id_bod_tipomov}}" >{{ $dato->descripcion }} </option>
                                    @endforeach
                                
                                </select>
                            </div>
                            
                        </div>

                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-3 control-label">Bodega</label>
                            <div class="col-sm-8">
                                <select data-placeholder="Seleccione Una Bodega" style="width: 100%;" class="form-control select2" name="cmb_bodega" id="cmb_bodega" >
                                    @foreach ($bodegas as $dato)
                                        <option value=""></option>
                                        <option value="{{ $dato->id_bodega}}" >{{ $dato->nombre }} </option>
                                    @endforeach
                                </select>
                            </div>
                            
                        </div>

                        <div class="form-group">

                            <label for="inputPassword3" class="col-sm-3 control-label">Observación</label>
                            <div class="col-sm-8">
                                <input type="text" minlength="1" maxlength="100" onKeyPress="if(this.value.length==100) return false;" class="form-control" id="observacion" name="observacion" placeholder="Observación">
                            </div>
                           
                        </div>

                        <div class="form-group">

                            <label for="inputPassword3" class="col-sm-3 control-label">Nro. Comprobante</label>
                            <div class="col-sm-8">
                                <input type="number" minlength="1" maxlength="100" onKeyPress="if(this.value.length==100) return false;" class="form-control" id="num_comprobante" name="num_comprobante" placeholder="Nro. Comprobante">
                            </div>
                           
                        </div>

                        <div class="form-group">

                            <label for="inputPassword3" class="col-sm-3 control-label">Nro. Factura/Proforma</label>
                            <div class="col-sm-8">
                                <input type="text" minlength="1" maxlength="100" onKeyPress="if(this.value.length==100) return false;" class="form-control" id="num_fact_proforma" name="num_fact_proforma" placeholder="Nro. Factura/Proforma">
                            </div>
                           
                        </div>

                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-3 control-label">Proveedor</label>
                            <div class="col-sm-8">
                                <select data-placeholder="Seleccione Un Proveedor" style="width: 100%;" class="form-control select2" name="idproveedor" id="idproveedor" >
                                
                                </select>
                            </div>
                            
                        </div>

                        <div class="form-group">

                            <label for="inputPassword3" class="col-sm-3 control-label">Producto</label>
                            <div class="col-sm-7">
                                <select data-placeholder="Seleccione Un Producto" style="width: 100%;" class="form-control select2" name="idproducto" id="idproducto" >
                                
                                </select>
                            </div>

                            <div class="col-sm-1" style="text-align-last: end;margin-top: 3px">
                                <button type="button" class="btn btn-primary " onclick="agregarCarrito()"><i class="fa fa-plus"></i></button>
                            </div>
                           
                        </div>

                       
                        <div style="margin-top:22px; margin-bottom: 22px; display:none" id="seccion_productos">
                            <!-- tabla inicial o cuando no haiga datos en el carrito -->
                            <div id="secctabla_items_sd" class="table-responsive" >
                                <table ref="tabla_item_sd"  style="color: black;font-size:13px"
                                    class="table table-striped table-bordered dataTable no-footer tble_carrito " role="grid" aria-describedby="datatable_info"
                                    id="idtabla_item_sd">
                                    <thead style="background-color:#3c8dbc; color:white; text-align: center;">
                                        <tr>
                                            <th scope="col" style="text-align:center"></th>
                                            <th  style="text-align: center" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-label="Name: activate to sort column ascending" aria-sort="descending">Producto</th>
                                            <th scope="col" style="text-align:center">Presentacion</th>
                                            <th scope="col" style="text-align:center">Categoria</th>
                                            <th scope="col" style="text-align:center">Cantidad</th>
                                            <th scope="col" style="text-align:center">Precio Unitario</th>
                                            <th scope="col" style="text-align:center">Total</th>
                                           
                                        </tr>
                                    </thead>
                                    <tbody id="carrito_producto">
                                      
                                    </tbody>
                                    <tfoot id="tb_pie_TotalMaterial">                                                        
                                                    
                                    </tfoot>
                                </table>
                            </div>   
                           
                        </div> 

                        <hr>
                        <div class="form-group">
                            <div class="col-sm-12 text-center" >
                            
                                <button type="submit" disabled id="btn_registrar" class="btn btn-success btn-sm">
                                   Registrar
                                </button>
                                <button type="button" id="btn_cancelar" style="display:none" onclick="cancelar()" class="btn btn-danger btn-sm">Cancelar</button>
                            </div>
                        </div>
                        
                    </div>

                </div>
            
            </form>
        </div>


    </section>

@endsection
@section('scripts')
    <script src="{{asset('plugins/sweetalert/sweetalert.js')}}"></script>
    <script src="{{asset('js/bodega/ingreso.js?v='.rand())}}"></script>




@endsection
