<?php

declare(strict_types=1);

namespace Midnite81\Core\Transformers\Contracts;

/**
 * The WriterInterface is an interface that defines a contract for classes that format output in a custom way.
 * Any class that wants to act as a writer and format output should implement this interface.
 */
interface WriterInterface
{
    /**
     * This method is used to generate JavaScript code for defining a constant object.
     *
     * @param array $details The details of the constant object to be generated.
     *                       - $details['name']: The name of the constant object.
     *                       - $details['type']: The type of the constant object. Possible values are 'enum' or 'object'.
     *                       - $details['cases']: An array of case names if the type is 'enum'.
     *                       - $details['constants']: An array of constant names and their corresponding values if the type is 'object'.
     * @return string The JavaScript code for defining the constant object.
     */
    public function write(array $details): string;
}
