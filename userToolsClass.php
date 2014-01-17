<?php

class Login

    {
    private $loginVars = array('Username','Password');
    
    public function __construct() {
       
            if(isset($_POST['Login']))
                {
                    $this->logInGetData();
                    
                }
            elseif(isset($_POST['recoverPass']))
            {
                $this->clearUsername();
            }
        ;
    }
    
    public function logInGetData()
    {
        if(empty($_POST['username']) || (empty($_POST['password'])))
        {
            echo "Please check your Username or Log In again.";
        }
        else
        {
            $this->loginVars['Username'] = $_POST['username'];
            $this->loginVars['Password'] = $_POST['password'];
            
            $this->cleanLogIn();
        }
    }


    public function cleanLogIn()
    {
        $this->loginVars['Username'] = clean_input($this->loginVars['Username']);
        $this->loginVars['Password'] = clean_input($this->loginVars['Password']);
        $this->loginVars['Password'] = md5($this->loginVars['Password']);
        
        $this->logInEvent();
    }
    
    public function logInEvent()
    {
        $query = "SELECT * FROM CRCMEMBERS_NEW WHERE member_email = '".$this->loginVars['Username']."' && member_pass = '".$this->loginVars['Password']."' ";

        $result = mysql_query($query);
        $row = mysql_fetch_assoc($result);
        if(mysql_num_rows($result) > 0)
        {
            //session_start();
           $_SESSION['member_id'] = $row['member_id'];
           $_SESSION['member_isadmin'] = $row['member_isadmin'];
           
           echo "<meta http-equiv='refresh' content='0'>";
           
           die();
       }
       
       else 
       {
           echo  "<script> alert('Username/Password combination is invalid')</script>";
           //header('Location: login.php');
           //die();
       }
       
       }
    
      
    private $recoveryLogIn = array('Username', 'Password');
    
    public function clearUsername()
    {
       if(empty($_POST['username']) || empty($_POST['password']))
       {
           echo "Your Username or Password is incorrect, please try again.";
       }
       else
       {
           
           $this->recoveryLogIn['Username'] = $_POST['username'];
           $this->recoveryLogIn['Password'] = $_POST['password'];
           
          
           
           $this->cleanRecover();
       }
    }
    
    public function cleanRecover()
    {
        $this->recoveryLogIn['Username'] = clean_input($this->recoveryLogIn['Username']);
        $this->recoveryLogIn['Password'] = clean_input($this->recoveryLogIn['Password']);
        $this->recoveryLogIn['Password'] = md5($this->recoveryLogIn['Password']);

        
        $this->changePassword();
        
    }
    public function changePassword()
    {
        $query = "SELECT * FROM CRCMEMBERS_NEW WHERE member_email = '".$this->recoveryLogIn['Username']."' ";
        $result = mysql_query($query);
        $row = mysql_fetch_array($result);
        
        if(!empty($row['member_id']))
        {
            mysql_query("UPDATE CRCMEMBERS_NEW SET member_pass = '".$this->recoveryLogIn['Password']."' WHERE member_id = '".$row['member_id']."' ");
            
            $email = new emails();
            $email->recoverPasswordEmail($this->recoveryLogIn['Username']);
            
        }
        else
        {
            echo  "<script> alert('Username/Password combination is invalid')</script>";
        }
    }
    
    public function logout()
    {
        unset($_SESSION['member_id']);
        unset($_SESSION['member_isadmin']);
        unset($_SESSION['login_time']);
        unset($_SESSION['logged_in']);
        
        session_destroy();
    }
}
?>
