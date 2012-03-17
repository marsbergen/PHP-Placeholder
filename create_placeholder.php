#!/usr/bin/php
<?php
require_once('placeholder.php');

error_reporting(0);

$width            = $argv[1];
$height           = $argv[2];
$background_color = $argv[3];
$text_color       = $argv[4];
$text             = $argv[5];

echo Placeholder::image($width, $height, $background_color, $text_color, $text);
echo "\n";