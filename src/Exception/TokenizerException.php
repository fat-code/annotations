<?php declare(strict_types=1);

namespace FatCode\Annotation\Exception;

use LogicException;

final class TokenizerException extends LogicException implements AnnotationException
{
    public static function forOutOfBounds(int $index) : TokenizerException
    {
        return new self("Trying to get token at {$index}, when index is out of bounds.");
    }
}
