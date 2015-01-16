<?php

namespace SebSept\FakeSendmail;

use MS\Email\Parser\Parser;

/**
 *
 * @todo inject ParserWrapper ?
 * @todo replace WriterInterface by WriterWrapperInterface
 * */
class FakeSendMail
{

    /**
     * @var string Source to read from
     *
     * could be a filename or anything that fopen() can read
     * @see http://php.net/manual/function.fopen.php
     * 
     */
    protected $source;

    /**
     * @var WriterInterface
     *
     * Instance to write the mail content
     * */
    protected $writer;

    /**
     * @var MailParser
     *
     * Instance to parse mail contents
     * */
    protected $parser;

    /**
     * @var string json
     *
     * mail content, ready to pass to Writer, json
     * */
    protected $mail_content;

    /**
     *
     * @param WriterInterface $writer object used to store the mail 
     * @param string          $source filename/input - may be specified only for testing.
     * */
    public function __construct(ParserInterface $parser = null, WriterInterface $writer = null,  $source = 'php://stdin')
    {
        $this->source = $source;
        $this->writer = $writer ? : new FileWriter;
        $this->parser = $parser ? : new Parser;
    }

    /**
     * Read mail content from input
     * 
     * @return FakeSendMail
     */
    public function read()
    {
        $parsed_content = $this->parser->parse(file_get_contents($this->source));
        $this->mail_content = json_encode($parsed_content);

        return $this;
    }

    /**
     * Store mail content
     * 
     * @throws \RuntimeException
     * @return FakeSendMail
     */
    public function write()
    {
        if (is_null($this->mail_content))
        {
            throw new \RuntimeException('did you call read() content ?');
        }
        $this->writer->store($this->mail_content);
        return $this;
    }

    public function __toString()
    {
        return json_encode($this->mail_content);
    }

}
