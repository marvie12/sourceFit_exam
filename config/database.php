<?php
include CONFIG_PATH."/variables.php";

Class DB
{
	private static $db;

	public static function getDB() {
        if(is_null(self::$db)) {
			self::$db = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8', DB_USERNAME, DB_PASSWORD);
        }
        return self::$db;
    }

	public static function select($table, $params = []) {
		$tbl = DB_PREFIX.$table; 	
    	$columns = isset($params['columns']) ? $params['columns']:"*";
    	$where = "";
    	$orderBy = "";

    	if (isset($params['where'])) {
    		if (is_array($params['where'])) {
    			$where = " WHERE ".implode(" and ", $params['where']);
    		} else {
    			$where = " WHERE ".$params['where'];
    		}    		
    	}

    	if (isset($params['orderBy'])) {
    		$orderBy = " ORDER BY ".$params['orderBy'];
    	}

    	$sql = "SELECT ".$columns." FROM ".$tbl;

		$sql .= $where.$orderBy;
		$request = self::getDB()->prepare($sql);
		$request->execute();
		return $request->fetchAll(PDO::FETCH_OBJ);
	}

    public static function find($tbl, $colum, $key)
    {
    	$tbl = DB_PREFIX.$tbl; 	
    	$sql = "SELECT * FROM ".$tbl." WHERE ".$colum." LIKE ".$key;
    	$req = self::getDB()->prepare($sql);
        $result = $req->execute();
        return $result?$req->fetchAll(PDO::FETCH_OBJ):null;
    }

	public static function create($tbl, $params)
    {
    	$tbl = DB_PREFIX.$tbl;
    	$colums = implode(",", array_keys($params));
    	$values = '"'.implode('","', array_values($params)).'"';

        $sql = "INSERT INTO ".$tbl." (".$colums.") VALUES (".$values.")";
        $req = self::getDB()->prepare($sql);
        $req->execute();
        return self::getDB()->lastInsertId();
    }

    public static function update($table, $col, $where="")
    {
        $tbl = DB_PREFIX.$table;

        $sql = "UPDATE ".$tbl." SET ".$col;
        
        if ($where) {
        	$sql = $sql." WHERE ".$where;        	
        }

        $req = self::getDB()->prepare($sql);
        $req->execute();

        return self::select($table,['where'=>$where]);
    }

    public static function delete($table="users", $where)
    {
        $tbl = DB_PREFIX.$table;
        $sql = "DELETE FROM ".$tbl." WHERE ".$where;
        
        $req = self::getDB()->prepare($sql);
        $req->execute();
    }
}

?>