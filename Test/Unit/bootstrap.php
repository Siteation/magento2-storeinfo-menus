<?php

declare(strict_types=1);

require __DIR__ . '/../../vendor/autoload.php';

/*
 * Magento generates *Factory classes at compile time, so a standalone checkout has none.
 * Define a plain stand-in for any factory whose product class exists, enough for PHPUnit to mock it.
 */
spl_autoload_register(static function (string $class): void {
    if (!str_ends_with($class, 'Factory')) {
        return;
    }
    $product = substr($class, 0, -strlen('Factory'));
    if (!class_exists($product) && !interface_exists($product)) {
        return;
    }
    $pos = strrpos($class, '\\');
    $namespace = $pos === false ? '' : substr($class, 0, $pos);
    $shortName = $pos === false ? $class : substr($class, $pos + 1);

    eval(sprintf(
        'namespace %s; class %s { public function create(array $data = []) { throw new \LogicException("Stub factory, mock it."); } }',
        $namespace,
        $shortName
    ));
});
