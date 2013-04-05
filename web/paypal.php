<?php

if (isset($_POST['amount']))
{
	$amount = $_POST['amount'];
}
if (isset($_POST['loginid']))
{
	$loginid = $_POST['loginid'];
}

$points = $amount * 100;
$pack = $points.' points';

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

	case 'success':      
		// Order was successful...
		// This is where you would probably want to thank the user for their order
		// or what have you.  The order information at this point is in POST
		// variables.  However, you don't want to "process" the order until you
		// get validation from the IPN.  That's where you would have the code to
		// email an admin, update the database with payment status, activate a
		// membership, etc.

		header('Location: http://www.rayku.com/shop');
		break;

	case 'cancel':       // Order was canceled...
		header('Location: http://www.rayku.com/shop/paypal');
		break;

	case 'ipn':          
		// Paypal is calling page for IPN validation...
		// It's important to remember that paypal calling this script.  There
		// is no output here.  This is where you validate the IPN data and if it's
		// valid, update your database to signify that the user has payed.  If
		// you try and use an echo or printf function here it's not going to do you
		// a bit of good.  This is on the "backend".  That is why, by default, the
		// class logs all IPN data to a text file.
			
		if ($p->validate_ipn()) {
			$con = mysql_connect("localhost", "root", "abc123") or die(mysql_error());
			$db = mysql_select_db("rayku_v2", $con) or die(mysql_error());
			
			mysql_query("Update fos_user_user set points=points+".$_GET['points']." Where id=".$_GET['loginid']) or die(mysql_error());
			// For this example, we'll just email ourselves ALL the data.
			$subject = 'Instant Payment Notification - Recieved Payment';
			$to = $notify_email;    //  your email
			$body =  "An instant payment notification was successfully recieved\n";
			$body .= "from ".$p->ipn_data['payer_email']." on ".date('m/d/Y');
			$body .= " at ".date('g:i A')."\n\nDetails:\n";
			
			foreach ($p->ipn_data as $key => $value) {
				$body .= "\n$key: $value";
			}
			mail($to, $subject, $body);
			header("Location: http://www.rayku.com");
		}
		break;
}

?>
