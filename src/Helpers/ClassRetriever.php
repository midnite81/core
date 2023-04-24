<?php

declare(strict_types=1);

namespace Midnite81\Core\Helpers;

use Midnite81\Core\Helpers\Response\ClassRetrieverResponse;
use ReflectionClass;
use ReflectionException;
use SplFileInfo;

class ClassRetriever
{
    /**
     * @param string $filename
     */
    public function __construct(protected string $filename)
    {
    }

    /**
     * Construct class from filename and return a ClassRetrieverResponse
     *
     * @param string $filename
     * @return ClassRetrieverResponse
     * @throws ReflectionException
     */
    public static function make(string $filename): ClassRetrieverResponse
    {
        return (new static($filename))->parseFile();
    }

    /**
     * Construct class from SplFileInfo and return a ClassRetrieverResponse
     *
     * @param SplFileInfo $splFileInfo
     * @return ClassRetrieverResponse
     * @throws ReflectionException
     */
    public static function fromSplFileInfo(SplFileInfo $splFileInfo): ClassRetrieverResponse
    {
        $fileName = $splFileInfo->getRealPath();

        return (new static($fileName))->parseFile();
    }

    /**
     * Parses the file passed to the class
     *
     * @return ClassRetrieverResponse
     * @throws ReflectionException
     */
    protected function parseFile(): ClassRetrieverResponse
    {
        $name = '';
        $type = '';
        $extends = '';
        $implements = [];
        $usedTraits = [];
        $fullyQualifiedName = '';

        $tokens = token_get_all(file_get_contents($this->filename));
        $count = count($tokens);
        for ($i = 0; $i < $count; $i++) {
            if ($tokens[$i][0] === T_CLASS) {
                $type = 'class';
                $i += 2;
                $name = $tokens[$i][1];
                break;
            } elseif ($tokens[$i][0] === T_INTERFACE) {
                $type = 'interface';
                $i += 2;
                $name = $tokens[$i][1];
                break;
            } elseif ($tokens[$i][0] === T_TRAIT) {
                $type = 'trait';
                $i += 2;
                $name = $tokens[$i][1];
                break;
            }
        }

        if (!empty($name)) {
            $namespace = '';
            $tokens = token_get_all(file_get_contents($this->filename));
            $count = count($tokens);
            for ($i = 0; $i < $count; $i++) {
                if ($tokens[$i][0] === T_NAMESPACE) {
                    $i += 2;
                    $namespace = $tokens[$i][1];
                    break;
                }
            }

            if (!empty($namespace)) {
                $fullyQualifiedName = $namespace . '\\' . $name;
            } else {
                $fullyQualifiedName = $name;
            }

            if ($type === 'class' || $type === 'trait') {
                $reflectionClass = new ReflectionClass($fullyQualifiedName);

                if ($reflectionClass->getParentClass()) {
                    $extends = $reflectionClass->getParentClass()->getName();
                }

                $implements = $reflectionClass->getInterfaceNames();

                $usedTraits = $reflectionClass->getTraitNames();
            }
        }

        $response = new ClassRetrieverResponse();
        $response->name = $fullyQualifiedName;
        $response->type = $type;
        $response->extends = $extends;
        $response->implements = $implements;
        $response->traits = $usedTraits;

        return $response;
    }
}
