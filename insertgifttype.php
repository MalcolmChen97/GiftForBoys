<?php
/**
 * Created by PhpStorm.
 * User: MalcolmChen
 * Date: 2017-11-18
 * Time: 4:10 PM
 */
require_once('connection.php');

$var=array();
$tag_insert = $_POST['tag'];

$sql = "INSERT INTO gifttype (id, name) VALUES (NULL, '$tag_insert');";
mysqli_query($conn,$sql);

echo '<br><input type="checkbox" value=' . $tag_insert . ' name="type[]" style="width:auto;">' . $tag_insert;

