<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Text;
use Carbon\Carbon;
use Intervention\Image\Facades\Image;

class TextController extends Controller
{
    
    function index(){
        return view("admin.texts");
    }

    function fetch($page = 1){

        try{

            $skip = ($page-1) * 20;

            $texts = Text::skip($skip)->take(20)->get();
            $textsCount = Text::count();

            return response()->json(["success" => true, "texts" => $texts, "textsCount" => $textsCount]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

    }

    function update(Request $request){

        $text = Text::where("id", $request->id)->first();

        if($text->type == "imagen"){

            if($request->get('image') != null){
                try{
                    
                    $imageData = $request->get('image');

                    if(strpos($imageData, "svg+xml") > 0){

                        $data = explode( ',', $imageData);
                        $fileName = Carbon::now()->timestamp . '_' . uniqid() . '.'."svg";
                        $ifp = fopen($fileName, 'wb' );
                        fwrite($ifp, base64_decode( $data[1] ) );
                        rename($fileName, 'images/texts/'.$fileName);
    
                    }else{

                        $fileName = Carbon::now()->timestamp . '_' . uniqid() . '.' . explode('/', explode(':', substr($imageData, 0, strpos($imageData, ';')))[1])[1];
                        Image::make($request->get('image'))->save(public_path('images/texts/').$fileName);

                    }
    
                }catch(\Exception $e){
    
                    return response()->json(["success" => false, "msg" => "Hubo un error al cargar la imagen", "err" => $e->getMessage(), "ln" => $e->getLine()]);
    
                }
            }

        }

        
        try{

            if($text->type == "imagen"){
                $text->image = $fileName;
            }else{
                $text->text = $request->text;
            }
            
            $text->update();

            return response()->json(["success" => true, "msg" => "Texto actualizado"]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

    }

}
