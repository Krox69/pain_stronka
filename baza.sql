DROP DATABASE IF EXISTS userbase;
CREATE DATABASE userbase;

USE userbase;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY, 
    username VARCHAR(25) NOT NULL,
    email VARCHAR(25) NOT NULL,
    userpass VARCHAR(255) NOT NULL,
    firstname VARCHAR(45) DEFAULT '',
    lastname VARCHAR(45) DEFAULT '',
    user_role VARCHAR(25) NOT NULL DEFAULT 'user',
    register_date DATE NOT NULL DEFAULT(CURRENT_DATE)
);

CREATE TABLE classes (
    id INT AUTO_INCREMENT, 
    class_name VARCHAR(10),
    PRIMARY KEY (id)
);

CREATE TABLE students (
    id INT AUTO_INCREMENT, 
    firstname VARCHAR(25), 
    surname VARCHAR(25),
    class_id INT,
    PRIMARY KEY (id),
    FOREIGN KEY (class_id) REFERENCES classes(id)
);

CREATE TABLE school_subjects (
    id INT AUTO_INCREMENT,
    subject_name VARCHAR(25),
    class_id INT,
    PRIMARY KEY (id),
    FOREIGN KEY (class_id) REFERENCES classes(id)
);

CREATE TABLE teachers (
    id INT AUTO_INCREMENT,
    firstname VARCHAR(25),
    surname VARCHAR(25),
    age INT,
    school_subject_id INT UNIQUE,
    PRIMARY KEY (id),
    FOREIGN KEY (school_subject_id) REFERENCES school_subjects(id)
);

INSERT INTO classes (class_name) VALUES ("3b");

INSERT INTO students (firstname, surname, class_id) VALUES ("Darek", "Grzanka", 1);
INSERT INTO students (firstname, surname, class_id) VALUES ("Mateusz", "Papier", 1);

INSERT INTO school_subjects (subject_name, class_id) VALUES ("PIPUSMECH", 1);
INSERT INTO school_subjects (subject_name, class_id) VALUES ("EDB", 1);

INSERT INTO teachers (firstname, surname, age, school_subject_id) VALUES ("Marek", "Cyganek", 25, 2);
INSERT INTO teachers (firstname, surname, age, school_subject_id) VALUES ("Wiesław", "Lamus", 20, 2);

INSERT INTO classes (class_name) VALUES ("3a");

INSERT INTO students (firstname, surname, class_id) VALUES ("Karol", "Świderski", 6);
INSERT INTO students (firstname, surname, class_id) VALUES ("Paweł", "Janek", 1);



SELECT firstname, surname, class_name FROM students, classes WHERE (students.class_id = classes.id);

SELECT firstname, surname, subject_name, class_name FROM teachers, school_subjects, classes WHERE (teachers.school_subject_id = school_subjects.id) AND (school_subjects.class_id = classes.id);