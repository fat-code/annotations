<?php declare(strict_types=1);

namespace FatCode\Annotation\Exception;

use RuntimeException;

final class AnnotationReaderException extends RuntimeException implements AnnotationException
{
    public static function forUndefinedClass(string $className) : self
    {
        return new self("Class {$className} does not exists or could not be loaded, please check your composer.json.");
    }

    public static function forUndefinedMethod(string $className, string $methodName) : self
    {
        return new self("Class {$className} does not define `{$methodName}` method.");
    }

    public static function forUndefinedProperty(string $className, string $propertyName) : self
    {
        return new self("Class {$className} does not define `{$propertyName}`` property.");
    }

    public static function forUndefinedFunction(string $functionName) : self
    {
        return new self("Function {$functionName} could not be found, please check your composer.json.");
    }
}
