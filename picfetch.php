<?php

$arr = file_get_contents("photostodownload.data.list");
$arr = explode("\n", trim($arr));

$total = count($arr);

echo "Files to download = ".$total."\n";

$starttime = time();

foreach($arr as $k=>$i){
	//echo("downloading: ".$i."\n");
	if($i) {
	exec("./picfetch.sh ".$i);
	if(!($k%500)) {
		$timeelapsed = (time()-$starttime)/60;
		echo $k."/".$total." files downloaded..Time elapsed: ". $timeelapsed." minutes..\n";
	}
	}
}

$timeelapsed = (time()-$starttime)/60;

echo "All $total files downloaded! Total time taken for operation: ".$timeelapsed." minutes.\n";

?>
