<?php

namespace Project\Core\Helper;

/**
 * String Helper Class
 *
 */
class ArrayHelper
{
    /**
     * @param $needle
     * @param $haystack
     * @param bool $strict
     * @return bool
     */
    public static function inArrayRecursive($needle, $haystack, $strict = false) {
        foreach ($haystack as $item) {
            if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && self::inArrayRecursive($needle, $item, $strict))) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param array $content
     * @param $keySearch
     * @return mixed|null
     */
    public static function extractContentIfExists(array $content, $keySearch)
    {
        if (array_key_exists($keySearch, $content)) {
            return $content[$keySearch];
        }

        return null;
    }

    /**
     * @param null $argName
     * @return array|mixed|null
     */
    public static function getArgByCommandLine($argName = null) {
        global $argv;
        if (empty($argv)) {
            return null;
        }

        $listArgs = [];
        foreach($argv as $arg) {
            if (strpos($arg, "--") !== false && strpos($arg, "=") !== false) {
                list($arg, $value) = explode("=", $arg);
                $listArgs[str_replace("--", "", trim($arg))] = trim($value);
            }
        }

        if (!empty($argName)) {
            $listArgs = array_key_exists($argName, $listArgs) ? $listArgs[$argName] : null;
        }

        return $listArgs;
    }
}
