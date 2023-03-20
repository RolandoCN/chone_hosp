<?php

namespace App\Http\Controllers\Bodega;
use App\Http\Controllers\Controller;
use App\Models\Accesos\Perfil;
use App\Models\Accesos\PerfilAcceso;
use App\Models\Bodega\Proveedor;
use App\Models\Bodega\Producto;
use App\Models\Bodega\CabeceraIngresoProdModel;
use App\Models\Bodega\DetalleIngresoProdModel;
use App\Models\Bodega\BodegaMovimiento;
use App\Models\User;
use \Log;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class IngresoBodegaController extends Controller
{
    public function index(){
        $tipoMov=DB::table('bod_tipomov')
        ->where('estado','A')->get();
        $bodegas=DB::table('bod_bodega')
        ->where('estado','A')->get();
        return view('bodega.ingreso',[
            "tipoMov"=>$tipoMov,
            "bodegas"=>$bodegas
        ]);
    }

    public function buscarProducto(Request $request){

        $data = [];
        if($request->has('q')){
            $search = $request->q;
            $text=mb_strtoupper($search);
            $data=Producto::where(function($query)use($text){
                $query->where('nombre', 'like', '%'.$text.'%');
                // ->orWhere('cedula', 'like', '%'.$text.'%');
            })
            ->take(10)->get();
        }
        
        return response()->json($data);

    }

    public function buscarProveedor(Request $request){

        $data = [];
        if($request->has('q')){
            $search = $request->q;
            $text=mb_strtoupper($search);
            $data=Proveedor::where(function($query)use($text){
                $query->where('nombre', 'like', '%'.$text.'%')
                ->orWhere('ruc', 'like', '%'.$text.'%');
            })
            ->take(10)->get();
        }
        
        return response()->json($data);

    }

    public function infoProducto($id){
        $data=DB::table('bod_producto as product')
        ->leftJoin('bod_categoria as cat', 'cat.idbod_categoria','product.id_categoria')
        ->leftJoin('bod_presentacion as pres', 'pres.idbod_presentacion','product.id_presentacion')
        ->select('product.idbod_producto as idproducto', 'product.nombre as producto', 'cat.nombre as categoria', 'product.id_categoria', 'product.id_presentacion','pres.descripcion as prese')
        ->where('idbod_producto',$id)
        ->first(); 
        return response()->json([
            "error"=>false,
            "data"=>$data           
        ]);      
    }

    public function guardaIngreso(Request $request){
        // dd($request->all());
        $transaction=DB::transaction(function() use ($request){
            try{ 
                $validator = Validator::make($request->all(), [
                    'tipo_movi' => 'required',
                    'cmb_bodega' => 'required',
                    'idproveedor' => 'required',
                    'observacion' => 'required',
                    'num_fact_proforma' => 'required',
                    'num_comprobante' => 'required',        
                    
                ]);
                
                if($validator->fails()){
                    return (['mensaje'=>'Complete todos los datos del formulario','error'=>true]);
                }

                $id_producto_array=$request->id_producto_sel;
       
                //registramos la cabecera
                $ingreso=new CabeceraIngresoProdModel();
                $ingreso->observacion=$request->observacion;
                $ingreso->num_comprobante=$request->num_comprobante;
                $ingreso->num_factura_proforma=$request->num_fact_proforma;
                $ingreso->estado='Ingresado';              
                $ingreso->fecha_ingreso=date('Y-m-d H:i:s');
                $ingreso->usuario_ingresa=auth()->user()->id;
                $ingreso->id_tipo_movimiento_ingreso=$request->tipo_movi;
                $ingreso->id_bodega=$request->cmb_bodega;
                $ingreso->id_proveedor=$request->idproveedor;

                if($ingreso->save()){
                    //array detalle
                    $id_producto_array=$request->id_producto_sel;
                    $producto_array=$request->producto_sel;
                    $id_categoria_array=$request->idcategoria_p;
                    $categoria_array=$request->categoria_p;
                    $id_presentacion_array=$request->idpresentacion_p;
                    $presentacion_array=$request->presentacion_p;
                    $pedido_array=$request->pedido;
                    $costo_unit_array=$request->costo_unit;
                    $total_array=$request->total;


                    $cont=0;
                    $total_factura_prof=0;
                    //registramos los detalles localmente
                    while($cont < count($id_producto_array)){

                        $costototal=$pedido_array[$cont] * number_format(($costo_unit_array[$cont]),2,'.', '');
                        $total_factura_prof=$total_factura_prof + $costototal;
                       
                        $detalles=new DetalleIngresoProdModel();
                        $detalles->id_cab_ingreso_producto=$ingreso->id_cab_ingreso_producto;
                        $detalles->id_producto=$id_producto_array[$cont];
                        $detalles->producto=$producto_array[$cont];
                        $detalles->id_categoria=$id_categoria_array[$cont];
                        $detalles->categoria=$categoria_array[$cont];
                        $detalles->id_presentacion=$id_presentacion_array[$cont];
                        $detalles->presentacion=$presentacion_array[$cont];
                        $detalles->cantidad=$pedido_array[$cont];
                        $detalles->costo_unitario=number_format(($costo_unit_array[$cont]),2,'.', '');
                        $detalles->total=number_format(($costototal),2,'.', '');
                        $detalles->estado='Ingresado';
                        $detalles->fecha_registro=date('Y-m-d H:i:s');
                        $detalles->usuario_registra=auth()->user()->id;
                        if($detalles->save()){
                            //income Record
                            $detalleMovimiento=new BodegaMovimiento();
                            $detalleMovimiento->producto=$producto_array[$cont];
                            $detalleMovimiento->id_producto=$id_producto_array[$cont];
                            $detalleMovimiento->categoria=$categoria_array[$cont];
                            $detalleMovimiento->presentacion=$presentacion_array[$cont];
                            $detalleMovimiento->cantidad=$pedido_array[$cont];
                            $detalleMovimiento->precio_unit=number_format(($costo_unit_array[$cont]),2,'.', '');
                            $detalleMovimiento->total=number_format(($costototal),2,'.', '');                        
                            $detalleMovimiento->fecha_creacion=date('Y-m-d H:i:s');
                            $detalleMovimiento->idusuario_crea=auth()->user()->id;
                            $detalleMovimiento->tipo="Ingreso";
                            $detalleMovimiento->estado="Ingresado";
                            $detalleMovimiento->save();

                            //update the stock of the product
                            $actualizaStock=Producto::where('idbod_producto',$detalles->id_producto)
                            ->first();
                            $current_stock=$actualizaStock->stock;
                            $actualizaStock->stock=$current_stock + $detalles->cantidad;
                            $actualizaStock->save();
                         
                            $cont=$cont+1;
                          
                        }            
                    
                            
                    } 

                    //actualizamos el valor
                    $ingreso=CabeceraIngresoProdModel::where('id_cab_ingreso_producto',$ingreso->id_cab_ingreso_producto)->update(['valor'=>$total_factura_prof]);

                    return (['mensaje'=>'Ingreso procesado exitosamente','error'=>false,'ingreso_data'=>$ingreso]);    

                }else{
                    DB::rollback();
                    return (['mensaje'=>'No se pudo registrar la información','error'=>true]); 
                }
                   
                
            } catch (\Throwable $e) {
                DB::rollback();
                Log::error(__CLASS__." => ".__FUNCTION__." => Mensaje =>".$e->getMessage());
                return (['mensaje'=>'Ocurrió un error,intentelo más tarde','error'=>true]); 
            }
        });
        return ($transaction);

    }
}