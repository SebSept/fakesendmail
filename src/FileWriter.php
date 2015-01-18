<?php

namespace SebSept\FakeSendmail;

/**
 * Writes data (parsed mail content) to a file.
 */
class FileWriter implements WriterInterface
{

    /**
     * @var string Where content will be written
     */
    protected $output_path;

    /**
     * 
     * @param string $output_path
     */
    public function __construct($output_path = null)
    {
        $this->output_path = $output_path ? $output_path :  sys_get_temp_dir().'/lastmail';
    }

    /**
     * Store data
     * 
     * @param  mixed $data
     * @throws FileWriterException
     */
    public function store($data)
    {
        if(false === @file_put_contents($this->output_path, $data))
        {
            throw new FileWriterException("Failed to write to [{$this->output_path}] ");
        }
    }

    /**
     * change output filename
     * 
     * @param string $filename
     */
    public function setOutputFileName($filename)
    {
        if ($filename == '' || basename($filename) != $filename) // filepath should not contain /
        {
            throw new FileWriterException("invalid filename [{$filename}]");
        }

        $this->output_path = dirname($this->output_path) . '/' . $filename;
    }

    public function getOutputPath()
    {
        return $this->output_path;
    }

    public function setOutputDirectory($directory)
    {
        $directory = rtrim($directory,'/').'/x';
        $this->output_path = dirname($directory).'/'.basename($this->output_path);
    }

}

/**
 * Custom Exception
 */
class FileWriterException extends \Exception {}
    
