<?php

declare(strict_types=1);

namespace Midnite81\Core\Helpers;

use Midnite81\Core\Exceptions\Arrays\ArrayKeyAlreadyExistsException;

class Arrays
{
    public static function arrayOrderBy()
    {
        $args = func_get_args();
        $data = array_shift($args);
        foreach ($args as $n => $field) {
            if (is_string($field)) {
                $tmp = [];
                foreach ($data as $key => $row) {
                    $tmp[$key] = $row[$field];
                }
                $args[$n] = $tmp;
            }
        }
        $args[] = &$data;
        call_user_func_array('array_multisort', $args);

        return array_pop($args);
    }

    /**
     * Implodes an array with the provided separator except for the last item which it prefixes and
     * for example ['one', 'two', 'three]
     * becomes one, two and three
     *
     * @param  array  $array
     * @param  string  $separator
     * @return string
     */
    public static function implodeAnd(array $array, string $separator = ','): string
    {
        return static::implodePenultimate($array, 'and', $separator);
    }

    /**
     * Implodes an array with the provided separator except for the last item which it prefixes or
     * for example ['one', 'two', 'three]
     * becomes one, two or three
     *
     * @param  array  $array
     * @param  string  $separator
     * @return string
     */
    public static function implodeOr(array $array, string $separator = ','): string
    {
        return static::implodePenultimate($array, 'or', $separator);
    }

    /**
     * Implodes an array with the provided separator except for the last item which it prefixes with the word you provide
     * for example with an array of ['one', 'two', 'three], separator of ',' and penultimateWord 'and/or'
     * becomes one, two and/or three
     *
     * @param  array  $array
     * @param  string  $separator
     * @param  string  $penultimateWord
     * @return string
     */
    public static function implodePenultimate(
        array $array,
        string $penultimateWord,
        string $separator = ',',
    ): string {
        $last = array_slice($array, -1);
        $first = implode("$separator ", array_slice($array, 0, -1));
        $both = array_filter(array_merge([$first], $last), 'strlen');

        return implode(" $penultimateWord ", $both);
    }

    /**
     * Renames a key in an array, overwriting the existing key if it exists, and removes the old key
     *
     * @param  array  $array
     * @param  string  $oldKey
     * @param  string  $newKey
     * @param  bool  $throwIfNewKeyAlreadyExists
     * @return void
     *
     * @throws ArrayKeyAlreadyExistsException
     */
    public static function renameKey(
        array &$array,
        string $oldKey,
        string $newKey,
        bool $throwIfNewKeyAlreadyExists = false
    ): void {
        if ($oldKey === $newKey) {
            return;
        }

        if (array_key_exists($newKey, $array) && $throwIfNewKeyAlreadyExists) {
            throw new ArrayKeyAlreadyExistsException($newKey);
        }

        if (array_key_exists($oldKey, $array)) {
            $array[$newKey] = $array[$oldKey];
            unset($array[$oldKey]);
        }
    }
}
