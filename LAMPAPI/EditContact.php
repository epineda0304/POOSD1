<?php
	$inData = getRequestInfo();

	$userId = $inData["User_ID"];
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
		#$sql = "SELECT * FROM people WHERE User_ID = " . $userId . " AND ID = " . $conactId;
		#$res = $conn->query($sql);

		$sql = "SELECT * FROM people WHERE User_ID = ? AND ID = ?";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param("ss", $userId, $conactId);
		$stmt->execute();

		$result = $stmt->get_result();

		if( $result->num_rows == 0)
		{
			returnWithError( "This contact does not exist for this user." );
		}
		else
		{
			$sql = "UPDATE people SET First_name = ?, Last_name = ?, email = ?, Phone_num = ?
				WHERE User_ID = ? AND ID = ?";
			$stmt = $conn->prepare($sql);
			$stmt->bind_param("ssssss", $firstName, $lastName, $email, $phoneNumber, $userId, $conactId);
			$stmt->execute();
			returnWithError("");
		}

		$stmt->close();
		$conn->close();
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
