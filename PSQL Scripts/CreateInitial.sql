-- Creating the data base
CREATE DATABASE books WITH ENCODING 'UTF8';

-- Creating the tables
CREATE TABLE authors (
    ID serial,
    author varchar(50) NOT NULL,
    PRIMARY KEY (ID)
);

CREATE TABLE books (
    ID serial,
    title varchar(100) NOT NULL,
    author_fk int,
    PRIMARY KEY (ID),
    FOREIGN KEY (author_fk) REFERENCES authors(ID) ON DELETE CASCADE
);