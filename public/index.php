<?php

DEFINE('PUBLIC_PATH', $_SERVER['DOCUMENT_ROOT']);
DEFINE('ROOT_PATH', str_replace("/public", '', PUBLIC_PATH));
DEFINE('CONFIG_PATH', ROOT_PATH."/config");

include CONFIG_PATH."/database.php";

function validateForm($post) {       
    if (isset($post['mobile']) && !is_numeric($post['mobile'])) {
        return "Invalid Contact Number.";
    }

    if (isset($post['email']) && !filter_var($post['email'], FILTER_VALIDATE_EMAIL)) {
        return "Invalid email format";
    }
}

$channels = ['add','edit','delete'];

$uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri_segments = explode('/', $uri_path);
$channel = $uri_segments[1];

if ($channel && !in_array($channel, $channels)) {
	header('Location: /');
}

$view = $channel?:'index';

$table = 'users';

switch ($channel) {
	case 'add':
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			unset($_POST['submit']);
			$user = $_POST;

			if ($errorMsg = validateForm($_POST)) {				
				return include TPL_PATH.'/'.$view.'.php';				
			}

			foreach ($_POST as $key => $value) {
				// check of user exist
				if ($key == 'name' || $key == 'email') {
					// table, column, value
					if (DB::find($table,$key,"'".$value."'")) {
						$errorMsg = ucwords($key).": ".$value." already Exist";
						return include TPL_PATH.'/'.$view.'.php';
					}
				}
				$_POST[$key] = strip_tags($value);
			}

			if (isset($_POST['birthdate'])) {
				$_POST['birthdate'] = strtotime($_POST['birthdate']);
			}

		    $user = DB::create($table,$_POST);
		    if ($user) {
		    	$users = DB::update($table,"user_id='ID-".$user."'","id='".$user."'");
		    	header('Location: /');
		    }
		    return false;
		}
		break;
	case 'edit':
		$userID = isset($uri_segments[2])?$uri_segments[2]:0;

		if ($userID) {

		    $user = DB::find($table,'user_id', "'".$userID."'");
		    if (!count($user)) {
		    	header('Location: /');
		    }
		    $user = $user[0];

			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				unset($_POST['submit']);
				
				if ($errorMsg = validateForm($_POST)) {				
					return include TPL_PATH.'/'.$view.'.php';				
				}

				$ctr = 0;
				$len = count($_POST);
				foreach ($_POST as $key => $value) {
					// check of user exist
					if ($key == 'name' || $key == 'email') {
						// table, column, value
						$userEO = DB::find($table,$key,"'".$value."'");
						if ($userEO && $userEO[0]->user_id != $userID) {
							$errorMsg = ucwords($key).": ".$value." already Exist";
							return include TPL_PATH.'/'.$view.'.php';
						}
					}

					if ($key == 'birthdate') {
						$value = strtotime($value);
					}
					$data = $key."='".addslashes(strip_tags($value))."'";
					$data .= $ctr == $len-1?'':', ';
					$col[] = $data;
					$ctr++;
				}
			    $users = DB::update($table,implode("", $col),"user_id='".$userID."'");
		    	header('Location: /edit/'.$userID);
			}
		} else {
		    header('Location: /');
		}
		break;
	case 'delete':
		$userID = isset($uri_segments[2])?$uri_segments[2]:0;

		if ($userID) {
		    $user = DB::find($table,'user_id', "'".$userID."'");
		    if (!count($user)) {
		    	header('Location: /');
		    }
		    DB::delete('users',"user_id ='".$userID."'");
		}
		header('Location: /');
		break;
	
	default:
		$users = DB::select($table,['orderBy'=>'user_id ASC']);
}

include TPL_PATH.'/'.$view.'.php';

?>