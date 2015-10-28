A simple Web Framework
=============================

This is a PHP micro-framework to develop websites.


.. code-block:: php

    <?php

    require_once(__DIR__ . '/../Framework/Loader.php');

    $loader->addNamespacePath('Blog\\',__DIR__.'/../src/Blog');
    $loader->addNamespacePath('CMS\\',__DIR__.'/../src/CMS');
    $loader->addNamespacePath('Framework\\',__DIR__.'/../Framework');
    
    $app = new \Framework\Application(__DIR__.'/../app/config/config.php');
    $app->run();

Framework works with PHP 5.3 or later.
