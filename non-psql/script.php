<?php
header("Access-Control-Allow-Origin: *");

$startDate = $_GET['startdate'];
$endDate = $_GET['enddate'];
$tableName = $_GET['tablename'];
$tableIDs = file_get_contents("tableIDs.json");
$tableIDs = json_decode($tableIDs, true);

//&& preg_match("/(\d{4})-(\d{2})-(\d{2})/", $enddate, $results)
if(preg_match("/(\d{4})-(\d{2})-(\d{2})/", $startDate, $results) 
	&& preg_match("/(\d{4})-(\d{2})-(\d{2})/", $endDate, $results) && $tableIDs[$tableName]){
	echo explode(" ", exec('./ona-get-data-and-run-extractor.sh '.$startDate.' '.$endDate.' '.$tableName.' '.$tableIDs[$tableName]))[0];
}else{
	echo "no";
}

?>
