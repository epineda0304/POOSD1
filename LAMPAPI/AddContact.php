<?php
	$inData = getRequestInfo();

	$firstName = $inData["first name"];
	$lastName = $inData["last name"];
	$phoneNumber = $indata["(xxx)xxx-xxx"];
	$email = $email["email@sample.com"];
	$userId = $inData["userId"];

	$conn = new mysqli("localhost", "TheCoders", "WeLoveCOP4331", "contacts");
	if ($conn->connect_error)
	{
		returnWithError( $conn->connect_error );
	}
	else
	{
		$stmt = $conn->prepare("INSERT into contacts (UserId, firstname, lastname, phoneNumber, email) VALUES(?, ?, ?, ?, ?)");
		$stmt->bind_param("sssss", $userId, $firstName, $lastName, $phoneNumber, $email);
		$stmt->execute();
		$stmt->close();
		$conn->close();
		returnWithError("");
	}

	function getRequestInfo()
	{
		return json_decode(file_get_contents('php://input'), true);
	}

	function sendResultInfoAsJson( $obj )
	{
		header('Content-type: application/json');
		echo $obj;
	}

	function returnWithError( $err )
	{
		$retValue = '{"error":"' . $err . '"}';
		sendResultInfoAsJson( $retValue );
	}

?>
