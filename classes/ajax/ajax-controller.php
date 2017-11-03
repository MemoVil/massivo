<?php 
include_once('../../../../config/config.inc.php');
include_once('../../../../init.php');

ddd($_POST);
if ($_POST['combination']){
	header('Content-Type: application/json');
	echo "Combinacion:" . $_POST['combination'] . " Nuevo valor:" . $val;
	echo json_encode("");
}
?>