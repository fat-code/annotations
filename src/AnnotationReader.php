<?php declare(strict_types=1);

namespace FatCode\Annotation;

use FatCode\Annotation\Exception\AnnotationReaderException;
use ReflectionClass;
use ReflectionFunction;

/**
 * Reads annotation from given context.
 */
class AnnotationReader
{
    /**
     * @var Parser
     */
    private $parser;

    public function __construct(Parser $parser = null)
    {
        $this->parser = $parser ?? new Parser();
    }

    public function readClassAnnotations(string $className) : array
    {
        if (!class_exists($className)) {
            throw AnnotationReaderException::forUndefinedClass($className);
        }
        $reflectionClass = new ReflectionClass($className);
        $docBlock = $reflectionClass->getDocComment();
        if (!is_string($docBlock)) {
            return [];
        }

        return $this->parser->parse($docBlock, Context::fromReflectionClass($reflectionClass));
    }

    public function readMethodAnnotations(string $className, string $methodName) : array
    {
        if (!class_exists($className)) {
            throw AnnotationReaderException::forUndefinedClass($className);
        }
        $reflectionClass = new ReflectionClass($className);
        if (!$reflectionClass->hasMethod($methodName)) {
            throw AnnotationReaderException::forUndefinedMethod($reflectionClass->name, $methodName);
        }
        $reflectionMethod = $reflectionClass->getMethod($methodName);
        $docBlock = $reflectionMethod->getDocComment();
        if (!is_string($docBlock)) {
            return [];
        }

        return $this->parser->parse(
            $docBlock,
            Context::fromReflectionMethod($reflectionMethod)
        );
    }

    public function readPropertyAnnotations(string $className, string $propertyName) : array
    {
        if (!class_exists($className)) {
            throw AnnotationReaderException::forUndefinedClass($className);
        }
        $reflectionClass = new ReflectionClass($className);
        if (!$reflectionClass->hasProperty($propertyName)) {
            throw AnnotationReaderException::forUndefinedProperty($reflectionClass->name, $propertyName);
        }
        $reflectionProperty = $reflectionClass->getProperty($propertyName);
        $docBlock = $reflectionProperty->getDocComment();
        if (!is_string($docBlock)) {
            return [];
        }

        return $this->parser->parse(
            $docBlock,
            Context::fromReflectionProperty($reflectionProperty)
        );
    }

    public function readFunctionAnnotations(string $functionName) : array
    {
        if (!function_exists($functionName)) {
            throw AnnotationReaderException::forUndefinedFunction($functionName);
        }
        $reflectionFunction = new ReflectionFunction($functionName);
        $docBlock = $reflectionFunction->getDocComment();
        if (!is_string($docBlock)) {
            return [];
        }
        
        return $this->parser->parse(
            $docBlock,
            Context::fromReflectionFunction($reflectionFunction)
        );
    }
}
