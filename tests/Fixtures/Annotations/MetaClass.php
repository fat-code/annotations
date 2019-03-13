<?php declare(strict_types=1);

namespace FatCodeTest\Annotation\Fixtures\Annotations;

use FatCode\Annotation\Annotation;
use FatCode\Annotation\NoValidate;
use FatCode\Annotation\Required;
use FatCode\Annotation\Target;

/**
 * @Annotation()
 * @Target(Target::TARGET_CLASS)
 * @NoValidate()
 */
class MetaClass
{
    /**
     * @Required
     * @var MetaProperty[]
     */
    public $properties = [];

    /**
     * @var string
     */
    public $name = 'DefaultName';
}
