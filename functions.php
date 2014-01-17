<?php

class db
{
    
    public function connect()
    {
        $connect = mysql_connect('68.178.141.18','crcnyc','West82213!');
            if($connect){
                mysql_select_db('crcnyc');
            }else{
                echo "Connection Failed";
            }
    }
    
    
}
    

function clean_input($text)
    {
        $text = stripslashes($text);
        $text = mysql_real_escape_string($text);
    
        return $text;
    }

//==============================================================================
function today_date(){
     
    $todaydate = date('d-m-Y');
    
    return $todaydate;
}
//==============================================================================
function findMember(){
    
    if(isset($_POST['findPeople'])){
        
        $search = $_POST['search'];
        
        $query = "SELECT * FROM CRCMEMBERS_NEW WHERE memeber_first LIKE %'".$search."'% OR member_last LIKE %'".$search."'% OR member_email LIKE %'".$search."'%";
        $result = mysql_query($query);
        
        return $result;
    }
}
//==============================================================================
function findAdminByName($id){
    
    $query = "SELECT * FROM CRCMEMBERS_NEW WHERE member_id = '".$id."' ";
    $result = mysql_query($query);
    $row = mysql_fetch_assoc($result);
    $first_name = $row['member_first'];
    
    echo $first_name;
}
//==============================================================================
function emailSent($id){
    
    $query = "UPDATE CRCMEMBERS_NEW SET lastmailsent = NOW() WHERE member_id = '".$id."' ";
    mysql_query($query);
}



?>
