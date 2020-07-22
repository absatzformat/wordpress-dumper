<?php

namespace Absatzformat\Wordpress\Dumper;

class Dumper{

	protected static $instance;

	public $backtraceLevel = 0;

	protected $rows = [];

	protected $groupStyles = [
		'background-color' => 'yellow',
		'padding' => '0 6px'
	];

	protected $logStyles = [
		'color' => 'blue'
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
				echo "console.group('%c$trace','$groupStyles');\n";

				foreach($logs as $log){

					$encoded = base64_encode($log);
					echo "console.log('%c'+decodeURIComponent(escape(atob('$encoded'))),'$logStyles');\n";
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