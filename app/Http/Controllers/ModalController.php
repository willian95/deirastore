<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;
use App\Modal;

class ModalController extends Controller
{
    
    function index(){

        return view("admin.modals");
    }

    function fetch(){

        try{

            $modal = Modal::first();
            return response()->json(["success" => true, "modal" => $modal]);

        }catch(\Exception $e){
            return response()->json(["success" => false, "err" => $e->getMessage(), "ln" => $e->getLine()]);
        }

    }

    function update(Request $request){

        try{

            if($request->get('image') != null){
                try{

                    $imageData = $request->get('image');
        
                    if(strpos($imageData, "svg+xml") > 0){
        
                        $data = explode( ',', $imageData);
                        $fileName = Carbon::now()->timestamp . '_' . uniqid() . '.'."svg";
                        $ifp = fopen($fileName, 'wb' );
                        fwrite($ifp, base64_decode( $data[1] ) );
                        rename($fileName, 'images/modal/'.$fileName);
        
                    }else{
        
                        $fileName = Carbon::now()->timestamp . '_' . uniqid() . '.' . explode('/', explode(':', substr($imageData, 0, strpos($imageData, ';')))[1])[1];
                        Image::make($request->get('image'))->save(public_path('images/modal/').$fileName);
                    }
        
                }catch(\Exception $e){
        
                    return response()->json(["success" => false, "msg" => "Hubo un error al cargar la imagen", "err" => $e->getMessage()]);
        
                }
            }

            $modal = Modal::first();

            dd($fileName);

            if($modal != null){
                $modal->status = $request->status;
                $modal->text = $request->text;
                if($request->get('image') != null){
                    $modal->image = url('/').'/images/modal/'.$fileName;
                }
                if($request->deleteImage == true){
                    $modal->image = null;
                }
                $modal->update();
            }else{
                $modal = new Modal;
                
                $modal->status = $request->status;
                $modal->text = $request->text;
                if($request->get('image') != null){
                    $modal->image = url('/').'/images/modal/'.$fileName;
                }
                $modal->save();

            }
               

            return response()->json(["success" => true, "msg" => "Modal Actualizado"]);

        }catch(\Exception $e){
            return response()->json(["success" => false, "err" => $e->getMessage(), "ln" => $e->getLine()]);
        }

    }

}
