<?php

	//
	//	Where to log?
	//
	function get_log_path() {

		$logpath = get_bloginfo('stylesheet_directory');
		$logpath = str_replace( get_bloginfo('wpurl') . '/', '', $logpath);
		$logpath = ABSPATH . $logpath . '/logs/';
		return $logpath;
	
	}

	//
	//	Clear the log gile
	//
	function clog() {

		$lfile = get_log_path() . "deliberate.log";
		if (file_exists( $lfile)) $ul = unlink( $lfile);
	
	}
	
	//
	//	Log some stuff
	//
	function dlog($string) {
	
		$lfile = get_log_path() . "deliberate.log";
		$lhandle = fopen( $lfile, "a+");
		
		if ($lhandle) {
			
			if (is_array( $string) || is_object( $string)) {

				ob_start();
				print_r($string);
				$lwrite = fwrite( $lhandle, ob_get_contents() . "\n");
				ob_end_clean();

			} else {

				$lwrite = fwrite( $lhandle, $string . "\n");
			}		

			fclose( $lhandle);

		}
	}

?>