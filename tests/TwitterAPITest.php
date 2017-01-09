<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TwitterAPITest extends TestCase {
    
    protected $api;
    protected $session;
    protected $config;
    protected $request;
    protected $redirect;
    protected $twitter;
    
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testSearchTweetsSuccess()
    {
        $response = $this->call('GET', 
                '/api/search/tweets', 
                ['username' => 'hello', 'count' => 1]);
        $this->assertEquals(200, $response->status());
    }
    
    public function testSearchTweetsWithoutParameters() {
        $response = $this->call('GET', 
                '/api/search/tweets');
        $this->assertEquals(500, $response->status());
    }
}
