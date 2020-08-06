<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostsController extends Controller
{

    public function index()
    {
        $posts = [
            [
                "Title" => "Title 1",
                "Body" => "Body 1"
            ],
            [
                "Title" => "Title 2",
                "Body" => "Body 2"
            ],
            [
                "Title" => "Title 3",
                "Body" => "Body 3"
            ],
            [
                "Title" => "Title 4",
                "Body" => "Body 4"
            ]
        ];

        return response($posts, 200);
    }
}
