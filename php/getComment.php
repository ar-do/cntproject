<?php
require 'db_config.php';

$sel = mysqli_query($con,"select * from comments");
$data = array();

while ($crow = mysqli_fetch_array($sel)) {
 $data[] = array("id"=>$crow['id'],"user_Id"=>$crow['user_Id'],"post_Id"=>$crow['post_Id'],"created_at"=>$crow['created_at'],"content"=>$crow['content'],"upvote"=>$crow['upvote'],"downvote"=>$crow['downvote']);
}
echo json_encode($data);
?>
