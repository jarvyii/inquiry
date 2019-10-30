<?php
/**
 * Class.ErrorHandler.php
 *
 *
 *
 * 
 * @link        /PHP/FLEX/class/Class.ErrorHandler.php
 * @category    MIA Systems
 * @copyright   Copyright (c) 2019 Mini-MAX Information Systems
 * @author      Jess Speed
 * 
 */
class ErrorHandler
{
	public $today, $date, $dateError, $dateErrorRan, 
					$response, $sendAlert, $timeStamp, $timeStamp2,
					$debug, $error;
	protected $e, $data;
	private $config;
	/////////////////////////////////////////////////////////////////////////
	function __construct( $handle='log', $e=false, $data=array(), $sendAlert=false )
	{
		$this->handler 		= ( strtoupper( $handle ) === 'EMAIL' ? 'EMAIL' : 'LOG' ); // Defaults to Logging errors
		$this->e 					= $e;    // Exception thrown
		$this->data 			= $data; // Could be a full class dump object
		$this->sendAlert 	= ( is_bool( $sendAlert ) && $sendAlert === true ? true : false ); // Defaults to false
		$this->debug 			= array();
		$this->error 			= false;
		$this->config();
		$this->handler();
	}
	/////////////////////////////////////////////////////////////////////////
	private function config()
	{ 
	/**
		* Setup to allow future control and expanding options for types of Error Alerts
		*
		* @param "EMAIL" - Currently not setup to Email
		*
		*/
		$this->config = [
											// Options
											"Options" => 	[
																		// Error Log Setup 
																			"LOG" =>  [ 
																									"Active" 	=> true,
																									"LOC" 		=> "/PHP/ErrorLog/",// Location of the ErrorLogs on IFS
																								],
																		// Email Alert setup
																			"EMAIL" =>  [ 
																										"Active" 	=> false,
																										"LOC" 		=> "/PHP/library/assets/PHPMailer/PHPMailerAutoload.php", // Location of the Mailer Class on IFS
																										"NOREPLY" 		=> "", // Default no reply email
																										"EMAIL_ADDR" 	=> "", // Default Email Address
																									]  
																		]
										];// End Configuration	


		$this->today = date( "l jS \of F Y h:i:s A", time() );
		$this->date = $this->today;
		$this->dateError = date_create();
		$this->dateErrorRan = date_format( $this->dateError,"m/d/Y" );	

    $msg =  'There was an Error with the Server. Server Error: ';
    $this->response['STMT'][0] = $this->data;
    $this->response['msg'] = 'ERROR';
    $this->response['ERROR'] = $msg . $this->e;  
      
    $this->debug['msg'] = 'ERROR';
    $this->debug['DEBUG']["ERROR"] = $msg . $this->e;

		$this->debug["DEBUG"][] = "\n\nConfiguration Setup"; 
		return;
    ///////////////////////////////////////////////////////////////////////
	}
	/////////////////////////////////////////////////////////////////////////
	private function handler()
	{ 
		// Check if Error is to be emailed as an Alert
		if ( $this->handler === "EMAIL" && $this->sendAlert && $this->config[ "Options" ][ "EMAIL" ][ "Active" ] ) 
		{
			if ( $this->emailError() ) $this->debug["DEBUG"][] = "\n\nError handler Completed"; 
			else  { $this->error = true; $this->debug["ERROR"][] = "\n\nError returned while attempting to email error. Please check your configuration and/or email address"; }
		}
		
		// Check if Logging error is setup
		if ( $this->config[ "Options" ][ "LOG" ][ "Active" ] )
		{
			if ( $this->logError( $this->data ) ) $this->debug["DEBUG"][] = "\n\nError handler Completed"; 
			else  { $this->error = true; $this->debug["ERROR"][] = "\n\nError returned while attempting to log error."; }
		} 

		$this->debug["DEBUG"][] = "\n\nError handler Completed"; 
		return;
    ///////////////////////////////////////////////////////////////////////
	}
	/////////////////////////////////////////////////////////////////////////
	private function emailError()
	{ 
		if (!class_exists('PHPMailerAutoload'))  require_once '/PHP/library/assets/PHPMailer/PHPMailerAutoload.php';
		/*********************************************************************/
		/************** Sent Email To MIA to inform results ******************/
		/*********************************************************************/
		$this->debug["DEBUG"][] = "\n\nEmailing Error handler Started."; 

		//Create a new PHPMailer instance
		$mail = new PHPMailer;

		$mail->IsSMTP();  
		//Set who the message is to be sent from
		$mail->setFrom( $this->config[ "Options" ][ "EMAIL" ][ "NOREPLY" ], "No Reply");

		$html='';
		$altBody='';
		/*********************************************************************/
		/*********************************************************************/
		$mail->addAddress( $this->config[ "Options" ][ "EMAIL" ][ "EMAIL_ADDR" ], ' ');

		// Try sending email
		try 
		{
		/*********************************************************************/
		/*********************************************************************/
		//Set the subject line
			$mail->Subject = 'Program Error Message | From: ' . 
									basename( $_SERVER["SCRIPT_FILENAME"], '.php') . 
										'.php | On: ' . $this->dateCheckRan;
			//Read an HTML message body from an external file, convert referenced images to embedded,
			//convert HTML into a basic plain-text alternative body
			$mail->isHTML(true); // Set email format to HTML

			$bodyHtml = "<br> There was an error reported on program run \n <br> Error occured on: ". 
					$date .
				" \n <br> Full Response from script: \n <br>". '';

			if ( !isset($this->response) ) $bodyHtml .= "\n <br> <b> No data was set for a response. Please check logic flow to build response to email. </b>";
			// if not set alert and skip html body build
			else 
			{
			// Response is set sift through to grab important error data 
				if (isset( $this->response['ERROR']) && $this->response['ERROR'] !== '' )  $bodyHtml .= "\n<br><br><b> Server Error Message: </b><br><br>" . $this->response['ERROR'];

				if (isset( $this->response['log'] ) && $this->response['log'] !== '' ) $bodyHtml .= "\n<br><br> <b> Log: </b><br>" . implode(',<br><br> ', $this->response['log']);

				if (isset( $this->response['USER'] ) ) 
				{
					$bodyHtml .= "\n<br><br> <b> Created by User: </b><br>". $this->response['USER'];
					$bodyHtml .= "\n<br><br> <b> User Ip: </b><br>". $GLOBALS['_SERVER']['REMOTE_ADDR'];
				}
				if (isset( $this->response['STMT'] ) &&  $this->response['STMT'] !== ''  )  $bodyHtml .= "\n<br><br> <b> SQL STMT Calls & Data Recieved: </b><br>" . implode(',<br><br> ', $this->response['STMT']);
				$trace = generateCallTrace();
				$this->response['Call_Trace'] = $trace;
				$bodyHtml .= "\n<br><br> <b> Call Stack Trace: </b><br>$trace";
			}

			$mail->Body = $bodyHtml;
			                  // . $debug;
			$altBody = "Full Response from script: \n<br>". json_encode( $this->response, JSON_PRETTY_PRINT ); 

			$mail->AltBody = $altBody;

		//send the message
			//Note that we don't need check the response from this because it will throw an exception if it has trouble
			if ( !$mail->send() )  echo json_encode( $this->response, JSON_PRETTY_PRINT ); // mail didn't sent echo data for spoolfile
		/*********************************************************************/
		/************************* Error handling ****************************/
		/*********************************************************************/
		} 
		catch ( phpmailerException $e ) 
		{
		  $this->debug['DevAlert'][0] = $e->errorMessage(); //Pretty error messages from PHPMailer
		  echo json_encode( $this, JSON_PRETTY_PRINT );
		} 
		catch (Exception $e) 
		{
		  $this->debug['DevAlert'][1] = $e->getMessage(); //Boring error messages from anything else!
		  echo json_encode( $this, JSON_PRETTY_PRINT );
		}  

		return true;
    ///////////////////////////////////////////////////////////////////////
	}
	/////////////////////////////////////////////////////////////////////////
	protected function generateCallTrace()
	{
    $e = new Exception();
    $trace = explode("\n", $e->getTraceAsString());
    // reverse array to make steps line up chronologically
    $trace = array_reverse($trace);
    array_shift($trace); // remove {main}
    array_pop($trace); // remove call to this method
    $length = count($trace);
    $result = array();
    
    for ($i = 0; $i < $length; $i++)
    {
      $result[] = ($i + 1)  . ')' . substr($trace[$i], strpos($trace[$i], ' ')); 
    }
    
    return "\t" . implode("\n<br>\t", $result);
	}
	/////////////////////////////////////////////////////////////////////////  
  protected function logError( $log )
  {
  // create debug dump and alert
    $this->timeStamp = date("mdY_His");
    $this->timeStamp2 = date("m/d/Y H:i:s A");
    ///////////////////////////////////////////////////////////////////////
    $filename = $this->timeStamp . '_ERROR_'.basename( $_SERVER["SCRIPT_FILENAME"], '.php' ).'.txt';
    $dir = $this->config[ "Options" ][ "LOG" ][ "LOC" ] . $filename;
    file_put_contents ( $dir , 'Program Dump: ' . json_encode( $log, JSON_PRETTY_PRINT ) . "\r\n", FILE_APPEND );
    $error = "\n\n".'Program Error Message | From: ' .  basename( $_SERVER["SCRIPT_FILENAME"], '.php') .  '.php | On: ' . $this->timeStamp2. "\n\n";
    file_put_contents ( $dir , $error . "\r\n", FILE_APPEND );
    ///////////////////////////////////////////////////////////////////////
  } 
  /////////////////////////////////////////////////////////////////////////
}
?>