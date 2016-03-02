<?php
/**
 * PHP NuSOAP API script example
 * ==============================================================================
 * 
 * @version v1.0: nusoap_api.php 2016/02/03
 * @copyright Copyright (c) 2016 Sagar Deshmukh
 * @author Sagar Deshmukh <sagarsdeshmukh91@gmail.com>
 * 
 * ==============================================================================
 *
 */

require_once("lib/nusoap.php");

// WSDL configuration
$server = new soap_server();
$server->configureWSDL('SOAP webservice API', "<webservice_url>"); // SOAP Webservice Url ex. http://www.domain_name.com/nusoap_api.php
$server->wsdl->schemaTargetNamespace = "<webservice_url>"; // SOAP Webservice Url
// eof WSDL configuration

// Web service methode initialization
$server->register('add_user', array('json'=>'xsd:string'),array('return' => 'xsd:string'),$ns);

/**
	* Add user in database
	* @param  string    
	* @return string
*/
function add_user($json)
{
	$result = array();
	$errors = array();

	if (validate_user())
	{
		// Input params
		$data =  convert_json_to_array($json);
		
		// Webservice bussness logic here
		
		$result  = array('message' => "Record added successfully");
	}
	else
	{
		$errors[] = 'User authentication failed!';
	}
	
	$result_array = array();
	$result_array['error']  = $errors;
	$result_array['result'] = $result;
	
	return json_encode($result_array);
}

/**
	* User request validation
*/
function validate_user()
{
	if($_SERVER['PHP_AUTH_USER'] == "WS_USERNAME" && $_SERVER['PHP_AUTH_PW'] == "WS_PASSWORD")  // Web service username and password validation
	{
		return true;
	}
	else
	{
		return false;
	}
}

/**
	* Convert json to array 
*/
function convert_json_to_array($json)
{		 
	return json_decode($json,true);
} 

if (!isset($HTTP_RAW_POST_DATA))
	$HTTP_RAW_POST_DATA = file_get_contents( 'php://input' );
	
$server->service($HTTP_RAW_POST_DATA);
?>