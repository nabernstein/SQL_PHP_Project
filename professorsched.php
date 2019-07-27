<html>
<body>
<?php
// username and password need to be replaced by your username and password
$link = mysql_connect("ecsmysql", "cs332s4", "iek1Haeh");
if (!$link) {
die("Could not connect: " . mysql_error());
};

mysql_select_db('cs332s4',$link);

$query = "SELECT DISTINCT P.Title as PTitle, P.Name as PName, C.CourseID, S.SectionID, C.Title as CTitle, S.Classroom, M.Day, S.StartTime, S.EndTime
		FROM PROFESSOR P
		JOIN SECTION S ON S.ProfessorSsn=P.Ssn
		JOIN COURSE C ON C.CourseID=S.CourseID
        JOIN SECTION_MEET_DAYS M ON (S.CourseID=M.CourseID AND S.SectionID=M.SectionID)
		WHERE P.Ssn=".$_POST["ssn"]." ORDER BY StartTime";

$result = mysql_query($query,$link);

$Title = mysql_result($result,0, "PTitle");
$Name = mysql_result($result,0, "PName");

$pagetitle = "Schedule: ".$Title." ".$Name;

echo "<head><title>".$pagetitle."</title><style>table {  font-family: arial, sans-serif;  border-collapse: collapse;  width: 100%;}";
echo "td, th {border: 1px solid #dddddd;text-align: left;padding: 8px;} tr:nth-child(even) {  background-color: #dddddd;}</style></head>";

echo "<h1>Welcome ".$Title." ".$Name.".</h1>";
echo "<h2>Your schedule is as follows:</h2>";

$Days = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");

echo "<table><tr><th>Course Title</th><th>Course ID</th><th>Section ID</th><th>Classroom</th><th>MeetingDay</th><th>Time</th></tr>";
foreach($Days as $day){
	for($i = 0; $i < mysql_numrows($result); $i++)
	{
		if(mysql_result($result,$i, "Day")==$day){	
		echo "<tr><th>".mysql_result($result,$i, "CTitle")."</th>";
		echo "<th>".mysql_result($result,$i, "CourseID")."</th><th>".mysql_result($result,$i, "SectionID")."</th>";
		echo "<th>".mysql_result($result,$i, "Classroom")."</th><th>".mysql_result($result,$i, "Day")."</th>";
		echo "<th>".date("h:i A", strtotime(mysql_result($result,$i, "StartTime")))." - ".date("h:i A", strtotime(mysql_result($result,$i, "EndTime")))."</th>";
		}
	}
}
echo "</table>";
//}
mysql_close($link);
?>
</body>
</html>
