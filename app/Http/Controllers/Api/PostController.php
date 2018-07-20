<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
    	$post = Auth::user()->posts()->get();

    	return response()->json([
    		'data' => $post
    	], 200);
    }
}
