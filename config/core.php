<?php
include "../config/variables.php";

Class DB
{
	private static $db;

	private function __construct() {
		return self::$db = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8', DB_USERNAME, DB_PASSWORD);
	}

	public static function select($table, $params = []) {
		$columns = isset($params['columns']) ? $params['columns']:'*';
		
		$request = self::$db->prepare('Select '.$columns.' FROM '.DB_PREFIX.$table);
		$request->execute();
		return $request->fetchObject();
	}	
}


echo $poll = DB::select('poll');

?>