<?php

namespace Codeception\Module;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

class UnitHelper extends \Codeception\Module
{

    protected $test;

    public function _before(\Codeception\TestCase $test)
    {
        $this->test = $test;
    }

    public function expectException($exception)
    {
        $this->test->setExpectedException($exception);
    }

    /**
     * Caution : request a path with a file at the end
     * @param type $filename
     */
    public function prepareOutputDirectory($filename)
    {
        $directory_name = dirname($filename);
        
        if(!file_exists($directory_name))
        {
            mkdir($directory_name, 0777, true);
        }
    }
}
