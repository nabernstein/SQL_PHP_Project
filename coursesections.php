<html>
	<body>
		<?php
			$link = mysql_connect("ecsmysql", "cs332s4", "iek1Haeh");
			if (!$link) {
			die("Could not connect: " . mysql_error());
			};

			mysql_select_db('cs332s4',$link);

			$courseQuery =
				"SELECT DISTINCT C.Title as CTitle, S.SectionID, P.Title as PTitle,
						P.Name, C.Units, M.Day, S.Classroom, S.StartTime, S.EndTime
 				FROM SECTION S
 				JOIN PROFESSOR P ON P.Ssn=S.ProfessorSsn
				JOIN COURSE C ON C.CourseId = S.CourseId
 				JOIN SECTION_MEET_DAYS M ON (M.CourseID = C.CourseID AND M.SectionID = S.SectionID)
				WHERE S.CourseID=".$_POST["cid"]." ORDER BY S.SectionID";


			$courseResult = mysql_query($courseQuery, $link);
			$course_title = mysql_result($courseResult, 0, "CTitle")." (".$_POST["cid"].") ";

			echo "<head><title>".$course_title."</title><style>table {  font-family:";
			echo "arial, sans-serif;  border-collapse: collapse;  width: 100%;}";
			echo "td, th {border: 1px solid #dddddd;text-align: left;padding: 8px;}";
			echo "tr:nth-child(even) {  background-color: #dddddd;}</style></head>";

			echo "<h1>Course information for: ".$course_title."</h1>";

			$num_sections = mysql_numrows($courseResult);

			$Days = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");

			echo "<table><th>Section</th><th>Professor</th><th>Meets on</th>";
			echo "<th>Time</th><th>Classroom</th><th>Enrolled</th>";

			for($i = 0; $i < $num_sections; $i++){
				$MeetDays = "";
				foreach ($Days as $day){
					$day_query = "SELECT COUNT(*)
									FROM SECTION_MEET_DAYS
									WHERE (CourseID=".$_POST["cid"]." AND SectionId="
									.mysql_result($courseResult ,$i, "SectionID")." AND Day='".$day."')";
					$day_result = mysql_query($day_query, $link);
					$day_count = mysql_result($day_result, 0);
					if($day_count > 0){
						$MeetDays .= ($day[0]." ");
					}
				}

				$enrolled_query = "SELECT COUNT(*) FROM ENROLLMENT WHERE (CourseID=".$_POST["cid"]
									." AND SectionId=".mysql_result($courseResult ,$i, "SectionID").")";
				$enrolled_result = mysql_query($enrolled_query, $link);
				$enrolled = mysql_result($enrolled_result, 0);

				echo "<tr><th>".mysql_result($courseResult,$i, "SectionID")."</th><th>";
				echo mysql_result($courseResult,$i, "PTitle")." ";
				echo mysql_result($courseResult,$i, "Name")."</th><th>".$MeetDays."</th><th>";
				echo date("h:i A", strtotime(mysql_result($courseResult,$i, "StartTime")))." - ";
				echo date("h:i A", strtotime(mysql_result($courseResult,$i, "EndTime")))."</th>";
				echo "<th>".mysql_result($courseResult,$i, "Classroom")."</th><th>".$enrolled."</th>";
			}

			echo "</table>";
			mysql_close($link);
		?>
	</body>
</html>