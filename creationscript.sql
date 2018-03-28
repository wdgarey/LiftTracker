DROP DATABASE IF EXISTS lifttracker;
CREATE DATABASE lifttracker;

DROP USER IF EXISTS 'lifttrackerwebuser'@'localhost';
CREATE USER 'lifttrackerwebuser'@'localhost' IDENTIFIED BY 'lifttrackerwebuser1234';
GRANT SELECT, UPDATE, INSERT, DELETE ON lifttracker.* TO 'lifttrackerwebuser'@'localhost';

USE lifttracker;

CREATE TABLE enduser
(
  id INT NOT NULL UNIQUE AUTO_INCREMENT,
  username VARCHAR(32) NOT NULL UNIQUE,
  email VARCHAR(100) NOT NULL,
  pwd VARCHAR(40) NOT NULL,
  vital tinyint(1) NOT NULL DEFAULT 0,
  firstname VARCHAR(40) NOT NULL DEFAULT '',
  lastname VARCHAR(40) NOT NULL DEFAULT '',
  height NUMERIC(5, 2) NOT NULL DEFAULT 0,
  weight NUMERIC(5, 2) NOT NULL DEFAULT 0,
  CONSTRAINT enduser_pk PRIMARY KEY (username)
) ENGINE=InnoDB;

INSERT INTO enduser (id, username, email, pwd, vital, firstname, lastname, height, weight) VALUES
  (1, 'admin', '', Sha1('pimp99'), 1, '', '', 0, 0),
  (2, 'wdgarey', 'w.d.garey@eagle.clarion.edu', Sha1('pimp99'), 0, 'Wes', 'G', 68, 160);

CREATE TABLE role
(
  id INT NOT NULL UNIQUE AUTO_INCREMENT,
  title VARCHAR(32) NOT NULL UNIQUE,
  vital tinyint(1) NOT NULL DEFAULT 0,
  CONSTRAINT role_pk PRIMARY KEY (title)
) ENGINE=InnoDB;

INSERT INTO role (id, title, vital) VALUES (1, 'admin', 1);

CREATE TABLE func
(
  id INT NOT NULL UNIQUE AUTO_INCREMENT,
  title VARCHAR(32) NOT NULL UNIQUE,
  vital tinyint(1) NOT NULL DEFAULT 0,
  CONSTRAINT function_pk PRIMARY KEY (title)
) ENGINE=InnoDB;

INSERT INTO func (id, title, vital) VALUES
  (1, 'enduseradd', 1),
  (2, 'enduseredit', 1),
  (3, 'enduserview', 1),
  (4, 'enduserdelete', 1),
  (5, 'manageendusers', 1),
  (6, 'roleadd', 1),
  (7, 'roleedit', 1),
  (8, 'roleview', 1),
  (9, 'roledelete', 1),
  (10, 'manageroles', 1);

CREATE TRIGGER givfunctoadmin_trig
AFTER INSERT ON func
  FOR EACH ROW
    INSERT INTO rolefunc (roleid, funcid)
    VALUES(1, NEW.id);

CREATE TABLE enduserrole
(
  roleid INT NOT NULL,
  enduserid INT NOT NULL,
  CONSTRAINT enduserrole_pk PRIMARY KEY (enduserid, roleid),
  CONSTRAINT enduserrole_role_fk FOREIGN KEY(roleid) REFERENCES role(id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT enduserrole_user_fk FOREIGN KEY(enduserid) REFERENCES enduser(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

INSERT INTO enduserrole (enduserid, roleid) VALUES
  (1, 1),
  (2, 1);

CREATE TABLE rolefunc
(
  roleid INT NOT NULL,
  funcid INT NOT NULL,
  CONSTRAINT rolefunc_pk PRIMARY KEY (roleid, funcid),
  CONSTRAINT rolefunc_func_fk FOREIGN KEY (funcid) REFERENCES func(id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT rolefunc_role_fk FOREIGN KEY (roleid) REFERENCES role(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

INSERT INTO rolefunc (roleid, funcid) VALUES
  (1, 1),
  (1, 2),
  (1, 3),
  (1, 4),
  (1, 5),
  (1, 6),
  (1, 7),
  (1, 8),
  (1, 9),
  (1, 10);

CREATE TABLE liftgrp
(
  id INT NOT NULL UNIQUE AUTO_INCREMENT,
  enduserid INT NOT NULL,
  title VARCHAR(32) NOT NULL UNIQUE,
  autoupdate tinyint(1) DEFAULT FALSE,
  autoupdatedate DATE,
  autoupdateincrement NUMERIC(4, 2) DEFAULT 0.0,
  CONSTRAINT liftgrp_pk PRIMARY KEY(enduserid, title),
  CONSTRAINT liftgrp_enduser_fk FOREIGN KEY(enduserid) REFERENCES enduser(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE lift
(
  id INT NOT NULL UNIQUE AUTO_INCREMENT,
  enduserid INT NOT NULL,
  title VARCHAR(32) NOT NULL UNIQUE,	
  trainingweight NUMERIC(6, 2) NOT NULL DEFAULT 0.0,
  CONSTRAINT lift_pk PRIMARY KEY(title),
  CONSTRAINT lift_enduser_fk FOREIGN KEY(enduserid) REFERENCES enduser(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE liftgrplift
(
  liftgrpid INT NOT NULL,
  liftid INT NOT NULL,
  CONSTRAINT liftgrplift_pk PRIMARY KEY (liftgrpid, liftid),
  CONSTRAINT liftgrplift_liftgrp_fk FOREIGN KEY (liftgrpid) REFERENCES liftgrp(id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT liftgrplift_lift_fk FOREIGN KEY (liftid) REFERENCES lift(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE liftrec
(
  id INT AUTO_INCREMENT,
  liftid INT NOT NULL,
  occurrence DATE NOT NULL,
  weight NUMERIC(6, 2) NOT NULL DEFAULT 0.0,
  reps INT NOT NULL DEFAULT 0,
  CONSTRAINT liftrec_pk PRIMARY KEY (id),
  CONSTRAINT liftrec_lift_fk FOREIGN KEY(liftid) REFERENCES lift(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE workplan
(
  id INT NOT NULL UNIQUE AUTO_INCREMENT,
  enduserid INT NOT NULL,
  title VARCHAR(32) NOT NULL UNIQUE,	
  CONSTRAINT workplan_pk PRIMARY KEY(enduserid, title),
  CONSTRAINT workplan_enduser_fk FOREIGN KEY(enduserid) REFERENCES enduser(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE workweek
(
  id INT NOT NULL UNIQUE AUTO_INCREMENT,
  workplanid INT NOT NULL,
  title VARCHAR(32) NOT NULL UNIQUE,	
  CONSTRAINT workweek_pk PRIMARY KEY(workplanid, title),
  CONSTRAINT workweek_workplan_fk FOREIGN KEY(workplanid) REFERENCES workplan(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE workday
(
  id INT NOT NULL UNIQUE AUTO_INCREMENT,
  workweekid INT NOT NULL,
  title VARCHAR(32) NOT NULL UNIQUE,
  CONSTRAINT workday_pk PRIMARY KEY(workweekid, title),
  CONSTRAINT workday_workweek_fk FOREIGN KEY(workweekid) REFERENCES workweek(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE workout
(
  id INT NOT NULL UNIQUE AUTO_INCREMENT,
  enduserid INT NOT NULL,
  title VARCHAR(32) NOT NULL UNIQUE,
  CONSTRAINT workout_pk PRIMARY KEY(enduserid, title),
  CONSTRAINT workout_enduser_fk FOREIGN KEY(enduserid) REFERENCES enduser(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE exercise
(
  id INT NOT NULL UNIQUE AUTO_INCREMENT,
  enduserid INT NOT NULL,
  title VARCHAR(32) NOT NULL UNIQUE,
  CONSTRAINT exercise_pk PRIMARY KEY(enduserid, title),
  CONSTRAINT exercise_enduser_fk FOREIGN KEY(enduserid) REFERENCES enduser(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE exerciseset
(
  id INT NOT NULL UNIQUE AUTO_INCREMENT,
  exerciseid INT,
  title VARCHAR(32) NOT NULL UNIQUE,
  percent NUMERIC(2, 2) NOT NULL,
  reps INT NOT NULL,
  CONSTRAINT iteration_pk PRIMARY KEY(exerciseid, title),
  CONSTRAINT iteration_exercise_fk FOREIGN KEY(exerciseid) REFERENCES exercise(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE exerciseinst
(
  id INT NOT NULL UNIQUE AUTO_INCREMENT,
  exerciseid INT NOT NULL,
  workoutid INT NOT NULL,
  liftid INT,
  CONSTRAINT exerciseinst_pk PRIMARY KEY (id),
  CONSTRAINT exerciseinst_exercise_fk FOREIGN KEY(exerciseid) REFERENCES exercise(id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT exerciseinst_workout_fk FOREIGN KEY(workoutid) REFERENCES workout(id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT exerciseinst_lift_fk FOREIGN KEY(liftid) REFERENCES lift(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;
