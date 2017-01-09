<?php

namespace App\Http\Controllers\Twitter\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Auth;
use Socialite;
use tmhOAuth;

class TwitterAuthController extends Controller {
    
    protected $redirectPath = '/home';

    /**
     * Twitter Auth only application
     * @param string $twitterURL
     * @param string $consumerKey
     * @param string $consumerSecret
     * @return mixed
     */
    public static function applicationOnlyAuth(
            $consumerKey, 
            $consumerSecret) {
        $bearer = base64_encode($consumerKey.':'.$consumerSecret);
        $params = array(
            'grant_type' => 'client_credentials',
        );
        $tmhOAuth = new tmhOAuth([
            'consumer_key' => $consumerKey,
            'consumer_secret' => $consumerSecret
        ]);

        $code = $tmhOAuth->request(
            'POST',
            $tmhOAuth->url('/oauth2/token', null),
            $params,
            false,
            false,
            array(
                'Authorization' => "Basic ${bearer}"
            )
        );
        if ($code == 200) {
            $data = json_decode($tmhOAuth->response['response']);
            if (isset($data->token_type) && strcasecmp($data->token_type, 'bearer') === 0) {
                $new_bearer = $data->access_token;
                return $new_bearer;
            }
        } else {
            throw new Exception('Auth error: '.$tmhOAuth->response);
        }
    }    
    
}

