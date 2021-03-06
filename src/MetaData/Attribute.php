<?php declare(strict_types=1);

namespace FatCode\Annotation\MetaData;

final class Attribute
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var bool
     */
    private $required;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string[]
     */
    private $enum;

    /**
     * @var bool
     */
    private $validate = true;

    public function __construct(string $name, $type = 'mixed', bool $required = false)
    {
        $this->name = $name;
        $this->type = $type;
        $this->required = $required;
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function getType() : string
    {
        if (is_array($this->type)) {
            return end($this->type) . '[]';
        }

        return $this->type;
    }

    public function disableValidation() : void
    {
        $this->validate = false;
    }

    public function isRequired() : bool
    {
        return $this->required;
    }

    public function isEnum() : bool
    {
        return $this->enum !== null;
    }

    public function setEnumeration(array $values) : void
    {
        $this->enum = $values;
    }

    public function validate($value) : bool
    {
        if (!$this->validate) {
            return true;
        }

        if (!$this->required && $value === null) {
            return true;
        }

        if ($value === null) {
            return false;
        }

        if ($this->isEnum()) {
            return $this->validateEnum($value);
        }

        if (!$this->validateType($this->type, $value)) {
            return false;
        }

        return true;
    }

    private function validateEnum($value) : bool
    {
        if (is_array($this->type)) {
            foreach ($value as $item) {
                if (!in_array($item, $this->enum, true)) {
                    return false;
                }
            }
            return true;
        }
        return in_array($value, $this->enum, true);
    }

    private function validateType($type, $value) : bool
    {
        switch (true) {
            case $type === 'mixed' || $type === ['mixed']:
                return true;
            case $type === 'string':
                return is_string($value);
            case $type === 'boolean':
            case $type === 'bool':
                return is_bool($value);
            case $type === 'int':
            case $type === 'integer':
                return is_int($value);
            case $type === 'double':
            case $type === 'float':
                return is_float($value);
            case $type === 'object':
                return is_object($value);
            case is_array($type):
                if (!is_array($value)) {
                    return false;
                }
                foreach ($value as $item) {
                    if (!$this->validateType(end($type), $item)) {
                        return false;
                    }
                }
                return true;
            case is_string($type) && class_exists($type):
                return $value instanceof $type;

            // Ignore unknown type annotation
            default:
                return false;
        }
    }
}
