<?php declare(strict_types=1);

namespace FatCodeTest\Annotation\Fixtures\Annotations;

use FatCode\Annotation\Annotation;
use FatCode\Annotation\Enum;
use FatCode\Annotation\NoValidate;
use FatCode\Annotation\Target;

/**
 * @Annotation()
 * @Target(Target::TARGET_ALL)
 * @NoValidate()
 */
class SimpleAnnotation
{
    /**
     * @Enum('a', 'b', 'c')
     * @var string
     */
    public $attribute = '';

    public function getAttribute() : string
    {
        return $this->attribute;
    }
}
