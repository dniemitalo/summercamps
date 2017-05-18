<?php
require_once('db.php');
// echo "Camp signup is still under construction. Development in progress as of 5/11/17.";

$first = trim(mysqli_real_escape_string($conn,$_POST['first']));
$last = trim(mysqli_real_escape_string($conn,$_POST['last']));
$grade = $_POST['grade'];
$camp = $_POST['camp'];
$parent_first = trim(mysqli_real_escape_string($conn,$_POST['parent_first']));
$parent_last = trim(mysqli_real_escape_string($conn,$_POST['parent_last']));
$phone1 = trim(mysqli_real_escape_string($conn,$_POST['phone1']));
$phone2 = trim(mysqli_real_escape_string($conn,$_POST['phone2']));
$email1 = trim(mysqli_real_escape_string($conn,$_POST['email1']));
$email2 = trim(mysqli_real_escape_string($conn,$_POST['email2']));
$experience = trim(mysqli_real_escape_string($conn,$_POST['experience']));
$allergies = trim(mysqli_real_escape_string($conn,$_POST['allergies']));
$other = trim(mysqli_real_escape_string($conn,$_POST['other']));
$agree = $_POST['agree'];

$sql = "SELECT * FROM camps WHERE id = $camp";
if ($result = mysqli_query($conn,$sql)){
	$row = mysqli_fetch_assoc($result);
	$camp_type = $row['type'];
	$camp_date = $row['week'];
}
else {
	die("<p>The registration site is having trouble reaching the database. Please try registering again.</p><p><a href='http://www.nemoquiz.com/camps'>Back to Registration Form</a></p>");
}

$sql = "INSERT INTO students (first,last,grade,camp,parent_first,parent_last,phone1,phone2,email1,email2,experience,allergies,other,agree) VALUES ('$first','$last','$grade','$camp','$parent_first','$parent_last','$phone1','$phone2','$email1','$email2','$experience','$allergies','$other','$agree')";
if ($result = mysqli_query($conn,$sql)){

	$echo_txt = "<p>$first $last has been successfully registered for the $camp_date $camp_type camp.<br></p>".
	"<p>This is a five day camp (Monday-Friday) from 8 AM to noon each day.<br></p>".
	"<p>To complete your registration, you need to pay the registration fee.<br>".
	"It can be dropped off at Linn-Mar High School to the cashier, Joyce Dayton, at the 11-12 office.</p>".
	"<p>Or, it can be mailed:<br>".
	"Linn-Mar Robotics Summer Camps<br>".
	"Linn-Mar High School<br>".
	"3111 North 10th Street<br>".
	"Marion, IA 52302</p>".
	"<p>Checks can be made out to Linn-Mar Robotics. Lego camps are \$100 and Vex camps are \$150.<br>".
	"Your child's spot in the camp becomes officially reserved as soon as payment is received.</p>".
	"<p>Camps will take place at Linn-Mar High School in rooms by the 'Pride Rock Commons' north entrance.<br>".
	"The north door (on 33rd Ave, by the stadium) leads directly to this area.<br>".
	"Simply enter through the main north entrance, and we will be visible from that entrance.</p>".
	"<p>Contact Dan Niemitalo (dniemitalo@linnmar.k12.ia.us, 319-400-2730) if you have questions.<br></p>".
	"<p>Thank you!</p>".
	"<p><a href='http://www.nemoquiz.com/camps'>Back to Registration Form</a></p>";
	echo $echo_txt;

	$to = "$email1";
	$subject = "Linn-Mar Robotics Summer Camp Registration";
	$headers = "From: nemosha1@just136.justhost.com";
	$txt = "$first $last has been successfully registered for the $camp_date $camp_type camp.\r\n".
	"This is a five day camp (Monday-Friday) from 8 AM to noon each day.\r\n".
	"To complete your registration, you need to pay the registration fee.\r\n".
	"It can be dropped off at Linn-Mar High School to the cashier, Joyce Dayton, at the 11-12 office.\r\n".
	"Or, it can be mailed:\r\n".
	"Linn-Mar Robotics Summer Camps\r\n".
	"Linn-Mar High School\r\n".
	"3111 North 10th Street\r\n".
	"Marion, IA 52302\r\n".
	"Checks can be made out to Linn-Mar Robotics. Lego camps are \$100 and Vex camps are \$150.\r\n".
	"Your child's spot in the camp becomes officially reserved as soon as payment is received.\r\n".
	"Camps will take place at Linn-Mar High School in rooms by the 'Pride Rock Commons' north entrance.".
	"The north door (on 33rd Ave, by the stadium) leads directly to this area.\r\n".
	"Simply enter through the main north entrance, and we will be visible from that entrance.\r\n".
	"Contact Dan Niemitalo (dniemitalo@linnmar.k12.ia.us, 319-400-2730) if you have questions.\r\n".
	"Thank you!";
	mail($to,$subject,$txt,$headers);
}
else{
	die("<p>The registration site is having trouble reaching the database. Please try registering again.</p><p><a href='http://www.nemoquiz.com/camps'>Back to Registration Form</a></p>");
}

mysqli_close($conn);
?>