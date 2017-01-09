<?php 

namespace App\Http\Controllers\Twitter\TwitterAPI;

use App\History;

/**
 * Class API
 */
class Api {
    
    private $bearerToken;
    private $twitterURL;
    
    /**
     * The constructor.
     * @param string $twitterURL
     * @param string $bearerToken
     */
    public function __construct($twitterURL, $bearerToken) {
        $this->bearerToken = $bearerToken;
        $this->twitterURL = $twitterURL;
    }
    
    /**
     * Call to twitter API
     * @param string $method (GET|POST|PUT|DELETE)
     * @param string $path
     * @param array $parameters
     * @return type
     */
    private function twitterCall($method, $path, $parameters) {        
        //convert the parameters into a query string
        $params = $this->parseParameters($parameters);
        
        //call
        //try {
            $req = array(
              'http'=>array(
                'method' => $method,
                'header' => 'Authorization: Bearer '.$this->bearerToken.''
              )
            );

            //Create the context
            $context = stream_context_create($req);

            //Get the JSON data
            $json = file_get_contents($this->twitterURL.'1.1/'.$path.'.json?'.$params,false,$context);
            $result = json_decode($json,true);
            
        //} catch (App\Exceptions $e) {
            //throw new Exception('Error. The method '.$method.' cannot be executed. '.$e->getMessage());
        //}
        
        //try {
            //save the history in database
            $saveHistory = $this->saveHistoryInDatabase($method, $path, $parameters, $json);
        //} catch (App\Exceptions $e) {
            //throw new Exception('Error. The history of the call cannot be stored in the database. '.$e->getMessage());
        //}
        
        return $result;
    }
    
    /**
     * Function to convert the array parameters into a query string.
     * @param type $parameters
     * @return type
     */
    private function parseParameters($parameters) {
        $arrayParams = array();
        foreach($parameters as $key => $param) {
            $arrayParams[] = $key.'='.$param;
        }
        
        return implode('&', $arrayParams);
    }
    
    private function saveHistoryInDatabase($method, $path, $params, $result) {
        return History::create([
            'call_to' => 'twitter',
            'method' => $method,
            'path' => $path,
            'username' => $params['screen_name'],
            'count' => $params['count'],
            'json_result' => $result
        ]);
    }

    /**
     * Helper method for making a GET request.
     * @param  string $path
     * @param  array $parameters
     * @return mixed
     */
    public function get($path, array $parameters = array())
    {
        return $this->twitterCall('GET', $path, $parameters);
    }

    /**
     * Helper method for making a POST request.
     * @param  string $path
     * @param  array $parameters
     * @return mixed
     */
    public function post($path, array $parameters = array())
    {
        return $this->twitterCall('POST', $path, $parameters);
    }

    /**
     * Helper method for making a PUT request.
     * @param  string $path
     * @param  array $parameters
     * @return mixed
     */
    public function put($path, array $parameters = array())
    {
        return $this->twitterCall('PUT', $path, $parameters);
    }

    /**
     * Helper method for making a DELETE request.
     * @param  string $path
     * @param  array $parameters
     * @return mixed
     */
    public function delete($path, array $parameters = array())
    {
        return $this->twitterCall('DELETE', $path, $parameters);
    }
}
