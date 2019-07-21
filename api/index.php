<?php
header('content-type:application/json');

echo json_encode(array('code' => '400', 'message' => 'Mauvaise requête GET'));
header('HTTP/2 400 Bad Request');