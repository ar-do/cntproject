<?php
require 'db_config.php';

$sel = mysqli_query($con,"select * from posts");
$data = array();

while ($row = mysqli_fetch_array($sel)) {
 $data[] = array("id"=>$row['id'],"userId"=>$row['userId'],"title"=>$row['title'],"description"=>$row['description'],"upvote"=>$row['upvote'],"downvote"=>$row['downvote'],"saved"=>$row['saved'],"created_at"=>$row['created_at'],"updated_at"=>$row['updated_at']);
}
echo json_encode($data);
?>
