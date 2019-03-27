<?php declare(strict_types=1);

namespace FatCode\Annotation;

use Reflector;
use ReflectionClass;
use ReflectionProperty;
use ReflectionFunction;
use ReflectionMethod;

class ReflectorImports
{
    /**
     * @var string[]
     */
    private static $fileImports = [];

    /**
     * @var string
     */
    private $filename;

    /**
     * @var int
     */
    private $startLine;

    /**
     * @var string
     */
    private $namespace;

    /**
     * @param ReflectionMethod|ReflectionClass|ReflectionProperty|ReflectionFunction|Reflector $reflector
     */
    public function __construct(Reflector $reflector)
    {
        if ($reflector instanceof ReflectionProperty) {
            $reflector = $reflector->getDeclaringClass();
        } elseif ($reflector instanceof ReflectionMethod) {
            $reflector = $reflector->getDeclaringClass();
        }

        $this->filename = $reflector->getFileName();
        $this->startLine = $reflector->getStartLine();
        $this->namespace = $reflector->getNamespaceName();
    }

    /**
     * @return string[]
     */
    public function getImports() : array
    {
        if (isset(self::$fileImports[$this->filename])) {
            return self::$fileImports[$this->filename];
        }

        if (empty($this->filename) || !is_file($this->filename) || !is_readable($this->filename)) {
            return self::$fileImports[$this->filename] = [];
        }

        return self::$fileImports[$this->filename] = $this->parseImports();
    }

    /**
     * @return string[]
     */
    private function parseImports() : array
    {
        $fileHandler = fopen($this->filename, 'r');
        if (!$fileHandler) {
            return [];
        }
        $contents = '';
        for ($i = 0; $i < $this->startLine; $i++) {
            $line = fgets($fileHandler, 4096);
            if (false === $line) {
                break;
            }
            $contents .= $line;
        }
        fclose($fileHandler);
        $identifier = '[a-z_\x7f-\xff][a-z0-9_\x7f-\xff\\\]*';
        $regex = "/use\s+({$identifier})(?:\s+as\s+({$identifier})\s*)?\s*;/i";
        preg_match_all($regex, $contents, $matches);
        $imports = [];
        for ($i = 0, $total = count($matches[0]); $i < $total; $i++) {
            $alias = $matches[2][$i];
            $namespace = $matches[1][$i];

            if (empty($alias)) {
                $parts = explode('\\', $namespace);
                $alias = end($parts);
            }

            $imports[$alias] = $namespace;
        }

        return $imports;
    }
}
