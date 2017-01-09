<?php

namespace App\Http\Controllers\Twitter\TwitterAPI;

use App\Http\Controllers\Twitter\Auth\TwitterAuthController;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Collection;

/**
 * Class Twitter
 */
class TwitterAPI {

    /**
     * The current bearer token.
     * @var null|string
     */
    protected $bearerToken;

    /**
     * The result format. Available: array, json.
     * @var string
     */
    protected $format = 'json';
    
    /**
     * The Twitter API URL
     */
    protected $twitterURL;

    /**
     * The constructor.
     *
     */
    public function __construct($twitterURL, $consumerKey, $consumerSecret, $format, $appOnly = false) {
        $this->twitterURL = $twitterURL;
        $this->consumerKey = $consumerKey;
        $this->consumerSecret = $consumerSecret;
        $this->format = $format;

        $this->init($consumerKey, $consumerSecret, $appOnly);
    }

    /**
     * Initialize the oauth token api.
     * @param string $consumerKey
     * @param string $consumerSecret
     */
    public function init($consumerKey, $consumerSecret, $appOnly) {
        if($appOnly) {
            $this->bearerToken = TwitterAuthController::applicationOnlyAuth(
                    $consumerKey, 
                    $consumerSecret);
        }
        //TBI: user auth
    }
    
    /**
     * Function to get the user time line of a Twitter user.
     * @param array $params
     * @return json
     */
    public function getUserTimeLine($params) {
        $twitterAPI = new Api($this->twitterURL, $this->bearerToken);
        $result = $twitterAPI->get('statuses/user_timeline', $params, false, true);
        return $result;
    }

    /**
     * Reformat the result.
     * @param  object $result
     * @return mixed
     */
    public function reformatResult($result)
    {
        $collection = new Collection($result);
        
        switch ($this->format) {
            case 'json':
                return $collection->toJson();
                break;

            case 'object':
               return json_decode(json_encode($collection->toArray()), false);
               break;

            default:
                return $collection->toArray();
                break;
        }
    }
}
