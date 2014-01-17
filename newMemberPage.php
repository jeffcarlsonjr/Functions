<?php
include 'functions/globalClass.php';

$members = new members();

$id = $_GET['id'];

$_SESSION['new_id'] = $id;

$q = mysql_query("SELECT * FROM members WHERE member_id = '".$id."'");
$r = mysql_fetch_assoc($q);

?>
<!DOCTYPE html>
<html>
    <head>
        <title>New Member's Page</title>
        <!--<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">-->
<link href="stylesheet.css" type="text/css" rel="stylesheet"/>
<link href='http://fonts.googleapis.com/css?family=Josefin+Sans:400,600,700,400italic,600italic,700italic' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Cinzel' rel='stylesheet' type='text/css'>
</head>

<body>
    <div id="topBar"></div>
	<div id="wrapper">
        <div id="logo"></div>
        <div class="logotext"><h2>Contemporary Roman Catholics</h2></div>
    	
        <?php include 'nav.php' ?>
        
        <div id="content">
            <div class="contentLeft">
            	<div class="innerLeft">
                    <h2 align="center">Welcome to the CRC <?= $r['member_first']." ".$r['member_last']?></h2>
                        <span style="font-size: 16px; text-align: center;">Please look over your information</span>
                
                        
                        <form method="post">
                            <table width="75%" align="left">
                                <input type="hidden" name="name"/>
                                <tr>
                                    <td class="formtitle">First Name</td>
                                    <td class="formBox"><input type="text" name="fName" value='<?=$r['member_first']?>'/></td>
                                </tr>
                                <tr>
                                    <td class="formtitle">Last Name</td>
                                    <td class="formBox"><input type="text" name="lName" value='<?=$r['member_last']?>'/></td>
                                </tr>
                                <tr>
                                    <td class="formtitle">Email</td>
                                    <td class="formBox"><input type="text" name="email" value='<?=$r['member_email']?>'/></td>
                                </tr>
                                <tr>
                                    <td class="formtitle">Phone Number</td>
                                    <td class="formBox"><input type="text" name="dayphone" value='<?=$r['member_dayphone']?>'/></td>
                                </tr>
                                <tr>
                                    <td class="formtitle">Street</td>
                                    <td class="formBox"><input type="text" name="street" value='<?=$r['member_address']?>'/></td>
                                </tr>
                                <tr>
                                    <td class="formtitle">Apartment</td>
                                    <td class="formBox"><input type="text" name="apt" value='<?=$r['member_apt']?>'/></td>
                                </tr>
                                <tr>
                                    <td class="formtitle">City</td>
                                    <td class="formBox"><input type="text" name="city" value='<?=$r['member_city']?>'/></td>
                                </tr>
                                <tr>
                                    <td class="formtitle">State</td>
                                    <td class="formBox"><input type="text" name="state"  value='<?=$r['member_state']?>'/></td>
                                </tr>
                                <tr>
                                    <td class="formtitle">Zip</td>
                                    <td class="formBox"><input type="text" name="zip" value='<?=$r['member_zip']?>'/></td>
                                </tr>
                                <tr>
                                    <td class="formtitle">Occupation</td>
                                    <td class="formBox"><input type="text" name="occupation" value='<?=$r['member_occupation']?>'/></td>
                                </tr>
                                <tr>
                                    <td class="formtitle">Birthday Day</td>
                                    <td class='formBox'><input type='text' name='birthdate' value='<?= date ('m-d-Y', strtotime($r['member_birthdate']));?>'/></td>
                                </tr>
                                <tr>
                                    <td class="formtitle">Sex</td>
                                    <td class="formBox1" valign="top">
                                        Male &nbsp;<input type="radio" class="radio" name="sex" value="M" <?php if($r['member_sex'] == 'M') echo "checked"?>/>&nbsp;&nbsp;
                                        Female &nbsp;<input type="radio" class="radio" name="sex" value="F" <?php if($r['member_sex'] == 'F') echo "checked"?>/>
                                    
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td class="formtitle">Newsletter</td>
                                    <td class="formBox1" valign="top">
                                        
                                        Yes &nbsp;<input type="radio" class="radio" name="newsletter" value="1" <?php if($r['is_mailed'] == '1') echo "checked"?>/>
                                        &nbsp;&nbsp;
                                        No &nbsp;<input type="radio" class="radio" name="newsletter" value="0" <?php if($r['is_mailed'] == '0') echo "checked"?>/>
                                    
                                    </td>
                                </tr>
                                <tr>
                                    <td><input type="submit" class="confirm" name="updateMember" valu="Submit"/></td>
                                </tr>
                                
                                
                            </table>
                        </form>
                    </div>
            </div>
            <div class="contentRight">
            <?php include 'eventSide.php' ?>
            
            </div>
            
        </div>
    <?php include 'footer.php'?> 
    
</body>

</html>