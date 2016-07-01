<?php

/*
 * This file is part of the Oryzone PHPoAuthUserData package <https://github.com/Oryzone/PHPoAuthUserData>.
 *
 * (c) Oryzone, developed by Luciano Mammino <lmammino@oryzone.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace OAuth\UserData\Utils;

/**
 * Class ArrayUtils
 * @package OAuth\Utils
 */
class ArrayUtils
{
    /**
     * Utility method to convert an object to an array
     *
     * @param  object $object
     * @return array
     */
    public static function objectToArray($object)
    {
        if (!is_object($object) && !is_array($object)) {
            return $object;
        }

        return array_map('self::objectToArray', (array) $object);
    }

    /**
     * Utility method that allow to remove a list of keys from a given array.
     * This method does not modify the passed array but builds a new one.
     *
     * @param  array    $array
     * @param  string[] $keys
     * @return array
     */
    public static function removeKeys($array, $keys)
    {
        return array_diff_key($array, array_flip($keys));
    }

    /**
     * Extracts the values from the specified fields out of the map.
     *
     * @param array $map              A map containing the key => value pairs.
     * @param array $fields           An array of keys to extract.
     * @param bool  $removeDuplicates Whether or not to remove duplicate values.
     *
     * @return array The extracted values.
     */
    public static function extractMappedValues($map, $fields, $removeDuplicates = true)
    {
        $values = array();
        foreach ($fields as $field) {
            if ($map[$field] !== null && (!$removeDuplicates || !in_array($map[$field], $values))) {
                $values[] = $map[$field];
            }
        }

        return $values;
    }
}
