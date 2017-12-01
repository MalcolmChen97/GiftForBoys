<?php

require_once('connection.php');

$sql =$_POST['query'] ;
$giftresult = mysqli_query($conn,$sql);

$result = array();

while($row = mysqli_fetch_array($giftresult)){
      $id= $row['id'];
    $name=    $row['name'];
    $url=    $row['url'];
    $image_name=    $row['image_name'];
    $price=    $row['price'];
    $popularity = $row['popularity'];
    $result[]=array($id,$name,$url,$image_name,$price,$popularity);
    
    }
echo json_encode($result);



