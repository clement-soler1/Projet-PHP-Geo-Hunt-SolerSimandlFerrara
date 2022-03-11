
CREATE TABLE User (
    user_id INTEGER NOT NULL,
    username VARCHAR(32) NOT NULL,
    email VARCHAR(128) NOT NULL,
    password VARCHAR(256) NOT NULL,
    join_date DATE NOT NULL,
    profile_pic VARCHAR(4096) NOT NULL,
    description VARCHAR(2048) NOT NULL,
    admin BOOLEAN NOT NULL,
    CONSTRAINT User_acount_pk PRIMARY KEY (user_id)
);


CREATE TABLE Teams (
    team_id INTEGER NOT NULL,
    team_name VARCHAR(32) NOT NULL,
    CONSTRAINT Teams_pk PRIMARY KEY (team_id)
);


CREATE TABLE Questions (
    qu_id INTEGER NOT NULL,
    qu_title VARCHAR(128) NOT NULL,
    qu_text VARCHAR(2048) NOT NULL,
    privacy BOOLEAN NOT NULL,
    lat DOUBLE NOT NULL,
    lon DOUBLE NOT NULL,
    user_id INTEGER NOT NULL,
    CONSTRAINT Enigmes_pk PRIMARY KEY (qu_id)
);


CREATE TABLE Hunts (
    hunt_id INTEGER NOT NULL,
    hunt_title VARCHAR(128) NOT NULL,
    privacy BOOLEAN NOT NULL,
    lat DOUBLE NOT NULL,
    lon DOUBLE NOT NULL,
    user_id INTEGER NOT NULL,
    CONSTRAINT Pistes_pk PRIMARY KEY (hunt_id)
);


CREATE TABLE Access (
    hunt_id INTEGER NOT NULL,
    user_id INTEGER NOT NULL,
    CONSTRAINT Access_pk PRIMARY KEY (hunt_id, user_id)
);


CREATE TABLE Attempts (
    attempt_id INTEGER NOT NULL,
    hunt_id INTEGER NOT NULL,
    user_id INTEGER NOT NULL,
    attempt_time TIME NOT NULL,
    attempt_date DATE NOT NULL,
    score INTEGER NOT NULL,
    win BOOLEAN NOT NULL,
    CONSTRAINT Attempts_pk PRIMARY KEY (attempt_id)
);


CREATE TABLE Hunt_qu_list (
    qu_id INTEGER NOT NULL,
    hunt_id INTEGER NOT NULL,
    qu_num INTEGER NOT NULL,
    CONSTRAINT Hunt_qu_list_pk PRIMARY KEY (qu_id, hunt_id)
);

CREATE TABLE Teams_User (
    team_id INTEGER NOT NULL,
    user_id INTEGER NOT NULL,
    rank INTEGER NOT NULL,
    CONSTRAINT Teams_User_pk PRIMARY KEY (team_id, user_id)
);


ALTER TABLE Hunts ADD CONSTRAINT User_Hunts_fk
    FOREIGN KEY (user_id)
        REFERENCES User (user_id)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION;

ALTER TABLE Questions ADD CONSTRAINT User_Questions_fk
    FOREIGN KEY (user_id)
        REFERENCES User (user_id)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION;

ALTER TABLE Attempts ADD CONSTRAINT User_Attempts_fk
    FOREIGN KEY (user_id)
        REFERENCES User (user_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE;

ALTER TABLE Access ADD CONSTRAINT User_Access_fk
    FOREIGN KEY (user_id)
        REFERENCES User (user_id)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION;

ALTER TABLE Hunt_qu_list ADD CONSTRAINT Questions_Hunt_qu_fk
    FOREIGN KEY (qu_id)
        REFERENCES Questions (qu_id)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION;

ALTER TABLE Hunt_qu_list ADD CONSTRAINT Hunts_Hunt_qu_fk
    FOREIGN KEY (hunt_id)
        REFERENCES Hunts (hunt_id)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION;

ALTER TABLE Attempts ADD CONSTRAINT Hunts_Attempts_fk
    FOREIGN KEY (hunt_id)
        REFERENCES Hunts (hunt_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE;

ALTER TABLE Access ADD CONSTRAINT Hunts_Access_fk
    FOREIGN KEY (hunt_id)
        REFERENCES Hunts (hunt_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE;

ALTER TABLE Teams_User ADD CONSTRAINT User_Teams_User_fk
    FOREIGN KEY (user_id)
        REFERENCES User (user_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE;

ALTER TABLE Teams_User ADD CONSTRAINT Teams_Teams_User_fk
    FOREIGN KEY (team_id)
        REFERENCES Teams (team_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE;


DELIMITER //
CREATE FUNCTION getAvailableUser_ID ()
    RETURNS INT
BEGIN
    DECLARE id INT;
    SELECT COALESCE(MIN(u1.user_id+1),1) INTO id
    FROM User u1 LEFT JOIN User u2 ON u1.user_id+1 = u2.user_id
    WHERE u2.user_id IS NULL;
RETURN id;
END; //
DELIMITER ;