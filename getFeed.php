<?php
	//getFeed.php?search=%23Tallinn
	//https://github.com/J7mbo/twitter-api-php/blob/master/TwitterAPIExchange.php
	require_once("twitterApiExchange.php");
	require_once("config.php");
	
	$url = "https://api.twitter.com/1.1/search/tweets.json";
	$getField = "?q=%23Paris&result_type=recent";
	$requestMethod = "GET";
	$file_name = "cache.txt";
	$data_json = file_get_contents("cache.txt");
	$data = json_decode($data_json);

	//KONTROLLI, kas strtotime(date('c')) - strtotime($data->date_written) > 10
	if(strtotime(date('c')) - strtotime($data->date_written) > 10){
		//config tuleb config.php failist
		$twitter = new TwitterAPIExchange($config);
		$dataFromApi = $twitter->setGetField($getField)->buildOauth($url, $requestMethod)->performRequest();
		$o = new StdClass();
		$o->date_written = date('c');
		//teen stringi objektiks
		$o->api = json_decode($dataFromApi);

		//lisan siia vanad tagasi, mida siin ei ole
		foreach($data->api->statuses as $old_status){
			
			$new = true;
			
			foreach($o->api->statuses as $new_status){
				
				if($old_status->id != $new_status->id){
					$new = false; //oli olemas
				}
				
			}
			
			if($new){
				echo("lisatud juurde <br>");
				//lisan uutesse vana juurde
				array_push($o->api->statuses, $old_status);
			}
			
		}
		
		
		
		//teen objekti stringiks ja salvestan faili
		file_put_contents($file_name, json_encode($o));
		echo json_encode($o);
	}else{
		//echo $data_json;
		
		//var_dump($data->api->statuses[0]->id);
	}
	
?>