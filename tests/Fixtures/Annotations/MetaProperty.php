<?php declare(strict_types=1);

namespace FatCode\Tests\Annotation\Fixtures\Annotations;

use FatCode\Annotation\Annotation;
use FatCode\Annotation\Enum;
use FatCode\Annotation\NoValidate;
use FatCode\Annotation\Required;
use FatCode\Annotation\Target;

/**
 * @Annotation()
 * @Target(Target::TARGET_ANNOTATION, Target::TARGET_PROPERTY)
 */
class MetaProperty
{
    /**
     * @Required()
     * @var string
     */
    public $name;

    /**
     * @Enum("int", 'string', "float", "boolean")
     * @var string
     */
    public $type = 'string';

    /**
     * @NoValidate
     * @var MetaClass[]
     */
    public $default = [];
}
