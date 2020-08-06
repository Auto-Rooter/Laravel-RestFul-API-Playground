<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Post;


class PostsController extends Controller
{
    use ApiResponseTrait;
    
    public function index()
    {
        $posts = Post::get();
        return $this->apiResponse($posts);
    }

    public function show($id = 1){
        $post = Post::find($id);
        if($post){
            return $this->apiResponse($post);
        }
        return $this->apiResponse($post, "Post Not Found", 404);
        
    }
}
