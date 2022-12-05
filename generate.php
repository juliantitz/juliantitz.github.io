<?php 

/* fix forbidden issue on chrome with ajax request */
header("Access-Control-Allow-Origin: *");

/* only resond if the AJAX request is coming from localhost:8888 or http://dev.cybertronindia.com/animal-output-generator/ */
if ($_SERVER['HTTP_HOST'] == 'localhost:8888' || $_SERVER['HTTP_HOST'] == 'dev.cybertronindia.com' || $_SERVER['HTTP_HOST'] == 'juliantitz.github.io') {

    if(isset($_GET['animal'])) {
      $animal = $_GET['animal'];
      $outfit = $_GET['outfit'];
      $background = $_GET['background'];
      $style =  $_GET['style'];

      $prompt = $style." of a ".$animal." wearing a ".$outfit." in front of a ".$background.".";

      $curl = curl_init();
      $data = array (
        'prompt' => $prompt,
        'n' => 1,
        'size' => '1024x1024',
      );
      $payload = json_encode($data);
      curl_setopt($curl, CURLOPT_URL, "https://api.openai.com/v1/images/generations");
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
      curl_setopt($curl, CURLOPT_POSTFIELDS, $payload);
      curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization: Bearer sk-open-ai-key'));
      curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

      $response = curl_exec($curl);
      curl_close($curl);
      
      $response = json_decode($response);   
      echo $response->data[0]->url;   
    }    
} else {
    echo "Invalid Origin";}
  ?>