<?php

declare(strict_types=1);

namespace Midnite81\Core\Helpers;

use Illuminate\Support\Str;
use Midnite81\Core\Exceptions\Arrays\ArrayKeyAlreadyExistsException;
use RecursiveArrayIterator;
use RecursiveIteratorIterator;

class Arrays
{
    /**
     * Filters an array based on a value and options, with an option to filter by a specific key.
     *
     * @param array $original The original array to be filtered.
     * @param mixed $value The value used for filtering. Defaults to null.
     * @param array $options Additional options for filtering.
     *                        Available options are:
     *                        - 'negate' (bool): Whether to negate the filter results.
     *                        - 'caseSensitive' (bool): Whether to perform a case-sensitive search. Defaults to true.
     *                        - 'preserveKey' (bool): Whether to keep the original array key. Defaults to false.
     * @param string|null $filterKey The key to filter by in the associative array. Defaults to null.
     * @param bool $useOriginalIfValueEmpty Specifies whether to return the original array if the value is empty. Defaults to false.
     * @return array The filtered array.
     */
    public static function filter(
        array $original = [],
        mixed $value = '',
        array $options = [],
        ?string $filterKey = null,
        bool $useOriginalIfValueEmpty = false,
    ): array {
        if ($useOriginalIfValueEmpty && (is_null($value) || $value === '')) {
            return $original;
        }

        $filtered = array_filter($original, function ($item, $key) use ($value, $options, $filterKey) {
            $matches = false;

            if ($filterKey !== null && is_array($item)) {
                if (array_key_exists($filterKey, $item)) {
                    $currentValue = $item[$filterKey];
                    if (is_string($value) && $value !== '') {
                        if (!empty($options['caseSensitive'])) {
                            $matches = Str::contains($currentValue, $value);
                        } else {
                            $matches = Str::contains(strtolower($currentValue), strtolower($value));
                        }
                    } else {
                        $matches = $currentValue === $value;
                    }
                }
            } elseif ($filterKey === null || $filterKey === $key) {
                if (is_string($value) && $value !== '') {
                    if (!empty($options['caseSensitive'])) {
                        $matches = Str::contains($item, $value);
                    } else {
                        $matches = Str::contains(strtolower($item), strtolower($value));
                    }
                } else {
                    $matches = $item === $value;
                }
            }

            if (!empty($options['negate'])) {
                return !$matches;
            }

            return $matches;
        }, ARRAY_FILTER_USE_BOTH);

        // If preserveKey is not set, re-index the array
        if (empty($options['preserveKey']) && array_keys($original) === range(0, count($original) - 1)) {
            return array_values($filtered);
        }

        return $filtered;
    }


    /**
     * Filters an array case insensitively by a given value with the provided options.
     * If no element matches the value and $returnOriginalOnNoMatch is set to true, returns the original array.
     *
     * @param array $original The original array to filter.
     * @param mixed $value The value to use for filtering.
     * @param array $options Additional options for filtering.
     *                      Available options are:
     *                      - 'negate' (bool): Whether to negate the filter results.
     * @param bool $useOriginalIfValueEmpty Specifies whether to return the original array if the value is empty. Defaults to false.
     *
     * @return array The filtered array.
     */
    public static function filterInsensitive(
        array $original = [],
        mixed $value = null,
        array $options = [],
        ?string $filterKey = null,
        bool $useOriginalIfValueEmpty = false,
    ): array {
        $options['caseSensitive'] = false;

        return static::filter($original, $value, $options, $filterKey, $useOriginalIfValueEmpty);
    }


    /**
     * Sorts an array by a specified order
     * Example:
     * Arrays::arrayOrderBy($array, 'name', SORT_ASC);
     *
     * @return mixed|null
     */
    public static function arrayOrderBy(): mixed
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
     * for example ['one', 'two', 'three']
     * becomes one, two and three
     */
    public static function implodeAnd(array $array, string $separator = ','): string
    {
        return static::implodePenultimate($array, 'and', $separator);
    }

    /**
     * Implodes an array with the provided separator except for the last item which it prefixes or
     * for example ['one', 'two', 'three']
     * becomes one, two or three
     */
    public static function implodeOr(array $array, string $separator = ','): string
    {
        return static::implodePenultimate($array, 'or', $separator);
    }

    /**
     * Implodes an array with the provided separator except for the last item which it prefixes with the word you provide
     * for example with an array of ['one', 'two', 'three'], separator of ',' and penultimateWord 'and/or'
     * becomes one, two and/or three
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

    /**
     * Converts a multidimensional array to dot notation by flattening the array keys.
     * For example, ['foo' => ['bar' => 'baz']] becomes ['foo.bar' => 'baz'].
     *
     * @param array $original The original multidimensional array.
     *
     * @return array The array converted to dot notation.
     */
    public static function toDotNotation(array $original, bool $simple = false): array
    {
        $result = [];

        // Closure for getting sub-array by keys.
        $getSubArrayByKeys = function (array $array, array $keys) {
            foreach ($keys as $key) {
                if (isset($array[$key]) && is_array($array[$key])) {
                    $array = $array[$key];
                } else {
                    return [];
                }
            }
            return $array;
        };

        $iterator = new RecursiveIteratorIterator(
            new RecursiveArrayIterator($original),
            RecursiveIteratorIterator::LEAVES_ONLY
        );

        foreach ($iterator as $leafValue) {
            // Building the dot notation key for the current element.
            $keys = [];
            foreach (range(0, $iterator->getDepth()) as $depth) {
                $keys[] = $iterator->getSubIterator($depth)->key();
            }
            $dotKey = implode('.', $keys);

            // Adding the key-value pair.
            $result[$dotKey] = $leafValue;

            // If simple mode is false, add intermediate arrays.
            if (!$simple) {
                $subKeys = explode('.', $dotKey);
                array_pop($subKeys); // Remove the last key as it's already added.
                while (count($subKeys) > 0) {
                    $subKey = implode('.', $subKeys);
                    if (!array_key_exists($subKey, $result)) {
                        $result[$subKey] = $getSubArrayByKeys($original, $subKeys);
                    }
                    array_pop($subKeys);
                }
            }
        }

        return $result;
    }
}
