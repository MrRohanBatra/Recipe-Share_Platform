<?php

$filePath = './frontend/login.html';


if (file_exists($filePath)) {
    
    $contents = file_get_contents($filePath);
    
    echo $contents;
} else {
    
    echo "The file login.html does not exist.";
}
?>
