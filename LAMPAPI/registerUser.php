<?php

  $inData = getRequestInfo();

  $username = $inData["Username"];
  $password = $inData["Pwd"];
  $firstName = $inData["FirstName"];
  $lastName = $inData["LastName"];

  $conn = new mysqli("localhost", "TheCoders", "WeLoveCOP4331", "contacts");
  if ($conn->connect_error)
	{
		returnWithError( $conn->connect_error );
	}
  else
  {
    $sql = "SELECT ID, FirstName, LastName FROM Users Where Login=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();

    $result = $stmt->get_result();

    if ( $row = $result->fetch_assoc() )
    {
      returnWithError("Username Taken.");
    }
    else
    {
      $sql = "INSERT into Users (Login,Password,FirstName,LastName) VALUES(?,?,?,?)";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("ssss", $username,$password,$firstName,$lastName);
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
