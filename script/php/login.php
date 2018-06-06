<?php
	include("login_config.php");

	$error = "nothing";
	
	if(!empty($_POST))
	{
		$email = $_POST['email'];
		$password = $_POST['pass'];
		$action = $_POST['action'];

		if($action == "login")
		{
			$statement = $pdo->prepare("SELECT * FROM user WHERE email = :email");
			$result = $statement->execute(array('email' => $email));
			$user = $statement->fetch();
			
			if($user !== false){
				$statement = $pdo->prepare("SELECT * FROM passwd WHERE username = :uname");
				$result = $statement->execute(array('uname' => $user['username']));
				$pw = $statement->fetch();
				if(password_verify($password, $pw['password'])){
					$_SESSION['userID'] = $user['uniqueID'];
					if($_POST['remember'] === "on")
					{
						setcookie('userID', $_SESSION['userID'], time() + (365 * 24 * 60 * 60), '/');
					}
					else
					{
						if(isset($_COOKIE['userID']) && !empty($_COOKIE['userID']))
						{
							unset($_COOKIE['userID']);
						}
					}
					//log
					$statement = $pdo->prepare("INSERT INTO log (username, state, msg, timestamp) VALUES (:uname, :s, :msg, :ts)");
					$result = $statement->execute(array('uname' => $user['username'], 's' => 'INFO', 'msg' => 'Logged in', 'ts' => date(DATE_ATOM)));
					$response = array("status" => "200", "message" => "Logged in", "username" => $user["username"], "email" => $user["email"]);
				}
				else {
					$response = array("status" => "403", "message" => "Wrong Password");
				}
			}
			else 
			{
				$response = array("status" => "404", "message" => "Invalid E-mail");
			}
		}
		elseif($action == "logout"){
			//log
			$statement = $pdo->prepare("SELECT * FROM user WHERE uniqueID = :uid");
			$result = $statement->execute(array("uid" => $_SESSION['userID']));
			$user = $statement->fetch();
			$statement = $pdo->prepare("INSERT INTO log (username, state, msg, timestamp) VALUES (:uname, :s, :msg, :ts)");
			$result = $statement->execute(array('uname' => $user['username'], 's' => 'INFO', 'msg' => 'Logged out', 'ts' => date(DATE_ATOM)));
			session_destroy();
			if(isset($_COOKIE['userID']) && !empty($_COOKIE['userID']))
			{
				setcookie('userID', null, -1);
			}

			$response = array("status" => "200", "message" => "Logged out", "username" => $user["username"], "email" => $user["email"]);
		}
	}
	elseif(isset($_SESSION['userID'])){
		$statement = $pdo->prepare("SELECT * FROM user WHERE uniqueID = :uname");
		$result = $statement->execute(array('uname' => $_SESSION['userID']));
		$user = $statement->fetch();
		
		$response = array("status" => "200", "message" => "Already logged in", "username" => $user["username"], "email" => $user["email"]);
		
		if($user == false){
			unset($user);
			session_destroy();
			$response = array("status" => "404", "message" => "Logged in user doesn't exist anymore");
		}
	}
	elseif(isset($_COOKIE['userID'])){
		$statement = $pdo->prepare("SELECT * FROM user WHERE uniqueID = :uname");
		$result = $statement->execute(array('uname' => $_COOKIE['userID']));
		$user = $statement->fetch();
		
		$response = array("status" => "200", "message" => "Already logged in", "username" => $user["username"], "email" => $user["email"]);
		
		if($user == false){
			unset($user);
			setcookie('userID', null, -1);
			$response = array("status" => "404", "message" => "Logged in user doesn't exist anymore");
		}
	}
	else
	{
		$response = array("status" => "400", "message" => "No action given");
	}


	echo json_encode($response);
?>