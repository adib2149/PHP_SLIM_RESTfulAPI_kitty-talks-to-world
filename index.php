<?php
 

require './libs/Slim/Slim.php';
 
\Slim\Slim::registerAutoloader();
 
$app = new \Slim\Slim();
 
/** Echoing json response to client */
function echoRespnse($status_code, $response) {
    $app = \Slim\Slim::getInstance();
    // Http response code
    $app->status($status_code);
 
    // setting response content type to json
    $app->contentType('application/json');
 
    echo json_encode($response);
}

/* first GET request */
$app->get('/greetings', function() use ($app){
	
	$req = $app->request();
	$question = strtolower($req->get('q'));
	
	$containsHi = stristr($question,'hi') != false;
	$containsHello = stristr($question,'hello') != false;
	$containsGood = stristr($question,'good') != false;
	
	$response = [];
	
	if ($containsHi or $containsHello or $containsGood) {
		$response["answer"] = "Hello Kitty!";
	} else {
		$response["answer"] = "I don't know what are you saying.";
	}
	
    echoRespnse(200, $response);
});

/* second GET request */
$app->get('/weather', function() use ($app){
	
	$req = $app->request();
	$question = strtolower($req->get('q'));
	
	$containsIs = stristr($question,'is') != false;
	$containsIn = stristr($question,'in') != false;
	$containsWhatOrThere = (stristr($question,'what') != false) || (stristr($question,'there') != false);
	
	$response = [];
	
	if ($containsIs and $containsIn and $containsWhatOrThere) {
		
		$last_word_start = strrpos($question, ' ') + 1; // +1 so we don't include the space in our result
		$cityname = substr($question, $last_word_start); // $last_word = PHP.
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "http://api.openweathermap.org/data/2.5/weather?q=" . $cityname . "&appid=2de143494c0b295cca9337e1e96b00e0");
		curl_setopt($ch, CURLOPT_HEADER, 0);            // No header in the result 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return, do not echo result   

		// Fetch and return content, save it.
		$raw_data = curl_exec($ch);
		curl_close($ch);

		// If the API is JSON, use json_decode.
		$data = json_decode($raw_data);
		
		if (strpos($question,'temperature') !== false) {
			
			$temperature = $data->main->temp;
			$response["answer"] = $temperature . "K";
			
		} else if (strpos($question,'humidity') !== false) {
			
			$response["answer"] = $data->main->humidity;
			
		} else if (strpos($question,'rain') !== false) {
			
			$weatherid = $data->weather[0]->id;
			if ($weatherid >= 500 and $weatherid <= 599) {
				$response["answer"] = "Yes";
			} else {
				$response["answer"] = "no";
			}
			
		} else if (strpos($question,'clouds') !== false) {
			
			$weatherid = $data->weather[0]->id;
			if ($weatherid >= 800 and $weatherid <= 809) {
				$response["answer"] = "Yes";
			} else {
				$response["answer"] = "no";
			}
			
		} else if (strpos($question,'clear weather') !== false) {
			
			$weatherid = $data->weather[0]->id;
			if ($weatherid == 800) {
				$response["answer"] = "Yes";
			} else {
				$response["answer"] = "no";
			}
			
		} else {
			$response["answer"] = "I don't know what are you saying.";
		}
	} else {
		$response["answer"] = "I don't know what are you saying. Not in loop";
	}
	
    echoRespnse(200, $response);
});
		
$app->run();