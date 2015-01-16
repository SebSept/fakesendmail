<?php

namespace SebSept\FakeSendmail;

class FileWriter implements WriterInterface
{
    public function store($data)
    {
        file_put_contents('/tmp/lastmail', json_encode($data));
    }

}
