<?php



class Logger {

	const L_WARNING = '[WARNING]';
	const L_ERROR = '[ERROR  ]';
	const L_INFO = '[INFO   ]';

	//public $log_file = "logger_" . @date('YmdHis') . '.log';
	public $log_file = "logger.log";
	public $level = 0;

	// enable logging? you'll need create/write rights in working folder ///////////
	public $enable_logging = true;

	// print all info to stdout
	public $print_info_to_stdout = true;
	// $print_copy_info = true;

	public function log_string($s) {
	    $handle = fopen($this->log_file, 'a');
	    fwrite($handle, @date('[Y/M/d H:i:s] ') . $s);
	    fflush($handle);
	    fclose($handle);
	}

	public function build_msg($msg) {
	    $res = "";
	    for ($i = 0; $i < $this->level; ++$i)
	        $res .= "\t";
	    return $res . $msg . PHP_EOL;
	}

	public function print_string($s, $toStdOut = false) {
	    
	    if ($this->enable_logging) {
	        $this->log_string($s);
	    }
	    if ($toStdOut)
	        printf($s);
	}

	public function warn($msg) {
	    $this->print_string(self::L_WARNING . ' ' . $this->build_msg($msg));
	}

	public function info($msg, $print_always = false) {
	    $this->print_string(self::L_INFO . ' ' . $this->build_msg($msg), $this->print_info_to_stdout || $print_always);
	}

	public function err($msg) {
	    $this->print_string(self::L_ERROR . ' ' . $this->build_msg($msg));
	    printf(PHP_EOL);
	    exit(1);
	}
}
?>