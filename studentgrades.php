<html>
<body>
<?php
$link = mysql_connect("ecsmysql", "cs332s4", "iek1Haeh");
if (!$link) {
die("Could not connect: " . mysql_error());
};

mysql_select_db('cs332s4',$link);

$query = "SELECT S.Fname, S.Lname, E.CourseID, E.SectionID, C.Title, P.Name as PName, E.Grade, C.Units
 			FROM STUDENT S
			JOIN ENROLLMENT E ON S.CWID = E.CWID 
			JOIN COURSE C ON C.CourseId = E.CourseId
 			JOIN SECTION SE ON (SE.CourseID = E.CourseID AND SE.SectionID = E.SectionID)
 			JOIN PROFESSOR P ON P.Ssn = SE.ProfessorSSN
 			WHERE S.CWID=".$_POST["cwid"];


$result = mysql_query($query,$link);

$Fname = mysql_result($result,0, "Fname");
$Lname = mysql_result($result,0, "Lname");

$title = "Grades: ".$_POST["CWID"]." ".$Lname.", ".$Fname{0};

echo "<head><title>".$title."</title><style>table {  font-family: arial, sans-serif;  border-collapse: collapse;  width: 100%;}";
echo "td, th {border: 1px solid #dddddd;text-align: left;padding: 8px;} tr:nth-child(even) {  background-color: #dddddd;}</style></head>";


echo "<h1>Welcome ".$Fname. " ".$Lname.".</h1>";
echo "<h2>Your grades are as follows:</h2>";

echo "<table><tr><th>Course ID</th><th>Section ID</th><th>Class Title</th><th>Professor</th><th>Grade</th><th>Units</th></tr>";
for($i = 0; $i < mysql_numrows($result); $i++)
{
echo "<tr><th>".mysql_result($result,$i, "CourseID")."</th><th>".mysql_result($result,$i, "SectionID")."</th>";
echo "<th>".mysql_result($result,$i, "Title")."</th>"."<th>".mysql_result($result,$i, "PName")."</th>";
echo "<th>".mysql_result($result,$i, "Grade")."</th><th>".mysql_result($result,$i, "Units")."</th>";
}
echo "</table>";


mysql_close($link);
?>
</body>
</html>
