CREATE TABLE PROFESSOR(
    Ssn char(9),
    Title varchar(6),
    Name varchar(25),
    Sex varchar(6),
    Salary decimal(9,2),
    AreaCode char(3),
    PhoneNumber char(7),
    StAddress varchar(30),
    City varchar(15),
    State varchar(10),
    ZipCode int,
    PRIMARY KEY (Ssn)
);
    
INSERT INTO PROFESSOR
    (Ssn, Title, Name, Sex, Salary, AreaCode, PhoneNumber, StAddress, City, State, ZipCode)
VALUES
    ('663597855', 'Mr.', 'Davvos Seaworth', 'M', 750000.00, '949', '2077370', '1835 Newport Blvd', 'Costa Mesa', 'CA', '92627'),
    ('100654865', 'Dr.', 'Melisandre Redd', 'F', 82000.00, '562', '4395938', '785 Junipero Ave', 'Long Beach', 'CA', '90804'),
    ('743259866', 'Dr.', 'Tyrion Lannister', 'M', 67000.00, '714', '5297364', '690 E. Imperial Hwy', 'Brea', 'CA', '92821');

CREATE TABLE DEPARTMENT(
    DptID char(4),
    Name varchar(20),
    Phone char(10),
    OfficeLoc char(5),
    ChairSSN char(9),
    PRIMARY KEY (DptID),
    FOREIGN KEY (ChairSSN) REFERENCES PROFESSOR(Ssn)
);
    
INSERT INTO DEPARTMENT
    (DptID, Name, Phone, OfficeLoc, ChairSSN)
VALUES
    ('1321', 'Math', '1123581321', 'RK123', '100654865'),
    ('1010', 'Computer Science', '1123581010', 'WF362', '743259866')
;

CREATE TABLE PROFESSOR_DEGREES(
    Professor_SSN char(9),
    Degree varchar(25),
    FOREIGN KEY (Professor_SSN) REFERENCES PROFESSOR(Ssn)
);
    
INSERT INTO PROFESSOR_DEGREES
    (Professor_SSN, Degree)
VALUES
    ('663597855', 'BS Applied Mathematics'),
    ('663597855', 'MS Applied Mathematics'),
    ('663597855', 'BS Computer Science'),
    ('743259866', 'BS Mathematics'),
    ('743259866', 'PhD Mathematics'),
    ('743259866', 'BS Computer Science'),
    ('743259866', 'PhD Computer Science'),
    ('743259866', 'BS Physics'),
    ('743259866', 'PhD Physics'),
    ('100654865', 'BS Religious Studies'),
    ('100654865', 'PhD Computer Science')
;

CREATE TABLE COURSE(
    CourseID char(6),
    Title varchar(20),
    Textbook varchar(100),
    Units int,
    DptID char(4),
    PRIMARY KEY (CourseID),
    FOREIGN KEY (DptID) REFERENCES DEPARTMENT(DptID)
);

INSERT INTO COURSE
    (CourseID, Title, Textbook, Units, DptID)
VALUES
    ('275986', 'Algebra I', 'Introduction to Algebra by Tytos Lannister', 4, '1321'),
    ('316498', 'Intro to Programming', 'C Programming Language by Brian W. Kernighan and Dennis M. Ritchie', 3, '1010'),
    ('147796', 'Algebra II', 'Advanced Algebra by Tywin Lannister', 4, '1321'),
    ('697864', 'Linear Algebra', 'Introduction to Linear Algebra by Gilbert Strang', 4, '1321')
;

CREATE TABLE COURSE_PREREQS(
    CourseID char(6),
    Prereq_CourseID char(6),
    FOREIGN KEY (CourseID) REFERENCES COURSE(CourseID),
    FOREIGN KEY (Prereq_CourseID) REFERENCES COURSE(CourseID)
);
    
INSERT INTO COURSE_PREREQS
    (CourseID, Prereq_CourseID)
VALUES
    ('697864', '147796'),
    ('147796', '275986')
;

CREATE TABLE STUDENT(
    CWID char(9),
    Fname varchar(15),
    Lname varchar(15),
    Address varchar(50),
    Phone char(10),
    MajorDptID char(4),
    PRIMARY KEY (CWID),
    FOREIGN KEY (MajorDptID) REFERENCES DEPARTMENT(DptID)
);
    
    
INSERT INTO STUDENT
    (CWID, Fname, Lname, Address, Phone, MajorDptID)
VALUES
    ('965658754', 'John', 'Snow', '18181 Magnolia Way, Yorba Linda, CA 92886', '7149569897', '1321'),
    ('632565476', 'Danaerys', 'Targaryen', '3374 Knoxville Ave, Long Beach, CA 90808', '5623659786', '1010'),
    ('236489567', 'Arya', 'Stark', '950 W Central Ave, Brea, CA 92821', '7146593696', '1321'),
    ('457695315', 'Theon', 'Greyjoy', '6126 San Rolando Way, Buena Park, CA 90620', '9496563652', '1010'),
    ('695789654', 'Tommen', 'Baratheon', '8511 Martinique Dr, Huntington Beach, CA 92646', '7149569896', '1010'),
    ('123659948', 'Gendry', 'Waters', '6801 Westminster Blvd, Seal Beach, CA 90740', '5626663569', '1321'),
    ('566598787', 'Loras', 'Tyrell', '1805B Park Glen Cir, Santa Ana, CA 92706', '9516598869', '1010'),
    ('369878564', 'Margaery', 'Tyrell', '2011 W Cris Ave, Anaheim, CA 92804', '3233659486', '1321')
;

CREATE TABLE STUDENT_MINORS(
    CWID char(9),
    MinorDptID char(4),
    FOREIGN KEY (CWID) REFERENCES STUDENT(CWID),
    FOREIGN KEY (MinorDptID) REFERENCES DEPARTMENT(DptID)
);
    
    
INSERT INTO STUDENT_MINORS
    (CWID, MinorDptID)
VALUES
    ('457695315', '1321'),
    ('566598787', '1321'),
    ('965658754', '1010'),
    ('236489567', '1010')
;

CREATE TABLE SECTION(
    CourseID char(6),
    SectionID char(6),
    Classroom char(5),
    Seats int,
    StartTime time,
    EndTime time,
    ProfessorSSN char(9),
    PRIMARY KEY (CourseID,SectionID),
    FOREIGN KEY (ProfessorSSN) REFERENCES PROFESSOR(Ssn)
);
    
    
INSERT INTO SECTION
    (CourseID, SectionID, Classroom, Seats, StartTime, EndTime, ProfessorSSN)
VALUES
    ('275986', '01', 'WF110', 30, '12:15:00', '13:50:00', '663597855'),
    ('275986', '02', 'WF105', 30,  '9:00:00', '10:35:00', '100654865'),
    ('316498', '01', 'RK440', 35, '17:00:00', '18:15:00', '6635978555'),
    ('316498', '02', 'RK220', 35, '12:15:00', '13:30:00', '1006548655'),
    ('147796', '01', 'WF245', 20, '14:20:00', '16:30:00', '743259866'),
    ('697864', '01', 'WF105', 20, '16:45:00', '18:55:00', '743259866')
;

CREATE TABLE SECTION_MEET_DAYS(
    CourseID char(6),
    SectionID char(6),
    Day varchar(9),
    FOREIGN KEY (CourseID,SectionID) REFERENCES SECTION(CourseID,SectionID)
);
    
    
INSERT INTO SECTION_MEET_DAYS
    (CourseID, SectionID, Day)
VALUES
    ('275986', '01', 'Monday'),
    ('275986', '02', 'Tuesday'),
    ('316498', '01', 'Wednesday'),
    ('316498', '02', 'Thursday'),
    ('147796', '01', 'Friday'),
    ('697864', '01', 'Friday')
;

 CREATE TABLE ENROLLMENT(
    CWID char(9),
    CourseID char(6),
    SectionID char(6),
    Grade varchar(2),
    FOREIGN KEY (CWID) REFERENCES STUDENT(CWID),
    FOREIGN KEY (CourseID, SectionID) REFERENCES SECTION(CourseID, SectionID)
);
   

INSERT INTO ENROLLMENT
    (CWID, CourseID, SectionID, Grade)
VALUES
    ('965658754', '275986', '01', 'A+'),
    ('965658754', '316498', '01', 'A-'),
    ('965658754', '147796', '01', 'A'),
    ('965658754', '697864', '01', 'B+'),
    ('632565476', '275986', '01', 'B'),
    ('632565476', '316498', '01', 'B-'),
    ('236489567', '275986', '01', 'A'),
    ('236489567', '316498', '01', 'A+'),
    ('236489567', '147796', '01', 'A+'),
    ('236489567', '697864', '01', 'A'),
    ('457695315', '275986', '02', 'C+'),
    ('457695315', '147796', '01', 'C'),
    ('695789654', '275986', '02', 'B-'),
    ('695789654', '316498', '02', 'B'),
    ('123659948', '275986', '02', 'A-'),
    ('123659948', '316498', '02', 'B'),
    ('566598787', '275986', '01', 'B'),
    ('566598787', '316498', '02', 'B-'),
    ('369878564', '275986', '01', 'B+'),
    ('369878564', '316498', '01', 'B')
;