<?php

/**
 * FormatUtil
 * Format-related convenience methods.
 */
class FormatUtil
{


    /**
     * dump
     * generates an html representation of a variable
     * 
     * @param  mixed $var to display in html
     * @return void
     */
    public static function dump($var)
    {
        echo "<pre>" . htmlentities(print_r($var, true)) . "</pre>";
    }


    /**
     * endsWith
     * check if a string starts with another string
     * 
     * @param  mixed $haystack
     * @param  mixed $needle
     * @return void
     */
    public static function startsWith($haystack, $needle)
    {
        $length = strlen($needle);
        if (!$length) {
            return true;
        }
        return substr($haystack, $length) === $needle;
    }


    /**
     * endsWith
     * check if a string ends with another string
     * 
     * @param  mixed $haystack
     * @param  mixed $needle
     * @return void
     */
    public static function endsWith($haystack, $needle)
    {
        $length = strlen($needle);
        if (!$length) {
            return true;
        }
        return substr($haystack, -$length) === $needle;
    }


    public static function dd($var)
    {
        self::dump($var);
        die();
    }


    public static function formatTime($minutes)
    {
        $hours = floor($minutes / 60);
        $minutes = $minutes % 60;

        $result = "";

        if ($hours != 0) {
            $result .= $hours . 'h';
        }

        if ($minutes != 0) {
            $result .= $minutes . ' min';
        }

        return $result;
    }

    public static function getFormattedQuantity($unitName, $quantity,$nameIngredient)
    {
        $result = "";
        $pluralUnit = [
            "kg" => "kgs",
            "litre" => "litres",
            "piece" => "pieces"
        ];

        if ($unitName == "piece") {
            if($quantity>0){
                $nameIngredient = $nameIngredient."s";
            }
            $result = $quantity . " " .$nameIngredient;
        } else {
            $result =  $quantity . " " . $unitName. " de " .$nameIngredient;
        }

        return $result;
    }
}
