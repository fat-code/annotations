<?php declare(strict_types=1);

namespace FatCode\Tests\Annotation;

use FatCode\Annotation\Annotation;
use FatCode\Annotation\Context;
use FatCode\Annotation\NoValidate;
use FatCode\Annotation\Parser;
use FatCode\Annotation\Target;
use FatCode\Tests\Annotation\Fixtures\Annotations\AnnotatedClass;
use FatCode\Tests\Annotation\Fixtures\Annotations\MetaClass;
use FatCode\Tests\Annotation\Fixtures\Annotations\MetaProperty;
use FatCode\Tests\Annotation\Fixtures\Annotations\SimpleAnnotation;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

final class ParserTest extends TestCase
{
    public function testParseBuiltInAnnotations() : void
    {
        $reflection = new ReflectionClass(SimpleAnnotation::class);
        $parser = new Parser();
        $annotations = $parser->parse($reflection->getDocComment(), Context::fromReflectionClass($reflection));
        self::assertCount(3, $annotations);
        self::assertInstanceOf(Annotation::class, $annotations[0]);
        self::assertInstanceOf(Target::class, $annotations[1]);
        self::assertInstanceOf(NoValidate::class, $annotations[2]);
        self::assertSame([Target::TARGET_ALL], $annotations[1]->value);
    }

    public function testParseCustomAnnotation() : void
    {
        $reflection = new ReflectionClass(AnnotatedClass::class);
        $parser = new Parser();
        $annotations = $parser->parse($reflection->getDocComment(), Context::fromReflectionClass($reflection));

        self::assertCount(1, $annotations);
        $annotation = $annotations[0];
        self::assertInstanceOf(MetaClass::class, $annotation);
        self::assertCount(2, $annotation->properties);
        self::assertInstanceOf(MetaProperty::class, $annotation->properties[0]);
        self::assertSame('testInt', $annotation->properties[0]->name);
        self::assertSame('int', $annotation->properties[0]->type);
        self::assertSame([], $annotation->properties[0]->default);
        self::assertInstanceOf(MetaProperty::class, $annotation->properties[1]);
    }
}
