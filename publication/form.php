<HTML>
<HEAD>

</HEAD>
<BODY>
<?php
require_once( "../include/Vars.php" );
require_once( "../include/Utils-Misc.php" );

$headers  = "From: csep_admin<nobody@arachne2.cns.iit.edu>\r\n";
$headers .= "CC: laas@iit.edu\r\n";
$headers .= "Reply-To: csep@iit.edu\r\n";
$headers .= "Return-Path: csep@iit.edu\r\n";

$db1['host'] = 'arachne.iit.edu';
$db1['user'] = 'csep';
$db1['pass'] = 'ethics12';
$db1['dbName'] = 'csep';

$conn = @mysql_connect($db1['host'], $db1['user'], $db1['pass']);
$db = @mysql_select_db($db1['dbName']);


if(isset($_POST['Submit'])) {
	// First validate the form content. If Incomplete flag is set to 0 then continue else return to old page.
	$incomplete_form=0;
	$incomplete_error="";
	$name = $_POST['realname'];
	$email = $_POST['email'];
	$address =$_POST['Address'];
	$order=$order_list="";
	
	if($email == "") {
			$incomplete_form =1;
        	$incomplete_error= "Email field can not be blank";
	}
	else if(!ereg("^[-A-Za-z0-9_]+[-A-Za-z0-9_.]*[@]{1}[-A-Za-z0-9_]+[-A-Za-z0-9_.]*[.]{1}[A-Za-z]{2,5}$", $_POST['email'])){
	        $incomplete_form =1;
        	$incomplete_error="Email address is not valid.";
        
	} 
	else if ($name == ""){ 
			$incomplete_form =1;
			$incomplete_error= "Name field can not be blank.";
	} 
	else if ($address == ""){ 
			$incomplete_form =1;
			$incomplete_error="Address field can not be blank.";
	}
	else if ($_POST['publications'] == ""){ 
			$incomplete_form =1;
			$incomplete_error="It looks like you did not select any Publication to order. \n Please make your selection for placing the order.";
	}
	else {
			$domain = explode( "@", $email ); //get the domain name 
         
        	if ( !@fsockopen ($domain[1],80,$errno,$errstr,3)) { 
            	//if the connection can be established, the email address is probabley valid 
            	$incomplete_form =1;
        		$incomplete_error="Sorry email could not be sent to this address.";
        } 
	}
	
	if ($incomplete_form==1)
	{
		echo ('<form action="http://ethics.iit.edu/publication/order_error.php" method="POST">
	    <input type="hidden" name="order_error" value="'.$incomplete_error.'">
        </form>');
	} 
	else if ($incomplete_form==0)
	{
	 $error = "0";
		session_start( );

		$confirm_code=md5(uniqid(rand()));
	
		$message="Order Information \n --------------------------------------\n";
		$name = $_POST['realname'];
		$email = $_POST['email'];
		$address =$_POST['Address'];
		$order=$order_list="";
		$i=0;

		foreach($_POST['publications'] as $value) {
    		$order .=  $value."\n";
    		//$order_list .= $order ."\n";
			$i++;
		}
	
		if($conn == false OR $db == false) {
				die("Couldn't connect. <br> #" . mysql_errno() . ' : ' . mysql_error()); 
		} 
		else {
				$sql_order="INSERT INTO csep.temp_orders(confirm_code, name, email, torder, address) VALUES('$confirm_code', '$name', '$email', '$order', '$address')";
				$result=mysql_query($sql_order); //or die("Couldn't connect. <br> #" . mysql_errno() . ' : ' . mysql_error());
				if(!$result)
				$error .= "insert failed in temp_orders";
		}		
	
		$message .= "Name: ".$name. " \n"."Email: ".$email. "\n"."Address: ".$address." \n\n";
		$message .="There are ".$i." items in the order. \n --------------------------------------\n";
		$message .= $order; 
		$message .= "--------------------------------------\n\n";
		$message .= "To complete your order please go to http://ethics.iit.edu/publication/form.php?code=".$confirm_code;
		$message .= "\n\n If you fail to authenticate your order by clicking on the link, your order will not be processed. Please contact csep@iit.edu for any further questions.";
	
		//echo $message;

		$mail_to = $email;
		if (@mail($mail_to, ' New Order Mail', $message,$headers)) { 
 				echo ('<form action="http://ethics.iit.edu/index1.php/Publications/pending order" method="POST">
	   			<input type="hidden" name="order" value="$message">
       		 	</form>');
 				//echo('Mail sent successfully.'); 
		} 
		else { 
 				$error .= "Mail could not be sent."; 
		} 
	
			// clsoe database connection
			$result= mysql_close($conn);
			if(!$result)
			$error .= "database connection (post) not closed ";
	}
} 

else if (isset($_GET["code"]))
{
	$order_code=htmlentities($_GET["code"], ENT_QUOTES);
	$error = "0";
	if($conn == false OR $db == false) {
		die("Couldn't connect. <br> #" . mysql_errno() . ' : ' . mysql_error()); 
	} 
	else {
			$sql="select * from temp_orders where confirm_code='".$order_code."'";
			$result=mysql_query($sql); //or die("Couldn't connect. <br> #" . mysql_errno() . ' : ' . mysql_error());
			if(!$result)
			$error .= "can not select record from temp_orders";

			if(false==($valid_order = mysql_fetch_assoc ($result)))	{
				echo ('<form action="http://ethics.iit.edu/index1.php/Publications/expired order" method="POST">
						    <input type="hidden" name="order" value="$message">
							</form>');
				$error .='This code is wrong or has expired, please fill in the form again \n';
				//echo $error;
			}

			if($error=="0") {
				//**** IF NO ERROR - START
				//$valid_name=$valid_order['name'];
				$result=mysql_query("INSERT INTO confirmed_orders SET name='".$valid_order['name']."',email='".$valid_order['email']."',address='".$valid_order['address']."',order_details='".$valid_order['torder']."',confirmation_code='".$valid_order['confirm_code']."';");
				if(!$result)
					$error .= "can not insert record";
				$result=mysql_query("DELETE FROM temp_orders WHERE confirm_code='".$valid_order['confirm_code']."'");
				if(!$result)
					$error .= "can not delete record";
			}
			
			$result=mysql_query("select id,name,email from confirmed_orders where confirmation_code='".$order_code."';");
			if(!$result)
					$error.= "can not delete record";
			if(($valid_order = mysql_fetch_assoc ($result))) {
					$order_confirmation_message = "Dear ".$valid_order['name'].",\n Thank you for placing an order. Your order number is CSEP-A".$valid_order['id'].". \n Our librarian will contact you soon with the details. \n Please contact csep@iit.edu for any further questions.";
					$mail_to = $valid_order['email'];

					if (@mail($mail_to,'order confirmation email', $order_confirmation_message,$headers)) { 
							echo ('<form action="http://ethics.iit.edu/index1.php/Publications/confirmed order" method="POST">
						    <input type="hidden" name="order" value="$message">
							</form>');
					}
					
			} else { $error .= "error occured during sending conformation email";}
			 		
		
	}
	// Close Database Connection 
	$result= mysql_close($conn);
	if(!$result)
		$error .= "database connection (get) not closed ";
}

else {
	$error .= "Access Denied!! You must have come to this page without clicking the button.\n";
}

?>
<script>document.forms[0].submit( );</script>
</BODY> 
</HTML>