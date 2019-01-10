<?php

namespace PHPTool;


class ColorEcho
{
    public static function info($string)
    {
        echo ColorString::getColoredString($string, 'black', 'green') . PHP_EOL;
    }
	
    public static function warn($string)
    {
        echo ColorString::getColoredString($string, 'black', 'yellow') . PHP_EOL;
    }
	
    public static function error($string)
    {
        echo ColorString::getColoredString($string, 'white', 'red') . PHP_EOL;
    }
	
	public static function e($string, $foreground_color = null, $background_color = null) {
		echo ColorString::getColoredString($string, $foreground_color, $background_color) . PHP_EOL;
	}
}