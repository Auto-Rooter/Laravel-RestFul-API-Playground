<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Post;
use App\Http\Resources\PostResource;


class PostsController extends Controller
{
    use ApiResponseTrait;
    
    public function index()
    {
        // Pagination (1):

        // $offset = request()->has('offset') ? request()->get('offset') : 0 ;
        // $posts = PostResource::collection(Post::limit(10)->offset($offset)->get());

        // Pagination (2):
        $posts = PostResource::collection(Post::paginate($this->paginateLimit));

        return $this->apiResponse($posts, null, 200);
    }

    public function show($id = 1){
        $post = Post::find($id);
        if($post){
            return $this->apiResponse(new PostResource(Post::find($id)), null, 200);
        }
        return $this->apiResponse($post, "Post Not Found", 404);
        
    }


    public function store(Request $request){
        $post = Post::create($request->all());
        if($post){
            return $this->apiResponse(new PostResource($post), null, 201);
        }
        return $this->apiResponse(null, "Un-known Error", 400);
    }
}
