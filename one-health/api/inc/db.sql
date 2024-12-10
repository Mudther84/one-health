CREATE DATABASE if not exists `one-health`;

USE `one-health`;

--  Create Users Table 

CREATE TABLE `users` (
    `id` bigint primary key AUTO_INCREMENT ,
    `name` VARCHAR(255) NOT NULL,
    `email` VARCHAR (255) NOT NULL UNIQUE,
    `password` VARCHAR (255) NOT NULL,
    `token`    VARCHAR(255) UNIQUE NOT NULL
);


CREATE TABLE `messages` (
    `id` bigint primary key AUTO_INCREMENT ,
    `from` VARCHAR(255) not null ,
    `message` VARCHAR(255) not null ,
    `birth-date` datetime,
    `general-health` VARCHAR(255),
    foreign key (`from`) REFERENCES `users`(`token`) 
    ON DELETE CASCADE
    ON UPDATE CASCADE
);