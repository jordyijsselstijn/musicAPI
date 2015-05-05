<?php
require 'getMethods.php';
require 'postMethods.php';
require 'deleteMethods.php';
require 'putMethods.php';
require 'Slim/Slim.php';
\Slim\Slim::registerAutoloader();

$application= new \Slim\Slim();

$response = $application->response();
$headers = $application->request->headers;
$dataType= $headers["Accept"];
$contentType=$application->request->getContentType();

if(isset($_GET['limit'])){
	$limit=$_GET['limit'];
	
	}else{
	
	$limit="";
	
	}



$application->get('/', function(){
    echo "This is an API for retrieving information about artists and their music!";
});


$application->get('/albums/', function() use($response, $dataType, $limit, $dataType){

if($dataType=="application/json"){
	
	getAlbums("all", "application/json");
	
		$response->header('Content-Type', "application/json");
		
	}else if($dataType=="application/xml"){
	
		getAlbums("all", "application/xml");
		
		$response->header('Content-Type', "application/xml");
	
		}else if(empty($dataType)){
		
			getAlbums("all", "application/json");
			$response->header('Content-Type', "application/json");
	
			}else{
				$response->status(415);
	
}
   
    
});


$application->get('/albums/:id', function($id) use($response, $dataType){
	
	if(is_numeric($id)){
		
			getAlbums($id, $dataType);
			$response->header('Content-Type', $dataType);
			$response->status(200);	
			if(isEmpty($id)===true){
				$response->status(404);
				
			}
			
		}else{
		
			$response->status(400);
	}

});


$application->options('/albums/', function() use($response){
    $response->header('Allow', 'GET, POST, OPTIONS');
});


$application->options('/albums/:id', function() use($response){
    $response->header('Allow', 'GET, PUT, DELETE, OPTIONS');
});



$application->delete('/albums/:id', function($id) use($response){

    $response->header('Content-Type', 'application/json');

    if(deleteRecord($id)===true){
    
        $response->status(204);
        
    }else{
    
        $response->status(404);
        
    }
});



$application->post('/albums/', function() use($application, $response, $contentType){

    $response->header('Content-Type', 'application/json');

    $request=$application->request();

    $requestBody=$request->getBody();
    

    if(postAlbum($requestBody, $contentType)===true){

        $application->status(201);

        }else if(postAlbum($requestBody, $contentType)!=true){

            $application->status(400);
}
});



$application->put('/albums/:id', function($id) use($application, $response, $contentType){

    $request=$application->request();

    $requestBody=$request->getBody();

    if(updateAlbum($id, $requestBody, $contentType)===true){
    
        $application->status(200);

		}else{
			
			$application->status(400);
			
		}

});


$application->run();
