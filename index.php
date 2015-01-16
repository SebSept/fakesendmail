#!/bin/env php
<?php

Phar::mapPhar();

require 'phar://fakesendmail.phar/vendor/autoload.php';

$smtp = new SebSept\FakeSendmail\FakeSendMail();
$smtp->read();
$smtp->write();

__HALT_COMPILER();