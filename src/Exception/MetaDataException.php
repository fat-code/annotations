<?php declare(strict_types=1);

namespace FatCode\Annotation\Exception;

use FatCode\Annotation\Context;
use FatCode\Annotation\MetaData\MetaData;
use RuntimeException;

final class MetaDataException extends RuntimeException implements AnnotationException
{
    public static function forInvalidTarget(string $target, Context $context) : self
    {
        return new self("Invalid target {$target} passed in {$context}");
    }

    public static function forUndefinedAttribute(MetaData $metaData, string $attribute) : self
    {
        return new self("Annotation class {$metaData->getClass()} defines no attribute {$attribute}.");
    }

    public static function forNoFailedAttributes() : self
    {
        return new self("Could not retrieve last failed attribute, did you forget to run validateAttributes?");
    }
}
