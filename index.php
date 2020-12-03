<?php 
    session_start();

    $Fname = "";
    $Lname = "";
    $UserId = "";
    $pass = "";
    $conf = "";
    $userExist = false;
    $error = true;

    function Countt($str) 
    { 
        $upper = 0;
        for ($i = 0; $i < strlen($str); $i++) 
        { 
            if ($str[$i] >= 'A' & $str[$i] <= 'Z') {
                $upper++;
            }			
        }
        return $upper;
    }
    
    //if the next button is clicked
    if (isset($_POST['next'])) {
        //getting inputs
        $Fname = $_POST['Fname'];
        $Lname = $_POST['Lname'];
        $UserId = $_POST['Id'];
        $pass = $_POST['pass1'];
        $conf = $_POST['pass2'];
    
        if (empty($Fname)) { 
            $ERROR = "The first name field is requiered";
            $error = true;
        }
        else if (empty($Lname)) {
            $ERROR = "The last name field is requiered";
            $error = true;
        }
        else if (empty($UserId)) {
            $ERROR = "The user id field is requiered";
            $error = true;
        }
        else if (empty($pass)) {
            $ERROR = "The password field is requiered";
            $error = true;
        }
        else{
            // Validate password strength
            $lowercase = preg_match('@[a-z]@', $pass);
            $number    = preg_match('@[0-9]@', $pass);
            $specialChars = preg_match('@[^\w]@', $pass);
    
            if(Countt($pass)<2 || !$lowercase || !$number || !$specialChars || strlen($pass) < 8){
                $ERROR = " The password must contain at least two uppercase
    characters, 1 lowercase character, 1 special character from {!, @, #, $, %, ^, &},
    1 digit and a minimum length of 8 characters";
                $error = true;
            }
            else if ($pass !== $conf) {
                $ERROR = "The passwords doesn't match";
                $error = true;
            }
            else{
                $file = fopen("users.txt", "a") or die("Unable to open the file");
                $data = PHP_EOL. $UserId . " " . $Fname . " " . $Lname . " " . $pass;
                fwrite($file, $data);
                fclose($file);
                $_SESSION['UserId'] = $UserId;
                $_SESSION['Fname'] = $Fname;
                $_SESSION['Lname'] = $Lname;
                $error = false;

            }
        }
    }
    
    //if the check button is clicked
    if (isset($_POST['checkId'])) {
        if (empty($_POST['Id'])) {
            $ERROR = "The userID field is requiered";
        }
        else {
            $UserId = $_POST['Id'];
            if(file_exists("users.txt")){
                $handle = fopen("users.txt", "r");
                $userExist;
                if ($handle) {
                    while (($line = fgets($handle)) !== false) {
                        // process the line read.
                        $Word = explode(" ", trim($line));
                        if ($UserId === $Word[0]) {
                        $userExist = true; 
                        }
                        else {
                            $userExist = false;
                        }
                    }

                    fclose($handle);
                } else {
                    $ERROR = "Can't open the 'users.txt' file";
                }
                if ($userExist === true) {
                    $Fname = $_POST['Fname'];
                    $Lname = $_POST['Lname'];
                    $UserId = "";
                    $pass = $_POST['pass1'];
                    $conf = $_POST['pass2'];
                    $error = true;
                    $ERROR = "This userID is already assign";
                }
                else {
                    $Fname = $_POST['Fname'];
                    $Lname = $_POST['Lname'];
                    $UserId = $_POST['Id'];
                    $pass = $_POST['pass1'];
                    $conf = $_POST['pass2'];
                    $error = true;
                    $ERROR = "This userID is available";
                }
            } else {
                $ERROR = 'The file "users.txt" does not exists';
                $error = true;
            }
        }
    }
?>
<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='utf-8'>
    <title>Question 1</title>
    <link rel="stylesheet" href="style2good.css">
</head>
<body>
    <div class="main">
        <form action="<?php if ($error == true) {
            echo "index.php";
        } else {
            echo "process.php";} ?>" class="" method="POST">
            <div class="head">
                <img src="images/google2.0.0.jpg" alt="google_logo.jpg " class="logo">
                <h3>Create your Google Account</h3>
            </div>
            <div class="name">
                <input type="name" id="fname" name="Fname" value="<?php echo $Fname;?>">
                <label class="fname-lbl">First name</label>
                <input type="name" name="Lname" id="lname" value="<?php echo $Lname;?>">
                <label class="lname-lbl">Last name</label>
            </div>
            <div class="Username">
                <input id="Id" type="username"onblur="checkUserId()" name="Id" value="<?php echo $UserId; ?>">
                <label>Username</label>
                <span class="gmail">@gmail.com</span>
            </div>
            <a href="" class="line1">You can use letters, numbers & periods</a>
            <button type="submit" name="checkId" id="checkID"> Check Id</button><br>
            <a href="" class="line2">Use my current email address instead</a>
            <div class="pass">
                <input type="password"  class="password" id="pass1" name='pass1' value="<?php echo $pass;?>">
                <label id="pass1-lbl">Password</label>
                <input type="password"  class="password" id="pass2" name="pass2" value="<?php echo $conf; ?>">
                <label id="pass2-lbl">Confirm</label>
            </div>
            <div class="iconeye">
                <img src="hide.png" alt="eyehide.png" id="eye" onclick="show();">
            </div>
            <a href="" class="line3">Use 8 or more characters with a mix of letters, numbers & symbols</a>
            <div class="alert">
                <?php if(isset($ERROR)): ?>
                    <li>Notice: <?php echo $ERROR; ?></li>
                <?php endif; ?>
            </div>
            <a href="" class="line4">Sign in instead</a>
            <button type="submit" name="next" class="next"  id="next">Next</button>
        </form>
        <div class="image2">
            <img src="images/googleCloud_plateform.jpg" alt="Google_security.jpg">
        </div>
    </div>
    <script src="script.js">
        
    </script>
</body>
</html>