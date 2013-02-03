-- Renamed the registration_allowed field to make it consistant with
-- the nameing convention used in other tables
-- by Ali on 3 feb, 2013
ALTER TABLE EVENTS CHANGE registration_allowed active tinyint(1) NOT NULL;
