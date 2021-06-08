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

    
    /**
     * dd
     * dump and die
     *
     * @param  mixed $var
     * @return void
     */
    public static function dd($var)
    {
        self::dump($var);
        die();
    }

    
    /**
     * formatTime
     *
     * @param  mixed $minutes
     * @return void
     */
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
    
    /**
     * getFormattedQuantity
     *
     * @param  mixed $unitName
     * @param  mixed $quantity
     * @param  mixed $nameIngredient
     * @return void
     */
    public static function getFormattedQuantity($unitName, $quantity, $nameIngredient)
    {
        $result = "";
        $pluralUnit = [
            "kg" => "kgs",
            "litre" => "litres",
            "piece" => "pieces"
        ];

        if ($unitName == "piece") {
            if ($quantity > 0) {
                $nameIngredient = $nameIngredient . "s";
            }
            $result = $quantity . " " . $nameIngredient;
        } else {
            $result =  $quantity . " " . $unitName . " de " . $nameIngredient;
        }

        return $result;
    }
    
    /**
     * formatDate
     *
     * @param  mixed $date
     * @return void
     */
    public static function formatDate($date)
    {
        $result = "";
        if ($date != null) {
            setlocale(LC_TIME, "fr_FR.UTF-8", "French");
            $result = strftime('%d %B %Y %Hh%M', strtotime($date));
        } else {
            $result = "-";
        }
        return $result;
    }

    public static function currentSqlDate(){
        return static::dateTimeToSqlDate(new DateTime());
    }

    public static function dateTimeToSqlDate($dt){
        return $dt->format('Y-m-d H:i:s');
    }

}
