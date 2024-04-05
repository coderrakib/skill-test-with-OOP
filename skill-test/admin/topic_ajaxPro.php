<?php

   require_once ('../connect.php');

   $sql = "SELECT * FROM question_category
        WHERE parent_id LIKE '%".$_GET['id']."%'"; 


   $result = $mysqli->query($sql);


   $json = [];
   while($row = $result->fetch_assoc()){
        $json[$row['id']] = $row['category_name'];
   }


   echo json_encode($json);
?>