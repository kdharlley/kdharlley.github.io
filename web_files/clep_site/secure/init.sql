-- Put ALL SQL in between `BEGIN TRANSACTION` and `COMMIT`
-- list of all databases:
-- users, sessions, events, eboard, eboard_events, listerv, positions, applications, responsibilities
-- Use Ctrl+F to navigate yourself easily through this page because there's a lot of code!
BEGIN TRANSACTION;

-- administrative login users
CREATE TABLE `users` (
	`id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
	`first_name` TEXT NOT NULL,
  'username' TEXT NOT NULL UNIQUE,
  'password' TEXT NOT NULL
);

INSERT INTO `users` (first_name,username,password) VALUES ("fox","fox","$2y$10$Y19JRPNwVE6Nilih4l8YSuB/lIDFhlzjx4nxI24h70ETc18SxIHv2"); -- password: hahaha
INSERT INTO `users` (first_name,username,password) VALUES ("brown","brown","$2y$10$8faIVXYPYOpSl6uhlipWreLD16X5mGCyBwvpeNqSmlyqn.3mYPZS6"); -- password: hahaha
-- username and passwords to login // user information!

CREATE TABLE 'sessions'(
  	`id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
    `user_id` INTEGER NOT NULL,
    'session' TEXT NOT NULL UNIQUE
);
--  events database for events.php
CREATE TABLE 'events'(
  	`id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
    `title` TEXT NOT NULL,
    'start_datetime' TEXT NOT NULL, -- must be YYYY-MM-DD HH:MM:SS (24 hour time) format to be used in queries
    'end_time' TEXT NOT NULL,
    'location' TEXT NOT NULL,
    `description` TEXT
);

INSERT INTO `events` (title,start_datetime,end_time,location,description) VALUES ("Language Corner","2019-05-04 16:30:00","5:30 PM","WSH 604","Come to practice or teach speaking skills in a foreign language through conversations and games! Food and refreshments will be provided.");
INSERT INTO `events` (title,start_datetime,end_time,location,description) VALUES ("Language Corner","2019-04-27 16:30:00","5:30 PM","WSH 604","Come to practice or teach speaking skills in a foreign language through conversations and games! Food and refreshments will be provided.");
INSERT INTO `events` (title,start_datetime,end_time,location,description) VALUES ("LEP Movie Night","2018-10-28 16:00:00","6:00 PM","WSH 411","The Language Expansion Program is proud to screen Amélie, a French romantic comedy. Amélie is a fanciful comedy about a young woman who discreetly orchestrates the lives of the people around her, creating a world exclusively of her own making. Shot in over 80 Parisian locations, acclaimed director Jean-Pierre Jeunet invokes his incomparable visionary style to capture the exquisite charm and mystery of modern-day Paris through the eyes of a beautiful ingenue.");

-- ^^^ seed data for events

-- eboard members database
CREATE TABLE 'eboard'(
  	`id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
    `name` TEXT NOT NULL,
    'position' TEXT NOT NULL,
    'bio' TEXT NOT NULL,
    'extension' TEXT NOT NULL
);

INSERT INTO 'eboard' (name, position, bio, extension) VALUES ("Erick Palma", 'President', "Erick Palma is a senior in the College of Arts and Sciences, majoring in Computer Science. Erick speaks English and Spanish, and practices Japanese during LEP's Language Corners. This year as president, he looks forward to coordinating language maintenance events to fulfill LEP's language learning vision. Outside of LEP, he drums for Cornell's only taiko drumming group, Yamatai.", 'jpg');

-- this information is from the organization's current website, http://orgsync.rso.cornell.edu/org/lep
INSERT INTO 'eboard' (name, position, bio, extension) VALUES ("Camelia Wu", 'Treasurer', "Camelia Wu is a junior majoring in Chemical Engineering in the College of Engineering. Having lived in China and Canada, she speaks both French and Mandarin. She is also learning Spanish. As co-treasurer, she works with Aaron to manage the program funds. Outside LEP, she is a member of Operation Smile and she is a foodie who loves travelling and art.", 'jpg');

-- this information is from the organization's current website, http://orgsync.rso.cornell.edu/org/lep
INSERT INTO 'eboard' (name, position, bio, extension) VALUES ("Pippen Wu", 'Publicity Chair', "Pippen Wu is a junior in the college of Arts and Sciences, majoring in Computer Science. He speaks Mandarin and English, and practices Japanese and Spanish in weekly language corners. As Publicity Chair, he will be designing posters and quarter cards for the program, as well as doing the layout for a newly established magazine named Polyglot.", 'jpg');
-- ^^^ seed data for current eboard members

-- eboard member that is in charge of events
CREATE TABLE 'eboard_events' (
  	`id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
    'event_id' INTEGER NOT NULL,
    'eboard_id' INTEGER NOT NULL
);

INSERT INTO 'eboard_events' ( event_id, eboard_id) VALUES (1, 2);
INSERT INTO 'eboard_events' ( event_id, eboard_id) VALUES (1, 3);
INSERT INTO 'eboard_events' ( event_id, eboard_id) VALUES (2, 1);
-- ^^^ eboard events seed data

-- people who want to be added to the listerv
CREATE TABLE 'listerv' (
  	`id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
    `fullname` TEXT NOT NULL,
    `email` TEXT NOT NULL,
    'class' INTEGER NOT NULL,
    'speak' TEXT NOT NULL,
    'practice' TEXT NOT NULL
);

INSERT INTO 'listerv' (fullname, email, class, speak, practice) VALUES ('Billie Sun', 'billie@gmail.com', '2019', 'English, Persian, German', 'German, Persian');
INSERT INTO 'listerv' (fullname, email, class, speak, practice) VALUES ('Ashley Shen', 'ashley@gmail.com', '2018', 'Spanish, Portuguese', 'Portuguese');
INSERT INTO 'listerv' (fullname, email, class, speak, practice) VALUES ('Kenneth Harlley', 'kenneth@gmail.com', '2020', 'English, Japanese', 'Japanese');
--^^^ listerv seed data

-- This table is used to list the available positions for which users can apply to. Logged in users have the ability to add or remove positions from this list. vvvv

CREATE TABLE 'positions'(
  	`id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
    `title` TEXT NOT NULL
);

INSERT INTO `positions` (id,title) VALUES (1,"Organizational Chair");
INSERT INTO `positions` (id,title) VALUES (2,"Webmaster");
INSERT INTO `positions` (id,title) VALUES (3,"Event Planner");
INSERT INTO `positions` (id,title) VALUES (4,"Community Outreach Chair");
--^^^ seed data for positions

-- applications for applying to be an eboard member
CREATE TABLE 'applications'(
  	'id' INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
    'position' TEXT NOT NULL,
    'full_name' TEXT NOT NULL,
    'netid' TEXT NOT NULL,
    'graduation' TEXT NOT NULL,
    'college' TEXT NOT NULL,
    'major' TEXT NOT NULL,
    'phone' TEXT NOT NULL,
    'languages' TEXT NOT NULL,
    'credits' TEXT,
    'other_activities' TEXT,
    'why' TEXT NOT NULL,
    'what_skills' TEXT NOT NULL,
    'time_commitments' TEXT NOT NULL,
    'time_management' TEXT NOT NULL,
    'file_name' TEXT NOT NULL,
    'file_ext' TEXT NOT NULL
);

INSERT INTO 'applications' (position, full_name, netid, graduation, college, major, phone, languages, credits, other_activities, why, what_skills, time_commitments, time_management, file_name, file_ext) VALUES ('Organizational Chair', 'Genavieve Koyn', 'ghk49', 'May 2021', 'ILR', 'ILR and Education', '716-418-2200', 'Spanish', '17', 'Debate team, public service scholars, middle school writing tutor, SA Committees', 'I love LEP and want to help make the club better', 'I am very good at writing in my planner.', 'To be honest I think I might die next semester.', 'Cold brew', 'gena_resume.docx', 'docx');

INSERT INTO 'applications' (position, full_name, netid, graduation, college, major, phone, languages, credits, other_activities, why, what_skills, time_commitments, time_management, file_name, file_ext) VALUES ('Event planning', 'Hahnbee Lee', 'hl985', 'May 2022', 'Arts and Sciences', 'Information Science', '711-911-0843', 'Gaeilc', '20', 'Hammocking club, squirrel watching club', 'I love LEP events and want to help plan them', 'I throw really good parties', 'I will be taking more credits than usual but I think the classes will be easy', 'Once the squirrels hibernate I will have much more time to plan events!', 'resume2.pdf', 'pdf');
--^^ seed data for applications to become an eboard member

-- responsibilities for each eboard position
CREATE TABLE 'responsibilities'(
  `id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
  `position_id` TEXT NOT NULL,
  'responsibility' TEXT NOT NULL
);

--Organizational Chair
-- this information is from the organization's current website, http://orgsync.rso.cornell.edu/org/lep
INSERT INTO 'responsibilities' (position_id,responsibility) VALUES (1,"3-4 hours per week expected commitment");
INSERT INTO 'responsibilities' (position_id,responsibility) VALUES (1,"Compiles agendas and to-do lists");
INSERT INTO 'responsibilities' (position_id,responsibility) VALUES (1,"Takes attendance and records minutes for weekly board meetings");
INSERT INTO 'responsibilities' (position_id,responsibility) VALUES (1,"Keeps emails and documents categorized");
INSERT INTO 'responsibilities' (position_id,responsibility) VALUES (1,"Assists the president with calendar keeping and tracks assignment completion");
INSERT INTO 'responsibilities' (position_id,responsibility) VALUES (1,"Is responsible for taking attendance during Language Corners");

--Webmaster
-- this information is from the organization's current website, http://orgsync.rso.cornell.edu/org/lep
INSERT INTO 'responsibilities' (position_id,responsibility) VALUES (2,"2-4 hours per week expected commitment");
INSERT INTO 'responsibilities' (position_id,responsibility) VALUES (2,"Handles logistics on website (posting events, program status, etc.)");
INSERT INTO 'responsibilities' (position_id,responsibility) VALUES (2,"Responsible for sending Language Corner and other event reminder emails, as well as responding to email inquiries");
INSERT INTO 'responsibilities' (position_id,responsibility) VALUES (2,"Manages LEP’s online publicity and coordinates with event planning chair to publicize events online");

--Event Planner
-- this information is from the organization's current website, http://orgsync.rso.cornell.edu/org/lep
INSERT INTO 'responsibilities' (position_id,responsibility) VALUES (3,"3-4 hours per week expected commitment");
INSERT INTO 'responsibilities' (position_id,responsibility) VALUES (3,"Coordinates with TIP’s event planning chair to plan the semesterly Taste of Culture (time commitment changes to 4-5 hours per week during ToC season)");
INSERT INTO 'responsibilities' (position_id,responsibility) VALUES (3,"Coordinate with Cornell administration and Health and Safety to secure venue, food, and beverage approvals");
INSERT INTO 'responsibilities' (position_id,responsibility) VALUES (3,"Collect contracts and other relevant information from participating organizations");
INSERT INTO 'responsibilities' (position_id,responsibility) VALUES (3,"Discuss format, dates, and time of events together with other board members");
INSERT INTO 'responsibilities' (position_id,responsibility) VALUES (3,"Book rooms, order food and beverages, equipment set-up");
INSERT INTO 'responsibilities' (position_id,responsibility) VALUES (3,"Works with treasurer to budget and pick the food for every weekly Language Corner");

--Community Outreach Chair
-- this information is from the organization's current website, http://orgsync.rso.cornell.edu/org/lep
INSERT INTO 'responsibilities' (position_id,responsibility) VALUES (4,"3-4 hours per week expected commitment");
INSERT INTO 'responsibilities' (position_id,responsibility) VALUES (4,"Sends emails to Cornell Language professors and cultural clubs to recruit attendees for Language Corner");
INSERT INTO 'responsibilities' (position_id,responsibility) VALUES (4,"Works with other language resources (Language House, Language Resource Center) to make LEP and Language corner known for the purpose of increasing attendance at weekly Language Corners");
INSERT INTO 'responsibilities' (position_id,responsibility) VALUES (4,"Coordinates with publicity chair to create slides so that professor can advertise LEP in classrooms");
-- ^^^ seed data for responsibilities
COMMIT;
