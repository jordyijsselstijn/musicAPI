<?php

require'DB_class.php';


function getAlbums($id, $datatype)
{


    $albumObject = array();
    $xmlPagination= "";


    $mysqli = new mysqli('sql.cmi.hro.nl', '0836312', '66b4c860', '0836312');

        if ($mysqli->connect_errno) {
            printf("DB connect failed: %s\n", $mysqli->connect_error);
            exit;
        }
		    $nextPage=1;
		    $previousPage=1;
		    $next=1;
		
		    $numRows=$mysqli->query("SELECT COUNT(*) AS total FROM  albums");
		    $rowCount=$numRows->fetch_assoc();
		    $numberOfRows=$rowCount['total'];
		
		    $currentItems=$numberOfRows;

            if ($id !="all") {
	            	
	            $query = "SELECT * FROM albums WHERE id='$id'";
	            
            } else {

				$id="";

                if(empty($_GET['limit'])){

                 $query = "SELECT * FROM albums";

                }else{

                    $currentItems=intval($_GET['limit']);
                    $query = "SELECT * FROM albums LIMIT $currentItems";

	                    if(isset($_GET['start'])){
	
	                        $startingPoint=$_GET['start'];
	                        $query = "SELECT * FROM albums LIMIT $currentItems OFFSET $startingPoint";
							}
						}
            }


			$result = $mysqli->query($query);
    
            if(isset($_GET['limit'])){

	            $totalPages=ceil($numberOfRows/intval($_GET['limit']));
	            $limit=intval($_GET['limit']);
	            
	            
	            $modulus=$numberOfRows%intval($_GET['limit']);
	            
				$lastPage=$numberOfRows-$modulus;
				
				if(!isset($_GET['start'])){
			
						$nextPage= 1+intval($_GET['limit']);
						$previousPage=1;
						$currentPage=1;
						$next=2;
						
						
				}else{
				
						$start=intval($_GET['start']);
						
							if($limit+$start>=$numberOfRows){
							
								$currentItems=$numberOfRows-$start;
								$nextPage=$start;
								$currentPage=$totalPages;
								$next=$totalPages;
								
								}else{							
									$nextPage= $start+$limit;
									$currentItems=$limit;
									$currentPage=ceil($start/$limit);
									$next=$currentPage+1;
								}
							if($start-$limit<=1){
								
								$previousPage=1;
							}else{
								
								$previousPage=$start-$limit;
							}		
					}

			
			
        }else{

            $totalPages=1;
            $limit=$numberOfRows;
            $lastPage=1;
            $nextPage=1;
            $previousPage=1;
            $currentPage=1;
            $next=1;
        }

    if ($datatype == "application/xml") {
    
		if($id==""){
			echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>";
			echo "<albums><items>";
			
			        while ($rows = $result->fetch_assoc()) {

							$albumXml = "<item>

                            <id>" . $rows['id'] . "</id>
                            <albumName>" . $rows['albumName'] . "</albumName>
                            <producer>" . $rows['producer'] . "</producer>
                            <date>" . $rows['date'] . "</date>
                            <artist>".$rows['artist']."</artist>
                            <label>" . $rows['label'] . "</label>
                            <genre>".$rows['genre']."</genre>
                            <links>
                                <link>
                                    <rel>Self</rel>
                                    <href>http://student.cmi.hro.nl/0836312/jaar2/restfull_eindOpdracht/albums/" . $rows['id'] . "</href>
                                </link>
                                <link>
                                    <rel>Collection</rel>
                                    <href>http://student.cmi.hro.nl/0836312/jaar2/restfull_eindOpdracht/albums/</href>
                                </link>
                            </links>
                            </item>";

							echo $albumXml;

								
							
							}
							
							echo "</items>";
							echo "<links><link>
									<rel>Self</rel>
									<href>http://student.cmi.hro.nl/0836312/jaar2/restfull_eindOpdracht/albums/</href>
								</link>
								</links>";
							echo "<pagination>
								<currentPage>".$currentPage."</currentPage>
								<currentItems>".$currentItems."</currentItems>
								<totalPages>".$totalPages."</totalPages>
								<totalItems>".$numberOfRows."</totalItems>
								<links>
									<link>
										<rel>first</rel>
										<page>1</page>
										<href>http://student.cmi.hro.nl/0836312/jaar2/restfull_eindOpdracht/albums/?limit=".$limit."</href>
									</link>
									<link>
										<rel>last</rel>
										<page>".$totalPages."</page>
										<href>http://student.cmi.hro.nl/0836312/jaar2/restfull_eindOpdracht/albums/?limit=".$limit."&amp;start=".$lastPage."</href>
									</link>									
									<link>
										<rel>previous</rel>
										<page>".$previousPage."</page>
										<href>http://student.cmi.hro.nl/0836312/jaar2/restfull_eindOpdracht/albums/?limit=".$limit."&amp;start=".						$previousPage."</href>
									</link>
									<link>
										<rel>next</rel>
										<page>".$nextPage."</page>
										<href>http://student.cmi.hro.nl/0836312/jaar2/restfull_eindOpdracht/albums/?limit=".$limit."&amp;start=".$nextPage."</href>
									</link>

									
								</links>
								</pagination></albums>";
								
								
							
								
								
							}else{
							echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>";
							echo "<album>";
							while ($rows = $result->fetch_assoc()) {
				    echo   "<id>" . $rows['id'] . "</id>
                            <albumName>" . $rows['albumName'] . "</albumName>
                            <producer>" . $rows['producer'] . "</producer>
                            <date>" . $rows['date'] . "</date>
                            <artist>".$rows['artist']."</artist>
                            <label>" . $rows['label'] . "</label>
                            <genre>".$rows['genre']."</genre>
                            <links>
                                <link>
                                    <rel>Self</rel>
                                    <href>http://student.cmi.hro.nl/0836312/jaar2/restfull_eindOpdracht/albums/" . $rows['id'] . "</href>
                                </link>
                                <link>
                                    <rel>Collection</rel>
                                    <href>http://student.cmi.hro.nl/0836312/jaar2/restfull_eindOpdracht/albums/</href>
                                </link>
                            </links></album>";	
		}
		
		}
        
    }else{



        while ($rows = $result->fetch_assoc()) {

            $links = array(
                array("rel" => "self", "href" => "http://student.cmi.hro.nl/0836312/jaar2/restfull_eindOpdracht/albums/" . $rows['id']),
                array("rel" => "collection", "href" => "http://student.cmi.hro.nl/0836312/jaar2/restfull_eindOpdracht/albums/")
            );

            $album = array("id" => $rows['id'], 
            				"albumName" => $rows['albumName'],
            				"producer"=> $rows['producer'], 
            				"date" => $rows['date'], 
            				"artist"=>$rows['artist'], 
            				"label" => $rows['label'], 
            				"genre"=>$rows['genre'], 
            				"links"=>$links);

			if($id!=""){
								
				echo json_encode($album);
								
			}else{
				
				array_push($albumObject, $album);
			}
            

        }




        

        
			$array=array("items"=>$albumObject, "links"=>array(array("rel"=>"self", "href"=>"http://student.cmi.hro.nl/0836312/jaar2/restfull_eindOpdracht/albums/".$id)),

			"pagination"=>
				array("currentPage"=>$currentPage, "currentItems"=>intval($currentItems), "totalPages"=>$totalPages, "totalItems"=>intval($numberOfRows),"links"=>array(
	            array("rel"=>"first","page"=>1, "href"=>"http://student.cmi.hro.nl/0836312/jaar2/restfull_eindOpdracht/albums/?limit=".$limit),
	            array("rel"=>"last", "page"=>$totalPages, "href"=>"http://student.cmi.hro.nl/0836312/jaar2/restfull_eindOpdracht/albums/?limit=".$limit."&start=".$lastPage),
	            array("rel"=>"next", "page"=>$next, "href"=>"http://student.cmi.hro.nl/0836312/jaar2/restfull_eindOpdracht/albums/?limit=".$limit."&start=".$nextPage),
	            array("rel"=>"previous", "page"=>$previousPage, "href"=>"http://student.cmi.hro.nl/0836312/jaar2/restfull_eindOpdracht/albums/?limit=".$limit."&start=".						$previousPage)))
				);
			if($datatype=="application/xml"){

								
			}	


	if($id==""){
		
		echo json_encode($array);
	}

       
}

}



function isEmpty($id){
	
	    $mysqli = new mysqli('sql.cmi.hro.nl', '0836312', '66b4c860', '0836312');

        if ($mysqli->connect_errno) {
            printf("DB connect failed: %s\n", $mysqli->connect_error);
            exit;
        }
		
		    $numRows=$mysqli->query("SELECT COUNT(*) AS total FROM  albums WHERE id='$id'");
	
			$rowCount=$numRows->fetch_assoc();
		    $numberOfRows=$rowCount['total'];
		    
		    if($numberOfRows>0){
			    
			    return false;
			    
		    }else{
			    
			    return true;
		    }
			
}