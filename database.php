<?PHP
require_once('connection.php');

$target_dir = "giftimage/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
if(isset($_POST['submit'])){
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}

if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}

if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.<br>";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded." . '<br>';
    } else {
        echo "Sorry, there was an error uploading your file." . '<br>';
    }
}

//end of update file
$imagename = $_FILES['fileToUpload']['name'];
$gift_name =  $_POST['name'];
$gift_price = $_POST['price'];
$gift_url = $_POST['url'];
$gift_popularity = $_POST['popularity'];
$gift_lowerage = $_POST['age'];
$gift_highage = $_POST['to'];
$gift_agetype = [];

function whetherinarray($text, $array){
    $len = count($array);
    for($i=0;$i<$len;$i++){
        if($array[$i]==$text){
            return false;
        }
    }
    return true;
}
//starting from 7
for($i = $gift_lowerage;$i<$gift_highage;$i++){
    if($i>=0 && $i<5){
        if(whetherinarray('baby',$gift_agetype)){
            $gift_agetype[] = "baby";
        }
    }else if($i>=5 && $i<12){
        if(whetherinarray('child',$gift_agetype)){
            $gift_agetype[] = "child";
        }
    }else if($i>=12 && $i<18){
        if(whetherinarray('teenager',$gift_agetype)){
            $gift_agetype[] = "teenager";
        }
    }else if($i>=18 && $i<45){
        if(whetherinarray('adult',$gift_agetype)){
            $gift_agetype[] = "adult";
        }
    }else if($i>=45 && $i<66){
        if(whetherinarray('middle-aged',$gift_agetype)){
            $gift_agetype[] = "middle-aged";
        }
    }else if($i>=66){
        if(whetherinarray('senior',$gift_agetype)){
            $gift_agetype[] = "senior";
        }
    }

}





$insertgift_query = "INSERT INTO giftinfo (id,name,url,image_name,price,popularity) VALUES (NULL, '$gift_name', '$gift_url','$imagename','$gift_price','$gift_popularity' );";
mysqli_query($conn,$insertgift_query);

$currentgift_id=mysqli_insert_id($conn);
echo "successfully insert giftinfo $currentgift_id<br>";

for($i=0;$i < count($gift_agetype);$i++){
    $agetypeid=-1;
    switch ($gift_agetype[$i]) {
        case "baby":
            $agetypeid = 7;
            break;
        case "child":
            $agetypeid = 8;
            break;
        case "teenager":
            $agetypeid = 9;
            break;
        case "adult":
            $agetypeid = 10;
            break;
        case "middle-aged":
            $agetypeid = 11;
            break;
        case "senior":
            $agetypeid = 12;
            break;
    }
    $inserthasagetype_query = "INSERT INTO gift_hasatype (gid,aid) VALUES ('$currentgift_id','$agetypeid');";
    mysqli_query($conn,$inserthasagetype_query);
    echo "successfully insert has_agetype<br>";

}

foreach($_POST['type'] as $selected){

    $searchid_query = "SELECT * FROM gifttype WHERE name='$selected';";
    $idresult = mysqli_query($conn,$searchid_query);
    $idfinal=-1;
    if (mysqli_num_rows($idresult) > 0) {
        while ($row = mysqli_fetch_assoc($idresult)) {
            $idfinal=$row['id'];
        }
    }
    $inserthasgifttype_query = "INSERT INTO gift_hasgtype (gid,typeid) VALUES ('$currentgift_id','$idfinal');";
    mysqli_query($conn,$inserthasgifttype_query);
    echo "successfully insert has_gifttype<br>";
}

echo "gifttable:<br>";
$gifttable_query = "SELECT * FROM giftinfo";
$giftresult = mysqli_query($conn,$gifttable_query);

if(mysqli_num_rows($giftresult) > 0){
    echo "<table>";
    echo "<tr>";
    echo "<th>id</th>";
    echo "<th>name</th>";
    echo "<th>url</th>";
    echo "<th>image_name</th>";
    echo "<th>price</th>";
    echo "<th>popularity</th>";
    echo "</tr>";
    while($row = mysqli_fetch_array($giftresult)){
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['name'] . "</td>";
        echo "<td>" . $row['url'] . "</td>";
        echo "<td>" . $row['image_name'] . "</td>";
        echo "<td>" . $row['price'] . "</td>";
        echo "<td>" . $row['popularity'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else{
    echo "No records matching your query were found.";
}