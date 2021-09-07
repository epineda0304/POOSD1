<?php

  $inData = getRequestInfo();

  $userId = $inData["userId"];
  $conactId = $inData["conactId"];

  $conn = new mysqli("localhost", "TheCoders", "WeLoveCOP4331", "COP4331");
  if ($conn->connect_error)
  {
    returnWithError( $conn->connect_error );
  }
  else
  {
    $sql = "SELECT FROM people WHERE First_name like ? and ID = ? ORDER BY First_name ASC";
    $stmt = $conn->prepare($sql);
    $id = "%" . $inData["ID"] . "%";

    $sql = "DELETE FROM people where ID = " . $id;
    if ($conn->query($sql) != TRUE) {
      returnWithError( "No Contact Found" );

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
