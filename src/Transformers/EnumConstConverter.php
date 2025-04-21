<?php

namespace Midnite81\Core\Transformers;

use Exception;
use JetBrains\PhpStorm\ArrayShape;
use Midnite81\Core\Exceptions\Transformers\ClassNotFoundException;
use Midnite81\Core\Transformers\Contracts\WriterInterface;
use Midnite81\Core\Transformers\Writer\DefaultWriter;
use ReflectionClass;
use ReflectionClassConstant;

class EnumConstConverter
{
    /**
     * Constructs a new instance of the class.
     *
     * @param string $className The name of the class or interface.
     * @param WriterInterface $writer The writer object used for writing.
     * @return void
     *
     * @throws Exception If the class or interface does not exist.
     */
    public function __construct(
        protected string $className,
        protected WriterInterface $writer = new DefaultWriter
    ) {
        if (!class_exists($className) && !interface_exists($className)) {
            throw new ClassNotFoundException("Class or interface $className does not exist.");
        }
    }

    /**
     * Converts the class or interface details to a string representation.
     *
     * @param string $visibility The visibility of the constants to parse. Default is 'public'.
     * @return string The string representation of the class or interface details.
     *
     * @throws Exception If no valid details are found in the class or interface.
     */
    public function convert(string $visibility = 'public'): string
    {
        $reflectionClass = new ReflectionClass($this->className);

        if ($reflectionClass->isEnum()) {
            $details = $this->parseEnum($reflectionClass);
        } else {
            $details = $this->parseConstants($reflectionClass, $visibility);
        }

        if (!$details) {
            throw new Exception("No valid details found in class or interface {$this->className}.");
        }

        return $this->writer->write($details);
    }

    /**
     * Parses an enumeration class and returns an array representation of the enum.
     *
     * @param ReflectionClass $reflectionClass The reflection class representing the enumeration.
     * @return array The array representation of the enum, with keys 'type', 'name', and 'cases'.
     */
    #[ArrayShape(['type' => 'string', 'name' => 'string', 'cases' => 'string[]'])]
    protected function parseEnum(ReflectionClass $reflectionClass): array
    {
        $enumName = $reflectionClass->getShortName();
        $cases = $reflectionClass->getConstants();

        $caseNames = array_keys($cases);

        return ['type' => 'enum', 'name' => $enumName, 'cases' => $caseNames];
    }

    /**
     * Parses the constants of a given ReflectionClass object based on the specified visibility.
     *
     * This method filters the constants of the given ReflectionClass object based on the specified visibility.
     * It returns an array of constants, where each constant is represented by its name and value.
     *
     * @param ReflectionClass $reflectionClass The ReflectionClass object to parse constants from.
     * @param string $visibility The visibility of the constants to include. Possible values are 'protected', 'private', and 'public'.
     * @return array|null An array representing the parsed constants. Each constant is represented by its name and value. If no constants are found, it returns null.
     */
    #[ArrayShape(['type' => 'string', 'name' => 'string', 'cases' => 'string[]'])]
    protected function parseConstants(ReflectionClass $reflectionClass, string $visibility): ?array
    {
        $visibilityFilter = match ($visibility) {
            'protected' => ReflectionClassConstant::IS_PUBLIC | ReflectionClassConstant::IS_PROTECTED,
            'private' => ReflectionClassConstant::IS_PUBLIC | ReflectionClassConstant::IS_PROTECTED | ReflectionClassConstant::IS_PRIVATE,
            default => ReflectionClassConstant::IS_PUBLIC,
        };

        $constants = array_filter(
            $reflectionClass->getReflectionConstants(),
            fn ($constant) => $constant->getModifiers() & $visibilityFilter
        );

        $filteredConstants = [];
        foreach ($constants as $constant) {
            $value = $constant->getValue();

            if (is_array($value)) {
                $value = $this->transformArrayReferences($value, $reflectionClass);
            }

            $filteredConstants[$constant->getName()] = $value;
        }

        $className = $reflectionClass->getShortName();

        if (empty($filteredConstants)) {
            return null;
        }

        return ['type' => 'const', 'name' => $className, 'constants' => $filteredConstants];
    }

    /**
     * Transforms array values that are references to class constants into a specific format.
     *
     * This method takes an array and a ReflectionClass object as input. It iterates over each value in the array.
     * If a value in the array matches a class constant value, it transforms the value into a specific format,
     * representing the reference to the class constant. Otherwise, it keeps the value unchanged.
     * The transformed values are returned as a new array.
     *
     * @param array $array The array to transform.
     * @param ReflectionClass $reflectionClass The ReflectionClass object to retrieve class constants from.
     * @return array The transformed array where values that are references to class constants are represented
     *               as an array with keys 'type' and 'value'. Other values are unchanged.
     */
    protected function transformArrayReferences(array $array, ReflectionClass $reflectionClass): array
    {
        $className = $reflectionClass->getShortName();
        $classConstants = $reflectionClass->getConstants();

        return array_map(function ($item) use ($className, $classConstants) {
            foreach ($classConstants as $constName => $constValue) {
                if ($item === $constValue) {
                    return ['type' => 'reference', 'value' => "$className.$constName"];
                }
            }

            return $item;
        }, $array);
    }
}
