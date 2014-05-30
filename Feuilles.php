<?php

class Feuilles
{
    
    protected $client_id;
    protected $client_secret;
    protected $redirect_uri;
    protected $access_token;
    
    public function __construct($args) {
    	$this->client_id = $args["client_id"];
    	$this->client_secret = $args["client_secret"];
    	$this->redirect_uri = $args["redirect_uri"];
    	
    	if (array_key_exists("access_token", $args)) {
    		$this->access_token = $args["access_token"];
    	}
    }
    
    public function getAccessToken($code, $grant_type = "authorization_code") {
        $query = array(
            'client_id' => $this->client_id,
            'client_secret' => $this->client_secret,
            'redirect_uri' => $this->redirect_uri,
            'code' => $code,
            'grant_type' => $grant_type
        );
        
        $options = array(
            'http' => array(
                'ignore_errors' => true,
                'method' => 'POST',
                'header' => array(
                    0 => 'User-Agent: Feuilles Client',
                    1 => 'Content-Type: application/x-www-form-urlencoded'
                ),
                'content' => http_build_query($query)
            )
        );
        
        $context  = stream_context_create($options);
        $response = file_get_contents("https://feuill.es/api/v1/oauth2/token", false, $context);
        
        return $response;
        
    }
    
    public function setAccessToken ($access_token) {
    	 $this->access_token = $access_token;
    }
    
    public function readDoc($sha) {
        $options = array(
            'http' => array(
                'ignore_errors' => true
            )
        );
        
        $context  = stream_context_create($options);
        $response = file_get_contents("https://feuill.es/api/v1/doc/read?access_token=" . $this->access_token . "&sha=" . $sha, false, $context);
        
        return $response;
        
    }
    
    
    public function createDoc($args) {
        
        $title = array_key_exists("title", $args) ? $args["title"] : "";
        $body  = array_key_exists("body", $args) ? $args["body"] : "";
        
        $query = array(
            'title' => $title,
            'body' => $body
        );
        
        $options = array(
            'http' => array(
                'ignore_errors' => true,
                'method' => 'POST',
                'header' => array(
                    0 => 'User-Agent: Feuilles PHP',
                    1 => 'Content-Type: application/x-www-form-urlencoded'
                ),
                'content' => http_build_query($query)
            )
        );
        
        $context  = stream_context_create($options);
        $response = file_get_contents("https://feuill.es/api/v1/doc/create?access_token=" . $this->access_token, false, $context);
        
        return $response;
        
    }
    
    public function updateDoc($sha, $args) {
        
        $title = array_key_exists("title", $args) ? $args["title"] : "";
        $body  = array_key_exists("body", $args) ? $args["body"] : "";
        
        $query = array(
            'sha' => $sha,
            'title' => $title,
            'body' => $body
        );
        
        $options = array(
            'http' => array(
                'ignore_errors' => true,
                'method' => 'POST',
                'header' => array(
                    0 => 'User-Agent: Feuilles PHP',
                    1 => 'Content-Type: application/x-www-form-urlencoded'
                ),
                'content' => http_build_query($query)
            )
        );
        
        $context  = stream_context_create($options);
        $response = file_get_contents("https://feuill.es/api/v1/doc/update?access_token=" . $this->access_token, false, $context);
        
        return $response;
        
    }
    
    public function deleteDoc($sha) {
        $query = array(
            'sha' => $sha
        );
        
        $options = array(
            'http' => array(
                'ignore_errors' => true,
                'method' => 'POST',
                'header' => array(
                    0 => 'User-Agent: Feuilles PHP',
                    1 => 'Content-Type: application/x-www-form-urlencoded'
                ),
                'content' => http_build_query($query)
            )
        );
        
        $context  = stream_context_create($options);
        $response = file_get_contents("https://feuill.es/api/v1/doc/delete?access_token=" . $this->access_token, false, $context);
        
        return $response;
        
    }
}