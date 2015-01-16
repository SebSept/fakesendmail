<?php

namespace SebSept\FakeSendmail;

interface WriterInterface
{
    /**
     * store the mail somewhere (or not)
     * */
    function store($data);
}
