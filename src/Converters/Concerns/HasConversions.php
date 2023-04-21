<?php

declare(strict_types=1);

namespace Midnite81\Core\Converters\Concerns;

trait HasConversions
{
    public function toMicroseconds(int $roundTo = 0): float|int
    {
        $totalMicroseconds = ($this->microseconds +
            $this->milliseconds * 1000 +
            $this->seconds * 1000000 +
            $this->minutes * 60 * 1000000 +
            $this->hours * 60 * 60 * 1000000 +
            $this->days * 24 * 60 * 60 * 1000000 +
            $this->weeks * 7 * 24 * 60 * 60 * 1000000 +
            $this->months * 30 * 24 * 60 * 60 * 1000000 +
            $this->quarters * 3 * 30 * 24 * 60 * 60 * 1000000 +
            $this->years * 365 * 24 * 60 * 60 * 1000000
        );

        return $this->roundResult($totalMicroseconds, $roundTo);
    }

    public function toMilliseconds(int $roundTo = 0): float|int
    {
        $totalMilliseconds = ($this->microseconds / 1000 +
            $this->milliseconds +
            $this->seconds * 1000 +
            $this->minutes * 60 * 1000 +
            $this->hours * 60 * 60 * 1000 +
            $this->days * 24 * 60 * 60 * 1000 +
            $this->weeks * 7 * 24 * 60 * 60 * 1000 +
            $this->months * 30 * 24 * 60 * 60 * 1000 +
            $this->quarters * 3 * 30 * 24 * 60 * 60 * 1000 +
            $this->years * 365 * 24 * 60 * 60 * 1000
        );

        return $this->roundResult($totalMilliseconds, $roundTo);
    }

    public function toSeconds(int $roundTo = 0): float|int
    {
        $totalSeconds = ($this->microseconds / 1000000 +
            $this->milliseconds / 1000 +
            $this->seconds +
            $this->minutes * 60 +
            $this->hours * 60 * 60 +
            $this->days * 24 * 60 * 60 +
            $this->weeks * 7 * 24 * 60 * 60 +
            $this->months * 30 * 24 * 60 * 60 +
            $this->quarters * 3 * 30 * 24 * 60 * 60 +
            $this->years * 365 * 24 * 60 * 60
        );

        return $this->roundResult($totalSeconds, $roundTo);
    }

    public function toMinutes(int $roundTo = 0): float|int
    {
        $totalMinutes =  ($this->microseconds / (1000000 * 60) +
            $this->milliseconds / (1000 * 60) +
            $this->seconds / 60 +
            $this->minutes +
            $this->hours * 60 +
            $this->days * 24 * 60 +
            $this->weeks * 7 * 24 * 60 +
            $this->months * 30 * 24 * 60 +
            $this->quarters * 3 * 30 * 24 * 60 +
            $this->years * 365 * 24 * 60
        );

        return $this->roundResult($totalMinutes, $roundTo);
    }

    /**
     * Convert to hours
     *
     * @param int $roundTo
     * @return float|int
     */
    public function toHours(int $roundTo = 0): float|int
    {
        $totalHours = ($this->years * 365 * 24) +
            ($this->quarters * 91 * 24) +
            ($this->months * 30 * 24) +
            ($this->weeks * 7 * 24) +
            ($this->days * 24) +
            ($this->hours) +
            ($this->minutes / 60) +
            ($this->seconds / 3600) +
            ($this->milliseconds / 3600000) +
            ($this->microseconds / 3600000000);

        return $this->roundResult($totalHours, $roundTo);
    }

    /**
     * Convert to days
     *
     * @param int $roundTo
     * @return float|int
     */
    public function toDays(int $roundTo = 0): float|int
    {
        $totalDays = ($this->years * 365) +
            ($this->quarters * 91) +
            ($this->months * 30) +
            ($this->weeks * 7) +
            ($this->days) +
            ($this->hours / 24) +
            ($this->minutes / 1440) +
            ($this->seconds / 86400) +
            ($this->milliseconds / 86400000) +
            ($this->microseconds / 86400000000);

        return $this->roundResult($totalDays, $roundTo);
    }

    /**
     * Convert to weeks
     *
     * @param int $roundTo
     * @return float|int
     */
    public function toWeeks(int $roundTo = 0): float|int
    {
        $totalWeeks = ($this->years * 52) +
            ($this->quarters * 13) +
            ($this->months * 4) +
            ($this->weeks) +
            ($this->days / 7) +
            ($this->hours / 168) +
            ($this->minutes / 10080) +
            ($this->seconds / 604800) +
            ($this->milliseconds / 604800000) +
            ($this->microseconds / 604800000000);

        return $this->roundResult($totalWeeks, $roundTo);
    }


    /**
     * Converts the total duration to months
     *
     * @param int $roundTo
     * @return float|int
     */
    public function toMonths(int $roundTo = 0): float|int
    {
        $totalMonths = $this->months +
            ($this->years * 12) +
            ($this->quarters * 3) +
            ($this->weeks * 0.25) +
            ($this->days * (1/30)) +
            ($this->hours * (1/(30*24))) +
            ($this->minutes * (1/(30*24*60))) +
            ($this->seconds * (1/(30*24*60*60))) +
            ($this->milliseconds * (1/(30*24*60*60*1000))) +
            ($this->microseconds * (1/(30*24*60*60*1000000)));

        return $this->roundResult($totalMonths, $roundTo);
    }

    /**
     * Converts the total duration to quarters
     *
     * @param int $roundTo
     * @return float|int
     */
    public function toQuarters(int $roundTo = 0): float|int
    {
        $totalQuarters = $this->quarters +
            ($this->years * 4) +
            ($this->weeks * 0.25 * (1/3)) +
            ($this->days * (1/30) * (1/3)) +
            ($this->hours * (1/(30*24)) * (1/3)) +
            ($this->minutes * (1/(30*24*60)) * (1/3)) +
            ($this->seconds * (1/(30*24*60*60)) * (1/3)) +
            ($this->milliseconds * (1/(30*24*60*60*1000)) * (1/3)) +
            ($this->microseconds * (1/(30*24*60*60*1000000)) * (1/3));

        return $this->roundResult($totalQuarters, $roundTo);
    }

    /**
     * Converts the total duration to years
     *
     * @param int $roundTo
     * @return float|int
     */
    public function toYears(int $roundTo = 0): float|int
    {
        $totalYears = $this->years +
            ($this->quarters * 0.25) +
            ($this->months * (1/12)) +
            ($this->weeks * 0.25 * (1/12)) +
            ($this->days * (1/30) * (1/12)) +
            ($this->hours * (1/(30*24)) * (1/12)) +
            ($this->minutes * (1/(30*24*60)) * (1/12)) +
            ($this->seconds * (1/(30*24*60*60)) * (1/12)) +
            ($this->milliseconds * (1/(30*24*60*60*1000)) * (1/12)) +
            ($this->microseconds * (1/(30*24*60*60*1000000)) * (1/12));

        return $this->roundResult($totalYears, $roundTo);
    }


    public function roundResult(float|int $result, int $roundTo): float|int
    {
        if ($roundTo === 0) {
            return (int) $result;
        }

        return $roundTo ? round($result, $roundTo) : $result;
    }
}
