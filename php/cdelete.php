<?php
require 'db_config.php';

$data = json_decode(file_get_contents("php://input"));
$id = $data->id;

$sql = "DELETE FROM comments WHERE id = '$id'";
$result = $con->query($sql);
?>
