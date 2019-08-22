<div class="contactForm">
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input type="text" name="name" placeholder="Your Name..">
        <input type="text" name="email" placeholder="Your Email..">
        <input type="text" name="subject" placeholder="Your Subject..">
        <input type="text" name="message" placeholder="Your Message..">
        <input type="submit" name="submitMessage">
    </form>
</div>
<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
$counter = 0;
if(isset($_POST['submitMessage']))
{
    if($_POST["name"]!=""){
        if(ctype_alpha($_POST["name"][0])){
            if(substr_count(trim($_POST["name"]), ' ') > 0){
                if (ctype_alpha(str_replace('-', '', str_replace(' ', '', $_POST["name"]))) === false) {
                    echo '<script language="javascript">';
                    echo 'alert("Name must contain letters, dash and spaces only")';
                    echo '</script>';
                }else{
                    $counter++;
                }
            }
            else{
                echo '<script language="javascript">';
                echo 'alert("Name must contain at least two words")';
                echo '</script>';
            }
        }
        else{
            echo '<script language="javascript">';
            echo 'alert("First letter of Name needs To Be Alphabatic")';
            echo '</script>';
        }

    }
    else
    {
        echo '<script language="javascript">';
        echo 'alert("Name can not be empty")';
        echo '</script>';
    }

    if($_POST["email"]!=""){
        if (strpos($_POST["email"], '@') !== false &&  strpos($_POST["email"], '.') !== false && strlen($_POST["email"])>2 && ctype_alpha($_POST["email"][0]) && ctype_alpha($_POST["email"][strlen($_POST["email"])-1]) && ctype_alpha($_POST["email"][strpos($_POST["email"], '@')+1]) && ctype_alpha($_POST["email"][strpos($_POST["email"], '.')+1])) {
            $counter++;
        }
        else{
            echo '<script language="javascript">';
            echo 'alert("Invalid Email")';
            echo '</script>';
        }
    }
    else
    {
        echo '<script language="javascript">';
        echo 'alert("Email can not be empty")';
        echo '</script>';
    }
}

if($counter===2){
    $mail = new PHPMailer();

    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    $mail->SMTPSecure = 'tls';
    $mail->SMTPAuth = TRUE;
    $mail->Username = 'webtechforcedme@gmail.com';
    $mail->Password = 'WebTechForcedMe!@12';

    $mail->setFrom($_POST['email'], $_POST['name']);

    $mail->addAddress('im.toufiq@gmail.com', 'Test Site');
    $mail->Subject = "Contact Form submission-".$_POST['name'];
    $mail->Body = $_POST['message'];
    if (!$mail->send())
    {
        echo '<script language="javascript">';
        echo'alert("Error:' .$mail->ErrorInfo.'")';
        echo '</script>';

    }
    else
    {
        echo '<script language="javascript">';
        echo'alert("Message Sent")';
        echo '</script>';
    }

}
?>