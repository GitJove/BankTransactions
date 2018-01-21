<?php

namespace App\Utilities\CustomLogger;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class LogMsg
{
    /**
     * @var string
     */
    private $file;

    /**
     * @var string
     */
    private $code;

    /**
     * LogMsg constructor.
     * @param string $file
     * @param string $code
     */
    public function __construct(string $file = '', string $code = '')
    {
        $this->setCode($code);
        $this->setFile($file);
    }

    /**
     * @param mixed $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @param mixed $file
     */
    public function setFile($file)
    {
        $this->file = $file;
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Generate new code
     */
    public function generateNewCode()
    {
        $this->setCode($this->generateLogCode());
    }

    /**
     * Error - Save log in specific file
     *
     * @param string $method
     * @param \Exception $exception
     *
     * @param string $file
     * @return String ;
     */
    public function error(string $method, \Exception $exception, $file = '')
    {
/*        if ($file) {
            $this->setFile($file);
        }*/
        $this->generateNewCodeIfNotExist();

/*        // set the logger config and create error code
        $file = $this->customLoggerConfig($this->file);*/

        $error = $this->prepareMessage(
            'ERROR',
            $this->code,
            sprintf('%s LINE:%s', $method, $exception->getLine()),
            $exception->getMessage()
        );

        Log::error($error);
/*        $this->writeInFile($file, $error);*/

        return $this->code;
    }

    /**
     * Info - Save log in specific file
     *
     * @param string $method - the method of execution
     * @param string $message
     * @param string $file
     * @return string
     */
    public function info(string $method, string $message, $file = '')
    {
/*        if ($file) {
            $this->setFile($file);
        }*/
        $this->generateNewCodeIfNotExist();
        // set the logger config and create error code
/*        $file = $this->customLoggerConfig($this->file);*/
        $error = $this->prepareMessage(
            'INFO',
            $this->code,
            $method,
            $message
        );

        Log::info($error);
/*        $this->writeInFile($file, $error);*/

        return $this->code;
    }

    /**
     * generateLogCode - generate unique log code
     *
     * @return String $hash - the unique log code
     */
    private function generateLogCode()
    {
        // generate unique code for the log
        return substr(md5(microtime()), 0, 25);
    }

    /**
     * Generate new token if exist
     */
    private function generateNewCodeIfNotExist()
    {
        if (!$this->code) {
            $this->generateNewCode();
        }
    }

    /**
     * customLoggerConfig - generate unique log code and set the log file location
     *
     * @param  String $file - the log file
     * @return string
     */
    private function customLoggerConfig($file = '')
    {
        // check if custom log file is specified
        if ($file) {
            $fileDir = config(sprintf('filesystems.logger.%s.dir_path', env('APP_ENV')));
            $logFile = sprintf('%s/%s.log', $fileDir, $file);
            $file = storage_path($logFile);
        }
        return $file;
    }

    /**
     * Prepare Message
     * @param $type
     * @param $hash
     * @param $method
     * @param $message
     * @return string
     */
    private function prepareMessage(string $type, string $hash, string $method, string $message)
    {
        return sprintf(
            '%s >> %s >> %s >> %s >> %s',
            $type,
            Carbon::now(),
            $hash,
            $method,
            $message
        );
    }

    /**
     * Write in file if exist
     * @param $file
     * @param $error
     */
    private function writeInFile($file, $error)
    {
        if ($file) {
            $fileOpen = fopen($file, "a+");
            fputs($fileOpen, "{$error}\n");
            fclose($fileOpen);
        }
    }
}