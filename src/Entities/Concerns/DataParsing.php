<?php

declare(strict_types=1);

namespace Midnite81\Core\Entities\Concerns;

use Midnite81\Core\Enums\ExpectedType;

trait DataParsing
{
    /**
     * Parses data and returns the expected type.
     *
     * @param object|array|string $data The data to be parsed.
     * @param ExpectedType $expectedResponse The expected type of the response (default is ExpectedType::Object).
     * @return object|array|string The parsed data with the expected type.
     */
    protected function parseData(
        object|array|string $data,
        ExpectedType $expectedResponse = ExpectedType::Object
    ): object|array|string {
        if ((is_string($data) && $expectedResponse === ExpectedType::String) ||
            (is_array($data) && $expectedResponse === ExpectedType::Array) ||
            (is_object($data) && $expectedResponse === ExpectedType::Object)
        ) {
            return $data;
        }

        if (is_string($data) && in_array($expectedResponse, [ExpectedType::Object, ExpectedType::Array])) {
            $assocArray = $expectedResponse === ExpectedType::Array;

            return json_decode($data, $assocArray);
        }

        if (is_array($data) && $expectedResponse === ExpectedType::Object) {
            return json_decode(json_encode($data));
        }

        if (is_object($data) && $expectedResponse === ExpectedType::Array) {
            return (array) $data;
        }

        return $data;
    }
}
