<?php

namespace spec\SebSept\FakeSendmail;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Argument\Token\AnyValueToken;

use SebSept\FakeSendmail\WriterInterface;
use \SebSept\FakeSendmail\ParserInterface;


class FakeSendMailSpec extends ObjectBehavior
{

    function let(ParserInterface $parser, WriterInterface $writer)
    {
        $this->beConstructedWith($parser, $writer, __DIR__ . '/../vendor/michaelesmith/email-parser/test/MS/Email/Parser/Test/files/0.txt');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('SebSept\FakeSendmail\FakeSendMail');
    }

    function it_read_input($parser)
    {
        $parser->parse(new Argument\Token\AnyValueToken())->shouldBeCalled();
        
        $this->read();
    }

    function it_writes_output($parser, $writer)
    {
        $writer->store(new Argument\Token\AnyValueToken())->shouldBeCalled();
        $parser->parse(new Argument\Token\AnyValueToken())->shouldBeCalled();
        
        $this->read()->write();
    }

    // function 
}
