<?php

namespace spec\SebSept\FakeSendmail;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Argument\Token\AnyValueToken;

use SebSept\FakeSendmail\WriterInterface;
use \SebSept\FakeSendmail\ParserInterface;


class FileWriterSpec extends ObjectBehavior
{

    function it_is_initializable()
    {
        $this->shouldHaveType('SebSept\FakeSendmail\FileWriter');
    }

    function it_store_data()
    {
        $this->store('some data');
    }
    
    function its_output_path_can_be_retrieved()
    {
        $this->getOutputPath()->shouldBeString();
    }
    
    function its_output_filename_can_be_changed()
    {
        $this->setOutputFileName('otherfilename_phpspec.txt');
    }
    
    function its_output_directory_can_be_changed()
    {
        $this->setOutputDirectory('otherfilename_phpspec');
    }
}
