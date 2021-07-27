<?php
$weatherFile = fopen("weather.txt", "a") or die("не удалось открыть файл");
$weatherString = date('l jS \of F Y h:i:s A') . "\t T=21C\t H=51%\t P=746";
fwrite($weatherFile, $weatherString);
fclose($weatherFile);