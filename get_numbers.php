<?php
require_once('db.php');
$sql = "SELECT camps.id, camps.type as type, camps.week as week, COUNT(students.camp) as studentCount FROM students JOIN camps ON camps.id = students.camp GROUP BY camp";
$result = mysqli_query($conn,$sql);
$output_array = array();
while($row = mysqli_fetch_assoc($result)){
	$output_array[] = $row;
}
echo json_encode($output_array);
mysqli_close($conn);
?>