#!/bin/env php
<?php

Phar::mapPhar('fakesendmail.phar');
require 'phar://fakesendmail.phar/vendor/autoload.php';

$fakesendmail = new SebSept\FakeSendmail\FakeSendMail();
$fakesendmail->read()->write();

__HALT_COMPILER();