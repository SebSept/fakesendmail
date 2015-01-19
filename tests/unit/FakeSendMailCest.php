<?php

use \UnitTester;

class basicCest
{
    use expectations;
    
    private $default_file_location = '/tmp/lastmail';

    public function _before(UnitTester $I)
    {
        if (file_exists($this->default_file_location))
        {
            $I->deleteFile($this->default_file_location);
        }
    }

    public function _after(UnitTester $I)
    {
        
    }

    public function runFakesendmailUsingCatPipedInput(UnitTester $I)
    {
        $I->runShellCommand("cat ".$this->expectations[0]['file']." | php fakesendmail.phar");
        $I->seeFileFound($this->default_file_location);
        $I->seeInThisFile($this->expectations[0]['expectation']);
    }

}

trait expectations
{
    /**
     * key : file
     * value : result after read & write
     */
    private $expectations = [
        [ 'file'        => 'vendor/michaelesmith/email-parser/test/MS/Email/Parser/Test/files/thunderbird.txt',
          'expectation' => '{"date":"Wed, 30 Jan 2013 16:18:32 -0600","to":[{"name":"","address":"atapi@astrotraker.com"}],"cc":[],"bcc":[{"name":"","address":"someone-in-bcc@somewhere.com"},{"name":"justin nainconnu","address":"someoneelse-in-bcc@somewhere.com"}],"from":{"name":"Michael Smith","address":"example@textilemanagement.com"},"subject":"Fwd: test subject","html_body":"<html>\n  <head>\n\n    <meta http-equiv=\"content-type\" content=\"text\/html; charset=ISO-8859-1\">\n  <\/head>\n  <body bgcolor=\"#FFFFFF\" text=\"#000000\">\n    <br>\n      <br>\n      <pre>--\n\nThanks,\nMichael\n\n\n<\/pre>\n      <br>\n    <\/div>\n    <br>\n  <\/body>\n<\/html>","text_body":"\n\n--\n\nThanks,\nMichael\n"}'
        ]
    ];
    
}
