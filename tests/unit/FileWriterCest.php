<?php

use \UnitTester;

use SebSept\FakeSendmail\FileWriter;

class FileWriterCest
{
    /**
     * @var string file path where content could be write
     */
    private $output_file;
    
    /**
     * @var SebSept\FakeSendmail\FileWriter
     * FileWriter used for tests
     */
    private $file_writer;
    
    public function _before(UnitTester $I)
    {
        $this->file_writer = new FileWriter;
    }

    public function _after(UnitTester $I)
    {
        // remove the used file
        if (file_exists($this->output_file))
        {
            $I->deleteFile($this->output_file);
        }
        
    }

    public function writeAFileToDefaultPath(UnitTester $I)
    {
        $data = 'writtent datas';
        $this->file_writer->store($data );
        $I->seeFileFound('/tmp/lastmail');
        $I->seeInThisFile($data );
    }

}
