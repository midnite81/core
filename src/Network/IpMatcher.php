<?php

declare(strict_types=1);

namespace Midnite81\Core\Network;

/**
 * Class IpMatcher
 *
 * This class is used to match IP addresses against a list of allowed IP addresses.
 */
class IpMatcher
{
    /**
     * @var array|string[]
     */
    protected array $ipAddresses;

    /**
     * Constructor method for the class.
     *
     * @param array|string $ip The IP address(es) to be assigned.
     */
    public function __construct(array|string $ip)
    {
        $this->ipAddresses = is_string($ip) ? [$ip] : $ip;
    }

    public static function of(array|string $ip): static
    {
        return new static($ip);
    }

    public static function fromRequestIp(): static
    {
        return new static(request()->ip());
    }

    public static function fromRequestIps(): static
    {
        return new static(request()->ips());
    }

    /**
     * Determines if the domain matches the IP address.
     *
     * @param string $ip
     * @return bool Returns true if a match is found, false otherwise.
     */
    public function match(string $ip): bool
    {
        if (in_array($ip, $this->ipAddresses)) {
            return true;
        }

        /**
         * This allows you to use wildcards in the allowed IPs
         * For example 127.* or 127.*.*.* will match anything that starts with 127.
         * This is useful if you want to allow all IPs on a local network, or docker network
         */
        $parsedAllowedIp = str_replace('.', '\.', $ip);
        $pattern = '/^' . str_replace('*', '\d{1,3}', $parsedAllowedIp) . '(\.\d{1,3})*$/';

        foreach ($this->ipAddresses as $ip) {
            if (preg_match($pattern, $ip)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Determines if any IP address in the given allowList matches the domain.
     *
     * @param string[] $ipList An array of IP addresses to check against.
     * @return bool Returns true if a match is found, false otherwise.
     */
    public function matchAgainstList(array $ipList): bool
    {
        foreach ($ipList as $ip) {
            if ($this->match($ip)) {
                return true;
            }
        }

        return false;
    }
}
