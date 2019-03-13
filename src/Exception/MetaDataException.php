<?php declare(strict_types=1);

namespace FatCode\Annotation\Exception;

use FatCode\Annotation\Context;
use FatCode\Annotation\MetaData\MetaData;
use FatCode\Exception\LogicException;

final class MetaDataException extends LogicException implements AnnotationException
{
    public static function forInvalidTarget($target, Context $context) : self
    {
        return new self("Invalid target {$target} passed in {$context}");
    }

    public static function forUndefinedAttribute(MetaData $metaData, string $attribute) : self
    {
        return new self("Annotation class {$metaData->getClass()} defines no attribute {$attribute}.");
    }
}
