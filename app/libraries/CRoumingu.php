<?php
namespace MyLibraries;
class CRoumingu{

    protected static $key ="701094af4518f41491a79da733600az0q";
    protected static $user = "rassbtx";
    protected static $function = "rassilka";
    protected static $pass = "g5Xzpuq3Daj";
    protected static $format = "json";
    protected static $v = 1;


    protected static function getCurl($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        // установка URL и других необходимых параметров
        curl_setopt($ch, CURLOPT_URL, $url);
        // загрузка страницы и выдача её браузеру
        $result = curl_exec($ch);

        return $result = json_decode($result);
    }

    public static  function getKopilkaGroups(){
        return self::getCurl('https://secure2.roumingu.net/api2/?v='.self::$v.'&key='.self::$key.'&user='.self::$user.'&function='.self::$function.'&command=getKopilkaGroups&params[pass]='.self::$pass.'&response='.self::$format);
    }

    public static  function getKopilkaEmails($id){
        //echo 'https://secure2.roumingu.net/api2/?v='.self::$v.'&key='.self::$key.'&user='.self::$user.'&function='.self::$function.'&command=getKopilkaEmails&params[pass]='.self::$pass.'&params[groups]='.$id.'&response='.self::$format;
        return self::getCurl('https://secure2.roumingu.net/api2/?v='.self::$v.'&key='.self::$key.'&user='.self::$user.'&function='.self::$function.'&command=getKopilkaEmails&params[pass]='.self::$pass.'&params[groups]='.$id.'&response='.self::$format);
    }


    public static  function getContragentsGroups(){
        return self::getCurl('https://secure2.roumingu.net/api2/?v='.self::$v.'&key='.self::$key.'&user='.self::$user.'&function='.self::$function.'&command=getContragentsGroups&params[pass]='.self::$pass.'&response='.self::$format);
    }

    public static  function getContragentsEmails($id){
        return self::getCurl('https://secure2.roumingu.net/api2/?v='.self::$v.'&key='.self::$key.'&user='.self::$user.'&function='.self::$function.'&command=getContragentsEmails&params[pass]='.self::$pass.'&params[groups]='.$id.'&response='.self::$format);
    }

}