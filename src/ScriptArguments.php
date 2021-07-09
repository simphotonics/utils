<?php

declare(strict_types=1);

//
// Description: Used to parse the input arguments of a script application.
// Usage      : Handles options prefixed with:
//                "-"  like -h
//                "--" like --help
//                "-f=user"
//                "--path=/home/user/"
class ScriptArgs
{

  private $_args = array();

  // -----------
  // Constructor
  // -----------
  public function __construct()
  {
    $this->_args = $this->_parse();
  }


  /**
   * Returns the parsed script argument
   */
  public function getArgs(): array
  {
    return $this->_args;
  }

  /**
   * Parses the script arguments.
   */
  private function _parse()
  {
    global $argv, $argc;
    // Script name
    $this->_args['script'] = $argv[0];
    // Process input args
    for ($i = 1; $i < $argc; ++$i) {
      $opt = '';
      // Extract option
      switch ($this->_isOption($argv[$i])) {
        case '-':
          $opt = substr($argv[$i], 1);
          break;
        case '--':
          $opt = substr($argv[$i], 2);
          break;
        default:
          $this->_args[] = $argv[$i];
          continue 2;
          break;
      }
      // Check if option entry exists
      if (array_key_exists($opt, $this->_args))
        continue;
      // Check if option contains =
      $pos = strpos($opt, '=');
      if ($pos !== FALSE) {
        $value = substr($opt, $pos + 1);
        $key = substr($opt, 0, $pos);
        $this->_args[$key] = $value;
        continue;
      }
      // Check if next entry is option
      if (($i + 1) < $argc) {
        if (!$this->_isOption($argv[$i + 1])) {
          $this->_args[$opt] = $argv[$i + 1];
          ++$i;
          continue;
        }
      }
      // Store empty option value
      $this->_args[$opt] = '';
    }
    return $this->_args;
  }

  private function _isOption(string $opt): bool
  {
    // Begin with one or two dashes;
    $pattern = '/^[-]{1,2}[a-z,A-Z]/';
    if (preg_match($pattern, $opt, $matches)) {
      $prefix = $matches[0];
      $prefix = substr($prefix, 0, -1);
      return $prefix;
    }
    return FALSE;
  }
}
