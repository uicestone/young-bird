<?php

$wx = new WeixinAPI();

header('Content-Type: application/json');
echo json_encode($wx->generate_jsapi_args());