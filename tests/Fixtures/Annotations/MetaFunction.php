<?php declare(strict_types=1);

namespace FatCode\Tests\Annotation\Fixtures\Annotations;

use FatCode\Annotation\Annotation;
use FatCode\Annotation\Required;
use FatCode\Annotation\Target;

/**
 * @Annotation()
 * @Target(Target::TARGET_FUNCTION, Target::TARGET_METHOD)
 */
class MetaFunction
{
    /**
     * @Required
     * @var string
     */
    public $name = 'DefaultName';
}
