<?php

namespace SebSept\FakeSendmail;

/**
 * Writes data (parsed mail content) to a file.
 */

class FileWriter implements WriterInterface
{
    public function store($data)
    {
        file_put_contents('/tmp/lastmail', $data);
    }

}
