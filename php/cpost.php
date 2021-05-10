<?php
require 'db_config.php';

$data = json_decode(file_get_contents("php://input"));

$text = $data->content;
$userId = "990001";
$post_Id = $data->post_Id;
$timestamp = date("Y-m-d H:i:s");
$sql = "INSERT INTO comments (user_Id,post_Id,content,created_at) VALUES ('$userId','$post_Id','$text','$timestamp')";
$result = $con->query($sql);
?>
