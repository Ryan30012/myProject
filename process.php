<?php 

session_start();

//to make sure the client won't just post the link for the process.php to get passed the index.php
/*if (isset($_SESSION['UserId'])) {
	header("Location:index.php");
	exit();
}*/


$userID = $_SESSION['UserId'];
$Fname = $_SESSION['Fname'];

//variables
$international = "";
$phone = "";
$recoveryEmail = "";
$month = "";
$day = "";
$year = "";
$gender = "";
$ERROR;

if (isset($_POST['submit-btn'])) {
	$international = $_POST['phone-region'];
	$phone = $_POST['phone'];
	$recoveryEmail = $_POST['email_recovery'];
	$month = $_POST['month'];
	$day = $_POST['day'];
	$year = $_POST['year'];
	$gender = $_POST['gender'];
	echo $_SESSION['UserId'];

	if (empty($phone)) {
		$ERROR = "The phone field is requiered";
	}
	elseif (empty($recoveryEmail)) {
		$ERROR = "The Email recovery field is requiered";
	}
	elseif (empty($day)) {
		$ERROR = "The day field is requiered";
	}
	elseif (empty($year)) {
		$ERROR = "The year field is requiered";
	}
	else {
		$Phone = $international . "-" . str_replace(" ", "-", $Phone);
		$file = fopen("users,txt", "a");
		if ($file) {
			$data = " " . $Phone . " " . $recoveryEmail . " " . $month . " " . $day . " " . $year . " " . $gender;
			fwrite($file, $data);
			fclose($file);
			$ERROR = "User account has been created successfully.";

		}
		else {
			$ERROR = "Couldn't open the file 'users.txt'";
		}
	}
	

}


?>
<!DOCTYPE html>
<html lang='en'>
<head>
	<meta charset='utf-8'>
	<title>Process</title>
	<link rel="stylesheet" href="process.css">
</head>
<body>
	<div class="main">
		<form action="<?php if($error == true){ echo "process.php";} else {
			echo "outcome.php";}?>" method="POST">
			<div class="head">
                <img src="images/google2.0.0.jpg" alt="google_logo.jpg " class="logo">
                <h3><?php echo $Fname; ?>, Welcome to Google</h3>
            </div>
			<div class="line_1">
				<br>
				<img src="images/profile-picture.png" alt="default profile picture" style="width:18px; height:18px;" class="profile-pic">
				<?php echo $userID; ?>@gmail.com
			</div>
			<div class="phone-number">
				<select name="phone-region" class="phone_region">
					<option value="+1">Canada</option>
					<option value="+1">USA</option>
					<option value="+81">Japan</option>
					<option value="+44">UK</option>
					<option value="+34">Spain</option>
					<option value="+33">France</option>
				</select>
				<input type="text" name="phone" class="phone">
				<label class="phone-lbl">Phone number</label>
			</div>
			<a href="#" class="line1">We'll use your number for account security. It won't be visible to <br> others.</a>
			<div class="recovery_email">
				<input type="text" name="email_recovery" class="email-recovery">
				<label class="email-R">Recovery email address</label>
			</div>
			<a href="#" class="line1">We'll use it to keep your account secure</a>
			<div class="date-birth">
				<select name="month" id="month">
					<option value="january">January</option>
					<option value="february">February</option>
					<option value="march">March</option>
					<option value="april">April</option>
					<option value="may">May</option>
					<option value="june">June</option>
					<option value="july">July</option>
					<option value="august">August</option>
					<option value="september">September</option>
					<option value="october">October</option>
					<option value="november">November</option>
					<option value="december">December</option>
				</select>
				<label class="month-lbl">Month</label>
				<input type="number" name="day" id="date">
				<label class="day-lbl">Day</label>
				<input type="number" name="year" id="year">
				<label class="year-lbl">Year</label>
			</div>
			<a href="#" class="line1">Your birthday</a>
			<div class="gender">
				<select name="gender" id="gender-info">
					<option value="rather-not-say">Rather not say</option>
					<option value="male">Male</option>
					<option value="female">Female</option>
				</select>
				<label class="gender-lbl">Gender</label>
			</div>
			<a href="#" class="line2">Why we asking for this information</a><br>
			<div class="buttons">
				<a href="index.php" class="line2">Back</a>
				<button type="submit" name="submit-btn" class="submit_btn">Submit</button>
			</div>
            <div class="alert">
                <?php if(isset($ERROR)): ?>
                    <li><?php echo $ERROR; ?></li>
                <?php endif; ?>
            </div>
			<div class="image2">
            	<img src="images/google_security_image.PNG" alt="Google_security.jpg">
        	</div>
		</form>
	</div>
</body>
</html>