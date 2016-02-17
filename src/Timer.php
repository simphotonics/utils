<?php
namespace Simphotonics\Utils;

use Simphotonics\Utils\ArrayUtils as ArrayUtils;

/**
 * @author D Reschner <d.reschner@simphotonics.com>
 * @copyright 2015 Simphotonics
 * Description: Timer class similar to Matlab's tic() toc().
 */
class Timer
{
    /**
     * Start time.
     * @var float
     */
    private $start = 0.0;

    /**
     * Stop time.
     * @var float
     */
    private $stop = 0.0;

    /**
     * Elapsed time.
     * @var float
     */
    private $elapsed = 0.0;

    /**
     * Lap count.
     * @var integer
     */
    private $count = 0;

    /**
     * Average time between immediate calls to tic() and toc().
     * @var float
     */
    public $calib = 0.0;

    /**
     * Standard deviation of $calib.
     * @var float
     */
    public $stDev = 0.0;

    /**
     * Logical flag use to reset the lap counter.
     * @see  $this->tac().
     */
    const RESET_COUNTER = 1;

    /**
     * Logical flag to keep lap counter.
     */
    const KEEP_COUNTER = 0;

    /**
     * Logical flag to add lap times.
     */
    const ADD_LAP   = 0;

    /**
     * Logical flag to reset lap times.
     */
    const RESET_LAP = 1;

  
    /**
     * Initialise object.
     * @return  void
     */
    public function __construct()
    {
        $this->calibrate();
        $this->reset();
    }
  
    /**
     * Output elapsed time.
     * @return string
     */
    public function __toString()
    {
        return " \n Elapsed time: (" . sprintf('%0.2f', $this->elapsed) ." +- ".
        sprintf('%0.2f', $this->stDev). ") microseconds.\n";
    }
  
    /**
     * Starts timer.
     * @param  int $flag self::RESET_COUNTER|self::KEEP_COUNTER
     * @return void
     */
    public function tic($flag = self::RESET_COUNTER)
    {
        $this->start = microtime(true);
        if ($flag) {
            $this->count = 0;
        }
    }
  
    /**
     * Stops timer and displays elapsed time.
     * @param  string $message is an optional user message.
     * @return void
     */
    public function toc($message = '')
    {
        $this->stop = microtime(true);
        ++$this->count;
        $this->elapsed = ($this->stop - $this->start ) * 1e6 - $this->calib;
        print $this;
        if ($message) {
            print $message . "\n";
        }
    }
  
    /**
     * Keeps lap time.
     * @param  int $flag Takes values self::ADD_LAP|self::RESET_LAP
     * @return void
     */
    public function tac($flag = self::ADD_LAP)
    {
        $this->stop = microtime(true);
        if ($flag) {
            $this->elapsed = ($this->stop - $this->start) * 1e6
            - $this->calib;
        } else {
            $this->elapsed += ($this->stop - $this->start) * 1e6
            - $this->calib;
        }
        ++$this->count;
    }
  
    /**
     * Returns elapsed time in microseconds.
     * @return float
     */
    public function elapsed()
    {
        return $this->elapsed;
    }
  
    /**
     * Resets timer.
     * @return void
     */
    public function reset()
    {
        $this->count = 0;
        $this->elapsed = 0;
        $this->start = 0;
        $this->stop = 0;
        return $this;
    }
  
    /**
     * Returns average lap time
     * @return float Time in microseconds.
     */
    public function lap()
    {
        return $this->elapsed / max($this->count, 1);
    }
  
    /**
     * Calculates $this->calib, the average time between immediate calls
     * to tic() and toc().
     * Initialises the standard deviation of $this->calib.
     * @return void
     */
    private function calibrate()
    {
        $imax = 20;
        $this->tic();
        $this->tac();
        for ($i=0; $i < $imax; $i++) {
            $this->tic();
            $this->tac(self::RESET_LAP);
            $calib[] = $this->elapsed;
        }
        $this->calib = ArrayUtils::mean($calib);
        $this->stDev = ArrayUtils::stDeviation($calib);
    }
}
