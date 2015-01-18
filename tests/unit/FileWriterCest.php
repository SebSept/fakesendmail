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
            chmod($this->output_file, '755');
            $I->deleteFile($this->output_file);
        }
    }

    public function writeAFileToDefaultPath(UnitTester $I)
    {
        $data = 'writtent datas';
        $this->file_writer->store($data);
        $I->seeFileFound('/tmp/lastmail');
        $I->seeInThisFile($data);
    }

    public function getOutputPath(UnitTester $I)
    {
        $output = $this->file_writer->getOutputPath();

        // it is string
        $I->assertTrue(is_string($output), 'it is string');

        // it has a dir
        $I->assertNotEmpty(dirname($output), 'it has a dir');

        // it has a file
        $I->assertNotEmpty(basename($output), 'it has a file');
    }

    public function verifyDefaultPathIsInSystemDefaultTmpDir(UnitTester $I)
    {
        $output = $this->file_writer->getOutputPath();
        // check sys_get_temp_dir() is in $output
        $I->assertEquals(1, preg_match('!' . sys_get_temp_dir() . '!', $output));
    }

    /**
     * Only filename should be changed, not dir
     * @param UnitTester $I
     */
    public function changeFilePath(UnitTester $I)
    {
        $file_name = 'otherfilename_codeception.txt';
        $this->file_writer->setOutputFileName($file_name);
        $I->assertEquals(sys_get_temp_dir().'/otherfilename_codeception.txt', $this->file_writer->getOutputPath());
    }

    public function changeFilePathWithNullOrEmptyValue(UnitTester $I)
    {
        $I->expectException('SebSept\FakeSendmail\FileWriterException');
        $this->file_writer->setOutputFileName('');
    }

    public function changeFilePathWithInvalidValue(UnitTester $I)
    {
        $I->expectException('SebSept\FakeSendmail\FileWriterException');
        $this->file_writer->setOutputFileName('sef/sef/zz');
    }

    public function changeDirectoryPath(UnitTester $I)
    {
        $directory_names = ['/tmp/mails/app/', '/tmp'];
        foreach ($directory_names as $directory_name)
        {
            $I->prepareOutputDirectory($directory_name);

            $this->file_writer->setOutputDirectory($directory_name);

            // add last slash if needed
            $directory_name .= substr($directory_name, -1, 1) != '/' ? '/' : '';
            $I->assertEquals($directory_name . 'lastmail', $this->file_writer->getOutputPath());
        }
    }

    public function constructItWithFullPath(UnitTester $I)
    {
        $this->output_file = '/tmp/mails/test_mail.json';
        $I->prepareOutputDirectory($this->output_file);
        
        $this->file_writer = new FileWriter($this->output_file);
        
        $I->assertEquals($this->output_file, $this->file_writer->getOutputPath());
    }
    
    public function contentIsWrittenInOutputPath(UnitTester $I)
    {
        $data = 'Whatever';
        $this->output_file = sys_get_temp_dir().'/mails/test_mail.json';
        $I->prepareOutputDirectory($this->output_file);
        
        $this->file_writer = new FileWriter($this->output_file);
        $this->file_writer->store($data);
        
        $I->seeFileFound($this->output_file);
        $I->seeFileContentsEqual($data);
    }
    
    public function storeToNotWritableFile(UnitTester $I)
    {
        $I->expectException('\SebSept\FakeSendmail\FileWriterException');
        
        $data = 'Whatever';
        $this->output_file = sys_get_temp_dir().'/mails/test_mail.json';
        $I->prepareOutputDirectory($this->output_file);
        $I->writeToFile($this->output_file, 'before');
        chmod($this->output_file, '555');
        
        $this->file_writer = new FileWriter($this->output_file);
        $this->file_writer->store($data);
    }
}
