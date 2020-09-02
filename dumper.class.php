<?php

namespace Absatzformat\Wordpress\Dumper;

class Dumper{

	protected static $instance;

	public $backtraceLevel = 0;

	public $useConsoleStyles = true;

	protected $rows = [];

	protected $groupStyles = [
		'color' => 'white',
		'background-color' => 'red',
		'padding' => '0 6px',
		'border-radius' => '2px',
	];

	protected $logStyles = [
		'background-color' => '#f2f2f2',
	];

	private function __construct(){

	}

	public static function print(){

		$self = self::getInstance();
		$rows = $self->rows;

		if(count($rows)){

			$groupStyles = $self->toCssString($self->groupStyles);
			$logStyles = $self->toCssString($self->logStyles);

			// print log scripts
			echo "<script>\n";
			foreach($rows as $trace => $logs){

				$trace = addslashes($trace);
				if($self->useConsoleStyles){
					echo "console.group('%cDUMPER%c %s','$groupStyles','','$trace');\n";
				}
				else{
					echo "console.group('DUMPER $trace');\n";
				}
				
				foreach($logs as $log){

					$encoded = base64_encode($log);
					if($self->useConsoleStyles){
						echo "console.log('%c'+decodeURIComponent(escape(atob('$encoded'))),'$logStyles');\n";
					}
					else{
						echo "console.log(decodeURIComponent(escape(atob('$encoded'))));\n";
					}
				}

				echo "console.groupEnd();\n";
			}
			echo "</script>\n";
		}
	}

	protected function toCssString($array){

		$str = '';

		foreach($array as $key => $val){
			$str .= $key.':'.$val.';';
		}

		return $str;
	}

	public static function getInstance(){

		if(!(self::$instance instanceof self)){
			self::$instance = new self();
		}

		return self::$instance;
	}

	public static function dump(){

		$self = self::getInstance();
		$vars = func_get_args();

		// get file and line
		$backtrace = debug_backtrace(false);
		// $self->rows[] = $backtrace;
		$line = $backtrace[$self->backtraceLevel]['file'].':'.$backtrace[$self->backtraceLevel]['line'];

		if(!isset($self->rows[$line])){

			$self->rows[$line] = [];
		}

		foreach($vars as $var){
			// TODO: prettify, parse, etc...
			$self->rows[$line][] = var_export($var, true);
		}
	}
}