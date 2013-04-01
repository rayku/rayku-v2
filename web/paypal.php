<?php

if (isset($_POST['pack']))
{
	$pack = $_POST['pack'];
}


if (isset($_POST['amount']))
{
	$amount = $_POST['amount'];
}

if (isset($_POST['loginid']))
{
	$loginid = $_POST['loginid'];
}
	
if (isset($_POST['points']))
{
	$points = $_POST['points'];
}



			$con = mysql_connect("db1.p.rayku.com", "rayku_db", "UthmCRtaum34qpGL") or die(mysql_error());
			$db = mysql_select_db("rayku_db", $con) or die(mysql_error());



$notify_email = 'admin@rayku.com';

$paypal_email = 'admin@rayku.com';



$amount = number_format($amount,2);



//----------------------------------------------------------------------------
// Setup class
require_once('paypal.class.php');  // include the class file
$p = new paypal_class;             // initiate an instance of the class

//$p->paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';   // testing paypal url
$p->paypal_url = 'https://www.paypal.com/cgi-bin/webscr';     // paypal url
            
// setup a variable for this script (ie: 'http://www.micahcarrick.com/paypal.php')
$this_script = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];

//getting ID
$cid=mysql_insert_id();

// if there is not action variable, set the default action of 'process'
if (empty($_GET['action'])) $_GET['action'] = 'process';  

switch ($_GET['action']) {
    
   case 'process':      // Process and order...

      // There should be no output at this point.  To process the POST data,
      // the submit_paypal_post() function will output all the HTML tags which
      // contains a FORM which is submited instantaneously using the BODY onload
      // attribute.  In other words, don't echo or printf anything when you're
      // going to be calling the submit_paypal_post() function.
 
      // This is where you would have your form validation  and all that jazz.
      // You would take your POST vars and load them into the class like below,
      // only using the POST values instead of constant string expressions.
 
      // For example, after ensureing all the POST variables from your custom
      // order form are valid, you might have:
      //
      // $p->add_field('first_name', $_POST['first_name']);
      // $p->add_field('last_name', $_POST['last_name']);
      
      $p->add_field('business', $paypal_email);             //Give here your email id
      $p->add_field('currency_code','CAD');
      $p->add_field('return', $this_script.'?action=success');
      $p->add_field('cancel_return', $this_script.'?action=cancel');
      $p->add_field('notify_url', $this_script.'?action=ipn&loginid='.$loginid.'&points='.$points);         
      $p->add_field('item_name', "Item Name: ".$pack);
      $p->add_field('amount', $amount);                                 //Amount for Signup   

      $p->submit_paypal_post(); // submit the fields to paypal
    //$p->dump_fields();      // for debugging, output a table of all the fields
      break;
      
   case 'success':      // Order was successful...
   
      // This is where you would probably want to thank the user for their order
      // or what have you.  The order information at this point is in POST 
      // variables.  However, you don't want to "process" the order until you
      // get validation from the IPN.  That's where you would have the code to
      // email an admin, update the database with payment status, activate a
      // membership, etc.  
 	  
	 // header('Location: http://www.adslang.com/index.php?mode=successadvertiserpayment');		
	 
	  
	  
	  header('Location: http://www.rayku.com/shop');		
	  //mysql_query("Update ".$table_prefix."clients set ispaid=1 Where clientid=".$_GET['cid']) or die("Something is wrong in cid");	
           
      // You could also simply re-direct them to another page, or your own 
      // order status page which presents the user with the status of their
      // order based on a database (which can be modified with the IPN code 
      // below).
      
      break;
      
   case 'cancel':       // Order was canceled...

 
      header('Location: http://www.rayku.com/shop/paypal');
      
      break;
      
   case 'ipn':          // Paypal is calling page for IPN validation...
   
      // It's important to remember that paypal calling this script.  There
      // is no output here.  This is where you validate the IPN data and if it's
      // valid, update your database to signify that the user has payed.  If
      // you try and use an echo or printf function here it's not going to do you
      // a bit of good.  This is on the "backend".  That is why, by default, the
      // class logs all IPN data to a text file.
     
      if ($p->validate_ipn()) {
	  
			$con = mysql_connect("db1.p.rayku.com", "rayku_db", "UthmCRtaum34qpGL") or die(mysql_error());

			$db = mysql_select_db("rayku_db", $con) or die(mysql_error());
	  
	  mysql_query("Update user set points=".$_GET['points']." Where id=".$_GET['loginid']) or die(mysql_error());
	  
  
         // For this example, we'll just email ourselves ALL the data.
         $subject = 'Instant Payment Notification - Recieved Payment';
         $to = $notify_email;    //  your email
         $body =  "An instant payment notification was successfully recieved\n";
         $body .= "from ".$p->ipn_data['payer_email']." on ".date('m/d/Y');
         $body .= " at ".date('g:i A')."\n\nDetails:\n";
         
         foreach ($p->ipn_data as $key => $value) { $body .= "\n$key: $value"; }
         mail($to, $subject, $body);
		 header("Location: http://www.rayku.com");
      }
      break;
 }     

?>
