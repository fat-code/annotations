<?php declare(strict_types=1);

namespace FatCode\Tests;

use FatCode\Annotation\Annotation;
use FatCode\Annotation\AnnotationReader;
use FatCode\Annotation\Enum;
use FatCode\Annotation\Exception\AnnotationException;
use FatCode\Annotation\Required;
use FatCode\Annotation\Target;
use FatCode\Tests\Annotation\Fixtures\Annotations\AnnotatedClass;
use FatCode\Tests\Annotation\Fixtures\Annotations\MetaFunction;
use FatCode\Tests\Annotation\Fixtures\Annotations\MetaProperty;
use PHPUnit\Framework\TestCase;

final class AnnotationReaderTest extends TestCase
{
    public function testReadFromClass() : void
    {
        $reader = new AnnotationReader();
        $annotations = $reader->readClassAnnotations(MetaProperty::class);
        self::assertCount(2, $annotations);
        self::assertInstanceOf(Annotation::class, $annotations[0]);
        self::assertInstanceOf(Target::class, $annotations[1]);
    }

    public function testFailReadFromClass() : void
    {
        $this->expectException(AnnotationException::class);
        $reader = new AnnotationReader();
        $annotations = $reader->readClassAnnotations('NonDefinedClass');
    }

    public function testReadFromMethod() : void
    {
        $reader = new AnnotationReader();
        $annotations = $reader->readMethodAnnotations(AnnotatedClass::class, 'annotatedMethod');

        self::assertCount(1, $annotations);
        self::assertInstanceOf(MetaFunction::class, $annotations[0]);
    }

    public function testFailReadFromMethod() : void
    {
        $this->expectException(AnnotationException::class);
        $reader = new AnnotationReader();
        $annotations = $reader->readMethodAnnotations(AnnotatedClass::class, 'notDefinedMethod');
    }

    public function testReadFromProperty() : void
    {
        $reader = new AnnotationReader();
        $annotations = $reader->readPropertyAnnotations(MetaProperty::class, 'type');

        self::assertCount(2, $annotations);
        self::assertInstanceOf(Required::class, $annotations[0]);
        self::assertInstanceOf(Enum::class, $annotations[1]);
    }

    public function testFailReadFromProperty() : void
    {
        $this->expectException(AnnotationException::class);
        $reader = new AnnotationReader();
        $annotations = $reader->readPropertyAnnotations(AnnotatedClass::class, 'xxx');
    }

    public function testReadFromFunction() : void
    {
        $reader = new AnnotationReader();
        $exists = function_exists('\FatCode\Tests\Fixtures\annotated_function');
        $annotations = $reader->readFunctionAnnotations('\FatCode\Tests\Fixtures\annotated_function');

        self::assertCount(1, $annotations);
        self::assertInstanceOf(MetaFunction::class, $annotations[0]);
    }
}
