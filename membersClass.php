<?
require_once 'crudClass.php';
require_once 'emailsClass.php';

class members
{

    public function checkUsernameExists($email)
    {
        $result = mysql_query("SELECT * FROM CRCMEMBERS_NEW WHERE member_email = '".$email."' ") ;
//         echo $result; die;
        if(mysql_num_rows($result) == 0)
        {
            return false;
        }
        else
        {
            return true;
        }
    }
    
    public function insertMember($data, $table)
    {
        $crud = new CRUD();
        
        $crud->insert($data, $table);
        
        $new_id = mysql_insert_id();
        
        session_start();
        
        $_SESSION['new_id'] = $new_id;
        
        $hashID = md5($new_id);
        
        mysql_query("UPDATE CRCMEMBERS_NEW SET hashID = '".$hashID."' WHERE member_id = '".$new_id."' ");
        
        $email = new emails();

        $email->memberEmail('CRCMEMBERS_NEW', 'member_id = "'.$_SESSION['new_id'].'"');

        $email->webMasterEmail('CRCMEMBERS_NEW', 'member_id = "'.$_SESSION['new_id'].'"');

        echo '<meta http-equiv="refresh" content="0;url=newMemberPage.php">';
    }
    
    public function updateMember($data, $table, $where)
    {
         $crud = new CRUD();
         $crud->update($data, $table, $where);
        
        
        echo '<meta http-equiv="refresh" content="0;url=index.php">';
    }
    
    public function firstName($table, $where)
    {
        $crud = new CRUD();
        $row = $crud->select($table, $where);
        
        return $row['member_first'];
    }
    
    public function newMembersDisplay()
    {
        $i = 0;
        $crud = new CRUD();
        $result = $crud->multiSelect('CRCMEMBERS_NEW', 'is_approved = 0');
        while($row =  mysql_fetch_assoc($result))
        {

            $i++;
            echo $i.". <a href='updateMembers.php?id=".$row['member_id']."'>". $row['member_first']." ".$row['member_last']."</a><br/>";
            if(empty($row['member_id']))
            {
                echo "<h4>Everyone is up to date</h4>";
            }
        }
    }
    
    public function deleteMember($table,$where)
    {
        $crud = new CRUD;
        $crud->delete($table, $where);
        echo 'hello world';
        echo '<meta http-equiv="refresh" content="0;url=updateMembers.php">';
    }
    
}
?>