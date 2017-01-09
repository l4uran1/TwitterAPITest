<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Twitter\TwitterAPIController;
use Illuminate\Http\Request;

class APIController extends Controller {
 
    public function searchTweets(Request $request) {
        return TwitterAPIController::getUserTimeLine($request);
    }
}