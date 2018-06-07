<?php
/**
* 
*/
require_once __DIR__."/LogerData.php";

class Loger
{

	public static function log($message, $data){
		$todayDate = date("Y.m.d");
		$logMessage = date("Y-m-d H:i:s").": ";
		if($data instanceof LogerData){
			$logMessage .= $data->class." ".$data->method." \n".$message;
		}else{
			$logMessage .= " \n".$message;
		}

		error_log($logMessage, 3, dirname(__DIR__)."/log/".$todayDate.".log");
	}
}
?>