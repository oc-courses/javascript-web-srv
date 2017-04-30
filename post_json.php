<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
$data = print_r(json_decode(file_get_contents('php://input'), true), true);
file_put_contents("post_json.log", $data);
