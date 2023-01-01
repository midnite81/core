<?php

declare(strict_types=1);

namespace Midnite81\Core\Transformers;

use Midnite81\Core\Exceptions\Transformers\NumberCannotBeNullException;

class HumanReadableNumber
{
    public function __construct(public int|float|null $number = null)
    {
    }

    /**
     * Factory create of the Number Transformer
     *
     * @param int|float $number
     * @return static
     */
    public static function make(int|float $number): self
    {
        return new self($number);
    }

    /**
     * Method to set the number outside the constructor
     *
     * @param int|float $number
     * @return $this
     */
    public function of(int|float $number): static
    {
        $this->number = $number;
        return $this;
    }

    /**
     * Gets the human readable version of the number passed to this class
     * Note: returned as string
     *
     * @param int|null $numberOfDecimals
     * @return string
     * @throws NumberCannotBeNullException
     */
    public function humanReadable(?int $numberOfDecimals = null): string
    {
        $this->checkReady();

        foreach ($this->getExponentAbbreviations() as $exponent => $abbreviation) {
            if ($this->number >= pow(10, $exponent)) {
                $displayNumber = $this->number / pow(10, $exponent);
                $decimals = $numberOfDecimals ?? $this->getNumberOfDecimals($exponent, $displayNumber);
                return number_format($displayNumber, $decimals) . $abbreviation;
            }
        }

        return (string)$this->number ?? '';
    }

    /**
     * Attempts to get the human readable version of the number passed to this class
     * however if an error is thrown, it will return the number passed to this class
     *
     * Note: This method will return a string
     *
     * @param int|null $numberOfDecimals
     * @return string
     */
    public function tryHumanReadable(?int $numberOfDecimals = null): string
    {
        try {
            return $this->humanReadable($numberOfDecimals);
        } catch (NumberCannotBeNullException) {
            return (string)$this->number ?? '';
        }
    }

    /**
     * Returns an array of <exponent, abbreviation> pairs for SI prefixes.
     *
     * @return array
     */
    protected function getExponentAbbreviations(): array
    {
        return [
            30 => 'Q',
            27 => 'R',
            24 => 'Y',
            21 => 'Z',
            18 => 'E',
            15 => 'P',
            12 => 'T',
            9 => 'B',
            6 => 'M',
            3 => 'K',
            0 => '',
            -3 => 'm',
            -6 => 'μ',
            -9 => 'n',
            -12 => 'p',
            -15 => 'f',
            -18 => 'a',
            -21 => 'z',
            -24 => 'y',
            -27 => 'x',
            -30 => 'w',
            -33 => 'v',
            -36 => 'u',
        ];
    }

    /**
     * Checks to ensure the number is set
     *
     * @return void
     * @throws NumberCannotBeNullException
     */
    protected function checkReady(): void
    {
        if (is_null($this->number)) {
            throw new NumberCannotBeNullException();
        }
    }

    /**
     * Calculates the number of decimals to use
     *
     * This check is used to determine whether or not to show decimal places in the abbreviated value. If the original
     * value is between 1000 and 999999 for the K, M, and B units, or between 1000000 and 999999999 for the T unit,
     * then the abbreviated value is shown with one decimal place. Otherwise, it is shown without decimal places.
     *
     * This is done to make the abbreviated value more readable. For example, if the original value is 1234.5678,
     * the abbreviated value with one decimal place would be 1.2K, which is easier to read than 1.23K. On the other
     * hand, if the original value is 999.999, the abbreviated value without decimal places would be 1000, which
     * is easier to read than 999.999K.
     *
     * @param int|string $exponent
     * @param float|int $displayNumber
     * @return int
     */
    protected function getNumberOfDecimals(int|string $exponent, float|int $displayNumber): int
    {
        return ($exponent >= 3 && round(abs($displayNumber)) < 1000 && !$this->isWholeNumber($displayNumber)) ? 1 : 0;
    }

    /**
     * This determines if a number is a whole number
     *
     * @param float|int $value
     * @return bool
     */
    protected function isWholeNumber(float|int $value): bool
    {
        if (is_int($value)) {
            return true;
        }

        return is_float($value) && $value == floor($value);
    }
}
