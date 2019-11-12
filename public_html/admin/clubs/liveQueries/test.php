<?php

//$isLeft = "lala";//isset($_POST["currPlayer"]) ? htmlspecialchars($_POST["currPlayer"]) : null;
//$action = "popa";// isset($_POST["action"]) ? htmlspecialchars($_POST["action"]) : null;
//$score = 3;//isset($_POST["score"]) ? htmlspecialchars($_POST["score"]) : null;
//$val = "dupa";//isset($_POST["val"]) ? htmlspecialchars($_POST["val"]) : null;

$_POST["currPlayer"] = "playertest";
$_POST["action"] = "actiontest";
$_POST["score"] = 33;
$_POST["val"] = "valtest";

$rlt = array();

foreach ($_POST as $l=>$v){
	$rlt[$l] = $v;
}

foreach ($_POST as $l=>$v){
	unset($_POST[$l]);
}

$rlt["request"] = "INSERT INTO billiard(name) VALUES(?)";
$rlt["erreur"] = false;

print_r(json_encode($rlt) );

?>
