<?php declare(strict_types=1);

namespace FatCode\Tests\Annotation;

use FatCode\Annotation\ReflectorImports;
use FatCode\Tests\Annotation\Fixtures\Annotations\MetaClass;
use FatCode\Tests\Annotation\Fixtures\Annotations\SimpleAnnotation;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionProperty;
use ReflectionMethod;

final class ReflectorImportsTest extends TestCase
{
    public function testReflectionClassImports() : void
    {
       $imports = new ReflectorImports(new ReflectionClass(MetaClass::class));
       self::assertSame(
           [
               'Annotation' => 'FatCode\Annotation\Annotation',
               'NoValidate' => 'FatCode\Annotation\NoValidate',
               'Required' => 'FatCode\Annotation\Required',
               'Target' => 'FatCode\Annotation\Target',
           ],
           $imports->getImports()
       );
    }

    public function testReflectionPropertyImports() : void
    {
        $imports = new ReflectorImports(new ReflectionProperty(MetaClass::class, 'properties'));
        self::assertSame(
            [
                'Annotation' => 'FatCode\Annotation\Annotation',
                'NoValidate' => 'FatCode\Annotation\NoValidate',
                'Required' => 'FatCode\Annotation\Required',
                'Target' => 'FatCode\Annotation\Target',
            ],
            $imports->getImports()
        );
    }

    public function testReflectionMethodImports() : void
    {
        $imports = new ReflectorImports(new ReflectionMethod(SimpleAnnotation::class, 'getAttribute'));
        self::assertSame(
            [
                'Annotation' => 'FatCode\Annotation\Annotation',
                'Enum' => 'FatCode\Annotation\Enum',
                'NoValidate' => 'FatCode\Annotation\NoValidate',
                'Target' => 'FatCode\Annotation\Target',
            ],
            $imports->getImports()
        );
    }
}
