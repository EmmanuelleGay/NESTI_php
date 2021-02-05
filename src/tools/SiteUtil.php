<?php 
SiteUtil::require('tools/FormatUtil.php');

/**
 * SiteUtil
 * Site-related convenience methods
 */
class SiteUtil{    
    /**
     * require
     * includes a file
     * @param  String $relativePath relative path of file
     * @param  bool $once require once?
     * @return void
     */
    public static function require(String $relativePath="", bool $once=true){
        $absolutePath =  self::toAbsolute("src/$relativePath");
        $once?require_once($absolutePath):require($absolutePath);
    }
     
    /**
     * toAbsolute
     * Turns a relative file path parameter into an absolute path (from project root);
     * @param  mixed $relativePath
     * @return String absolute path
     */
    public static function toAbsolute(String $relativePath=""): String{
        return dirname( __FILE__ ) . "/../../$relativePath";
    }

    
     /**
     * url
     * Transforms a relative (to project root) URL into an absolute one
     * @param  String URL $relative to project root
     * @return String absolute url
     */
    public static function url(String $relativeUrl=""): String{
        // base url is originally called script's directory
        $baseUrl = dirname($_SERVER["SCRIPT_NAME"]);

        // In local testing, we maycall a script in project root (')not /public) to simulate production .htaccess behavior
        if (FormatUtil::endsWith($baseUrl,"/public")){
            $baseUrl = dirname($baseUrl);
        }

        return $baseUrl . "/" . $relativeUrl;
    }

    /**
     * getUrlParameters
     * extracts an URL of the form /my/pretty/url from $_SERVER, and returns an array of slugs
     * 
     * @return Array of slugs, ie. ['my', 'pretty', 'url']
     */
    public static function getUrlParameters(): Array{
        if ( isset($_SERVER['REDIRECT_QUERY_STRING']) ) {
            $queryString = $_SERVER['REDIRECT_QUERY_STRING'];
        } else {
            $queryString = $_SERVER['QUERY_STRING'];
        }

        return explode('/',FormatUtil::sanitize($queryString));
    }


    public static function autoloadRegister(){
        spl_autoload_register(function ($className) {
            if ( FormatUtil::endsWith($className, "Controller")){
                self::require("controller/$className.php");
            } elseif ( FormatUtil::endsWith($className, "Dao")){
                self::require("model/dao/$className.php");
            } elseif ( FormatUtil::endsWith($className, "Util")){
                self::require("util/$className.php");
            } else {
                self::require("model/entity/$className.php");
            }
        });
    }
}