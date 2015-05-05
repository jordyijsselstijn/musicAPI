<?php



function postAlbum($postObj, $contentType){

    $json=json_decode($postObj, true);

    if($contentType=="application/json"){

        if(empty($json["albumName"]) || empty($json["producer"]) || empty($json["artist"]) || empty($json["label"]) || empty($json["genre"])){

            return false;

        }else{

            $albumName=$json["albumName"];
            $producer=$json["producer"];
            $artist=$json["artist"];
            $genre=$json["genre"];
            $label=$json["label"];

            $mysqli = new mysqli('sql.cmi.hro.nl', '0836312', '66b4c860', '0836312');

            if ($mysqli->connect_errno) {
                printf("DB connect failed: %s\n", $mysqli->connect_error);
                exit;
            }

            if(!empty($albumName) || !empty($producer) || !empty($artist)){


                $mysqli->query("INSERT INTO albums (albumName, producer, date, artist, label, genre) VALUES('$albumName', '$producer', NOW(), '$artist', '$label', '$genre')");

                if($mysqli->affected_rows>0){

                    return true;

                }

            }

        }

        return false;


    }else if($contentType=="application/x-www-form-urlencoded"){

        if(empty($_POST["albumName"]) || empty($_POST["producer"]) || empty($_POST["artist"]) || empty($_POST["label"]) || empty($_POST["genre"])){

            return false;

        }else{

            $albumName=$_POST['albumName'];
            $producer=$_POST['producer'];
            $artist=$_POST['artist'];
            $label=$_POST['label'];
            $genre=$_POST['genre'];

            $mysqli = new mysqli('sql.cmi.hro.nl', '0836312', '66b4c860', '0836312');

            if ($mysqli->connect_errno) {
                printf("DB connect failed: %s\n", $mysqli->connect_error);
                exit;
            }

            if(!empty($albumName) || !empty($producer) || !empty($artistId)){


                $mysqli->query("INSERT INTO albums (albumName, producer, date, artist, label, genre) VALUES('$albumName', '$producer', NOW(), '$artist', '$label', '$genre')");

                if($mysqli->affected_rows>0){

                    return true;

                }

            }

        }

        return false;

    }

}