CREATE DATABASE IF NOT EXISTS chuckwagon;

USE chuckwagon;

DROP TABLE IF EXISTS user_response;

CREATE TABLE response (
  id INT NOT NULL AUTO_INCREMENT,
  lunch_date DATE NOT NULL,
  user_name varchar(255) NOT NULL,
  user_response  BIT(1) DEFAULT 0,
  PRIMARY KEY (id),
  UNIQUE INDEX user_response_idx (lunch_date, user_name) 
);