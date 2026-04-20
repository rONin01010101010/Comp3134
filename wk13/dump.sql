-- ============================================================
-- COMP3134 Lab Exercise 9 — Database Dump
-- Schema: comp3134
-- Table: users
-- ============================================================

-- Create and use the schema
CREATE DATABASE IF NOT EXISTS comp3134;
USE comp3134;

-- -------------------------------------------------------
-- Table structure for `users`
-- -------------------------------------------------------
DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id`        INT(11)      NOT NULL AUTO_INCREMENT,
  `username`  VARCHAR(50)  NOT NULL,
  `email`     VARCHAR(100) NOT NULL,
  `firstname` VARCHAR(50)  NOT NULL,
  `lastname`  VARCHAR(50)  NOT NULL,
  `active`    TINYINT(1)   NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- -------------------------------------------------------
-- Data for table `users`
-- -------------------------------------------------------

-- 5 unique active rows
INSERT INTO `users` (`username`, `email`, `firstname`, `lastname`, `active`) VALUES
('jsmith',   'jsmith@email.com',   'John',   'Smith',    1),
('ajohnson', 'ajohnson@email.com', 'Alice',  'Johnson',  1),
('mbrown',   'mbrown@email.com',   'Michael','Brown',    1),
('ewilson',  'ewilson@email.com',  'Emily',  'Wilson',   1),
('cdavis',   'cdavis@email.com',   'Chris',  'Davis',    1);

-- 1 additional row: firstname = Ben, active = 0
INSERT INTO `users` (`username`, `email`, `firstname`, `lastname`, `active`) VALUES
('bthomas',  'bthomas@email.com',  'Ben',    'Thomas',   0);
