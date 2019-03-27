# FatCode Annotations [![Build Status](https://travis-ci.org/fatcode/annotations.svg?branch=master)](https://travis-ci.org/fatcode/annotations) [![Maintainability](https://api.codeclimate.com/v1/badges/6a28f90961197d43702e/maintainability)](https://codeclimate.com/github/fatcode/annotations/maintainability) [![Test Coverage](https://api.codeclimate.com/v1/badges/6a28f90961197d43702e/test_coverage)](https://codeclimate.com/github/fatcode/annotations/test_coverage)

## Introduction
Annotations is an attempt to provide meta data programing for php by extending docblock comments.
Syntax is compatible with latest [annotations rfc](https://wiki.php.net/rfc/annotations_v2).

### Installation
`composer install fatcode/annotations`

### Differences from RFC
The following annotations are not supported for various reasons:
 - `@Compiled` - as there is no compiling
 - `@SupressWarning` - There is no simple way to implement it in user-land
 - `@Repeatable` - all annotations are repeatable by default
 - `@Inherited` - same as `@SupressWarning`, there is no simple way to track php's inheritance tree in user-land

### Built-in annotations
- `@Annotation()` - makes class available as annotation
- `@Required()` - ensures that attribute is passed when annotation is used 
- `@NoValidate()` - turns off attribute validation
- `@Enum(mixed ...$value)` - defines valid values for annotated property
- `@Target(string ...$target)` - declares valid targets for annotation


## Defining an annotation

```php
<?php declare(strict_types=1);

use FatCode\Annotation\Target;
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
```

The above example defines annotation that is only valid for php classes (`@Target(Target::TARGET_CLASS)`).
Annotation will accept attribute `name` which is required (`@Required`) and must be of type `string`

## Using annotations

```php
<?php declare(strict_types=1);

/**
 * @MyAnnotation(name="Hello World")
 */
class AnnotatedClass
{
}
```

 The above example makes usage of newly declared `MyAnnotation` annotation.

## Retrieving annotations

### Retrieving class annotations
```php
<?php declare(strict_types=1);
use FatCode\Annotation\AnnotationReader;

$reader = new AnnotationReader();
$annotations = $reader->readClassAnnotations(AnnotatedClass::class);
var_dump($annotations);
/* will output:
array(1) {
     [0] =>
     class MyAnnotation#19 (1) {
       public $name =>
       string(11) "Hello World"
     }
   }
*/
```
Example code can be found [here](examples/get_class_annotations.php)
