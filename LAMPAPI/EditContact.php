<?php
	$inData = getRequestInfo();

	$firstName = $inData["First_name"];
	$lastName = $inData["Last_name"];
	$phoneNumber = $inData["Phone_num"];
	$email = $inData["email"];
	$conactId = $inData["ID"];

	$conn = new mysqli("localhost", "TheCoders", "WeLoveCOP4331", "contacts");
	if ($conn->connect_error)
	{
		returnWithError( $conn->connect_error );
	}
	else
	{
		$sql = "UPDATE people SET First_name = ?, Last_name = ?, Phone_num = ?, email = ? WHERE ID = ?";
		$stmt = $conn->prepare($sql);
		$stmt = bind_param("sssss", $firstName, $lastName, $phoneNumber, $emai, $conactId);
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
