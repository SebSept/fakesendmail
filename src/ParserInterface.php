<?php

namespace SebSept\FakeSendmail;

interface ParserInterface
{
    function parse($raw_data);
}
