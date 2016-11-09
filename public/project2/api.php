<?php
$host = "localhost";
$user = "root";
$password = "root";
$database = "myDB";
$connection = mysqli_connect($host, $user, $password);
if(!$connection){
die("Could not connect: " . mysqli_connect_error());}
$connection->select_db($database);

if($_SERVER["REQUEST_METHOD"] === "POST")
{
	var_dump($_POST);
	$id = intval($_POST["personID"]);
	getPerson($id);
}
elseif($_SERVER["REQUEST_METHOD"] === "GET")
{
	var_dump($_GET);
	$id = intval($_GET["personID"]);
}
else
{
	echo "Request method is bad, you should feel bad";
	die();
}

function getPerson()
{
	$resultSql =	"SELECT p.firstname, s.statename, p.food
					FROM Visits v
					INNER JOIN People p ON v.p_id = p.id
					INNER JOIN States s ON v.s_id = s.id
					WHERE v.p_id =" . $id;

	$query = mysqli_query ($connection, $resultSql) or die(mysqli_error($connection));
	$row2 = mysqli_fetch_array($query);
		
	$firstName = $row2["firstname"];
	$stateName = $row2["statename"];
	$foodName = $row2["food"];

	// Display Json format here

		if(!empty($firstName) && !empty($stateName) && !empty($foodName))
		{
			echo "<br><br><center> The human you select is : " . $firstName . "</center>";

			echo "<br><center> The state they're visited : " . $stateName . "</center>";

			while($row3 = mysqli_fetch_array($query))
			{
				$stateName = $row3["statename"];
				echo "<br><center> The state they're visited : " . $stateName . "</center>";				
			}

			echo "<br><center> Their favor food is : " . $foodName . "<br><br><br><br></center>";
		}

		else
		{
			echo "<br><center> You need to add a visit </center>";
		}
}

function insertPerson()
{

}
?>
