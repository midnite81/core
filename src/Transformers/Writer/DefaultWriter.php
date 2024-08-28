<?php

declare(strict_types=1);

namespace Midnite81\Core\Transformers\Writer;

use Midnite81\Core\Transformers\Contracts\WriterInterface;

class DefaultWriter implements WriterInterface
{
    /**
     * {@inheritDoc}
     */
    public function write(array $details): string
    {
        $name = $details['name'];

        $jsCode = "const $name = {\n";
        if ($details['type'] === 'enum') {
            foreach ($details['cases'] as $case) {
                $jsCode .= "    $case: \"$case\",\n";
            }
        } else {
            foreach ($details['constants'] as $constName => $value) {
                $jsCode .= "    $constName: " . $this->formatValue($value) . ",\n";
            }
        }

        $jsCode .= "};\n\nObject.freeze($name);\n";

        return $jsCode;
    }

    protected function formatValue($value): string
    {
        if (is_string($value)) {
            return json_encode($value);
        } elseif (is_array($value)) {
            if (isset($value['type']) && $value['type'] === 'reference') {
                return $value['value'];
            }

            return '[' . implode(', ', array_map([$this, 'formatValue'], $value)) . ']';
        } elseif (is_bool($value)) {
            return $value ? 'true' : 'false';
        } elseif (is_null($value)) {
            return 'null';
        } else {
            return (string) $value;
        }
    }
}
