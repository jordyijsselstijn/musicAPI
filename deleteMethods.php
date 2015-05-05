<?php

function deleteRecord($id){


    $mysqli = new mysqli('sql.cmi.hro.nl', '0836312', '66b4c860', '0836312');

    if ($mysqli->connect_errno) {
        printf("DB connect failed: %s\n", $mysqli->connect_error);
        exit;
    }

    if(!empty($id)){

        $mysqli->query("DELETE FROM albums WHERE id='$id'");

        if($mysqli->affected_rows>0){


            return true;

        }else{

            return false;
        }

    }


    return "not found";

}