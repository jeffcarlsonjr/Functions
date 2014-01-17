<?php

class events
{
    protected $crud;
    
    public function __construct() {
        $this->crud = new CRUD();
    }
    
    public function eventName($id)
    {
       
        $row = $this->crud->select('CRCEVENTS', 'event_ID = '.$id);
        echo "<div class='innerLeft'>";
        echo "<form method='POST'>";
        echo "<input type='hidden' name='event_id' value='$id'/>";
        echo "<div class='eventTitle'>Name</div> ";
        echo "<div class='eventDescription'>".$row['event_name']."</div>";
        echo "<div class='eventTitle'>Date</div>";
        echo "<div class='eventDescription'>".date('M-d-Y',  strtotime($row['event_date']))."</div>";
        echo "<div class='eventTitle'>Event</div>";
        echo "<div class='eventDescription'>".$row['event_description']."</div>";
        echo "<div class='eventTitle'>Cost </div> ";
        echo "<div class='eventDescription'> $".$row['event_cost']."</div>";
        echo "<div class='eventTitle'>Place</div> ";
        echo "<div class='eventDescription'>".$row['event_place']."</div>";
        echo "<div class='eventTitle'>Address</div> ";
        echo "<div class='eventDescription'>".$row['event_address']."</div>";
        echo "<div class='eventTitle'>How Many: <input type='text' name='quantity' class='quantity'/></div>";
        echo "<div class='eventTitle'><input type='submit' class='confirm' name='addEvent' value='Confirm'/></div>";
        echo "</form>";
        echo "</div>";
        
        session_start();
        $_SESSION['event_ID'] = $row['event_ID'];
        
        
    }
    
    public function eventLogin()
    {
        echo   '<div class="innerLeft">
                    <form method="post">
                        <div class="logIn">
                            <h2 algin="center">CRC Event Log In<br/>
                            <span style="font-size: 16px;">To sign up for an event, please log in first.</span></h2>
                            <div class="logInTitle">Email Address:</div>
                            <div class="logInTextBox"><input type="text" name="username" placeholder="Email address"/></div>
                            <div class="logInTitle">Password:</div>
                            <div class="logInTextBox"><input type="Password" name="password" placeholder="Password"/></div>
                            <div><input type="submit" class="submit" name="Login" value="Log In"/></div>
                    </form> 
                            <p></p>
                            <div class="logInTitle">Not a member? <a href="./HowToBeInvolved.php">Sign Up Now</a></div>
                            <div class="logInTitle">Forgot your password?  <a href="./forgotPassword.php">Click Here</a></div>
                            <div class="logInTitle">Return To Homepage <a href="./index.php">Home</a></div>
                        </div>

                </div>';
        
    }
    
    public function memberEvent($data, $table)
    {
                       
        $this->crud->insert($data, $table);
        
         echo '<meta http-equiv="refresh" content="0;url=eventSignUpConfirm.php">';
        
        
        
    }
    
    public function displayTodayEvents()
    {
        $inc = 0;
        $date = date('Y-m-d');
        $result = $this->crud->multiSelect('CRCEVENTS', 'event_date = "'.$date.'" ');
        while($row = mysql_fetch_assoc($result))
        {
            $inc++;
            echo "<div class='eventName'>".$inc.") ".$row['event_name']."</div>";
        }
    }
    
    public function displayMetaDescription($id)
    {
        $result = $this->crud->select('CRCEVENTS', 'event_ID = '.$id);
        
    echo "Contemporary Roman Catholic Young Adults or CRC will be holding our event".$result['event_name']." on ".date('d-M-Y',strtotime($result['event_date'])).". Please feel free to join us. ";
    } 
    
    public function eventConfirms()
    {
        echo "<table width='90%' cellpadding='3' cellspacing='3' align='left'>";
        
        $result = $this->crud->multiSelect('CRCEVENTS','event_date >= NOW()');
        while ($row = mysql_fetch_assoc($result)){
            $resultJoin = $this->crud->multiSelect('CRCMEMBERSEVENTS', 'event_id = '.$row['event_ID']);
            $rowJoin = mysql_fetch_assoc($resultJoin);
            if(!empty($rowJoin['event_id']))
            {
            echo "<tr>";
            echo "<td colspan='6'><h2>".$row['event_name']."</h2></td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td></td>";
            echo "<td><b>Name</b></td>";
            echo "<td><b>Email</b></td>";
            echo "<td><b>Quantity</b></td>";
            echo "<td><b>Pay Method</b></td>";
            echo "<td><b>Pay Status</b></td>";
            echo "</tr>";

            $i = 0;
            $q = $this->crud->multiSelect('CRCMEMBERSEVENTS','event_id = '.$row['event_ID']);
            while($row1 = mysql_fetch_assoc($q))
            {   

                $i++;
                $q2 = mysql_query("SELECT CRCMEMBERS_NEW.member_id, CRCMEMBERS_NEW.member_first, CRCMEMBERS_NEW.member_last, CRCMEMBERS_NEW.member_email, CRCMEMBERSEVENTS.confirm_id, CRCMEMBERSEVENTS.member_id, CRCMEMBERSEVENTS.quantity,CRCMEMBERSEVENTS.payment_method,CRCMEMBERSEVENTS.payment_status FROM CRCMEMBERS_NEW INNER JOIN CRCMEMBERSEVENTS ON CRCMEMBERS_NEW.member_id = CRCMEMBERSEVENTS.member_id WHERE CRCMEMBERSEVENTS.confirm_id = '".$row1['confirm_id']."' ");
                $row3 = mysql_fetch_array($q2);
                
                echo "<tr>";
                echo "<td>".$i.") </td>";
                echo "<td>".$row3['member_first']." ".$row3['member_last']."</td>";
                echo "<td>".$row3['member_email']."</td>";
                echo "<td>".$row3['quantity']."</td>";
                echo "<td>".$row3['payment_method']."</td>";
                echo "<td>".$row3['payment_status']."</td>";
                echo "</tr>";

            }


        }}
        echo "</table>";
        
    }
}

   

//==============================================================================

class eventPayment extends events
{
    protected $eventResult;
    protected $memberResult;
    protected $confirmed;
    protected $crud;
    
    public function __construct($event_id, $member_id) {
        $this->crud = new CRUD();
        $this->eventResult = $this->crud->select('CRCEVENTS', 'event_ID = '. $event_id);
        $this->memberResult = $this->crud->select('CRCMEMBERS_NEW', 'member_id = '.$member_id);
        $this->confirmed = $this->crud->select('CRCMEMBERSEVENTS','event_id = '.$event_id.' && member_id = '.$member_id );
        parent::__construct();
    }
    
    public function eventConfirmed()
    {
        echo '<p><strong>'.$this->memberResult['member_first'].' '.$this->memberResult['member_last'].'</strong>, you have been confirmed for the following event:</p><br/>
                
        <div class="eventTitle">Name:</div> 
        <div class="eventDescription">'.$this->eventResult['event_name'].'</div>
        <div class="eventTitle">Date:</div> 
        <div class="eventDescription">'.date('M-d-Y',strtotime($this->eventResult['event_date'])).'</div> 
        <div class="eventTitle">Time:</div>
        <div class="eventDescription">'.$this->eventResult['event_time'].'</div> 
        <div class="eventTitle">Event:</div>
        <div class="eventDescription">'.$this->eventResult['event_description'].'</div> 
        <div class="eventTitle">Cost:</div> 
        <div class="eventDescription">$'.$this->eventResult['event_cost'].'</div> 
        <div class="eventTitle">Place:</div>
        <div class="eventDescription">'.$this->eventResult['event_place'].'</div> 
        <div class="eventTitle">Address:</div> 
        <div class="eventDescription">'.$this->eventResult['event_address'].', '.$this->eventResult['event_city'].', '.$this->eventResult['event_state'].'</div>';
        
        if($this->eventResult['event_cost'] != '0'){ $this->payPal(); }
    }
    

    protected function payPal()
    {
        $cost = ($this->confirmed['quantity'] * $this->eventResult['event_cost']);
        
        echo '<p>With the Quantity of ' .$this->confirmed['quantity']. ' your total cost is $'.$cost.' </p> 
            <h3>Payment Methods:</h3>
            <p>Payments are non-refundable within 14 days of an event, unless otherwise specified.</p>
            <p>You can pay by PayPal or by check.  To pay by PayPal, click on the button below -- it will cost 3.4% more to pay by PayPal to cover their processing fee. </p> 
            <p>Otherwise, to pay by check, make your check payable to CRC, c/o Holy Trinity Church, 213 West 82nd St., NY, NY 10024. Your spot will be reserved once your check is received.</p>
            <div>           

            <form name="_xclick" action="https://www.paypal.com/cgi-bin/webscr" method="post">
                <input type="hidden" name="cmd" value="_xclick">
                <input type="hidden" name="business" value="crchtc@yahoo.com">
                <input type="hidden" name="item_name" value="'.$this->eventResult['event_name'].'">
                <input type="hidden" name="amount" value="'.$cost.'">
                <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" class="payPal"border="0" name="submit" alt="Make payments with PayPal - it is fast, free and secure!">
            </form>
            </div> ';
    }
}

?>


