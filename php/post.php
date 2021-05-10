<?php
require 'db_config.php';

$data = json_decode(file_get_contents("php://input"));

$text = $data->description;
$userId = "990001";
$title = $data->title;
$timestamp = date("Y-m-d H:i:s");
$sql = "INSERT INTO posts (userId,title,description,created_at) VALUES ('$userId','$title','$text','$timestamp')";
$result = $con->query($sql);
?>
