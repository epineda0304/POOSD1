<?php

  $inData = getRequestInfo();

  $username = $inData["Username"];
  $password = $inData["Pwd"];

  $conn = new mysqli("localhost", "TheCoders", "WeLoveCOP4331", "contacts");
  if ($conn->connect_error)
	{
		returnWithError( $conn->connect_error );
	}
  else
  {
    $sql = "SELECT Username FROM users WHERE Username=?";
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
      $sql = "INSERT INTO users (Username, Pwd) VALUES (?, ?)";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("ss", $username, $password);
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
