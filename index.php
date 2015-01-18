#!/bin/env php
<?php

Phar::mapPhar('fakesendmail.phar');
require 'phar://fakesendmail.phar/vendor/autoload.php';

// parse command line arguments
$args = CommandLine::parseArgs($_SERVER['argv']);

// create FileWriter
$writer_output = isset($args['output']) ? $args['output'] : null;
$writer = new \SebSept\FakeSendmail\FileWriter($writer_output);

// build & execute FakeSendMail
$fakesendmail = new SebSept\FakeSendmail\FakeSendMail(null, $writer);
$fakesendmail->read()->write();

__HALT_COMPILER();