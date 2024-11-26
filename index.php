<?php

$filePath = './frontend/login.html';


if (file_exists($filePath)) {
    
    $contents = file_get_contents($filePath);
    echo $contents;
}
?>
