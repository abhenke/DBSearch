<html>
<head>
<title>Aubri's Page</title>
<link rel="icon" href="https://aubri.s3.us-east-2.amazonaws.com/flower-512.png"> 
<style>
body{
text-align: center;
color: pink;
font-size: 24px;
background-color:gray;
margin-top:50px;
}
table{
	text-align: center;
	margin-right:auto;
	margin-left:auto;
</style>
</head>
<header>
Aubri's page for DB Search<br>
</header>
<body>
<form method="post">
	<label>State</label>
	<input type="text" name="state">
	<label>Symptom</label>
	<input type="text" name="symptom">
	<input type="submit" name="submit" value="Submit">
</form>

<?php
$dbhost = 'equine-do-user-2043635-0.a.db.ondigitalocean.com';
$port = 25060;
$dbuser = 'ahenke';
$password = 'testy';
$db = 'ahenke';

$conn = new mysqli($dbhost, $dbuser, $password, $db, $port);

/*******Connection Status Check********/
if ($conn->connect_errno) {
	echo $conn->connect_error;
}
/***********************************/
echo "<h3>Testing</h3>";
echo "<table><tr><th>Disease</th><th>No. Infected</th></tr>";
$state_name = $_POST['state'];
$symptom_name = $_POST['symptom'];
$query_three = "SELECT name, SUM(instance.number_involved) as num_infected
      		FROM instance JOIN illness i
		ON instance.illness_id = i.id JOIN location l
		ON instance.location_id = l.id
		WHERE state_name = '$state_name' AND symptoms LIKE '%$symptom_name%'
		GROUP BY name";
$result = $conn->query($query_three);
while($row = $result->fetch_assoc())
{
	echo "<tr><td>{$row['name']}</td><td>{$row['num_infected']}</td>";
}
echo "</table>";

$query = "SELECT name FROM instance JOIN illness i
		ON instance.illness_id = i.id JOIN location l
		ON instance.location_id = l.id
		WHERE state_name = 'NE' AND start_date > '2019-07-09 00:00:00'";
$result = $conn->query($query);
echo "<h3>Diseases in Nebraska since 2019-07-09</h3>";
echo "<table><tr><th>Disease</th></tr>";
while($row = $result->fetch_assoc())
{
	echo "<tr><td>{$row['name']}</td></tr>";
}
echo "</table>";

$query_two = "SELECT name FROM instance JOIN illness i
		ON instance.illness_id = i.id JOIN location l
		ON instance.location_id = l.id
		WHERE state_name = 'NE' 
		AND (symptoms LIKE '%nasal%' AND symptoms LIKE '%discharge%')";
$result = $conn->query($query_two);
echo "<h3>Diseases in Nebraska since 2019-07-09</h3>";
echo "<table><tr><th>Disease</th></tr>";
while($row = $result->fetch_assoc())
{
	echo "<tr><td>{$row['name']}</td></tr>";
}
echo "</table>";
mysql_close($conn);
?>
</body>
</html>
