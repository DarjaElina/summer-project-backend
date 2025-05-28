drop database if exits event_planner;
create database event_planner;
-- Creating user here
drop user if exists 'summer_project'@'localhost';
CREATE USER 'summer_project'@'localhost' IDENTIFIED BY 'summer123';
GRANT ALL PRIVILEGES ON event_planner.* TO 'summer_project'@'localhost';
FLUSH PRIVILEGES;