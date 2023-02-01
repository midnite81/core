<?php

declare(strict_types=1);

namespace Midnite81\Core\Helpers;

class UserAgent
{
    /**
     * @param string|null $userAgent
     * @return bool
     */
    public static function isFacebook(?string $userAgent = null): bool
    {
        return static::matchesPatternInUserAgent('facebookexternalhit', $userAgent);
    }

    /**
     * @param string|null $userAgent
     * @return bool
     */
    public static function isTwitter(?string $userAgent = null): bool
    {
        return static::matchesPatternInUserAgent('Twitterbot', $userAgent);
    }

    /**
     * @param string|null $userAgent
     * @return bool
     */
    public static function isAppleIMessageLinkPreviewer(?string $userAgent = null): bool
    {
        return static::matchesPatternInUserAgent('AppleWebKit', $userAgent)
            && static::matchesPatternInUserAgent('Facebot Twitterbot', $userAgent);
    }

    /**
     * @param string $pattern
     * @param string|null $userAgent
     * @return bool
     */
    protected static function matchesPatternInUserAgent(string $pattern, ?string $userAgent): bool
    {
        $userAgent = $userAgent ?? request()->userAgent() ?? '';

        return (bool) preg_match(
            '/' . $pattern . '/si',
            $userAgent
        );
    }
}
