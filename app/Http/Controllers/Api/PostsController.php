<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
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

        // Pagination (2): Laravel Pagination
        $posts = PostResource::collection(Post::paginate($this->paginateLimit));

        return $this->apiResponse($posts, null, 200);
    }

    public function show($id = 1){
        $post = Post::find($id);
        if($post){
            return $this->returnSuccessPost($post);
        }
        return $this->notFoundResponse();
        
    }


    public function store(Request $request){

        // Validation (1): 
        //        - Pros: Faster, and return Specific Error MSG
        //        - Cons: What you will do if the Form contains 100 Fields ?

        // if(!$request->has('title') && $request->get('title') == ''){
        //     return $this->apiResponse(null, "Title Is Required", 422);
        // }

        // if(!$request->has('body') && $request->get('body') == ''){
        //     return $this->apiResponse(null, "Body Is Required", 422);
        // }


        // Validation (2): Laravel Validation

        $validate = $this->validation($request);
        
        if($validate instanceof Response){
            return $validate;
        }

        $post = Post::create($request->all());

        if($post){
            return $this->createResponse(new PostResource($post));
        }

        return $this->unknownErrorResponse();
    }


    public function update($id, Request $request){

        $validate = $this->validation($request);
        
        if($validate instanceof Response){
            return $validate;
        }

        // Post::find($id)::update($request->all());
        $post = Post::find($id);

        if(!$post){
            return $this->notFoundResponse();
        }

        if($post){
            $post['title'] = $request->title;
            $post['body'] = $request->body;

            $post->save();

            return $this->returnSuccessPost($post);
        }

        return $this->unknownErrorResponse();

    }

    public function delete($id){
        $post = Post::find($id);

        if($post){
            $post->delete();
            return $this->deleteResponse();
        }

        return $this->notFoundResponse();
    }

    public function validation($request){
        
        return $this->validator($request->all(), [
            'title' => 'required|min:5|max:199',
            'body' => 'required|min:15|max:1500'
        ]);
    }

    public function returnSuccessPost($post){
        return $this->apiResponse(new PostResource($post));
    }
}
