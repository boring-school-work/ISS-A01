DROP DATABASE IF EXISTS giftdb;
CREATE DATABASE giftdb;
USE giftdb;

CREATE TABLE users (
  id int auto_increment PRIMARY KEY,
  email varchar(60) NOT NULL,
  username varchar(30) NOT NULL UNIQUE,
  passwd text NOT NULL
);
