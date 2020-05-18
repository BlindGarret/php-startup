<?php
/**
 * Description of what this module (or file) is doing.
 *
 * @author   Lucas Roe <lroe2930@gmail.com>
 */
require __DIR__.'/../vendor/autoload.php';
use PHPStartup\Bootstrapping\Bootstrapper;

$bootstrapper = new Bootstrapper();
$bootstrapper->initialize();
$bootstrapper->run();
