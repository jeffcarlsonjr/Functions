<?php
require_once 'lib/phpmailer/class.phpmailer.php';
require_once 'crudClass.php';

class emails
{


    public function botEmail($first,$last)
    {
        $to = "jeff.carlsonjr@gmail.com";
            $subject = "New Sign Up";
            $message = "Hello! ".$first." ".$last." is a bot and they just tried to sign up.";
            $from = "admin@crcnyc.org";
            $headers = "From:" . $from;
            mail($to,$subject,$message,$headers);
    }
    
    public function webMasterEmail($table, $where)
    {
        $crud = new CRUD;
        $crud->select($table, $where);
        $result = $crud->select($table, $where);
        
        $to = "jeff.carlsonjr@gmail.com";
        $subject = "New Sign Up";
        $message = "Hello! ".$result['member_first']." ".$result['member_last']." just signed up, please check it out.";
        $from = $result['member_email'];
        $headers = "From:" . $from;
        mail($to,$subject,$message,$headers);
    }
    
    public function memberEmail($table, $where)
    {
        
        $crud = new CRUD;
        $crud->select($table, $where);
        $result = $crud->select($table, $where);
        
            $mail = new PHPMailer;
            
            $body = "<center><img src='http://www.crcnyc.org/newTestSite/images/crcLogo.jpg'/></center>";
            $body .= "<p>Dear ".$result['member_first'].",</p>
                <p>Thank you for signing up with the CRC.</p> 
                <p>You will be receiving a newsletter every week that explains our up and coming events what we would like you to be a part of.</p>
                <p>We also meet every week after 5:30pm Service at Holy Trinity and we go out to one of the local establishments to get together and spend time together.</p>
                <p>If you have any questions, please feel free to write back to us here with this email address and we will get right back to you.</p>
                <br/>Thanks,<br/><br/>CRC Council";
            
            $mail->Subject = 'Welcome to the CRC NYC';
            $mail->IsHTML();
            $mail->AddAddress($result['member_email']);
            
            $mail->From = 'admin@crcnyc.org';
            $mail->FromName = 'CRC Council';
            $mail->AddReplyTo('admin@crcnyc.org');
            
            $mail->Body = $body;
            
            $mail->Send();
    }
    
    public function recoverPasswordEmail($username)
    {
            $crud = new CRUD;
            $result = $crud->select('CRCMEMBERS_NEW', 'member_email ="'.$username.'"');
                  
            $mail = new PHPMailer;
            $body = "<p>Dear ".$result['member_first'].",</p>
                <p>Your password to your CRC NYC account has been changed.</p>
                <p>If this is not you please go to <a href='http://crcnyc.org'>crcnyc.org</a> and change your password as well as email us right back and let us now please.</p>
                <p>If this is you, we hope that you did not run in to any troubles changing your password.</p>
                <p>Thank you,</p>
                <br/>CRC WebMaster";
            
            $mail->Subject = 'Your Password Was Changed';
            
           
            $mail->IsHTML();
            $mail->AddAddress($result['member_email']);
            
            $mail->From = 'admin@crcnyc.org';
            $mail->FromName = 'CRC WebMaster';
            $mail->AddReplyTo('admin@crcnyc.org');
            
            $mail->Body = $body;
            
            $mail->Send();
            
    }
}
?>
