<?php
  /**
	* PHP NuSOAP client script example
	* ==============================================================================
	* 
	* @version v1.0: nusoap_api_client.php 2016/02/03
	* @copyright Copyright (c) 2016 Sagar Deshmukh
	* @author Sagar Deshmukh <sagarsdeshmukh91@gmail.com>
	* 
	* ==============================================================================
    *
	*/

	require_once('lib/nusoap.php');

	$wsdl   = "<webservice_url>?wsdl"; // SOAP Webservice Url ex. http://www.domain_name.com/nusoap_api.php?wsdl

	$client = new nusoap_client($wsdl, 'wsdl');
	
	// Input params
	if (isset($_POST['submit']))
	{
		$username = $_POST['username'];
		$password = $_POST['password'];
		$json 	  = $_POST['json'];
	}
	else
	{
		$username = "WS_USERNAME";
		$password = "WS_PASSWORD";
		$json	  = '{"name":"Ajay","dept":"sales","address":"Nashik","birthdate":"24/04/1991"}';
	}
	// EOF Input params
	
	$client->setCredentials($username, $password);  // Webservice credential
    $error = $client->getError();
	
	if ($error)
	{
		echo $error; die();
	}
	
	$action = "add_user"; // Webservice methode name
	
	$result = array();

	if (isset($action))
	{
		$data["json"] = $json;
		$result['response'] = $client->call($action, $data);
	}
	
	// Display webservice details
	echo "<h1>SOAP Web Service Client</h1>";
	echo "<h3>Web service URL : ".str_replace("?wsdl","",$wsdl)."</h3>";
	echo "<h3>Operation Name : </h3>".$action;
	echo "<form action=\"\" method=\"post\" >";
	echo "<h3>Webservice Credentials : </h3>";
	echo "Username : ";
	echo "<input type=\"text\" style=\"width:200px;\" name=\"username\" value=\"WS_USERNAME\">";
	echo "<br>";
	echo "Password : ";
	echo "<input type=\"text\" style=\"width:200px;\" name=\"password\" value=\"WS_PASSWORD\">";
	
	echo "<h3>Input Parameter : </h3>";
	echo "<table> <tr><td>json = </td><td><textarea name=\"json\" rows='6' cols='100'>".$json."</textarea></td></tr></table>";
	
	echo "<input type=\"submit\" name=\"submit\" value=\"Invoke\">";
	echo "<br>";
	echo "<h3>Output : </h3>";
	echo $result['response'];
	echo "<br><br>";
	echo "<form>";
	echo "-------------------------------------------------------------------------";
	echo "-------------------------------------------------------------------------";
	echo "<h2>Request</h2>";
	echo "<pre>" . htmlspecialchars($client->request, ENT_QUOTES) . "</pre>";
	echo "<h2>Response</h2>";
	echo "<pre>" . htmlspecialchars($client->response, ENT_QUOTES) . "</pre>";
?>