<?php

if (!$loader = include __DIR__.'/../vendor/.composer/autoload.php') {
    $nl = PHP_SAPI === 'cli' ? PHP_EOL : '<br />';
    echo "$nl$nl";
    if (is_writable(dirname(__DIR__))) {
        file_put_contents(dirname(__DIR__).'/composer.phar', file_get_contents('http://getcomposer.org/composer.phar'));
        die("You must set up the project dependencies.$nl".
            "Composer has been downloaded.$nl".
            "Run the following command in ".dirname(__DIR__).":$nl$nl".
            "php composer.phar install$nl");
    }
    die("You must set up the project dependencies.$nl".
        "Run the following commands in ".dirname(__DIR__).":$nl$nl".
        "wget http://getcomposer.org/composer.phar$nl".
        "php composer.phar install$nl");
}

use Doctrine\Common\Annotations\AnnotationRegistry;

// intl
if (!function_exists('intl_get_error_code')) {
    require_once __DIR__.'/../vendor/symfony/src/Symfony/Component/Locale/Resources/stubs/functions.php';

    $loader->add('IntlDateFormatter', __DIR__.'/../vendor/symfony/src/Symfony/Component/Locale/Resources/stubs');
    $loader->add('Collator', __DIR__.'/../vendor/symfony/src/Symfony/Component/Locale/Resources/stubs');
    $loader->add('Locale', __DIR__.'/../vendor/symfony/src/Symfony/Component/Locale/Resources/stubs');
    $loader->add('NumberFormatter', __DIR__.'/../vendor/symfony/src/Symfony/Component/Locale/Resources/stubs');
}

AnnotationRegistry::registerLoader(function($class) use ($loader) {
    $loader->loadClass($class);
    return class_exists($class, false);
});
AnnotationRegistry::registerFile(
    __DIR__.'/../vendor/doctrine/orm/lib/Doctrine/ORM/Mapping/Driver/DoctrineAnnotations.php'
);
AnnotationRegistry::registerFile(
    __DIR__.'/../vendor/doctrine/mongodb-odm/lib/Doctrine/ODM/MongoDB/Mapping/Annotations/DoctrineAnnotations.php'
);

// Swiftmailer needs a special autoloader to allow
// the lazy loading of the init file (which is expensive)
require_once __DIR__.'/../vendor/swiftmailer/swiftmailer/lib/classes/Swift.php';
Swift::registerAutoload(__DIR__.'/../vendor/swiftmailer/swiftmailer/lib/swift_init.php');
