<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\BannerStoreRequest;
use App\Http\Requests\BannerUpdateRequest;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;
use App\Banner;

class BannerController extends Controller
{
    
    function index(){

        return view('admin.banners');

    }

    function store(BannerStoreRequest $request){

        try{

            try{

                $imageData = $request->get('image');
                $fileName = Carbon::now()->timestamp . '_' . uniqid() . '.' . explode('/', explode(':', substr($imageData, 0, strpos($imageData, ';')))[1])[1];
                Image::make($request->get('image'))->save(public_path('images/banners/').$fileName);
    
            }catch(\Exception $e){
    
                return response()->json(["success" => false, "msg" => "Hubo un error al cargar la imagen", "err" => $e->getMessage(), "ln" => $e->getLine()]);
    
            }

            try{
                
                $banner = new Banner;
                $banner->link = $request->link;
                $banner->image = $fileName;
                $banner->size = $request->size;
                $banner->position = $request->position;
                $banner->title = $request->title;
                $banner->text = $request->text;
                $banner->text_color = $request->textColor;
                $banner->title_color = $request->titleColor;
                $banner->button_text = $request->buttonText;
                $banner->button_color = $request->buttonColor;
                $banner->button_text_color = $request->buttonTextColor;
                $banner->location = $request->location;
                $banner->save();
    
                return response()->json(["success" => true, "msg" => "Banner registrado"]);
    
            }catch(\Exception $e){
    
                return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);
    
            }


        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Ha ocurrido un error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

    }

    function fetchAdmin($page = 1){

        try{

            $skip = ($page-1) * 10;

            $banners = Banner::skip($skip)->take(10)->get();
            $bannersCount = Banner::count();

            return response()->json(["success" => true, "banners" => $banners, "bannersCount" => $bannersCount]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor"]);

        }

    }

    function update(BannerUpdateRequest $request){

        if($request->get('image') != null){
            try{

                $imageData = $request->get('image');
                $fileName = Carbon::now()->timestamp . '_' . uniqid() . '.' . explode('/', explode(':', substr($imageData, 0, strpos($imageData, ';')))[1])[1];
                Image::make($request->get('image'))->save(public_path('images/banners/').$fileName);

            }catch(\Exception $e){

                return response()->json(["success" => false, "msg" => "Hubo un error al cargar la imagen", "err" => $e->getMessage(), "ln" => $e->getLine()]);

            }
        }
        try{

            
            $banner = Banner::find($request->id);
            $banner->link = $request->link;
            if($request->get('image') != null){
                $banner->image = $fileName;
            }
            $banner->size = $request->size;
            $banner->position = $request->position;
            $banner->title = $request->title;
            $banner->text = $request->text;
            $banner->text_color = $request->textColor;
            $banner->title_color = $request->titleColor;
            $banner->button_text = $request->buttonText;
            $banner->button_color = $request->buttonColor;
            $banner->button_text_color = $request->buttonTextColor;
            $banner->location = $request->location;
            $banner->update();

            return response()->json(["success" => true, "msg" => "Banner actualizado"]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

    }

    function delete(Request $request){

        try{

            $banner = Banner::find($request->id);
            $banner->delete();

            return response()->json(["success" => true, "msg" => "Banner eliminado"]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

    }

}