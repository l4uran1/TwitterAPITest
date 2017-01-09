<?php

namespace App\Http\Controllers\Twitter;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Twitter\TwitterAPI\TwitterAPI;
use App\Exceptions;

class TwitterAPIController extends Controller {
 
    public static function getUserTimeLine($request) {
//        try {
            $params = array();
            $params['screen_name'] = $request->input('username') ? 
                    $request->input('username') : '';
            $params['count'] = $request->input('count') ? 
                    $request->input('count') : 10;
//        } catch (Exception $ex) {
//            Exception::report('Error. The twitter API cannot be authenticated as application. '.$e->getMessage());
//        }
        if($request->input('username') == NULL) {
            abort(500,'Error. The username must be provided.');
        }
        //try {
        //create the instance to be authenticated
            $twitter = new TwitterAPI(
                env('TWITTER_API_BASE'),
                env('T_CONSUMER_KEY'),
                env('T_CONSUMER_SECRET'),
                'json',
                true);
//        } catch (Exceptions $e) {
//            throw new Exception('Error. The twitter API cannot be authenticated as application. '.$e->getMessage());
//        }
        
        //try {
            //call to the api
            $result = $twitter->getUserTimeLine($params);

            return $result;
//        } catch (App\Exceptions $e) {
//            throw new Exception('API Error. '.$e->getMessage());
//        }
    }
}