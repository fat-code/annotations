<?php declare(strict_types=1);

namespace Igni\OpenApi\Exception;

use Igni\Annotation\Context;
use LogicException;
use Throwable;

final class TokenizerException extends LogicException
{
    public static function forOutOfBounds(int $index) : Throwable
    {
        return new class("{$index} is out of bounds") extends TokenizerException implements OutOfBoundsException {
        };
    }

    public static function forUnexpectedRewindCall() : Throwable
    {
        return new class("Cannot rewind tokenizer in current state.") extends TokenizerException implements RuntimeException {
        };
    }
}
