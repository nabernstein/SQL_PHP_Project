<html>
<body>
<?php
$link = mysql_connect("ecsmysql", "cs332s4", "iek1Haeh");
if (!$link) {
die("Could not connect: " . mysql_error());
};

mysql_select_db('cs332s4',$link);

$courseQuery = "SELECT Title, CourseID FROM COURSE WHERE CourseID=".$_POST["cid"];
$courseResult = mysql_query($courseQuery, $link);

$course_title = mysql_result($courseResult, 0, "Title");
$title = $_POST["cid"]."-".$_POST["sid"];

echo "<head><title>Grades ".$title."</title><style>table {  font-family: arial, sans-serif;  border-collapse: collapse;  width: 100%;}";
echo "td, th {border: 1px solid #dddddd;text-align: left;padding: 8px;} tr:nth-child(even) {  background-color: #dddddd;}</style></head>";

echo "<h1>Course Grades for ".$title.": ".$course_title."</h1>";

//echo "<head><title>".$pagetitle."</title><style>table {  font-family: arial, sans-serif;  border-collapse: collapse;  width: 100%;}";
//echo "td, th {border: 1px solid #dddddd;text-align: left;padding: 8px;} tr:nth-child(even) {  background-color: #dddddd;}</style></head>";

$Grades = array("'A+'","'A'","'A-'","'B+'","'B'","'B-'","'C+'","'C'","'C-'","'D+'","'D'","'D-'","'F'");
echo "<table><th>Grade</th><th>Count</th>";

foreach($Grades as $grade){
	$query = "SELECT COUNT(*) FROM ENROLLMENT WHERE CourseID=".$_POST["cid"]." AND SectionID=".$_POST["sid"]." AND Grade=".$grade;
	$result = mysql_query($query, $link);
	$count = mysql_result($result, 0);

	if($count > 0){
		echo "<tr><th>".str_replace('\'','',$grade)."</th><th>".$count."</th>";
	}
}



echo "</table>";

mysql_close($link);
?>
</body>
</html>
