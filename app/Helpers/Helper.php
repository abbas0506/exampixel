<?php

namespace App\Helpers;

class Helper
{
    static function parseTex($text, bool $question = false)
    {
        $text = preg_replace_callback('/\\\\\(.*?\\\\\)|_/', function ($matches) {
            if (strpos($matches[0], '\\(') === 0) {
                return $matches[0];
            } else {
                return '\\_';
            }
        }, $text);
        $patternForAnd = '/(\b\w{2,}+)\s*&\s*(\w{2,}+\b)/';
        $replacementAnd = '$1\\&$2';
        $text = preg_replace($patternForAnd, $replacementAnd, $text);
        $text = str_replace("%", "\%", $text);
        return $text;
        // $text = str_replace("&","\&",$text);
        $pattern = "/([\x{0600}-\x{06FF}\x{0750}-\x{077F}\x{FB50}-\x{FDFF}\x{FE70}-\x{FEFF}]+)/u";
        if (preg_match($pattern, $text)) {
            return "\\begin{RTL}" . $text . "\\end{RTL}";
        }
        return $text;
        // Replacement pattern to wrap Urdu text with \\texturdu{}
        $replacement = '\\texturdu{$1}';
        // Applying the replacement
        return preg_replace($pattern, $replacement, $text);
    }

    static function parseAnswer($text, bool $last = false)
    {
        $text = Helper::parseTex($text);
        // $len = strlen($text);
        // if($len > 50){
        //     $cm = 10;
        // }else if($len > 40){
        //     $cm = 8;
        // }else if($len > 30){
        //     $cm = 6;
        // }else if($len > 20){
        //     $cm = 4;
        // }else{
        //     $cm = 2;
        // }
        return $last ? "$text" : "\makebox[4cm][l]{{$text}}";
    }

    static function hasUrdu($text)
    {
        $pattern = "/([\x{0600}-\x{06FF}\x{0750}-\x{077F}\x{FB50}-\x{FDFF}\x{FE70}-\x{FEFF}]+)/u";
        return preg_match($pattern, $text);
    }
}
