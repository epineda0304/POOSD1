<?php

	$inData = getRequestInfo();

	$searchResults = "";
	$searchCount = 0;

	$conn = new mysqli("localhost", "TheCoders", "WeLoveCOP4331", "contacts");
	if ($conn->connect_error)
	{
		returnWithError( $conn->connect_error );
	}
	else
	{
		$sql = "SELECT * FROM people WHERE (First_name like ? or Last_name like ?) and User_ID = ? ORDER BY First_name, Last_name";
		$stmt = $conn->prepare($sql);
		$fname = "%" . $inData["search"] . "%";
		$lname = "%" . $inData["search"] . "%";
		$stmt->bind_param("sss", $fname, $lname, $inData["User_ID"]);
		$stmt->execute();

		$result = $stmt->get_result();

		while( $row = $result->fetch_assoc() )
		{
			if( $searchCount > 0 )
			{
				$searchResults .= ",";
			}
			$searchCount++;
			#$searchResults .= '"' . 'ID: ' . $row["ID"] .
			#												' | First Name: ' . $row["First_name"] .
			#												' | Last Name: ' . $row["Last_name"] .
			#												' | Phone Number: ' . $row["Phone_num"] .
			#												' | Email: ' .	$row["email"] .
			#												' | Associated User ID: ' . $row["User_ID"] . '"';

			$tojson = array("ID"=>$row["ID"],
										"First_name"=>$row["First_name"],
										"Last_name"=>$row["Last_name"],
										"Email"=>$row["email"],
										"Phone_num"=>$row["Phone_num"],
										"User_ID"=>$row["User_ID"]);

			$searchResults .= json_encode($tojson);
		}

		if( $searchCount == 0 )
		{
			returnWithError( "No Records Found" );
		}
		else
		{
			returnWithInfo( $searchResults );
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
		$retValue = '{"id":0,"firstName":"","lastName":"","error":"' . $err . '"}';
		sendResultInfoAsJson( $retValue );
	}

	function returnWithInfo( $searchResults )
	{
		$retValue = '{"results":[' . $searchResults . '],"error":""}';
		sendResultInfoAsJson( $retValue );
	}

?>
