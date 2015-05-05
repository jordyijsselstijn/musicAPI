<?php

function updateAlbum($id, $updateObj, $contentType){


    if($contentType=="application/json"){
    
    	$jsonObj=json_decode($updateObj, true);

        if(empty($jsonObj["albumName"]) || empty($jsonObj["producer"]) || empty($jsonObj["artist"]) || empty($jsonObj["genre"]) || empty($jsonObj["label"])){
        
        return false;
        
        }else{

            

            $albumName=$jsonObj["albumName"];
            $producer=$jsonObj["producer"];
            $artist=$jsonObj["artist"];
            $genre=$jsonObj["genre"];
            $label=$jsonObj["label"];


            $mysqli = new mysqli('sql.cmi.hro.nl', '0836312', '66b4c860', '0836312');

            if ($mysqli->connect_errno) {
                printf("DB connect failed: %s\n", $mysqli->connect_error);
                exit;
            }

	            $mysqli->query("UPDATE albums SET albumName='$albumName', producer='$producer', date=NOW(), artist='$artist', genre='$genre', label='$label' WHERE id='$id'");
	
			            if($mysqli->affected_rows>0){
			
			                return true;
			
			            }else{
				            
				            return false;
			            }
                 
			}


    }else if($contentType=="application/x-www-form-urlencoded"){

        if(empty($_POST["albumName"]) || empty($_POST["producer"]) || empty($_POST["artist"]) || empty($_POST["genre"]) || empty($_POST["label"])){
        
        return false;
        
        }else{

            $albumName=$_POST['albumName'];
            $producer=$_POST['producer'];
            $artist=$_POST['artist'];
            $genre=$_POST['genre'];
            $label=$_POST['label'];

            $mysqli = new mysqli('sql.cmi.hro.nl', '0836312', '66b4c860', '0836312');

            if ($mysqli->connect_errno) {
                printf("DB connect failed: %s\n", $mysqli->connect_error);
                exit;
            }

            $mysqli->query("UPDATE albums SET albumName='$albumName', producer='$producer', date=NOW(), artist='$artist', genre='$genre', label='$label' WHERE id='$id'");

	            if($mysqli->affected_rows>0){
	
	                return true;
	
	            }else{
		            
		            return false;
		            
	            }
        }

        

    }

}