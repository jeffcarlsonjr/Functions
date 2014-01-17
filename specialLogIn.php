<?php 

class DB
{
	private $host, $username, $password, $database;
	
	public function __construct($host,$usename,$password,$database)
	{
            $this->host = $host;
            $this->username = $usename;
            $this->password = $password;
            $this->database = $database;
	}
	
	public function connect()
	{
            $myconnect = mysql_connect($this->host,$this->username,$this->password);
            if(!$myconnect)
                {
                echo mysql_error();

                }


            $dbconnect = mysql_select_db($this->database, $myconnect);
            if(!$dbconnect)
                {
                echo mysql_error();

                }
        }
}



interface post_data {
 
	// Create interface that the main class will rely on
 
	function login_get_data();
	function login_clean_data();
	function login_check_data();
 
	}
abstract class sql_server {
 
        // Class that handles the SQL connection
        
	public $cnx;
	public function __construct() {
		$this -> cnx = mysql_connect('localhost','root','root','348990_ChambersStreet01');
		mysql_select_db('348990_ChambersStreet01', $this -> cnx);
		}
	}

class Logins extends sql_server implements post_data
{
    private $loginVars = array('Username'=>null,'Password'=>null);
    
    public function __construct() {
        parent::__construct();
            if(isset($_POST['Login']))
                {
                    $this->login_get_data();
                    
                }
        ;
    }
    
    public function login_get_data()
    {
        //Giving error i any of the fields are empty
        
        if(empty($_POST['username']) || empty($_POST['password']))
        {
            echo "<script> alert('Make sure that you fill in all the fields')</script>";
            //header('Location: login.php');
        }
        //Else continue
        
        else
        {
            $this->loginVars['Username'] = $_POST['username'];
            $this->loginVars['Password'] = $_POST['password'];
            
            $this->login_clean_data();
        }
    }
    
   public function login_clean_data()
   {
       $this->loginVars['Username'] = mysql_real_escape_string($this->loginVars['Username']);
       $this->loginVars['Password'] = mysql_real_escape_string($this->loginVars['Password']);
       $this->loginVars['Password'] = md5($this->loginVars['Password']);
       
       $this->login_check_data();
       
   }
   
   public function login_check_data()
   {
       $query = mysql_query("SELECT * FROM Login WHERE USERNAME = '".$this->loginVars['Username']."' && PASSWORD = '".$this->loginVars['Password']."' ");
       $row = mysql_fetch_assoc($query);
       if(mysql_num_rows($query) > 0)
       {
           
           session_start();
           $_SESSION['userid'] = $row['userId'];
           
           $_SESSION['username'] = $this->loginVars['Username'];
           $_SESSION['password'] = $this->loginVars['Password'];
           
           header('Location: index.php');
           die();
       }
       
       else 
       {
           echo  "<script> alert('Username/Password combination is invalid')</script>";
           //header('Location: login.php');
           //die();
       }
   }
}

class tools
{
    public function metaRedirect($length,$where)
    {
        echo '<meta http-equiv="refresh" content="'.$length.';url='.$where.'">';
    }
}

?>