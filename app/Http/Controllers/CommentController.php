<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreCommentRequest;
use App\Comment;

class CommentController extends Controller
{
    
    function store(StoreCommentRequest $request){

        try{    

            $sanitize = str_replace("\n", "", $request->comment);

            $comment = new Comment;
            $comment->comment = $sanitize;
            $comment->user_id = \Auth::user()->id;
            $comment->product_id = $request->product_id;
            $comment->save();

            return response()->json(["success" => true, "msg" => "Comentario realizado"]);

        }catch(\Exception $e){
            return response()->json(["success" => false, "err" => $e->getMessage(), "ln" => $e->getLine(), "msg" => "Error en el servidor"]);
        }

    }

    function fetch(Request $request){

        try{
            $commentsArray = [];
            $dataAmount = 10;
            $skip = ($request->page-1) * $dataAmount;

            $comments = Comment::where("product_id", $request->product_id)->with("user")->has("user")->skip($skip)->take($dataAmount)->orderBy("id", "desc")->get();
            $commentsCount = Comment::where("product_id", $request->product_id)->with("user")->has("user")->count();

            foreach($comments as $comment){

                $commentsArray[] = [
                    "comment" => $comment,
                    "date" => $comment->created_at->format("d-m-Y")
                ];

            }
            
            return response()->json(["success" => true, "comments" => $commentsArray, "commentsCount" => $commentsCount, "dataAmount" => $dataAmount]);

        }catch(\Exception $e){
            return response()->json(["success" => false, "err" => $e->getMessage(), "ln" => $e->getLine(), "msg" => "Error en el servidor"]);
        }

    }

}
