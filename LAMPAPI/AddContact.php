<?php
	$inData = getRequestInfo();

	$firstName = $inData["First_name"];
	$lastName = $inData["Last_name"];
	$phoneNumber = $inData["Phone_num"];
	$email = $inData["email"];
	$userId = $inData["User_ID"];;

	$conn = new mysqli("localhost", "TheCoders", "WeLoveCOP4331", "contacts");
	if ($conn->connect_error)
	{
		returnWithError( $conn->connect_error );
	}
	else
	{
		$stmt = $conn->prepare("INSERT into people (First_name, Last_name, Phone_num, User_ID, email) VALUES(?, ?, ?, ?, ?)");
		$stmt->bind_param("sssss", $firstName, $lastName, $phoneNumber, $userId, $email);
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
