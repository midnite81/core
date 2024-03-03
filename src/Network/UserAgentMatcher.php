<?php

declare(strict_types=1);

namespace Midnite81\Core\Network;

use Illuminate\Support\Str;
use InvalidArgumentException;
use Midnite81\Core\Contracts\Network\Libraries\LibraryInterface;

class UserAgentMatcher
{
    /**
     * Class constructor.
     *
     * @param string|null $userAgent Optional user agent string. Defaults to null.
     * @param array<int, LibraryInterface|class-string> $dictionaries Optional array of dictionaries. Defaults to an
     *                                                                empty array.
     * @return void
     */
    public function __construct(
        protected ?string $userAgent = null,
        protected array $dictionaries = [],
    ) {
        if ($userAgent === null) {
            $this->userAgent = request()->header('User-Agent') ?? 'UnknownUserAgent';
        }
    }

    /**
     * Determines if the user agent matches the dictionaries.
     *
     * @param bool $exactMatch Whether to perform an exact match or not. Defaults to false.
     * @param bool $caseSensitive Whether to perform a case-sensitive match. Defaults to false.
     * @param bool $matchKey Whether to match on keys as well as values. Defaults to false.
     * @return bool Returns true if a match is found, false otherwise.
     */
    public function match(bool $exactMatch = false, bool $caseSensitive = false, bool $matchKey = false): bool
    {
        $this->initialise();
        $convertValue = fn ($value) => $caseSensitive ? $value : strtolower($value);
        $useragent = $convertValue($this->userAgent);

        foreach ($this->dictionaries as $dictionary) {
            $dictionaryCollection = $dictionary->dictionary();

            if ($matchKey) {
                $keyContains = $dictionaryCollection->keys()->contains(function ($key) use (
                    $caseSensitive,
                    $convertValue,
                    $exactMatch,
                    $useragent
                ) {
                    if ($exactMatch) {
                        return $useragent === $convertValue($key);
                    }

                    return Str::of($useragent)->contains($convertValue($key), !$caseSensitive);
                });

                if ($keyContains) {
                    return true;
                }
            }

            $valueContains = $dictionaryCollection->contains(function ($value) use ($caseSensitive, $convertValue, $useragent, $exactMatch) {
                if ($exactMatch) {
                    return $useragent === $convertValue($value);
                }

                return Str::of($useragent)->contains($convertValue($value), !$caseSensitive);
            });

            if ($valueContains) {
                return true;
            }

        }

        return false;
    }

    /**
     * Determines if the user agent does not match any of the dictionaries.
     *
     * @param bool $exactMatch Whether to perform an exact match or not. Defaults to false.
     * @param bool $caseSensitive Whether to perform a case-sensitive match. Defaults to false.
     * @param bool $matchKey Whether to match on keys as well as values. Defaults to false.
     * @return bool True if the user agent does not match any dictionary, false otherwise.
     */
    public function noMatch(bool $exactMatch = false, bool $caseSensitive = false, bool $matchKey = false): bool
    {
        return !$this->match($exactMatch, $caseSensitive, $matchKey);
    }

    /**
     * Set the user agent string.
     *
     * @param string|null $userAgent The user agent string to be set. Defaults to null.
     * @return UserAgentMatcher Returns the current UserAgent instance.
     */
    public function setUserAgent(?string $userAgent): UserAgentMatcher
    {
        $this->userAgent = $userAgent;

        return $this;
    }

    /**
     * Sets the dictionaries.
     *
     * @param array<int, LibraryInterface|class-string> $dictionaries An array of dictionaries.
     * @return UserAgentMatcher The UserAgent object.
     */
    public function setDictionaries(array $dictionaries): UserAgentMatcher
    {
        $this->dictionaries = $dictionaries;

        return $this;
    }

    /**
     * Initialises the dictionaries used for matching the user agent.
     *
     * @throws InvalidArgumentException If no dictionaries have been set, or if a dictionary class does not implement
     *                                  LibraryInterface.
     */
    protected function initialise(): void
    {
        if (empty($this->dictionaries)) {
            throw new InvalidArgumentException('No dictionaries have been set');
        }

        foreach ($this->dictionaries as $key => $dictionary) {
            if (is_string($dictionary)) {
                if (class_exists($dictionary)) {
                    $instance = new $dictionary();
                    if ($instance instanceof LibraryInterface) {
                        $this->dictionaries[$key] = $instance;
                    } else {
                        throw new InvalidArgumentException('The class ' . $dictionary . ' must implement ' . LibraryInterface::class);
                    }
                } else {
                    throw new InvalidArgumentException('The class ' . $dictionary . ' could not be found');
                }
            } elseif (!$dictionary instanceof LibraryInterface) {
                // If the dictionary is not a string and does not implement LibraryInterface, throw an exception
                $name = is_object($dictionary) ? get_class($dictionary) : gettype($dictionary);
                throw new InvalidArgumentException('The class ' . $name . ' must implement ' . LibraryInterface::class);
            }
        }
    }
}
