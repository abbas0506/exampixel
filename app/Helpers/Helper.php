<?php

namespace App\Helpers;
use Illuminate\Support\Facades\App;
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
        $replacementAnd = '$1 \& $2';
        $text = preg_replace($patternForAnd, $replacementAnd, $text);
        // $text = str_replace(['\(', '\)'], '$', $text);
        // $text = str_replace("%", "\%", $text);
        $text = str_replace("both a & b", "both a \& b" , $text);
        $text  = str_replace('ـ', '\_', $text);
        $text = strlen(trim($text)) == 2 && $text == '&&' ? '\&\&' : $text;
        $text = strlen(trim($text)) == 1 && $text == '#' ? '\#' : $text;
        $text = strlen(trim($text)) == 1 && $text == '&' ? '\&' : $text;
        $text = strlen(trim($text)) == 1 && $text == '|' ? '\|' : $text;
        // $text = strlen(trim($text)) == 1 && $text == "\\" ? "\\backslash" : $text;
        // $text = str_replace('\\\\', '\\backslash\\backslash', $text);

        return $text;
        // $text = str_replace("&","\&",$text);
        $pattern = "/([\x{0600}-\x{06FF}\x{0750}-\x{077F}\x{FB50}-\x{FDFF}\x{FE70}-\x{FEFF}]+)/u";
        // if (preg_match($pattern, $text)) {
        //     return "\\begin{RTL}" . $text . "\\end{RTL}";
        // }
        return $text;
        // Replacement pattern to wrap Urdu text with \\texturdu{}
        $replacement = '\\texturdu{$1}';
        // Applying the replacement
        return preg_replace($pattern, $replacement, $text);
    }

    static function parseAnswer($text, bool $last = false)
    {
        $text = Helper::parseTex($text);
        // return $text;
        $len = strlen($text);
        if($len >= 40){
            $cm = 12;
        }else{
            $cm = 4;
        }
        $rtl = App::currentLocale() == 'ur' ? 'r' : 'l';
        return $last ? "$text" : "\makebox[$cm cm][$rtl]{{$text}}";
    }

    static function hasUrdu($text)
    {
        $pattern = "/([\x{0600}-\x{06FF}\x{0750}-\x{077F}\x{FB50}-\x{FDFF}\x{FE70}-\x{FEFF}]+)/u";
        return preg_match($pattern, $text);
    }
}
