<?php

require('../phpMQTT.php');

$server = "mq.stg.netobjex.com";     // change if necessary
$port = 1883;                     // change if necessary
$username = "daf7a56b-9959-4e3a-a605-93a15cca2edc";                   // set your username
$password = "qCp^B9M6";                   // set your password
$topic       = "/topic/device/OrderFeed/in";
$client_id = "8f38c869-38c9-4313-9747-5d1ce926d24f"; // make sure this is unique for connecting to sever - you could use uniqid()

$mqtt = new Bluerhinos\phpMQTT($server, $port, $client_id);

$arr = array(

		   "payloadType"=>"OrderFeed", "queueName"=>"OrderFeed", "order_id"=>1, "customer_id"=>2,  "customer_group_id"=>12,

		   "shipping_firstname"=>"john",  "shipping_lastname"=>"doe", "shipping_address_1"=>"400 Campus Dr, Somerset, NJ 08873, USA",

		   "shipping_address_2"=>"",  "shipping_city"=>"", "shipping_postcode"=>"", "shipping_method"=>"",

		   "total"=>"7.89", "order_status_id"=>"5",  "date_added"=>"2021-02-04 08:12:27",  "lat"=>40.54807,

		   "lon"=>-74.5451, "catering_order"=>"1",  "processed_order"=>"0"
 
		);
//echo json_encode($arr);

echo "Connecting...\n";

if ($mqtt->connect(true, NULL, $username, $password)) {
	$topics['/topic/device/OrderFeed/in'] = array('qos' => 0, 'function' => 'procMsg');
	$mqtt->subscribe($topics, 0);
	echo "Subscribed to topic: " . $topic . "\n";
	$mqtt->publish($topic, json_encode($arr), 0, false);
	echo "Publishing message... ";
	$mqtt->close();
} else {
    echo "Time out!\n";
}
?>