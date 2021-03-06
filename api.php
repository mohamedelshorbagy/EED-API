<?php

require 'confing.php';
require 'Slim/Slim.php';
\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();



$app->get("/getVisitorData/:id" , function($id) use ($app) {

  $db = getDB();

  $stmt = $db->prepare('SELECT * FROM test WHERE random="'.$id.'" LIMIT 1');

  $stmt->execute();

  $visitor = $stmt->fetchAll();

  $count = $stmt->rowCount();
  $results = '';
  if($count > 0) {


	 // $app->response->setStatus(200);
	 $success = '{

			 "flag": true,
		 	 "msg": "Visitor Found"
		}';
	 echo json_encode($visitor);
 
 } else {

	 // $app->response->setStatus(422);
	 $error = '{"flag": false,"msg": "Oops! Visitor Not Found"}';
	 echo $error;
 }


});



$app->get("/fetchCheck" , function() use ($app) {

	$db = getDB();

	$stmt = $db->prepare('SELECT * FROM test WHERE checked=1');

	$stmt->execute();


	$count = $stmt->rowCount();


	
	echo '{"count":"'.$count.'"}';


});




$app->get("/fetchUnCheck" , function() use ($app) {

	$db = getDB();

	$stmt = $db->prepare('SELECT * FROM test WHERE checked=0');

	$stmt->execute();


	$count = $stmt->rowCount();



	echo '{"count":"'.$count.'"}';



});




$app->get("/checkVisitor/:id" , function($id) use ($app) {

	$db = getDB();

	$id = is_numeric($id) ? intval($id) : 0;


	$stmt = $db->prepare("UPDATE test SET checked=1 WHERE random='".$id."'");

	$stmt->execute();



	$count = $stmt->rowCount();
	  if($count > 0) {

	 // $app->response->setStatus(200);
	 $success = '{"flag": true,"msg": "Visitor is Checked In Successfully","count":"'.$count.'"}';
	 echo $success;
 
 } else {

	 // $app->response->setStatus(422);
	 $error = '{"flag": false,"msg": "Oops! Visitor is Checked In Already or Not Found" , "count":"'.$count.'"}';
	 echo $error;
 }






});



$app->get("/uncheckVisitor/:id" , function($id) use ($app) {

	$db = getDB();


	$id = is_numeric($id) ? intval($id) : 0;



	$stmt = $db->prepare("UPDATE test SET checked=0 WHERE random='".$id."'");


	$stmt->execute();
	$count = $stmt->rowCount();

	   if($count > 0) {

	 // $app->response->setStatus(200);
	 $success = '{"flag": true,"msg": "Visitor is Checked Out Successfully","count":"'.$count.'"}';
	 echo $success;
 
 } else {

	 // $app->response->setStatus(422);
	 $error = '{"flag": false,"msg": "Oops! Visitor is CheckOut Already or Not Found" , "count":"'.$count.'"}';
	 echo $error;
 }
	


});


$app->run();



?>
