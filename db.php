<?php 
	define('HOST', '127.0.0.1');
	define('USER', 'root');
	define('PASS', '');
	define('DB', 'database');

	function open_database(){
		$conn = new mysqli(HOST, USER, PASS, DB);
		if ($conn->connect_error){
			die('Connect error: '. $conn->connect_error);	
		}
		return $conn;
	}

	function login($user, $pass)
		{
			$sql = "select * from account where username = ?";
			$conn = open_database();

			$stm = $conn -> prepare($sql);
			$stm -> bind_param('s',$user);
			if (!$stm -> execute()) {
				return null;
			}

			$result = $stm -> get_result();
			$data = $result-> fetch_assoc();
			$hashed_password = $data['password'];
			
			if (!password_verify($pass, $hashed_password)){
				return null;
			}
			else return $data;

		}	

		function role($user)
		{
			$sql = "select role from account where username = ?";
			$conn = open_database();

			$stm = $conn -> prepare($sql);
			$stm -> bind_param('s',$user);
			if(!$stm->execute()){
				die('Query error:'. $stm->error);
			}
			$role = $stm->get_result();
			return $role;

		}






		function check_email($email){
		$sql = 'select username from account where email = ?';
		$conn = open_database();
		$stm = $conn->prepare($sql);
		$stm->bind_param('s',$email);
		if(!$stm->execute()){
			die('Query error:'. $stm->error);
		}
		$result = $stm->get_result();
		if ($result->num_rows > 0){
			return true;
		}else{
			return false;
		}
	}

	function signup($user, $pass, $first, $last, $birthday, $email, $phone){


		if(check_email($email)){
			return array('code'=>1,'error' => 'Email exists');
		}

		$hash = password_hash($pass, PASSWORD_DEFAULT);
		$rand = random_int(0, 1000);
		$token = md5($user .'+'.$rand);

		$sql = 'insert into account(username, password, firstname, lastname, birthday, email, phone) values(?,?,?,?,?,?,?) ';

		$conn = open_database();
		$stm = $conn->prepare($sql);
		$stm->bind_param('sssssss', $user, $hash, $first, $last, $birthday, $email, $phone );
		if (!$stm -> execute()){
			return array('code' => 2, 'error' => 'Can not execute command' );
		}
		return array('code' => 0, 'error' => 'Create account successfully' );
	}
	function sendActivationEmail($email,$token){
		// Instantiation and passing `true` enables exceptions
		$mail = new PHPMailer(true);
		try {
			//Server settings
			//$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
			$mail->isSMTP(); 
			$mail->CharSet = 'UTF-8';                                         // Send using SMTP
			$mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
			$mail->SMTPAuth   = true;                                   // Enable SMTP authentication
			$mail->Username   = 'vienhoanglong789@gmail.com';                     // SMTP username
			$mail->Password   = 'daptbeyssmmcdtwv';                               // SMTP password
			$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
			$mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

			//Recipients
			$mail->setFrom('vienhoanglong789@gmail.com', 'Admin classroom');
			$mail->addAddress($email, 'Nguoi nhan');     // Add a recipient
			// Content
			$mail->isHTML(true);                                  // Set email format to HTML
			$mail->Subject = 'Khôi phục mật khẩu của bạn';
			$mail->Body    = "Click <a href='http://localhost:8888/New folder/resetpass.php?email=$email&token=$token'>Vào đây<a>để khôi phục mật khẩu của bạn ";
			$mail->send();
			return true;
		} catch (Exception $e) {
			return false;
		}
	}
	function sendResetEmail($email,$token){
		$sql ='select username from account where email=? and activate_token =? and activated =0';

		$conn = open_database();
		$stm = $conn->prepare($sql);
		$stm->bind_param('ss,$email,$token');
		if(!$stm->execute()){
			return array('code'=>1, 'error'=>'Can not execute command');
		}
		$result = $stm->get_result();
		if($result->num_rows==0){
			return array('code'=>2, 'error'=>'Email address or token not found');
		}
		//found
		$sql = "update account set activated = 1, activate_token= '' where email =?";
		$stm = $conn->prepare($sql);
		$stm->bind_param('s',$email);
		if(!$stm->execute()){
			return array('code'=>1, 'error'=>'Can not execute command');
		}
		return array('code'=>0, 'message'=>'Account Activated');

	}
	function resetPassword($email){
		if(!is_email_exists($email)){
			return array('code'=>1, 'error'=>'Email not exist');
		}
		$token = md5($email.'+'.random_int(1000,2000));
		$sql = 'update reset_token set token =? where email =?';

		$conn = open_database();
		$stm = $conn->prepare($sql);
		$stm->bind_param('ss',$token, $email);
		if(!$stm->execute()){
			return array('code'=>2, 'error'=>'Can not execute command');
		}
		if($stm->affected_rows == 0){
			$exp = time()+3600 * 24;
			$sql = 'insert into reset_token values(?,?,?)';
			$stm = $conn->prepare($sql);
			$stm->bind_param('ssi', $email, $token, $exp);

			if(!$stm->execute()){
				return array('code'=>1, 'error' =>'Can not execute command');
			}
		}
		$success = sendResetEmail($email,$token);
		return array('code'=>0, 'success' =>$success);
	}


	function addclass($classname, $classroom, $classtime, $teacher){

		$rand = substr(sha1(time()), 0, 5);

		$sql = 'insert into classmananger(classcode, classname, classroom, classtime, people) values (?,?,?,?,?)';

		
		$conn = open_database(); 
		$stm = $conn->prepare($sql);
		$stm->bind_param('sssss',$rand,$classname,$classroom,$classtime,$teacher);

		if (!$stm -> execute()){
			return array('code' => 2, 'error' => 'Can not execute command' );
		}
		return array('code' => 0, 'error' => 'Create account successfully' );
	}	


	function delclass($classcode){

		$sql = 'delete from classmananger where classcode = ?';
		$conn = open_database();
		$stm = $conn->prepare($sql);
		$stm->bind_param('s', $classcode);
		if (!$stm -> execute()){
			return array('code' => 2, 'error' => 'Can not execute command' );
		}
		return array('code' => 0, 'error' => 'Delete account successfully' );
	}	



	function joinclass($user, $pass, $classcode)
		{
			$sql = "select * from account where username = ?";
			$conn = open_database();

			$stm = $conn -> prepare($sql);
			$stm -> bind_param('s',$user);
			if (!$stm -> execute()) {
				return array('code' => 3, 'error' => 'Can not execute command' );
			}

			$result = $stm -> get_result();
			$data = $result-> fetch_assoc();

			$hashed_password = $data['password'];
			if (!password_verify($pass, $hashed_password)){
				return array('code' => 1, 'error' => 'incorrect passsword' );
			}
			else{
				$temple_people='select people from classmananger where classcode=?';
				$conn = open_database();
				$stmp = $conn->prepare($temple_people);
				$stmp->bind_param('s',$classcode);

				$stmp -> execute();
				$result = $stmp -> get_result();
				$people1 = $result -> fetch_array();

				$hu =  $people1["people"] .", ". $user;


				$sql = 'update classmananger set people = ? where classmananger.classcode = ?';
				$conn = open_database();
				$stm = $conn->prepare($sql);
				$stm->bind_param('ss',$hu,$classcode);
				if (!$stm -> execute()){
					return array('code' => 2, 'error' => 'Can not execute command' );
				}

				else return array('code' => 0, 'error' => 'Create account successfully' );
			}
			/*join_class($user, $classcode);*/

		}

		


?>