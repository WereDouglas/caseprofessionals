<?php


class StringHelper
{
    public static function friendlyString($string)
    {
        return trim(ucwords(preg_replace('/[.,-_;:]/', ' ', $string)));
    }

    public static function machineString($string)
    {
        return strtolower(preg_replace('/[\s+,-.;:]/', '_', $string));
    }

    public static function startsWith($haystack, $needle) {
        // search backwards starting from haystack length characters from the end
        $haystack = trim($haystack);
        return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== FALSE;
    }

    public static function endsWith($haystack, $needle) {
        // search forward starting from end minus needle length characters
        return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== FALSE);
    }

    public static function tagContains($haystack, $tag, $string)
    {
        $src = self::extractHtmlAttribute($haystack, 'script', 'src');
        return $src != '';
    }

    public static function extractHtmlAttribute($haystack, $tag, $attribute){
        preg_match('/< *'.$tag.'[^>]*'.$attribute.' *= *["\']?([^"\']*)/i', $haystack, $matches);
        return $matches;
    }

    private static function stringContains($haystack, $needle)
    {
        return strpos($haystack, $needle) !== false;
    }



    public static function numberToAlphabet($number){
        $alphabet =   ['A','B','C','D','E','F','G','H','I','J','K','L','M',
            'N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];

        $alphabetSize = count($alphabet);

        if($number > $alphabetSize){
            $first = floor($number/$alphabetSize);
            $second = $number%$alphabetSize;

            if($second == 0)
                return self::numberToAlphabet($first - 1).$alphabet[$alphabetSize - 1];
            return self::numberToAlphabet($first).$alphabet[($second - 1)];
        }

        return $alphabet[$number - 1];
    }


}