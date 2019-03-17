<?php declare(strict_types=1);

require_once '../vendor/autoload.php';

use FatCode\Annotation\Required;
use FatCode\Annotation\Annotation;
use FatCode\Annotation\Target;
use FatCode\Annotation\AnnotationReader;

/**
 * @Annotation
 * @Target(Target::TARGET_CLASS)
 */
class MyAnnotation
{
    /**
     * @Required
     * @var string
     */
    public $name;
}

/**
 * @MyAnnotation(name="Hello World")
 */
class AnnotatedClass
{
}

$reader = new AnnotationReader();
$annotations = $reader->readClassAnnotations(AnnotatedClass::class);

var_dump($annotations);
