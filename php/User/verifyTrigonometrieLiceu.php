<?php

session_start();


include_once '../model/user.php';
include_once '../database.php';

$database = new Database();
$db = $database->connect();

$user = new User($db);

$post = $_POST["answer"];
$pass = $_POST["custId"];


$query1 = "SELECT score FROM trigonometrie_liceu WHERE ID =:id_pr";
$query = "SELECT answear FROM trigonometrie_liceu  WHERE ID =:id_pr";
$query2 = "SELECT score FROM users WHERE ID =:id_usr";




$stmt2 = $db->prepare($query2);
$stmt1 = $db->prepare($query1);
$stmt = $db->prepare($query);



$stmt2->bindParam(":id_usr", $_SESSION['ID']);
$stmt1->bindParam(":id_pr", $pass);
$stmt->bindParam(":id_pr", $pass);


$stmt2->execute();
$stmt->execute();
$stmt1->execute();


$row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$row1 = $stmt1->fetch(PDO::FETCH_ASSOC);


$user->score_prb = $row1['score'];
$user->score = $row2['score'];
$user->id_problem = $pass;
$user->id = $_SESSION['ID'];



if($row['answear'] == $post and $user->insertPairTL()){
   $test = $user->verifyResponse();
   if($test){

      $update_score=array(
            "message" => "Felicitari raspunsul este corect!"
      );
   }
}
else if($user->alreadyResolvedTL() == true){
   $update_score = array(
      "message" => "Ai raspuns deja la asta!"
   );
}
else {
   $update_score = array(
      "message" => "Raspunsul nu este corect!",

   );
}

echo json_encode($update_score);

?>