<?php

  $inData = getRequestInfo();

  $conactId = $inData["ID"];

  $conn = new mysqli("localhost", "TheCoders", "WeLoveCOP4331", "contacts");
  if ($conn->connect_error)
  {
    returnWithError( $conn->connect_error );
  }
  else
  {
    $sql = "DELETE FROM people WHERE ID = $conactId";
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
