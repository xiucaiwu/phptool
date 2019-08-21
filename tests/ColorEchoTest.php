<?php

require_once '../vendor/autoload.php';

use PHPTool\ColorEcho;

ColorEcho::info('Hello, world!');
ColorEcho::warn('Hello, world!');
ColorEcho::error('Hello, world!');
ColorEcho::e('Hello, world!', "purple", "yellow");
ColorEcho::e('Hello, world!', "blue", "light_gray");
ColorEcho::e('Hello, world!', "red", "black");
ColorEcho::e('Hello, world!', "cyan", "green");
ColorEcho::e('Hello, world!', "cyan");
ColorEcho::e('Hello, world!', null, "cyan");