<?php

declare(strict_types=1);

namespace Midnite81\Core\Helpers;

use Exception;
use PhpToken;
use SplFileInfo;

class ClassRetriever
{
    /**
     * @throws Exception
     */
    public function __construct(protected string $filename)
    {
    }

    /**
     * @param string $filename
     * @return array
     *
     * @throws Exception
     */
    public static function make(string $filename): array
    {
        return (new static($filename))->parseFile();
    }

    /**
     * @param SplFileInfo $splFileInfo
     * @return array
     *
     * @throws Exception
     */
    public static function fromSplFileInfo(SplFileInfo $splFileInfo): array
    {
        $fileName = $splFileInfo->getRealPath();

        return (new static($fileName))->parseFile();
    }

    /**
     * @return array
     *
     * @throws Exception
     */
    protected function parseFile(): array
    {
        $getNext = null;
        $getNextNamespace = false;
        $skipNext = false;
        $isAbstract = false;
        $response = ['namespace' => null, 'class' => [], 'trait' => [], 'interface' => [], 'abstract' => []];

        foreach (PhpToken::tokenize(file_get_contents($this->filename)) as $token) {
            if (!$token->isIgnorable()) {
                $name = $token->getTokenName();
                switch ($name) {
                    case 'T_NAMESPACE':
                        $getNextNamespace = true;
                        break;
                    case 'T_EXTENDS':
                    case 'T_USE':
                    case 'T_IMPLEMENTS':
                        $skipNext = true;
                        break;
                    case 'T_ABSTRACT':
                        $isAbstract = true;
                        break;
                    case 'T_CLASS':
                    case 'T_TRAIT':
                    case 'T_INTERFACE':
                        if ($skipNext) {
                            $skipNext = false;
                        } else {
                            $getNext = strtolower(substr($name, 2));
                        }
                        break;
                    case 'T_NAME_QUALIFIED':
                    case 'T_STRING':
                        if ($getNextNamespace) {
                            if (array_filter($response)) {
                                throw new Exception(
                                    sprintf('Namespace must be defined first in %s', $this->filename)
                                );
                            } else {
                                $response['namespace'] = $token->text;
                            }
                            $getNextNamespace = false;
                        } elseif ($skipNext) {
                            $skipNext = false;
                        } elseif ($getNext) {
                            if (in_array($token->text, $response[$getNext])) {
                                throw new Exception(
                                    sprintf('%s %s has already been found in %s',
                                        $response[$getNext], $token->text,
                                        $this->filename
                                    )
                                );
                            }
                            if ($isAbstract) {
                                $isAbstract = false;
                                $getNext = 'abstract';
                            }
                            $response[$getNext][] = $token->text;
                            $getNext = null;
                        }
                        break;
                    default:
                        $getNext = null;
                }
            }
        }
        $namespace = $response['namespace'] ?? '';
        $firstClass = $response['class'][0] ?? '';
        $firstInterface = $response['interface'][0] ?? '';
        $response['namespace_and_class'] = $namespace . '\\' . $firstClass;
        $response['namespace_and_interface'] = $namespace . '\\' . $firstInterface;
        $response['filename'] = $this->filename;

        return $response;
    }
}
