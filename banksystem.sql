-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 08, 2023 at 12:17 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `banksystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `adminaccount`
--

CREATE TABLE `adminaccount` (
  `accountNumber` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `hpNumber` varchar(50) NOT NULL,
  `ICNumber` varchar(50) NOT NULL,
  `address` varchar(50) NOT NULL,
  `DOB` varchar(50) NOT NULL,
  `position` varchar(50) NOT NULL,
  `salary` varchar(50) NOT NULL,
  `dateOfEmployment` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `adminaccount`
--

INSERT INTO `adminaccount` (`accountNumber`, `email`, `hpNumber`, `ICNumber`, `address`, `DOB`, `position`, `salary`, `dateOfEmployment`) VALUES
('MjkzNDgxOTIzNDU2', 'aTIxMDIwOTExQHN0dWRlbnQubmV3aW50aS5lZHUubXk=', 'MDEyODQzMjM0NQ==', 'OTcwMzE1MDgwMTIz', 'MTEgUGVubnkgU3RyZWV0', 'MTk5Ny0wMy0xNQ==', 'Q0VP', 'MTUwMDA=', 'MjAyMy0wMS0wMQ=='),
('MTgyOTM4NDkzOTIz', 'aTIxMDIwOTEyQHN0dWRlbnQubmV3aW50aS5lZHUubXk=', 'MDE5MzQ1MjgzNA==', 'OTgwODI0MDkyMzQ=', 'MzQgWWVsbG93IFJvYWQ', 'MTk5OC0wOC0yNA==', 'Q0VP', 'MTUwMDA=', 'MjAyMy0wMS0wMw=='),
('Mzg0OTI4MzkyODM0', 'dG9tcG9sYW5kQGdtYWlsLmNvbQ==', 'MDEyMzQzODI4Mg==', 'ODkxMDE2MDkyMzQx', 'OTEgQ29taWMgQXZlbnVl', 'MTk4OS0xMC0xNg==', 'ZW1wbG95ZWU=', 'MzcwMA==', 'MjAyMy0wMi0xMA=='),
('Mzg0OTI4MzQ4MjM0', 'c2VyZW5hd0BnbWFpbC5jb20=', 'MDEyOTM5MjgzNA==', 'NzcwNTEyMDUzOTQ4', 'NDUgQ291cnQgRmllbGQ=', 'MTk3Ny0wNS0xMg==', 'ZW1wbG95ZWU=', 'NDAwMA==', 'MjAyMy0wMi0wMQ=='),
('NDg1OTM4NDU5MjM0', 'ZGFuaWVsY2xpZmZAZ21haWwuY29t', 'MDExMjg0OTI4Mw==', 'ODgwNDA0MDYxMjM0', 'MjIgU2NvdHRpc2ggR3JvdmU=', 'MTk4OC0wNC0wNA==', 'bWFuYWdlcg==', 'NTMwMA==', 'MjAyMy0wMy0wMQ==');

-- --------------------------------------------------------

--
-- Table structure for table `companyaccount`
--

CREATE TABLE `companyaccount` (
  `accountNumber` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `hpNumber` varchar(50) NOT NULL,
  `address` varchar(50) NOT NULL,
  `registrationNumber` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `companyaccount`
--

INSERT INTO `companyaccount` (`accountNumber`, `email`, `hpNumber`, `address`, `registrationNumber`) VALUES
('MjgzNzQ5NTEzNDg4', 'aW50aXVuaXZlcnNpdHlAZ21haWwuY29t', 'MDE3NDgyOTM4MTEx', 'TmlsYWk=', 'MTk0ODAxMDAwMDA1'),
('MjM4NDkyODM4Mzk5', 'bWF4aXNAZ21haWwuY29t', 'MDEyODg4MjM0NQ==', 'S3VhbGEgTHVtcHVy', 'MTk1ODAyMDAwMDE1'),
('MTgyOTM0NzM4Mjkz', 'c3Vud2F5dW5pQGdtYWlsLmNvbQ', 'MDEyODM0NzE4Mg==', 'U3ViYW5nIEpheWE=', 'MTk2MDAzMDAwMDMy'),
('Mzg0NzI2NTc1NzQz', 'c2FpbnN3YXRlckBnbWFpbC5jb20=', 'MDE4MjI0MzgyMw==', 'U2VyZW1iYW4=', 'MTk2MTA0MDAwMDQ3'),
('Mzg0OTIwMzkzOQ==', 'bWF5YmFua0BnbWFpbC5jb20=', 'MDE4MjgyMzM0NA==', 'S3VhbGEgTHVtcHVy', 'MTk2MTA1MDAwMDU5'),
('MzgyOTM4NDc1NjM3', 'Y2ltYmJhbmtAZ21haWwuY29t', 'MDE4MjIyMzkzOQ==', 'UGV0YWxpbmcgSmF5YQ==', 'MTk2MjA2MDAwMDYx'),
('NzM5MjgzNzQ2NTgz', 'dGVuYWdhYmVyaGFkQGdtYWlsLmNvbQ==', 'MDEyMzg0NzU4Mg==', 'S3VhbGEgTHVtcHVy', 'MTk2MjA3MDAwMDYy'),
('ODM1NzM5NTg0NDY2', 'ZGlnaW1zaWFAZ21haWwuY29t', 'MDE5MjgzNDQyMg==', 'U3ViYW5nIEpheWE=', 'MTk2MzA4MDAwMDcw');

-- --------------------------------------------------------

--
-- Table structure for table `favourites`
--

CREATE TABLE `favourites` (
  `faveID` varchar(50) NOT NULL,
  `accountNumber` varchar(50) NOT NULL,
  `faveAccNumber` varchar(50) NOT NULL,
  `faveAccName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `favourites`
--

INSERT INTO `favourites` (`faveID`, `accountNumber`, `faveAccNumber`, `faveAccName`) VALUES
('MTQz', 'MjgzOTQ4MTkyODM0', 'OTI4MzkxODI5Mzg0', 'S2F0aHJ5biBMaW0='),
('NzY3', 'MjgzOTQ4MTkyODM0', 'NzE4MjMzODQ5NTIz', 'TWljaGVsbGUgRmFuZw==');

-- --------------------------------------------------------

--
-- Table structure for table `paybill`
--

CREATE TABLE `paybill` (
  `transID` varchar(50) NOT NULL,
  `accountNumber` varchar(50) NOT NULL,
  `description` varchar(50) NOT NULL,
  `credit` varchar(50) NOT NULL,
  `debit` varchar(50) NOT NULL,
  `balance` varchar(50) NOT NULL,
  `transDate` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `paybill`
--

INSERT INTO `paybill` (`transID`, `accountNumber`, `description`, `credit`, `debit`, `balance`, `transDate`) VALUES
('MDAwMDAwMDc=', 'NzM5MjgzNzQ2NTgz', 'UGF5IGJpbGwgdG8gVGVuYWdhIE5hc2lvbmFsIEJlcmhhZA==', 'MTAw', 'MA==', 'NTAwMA==', 'MjAyMy0wMy0xMw=='),
('MDAwMDAwMDE=', 'Mzg0NzI2NTc1NzQz', 'UGF5IGJpbGwgdG8gU0FJTlMgQWlyIE5lZ2VyaQ==', 'MTA=', 'MA==', 'MjAwMA==', 'MjAyMy0wMy0wNQ=='),
('MDAwMDAwMDg=', 'NzM5MjgzNzQ2NTgz', 'UGF5IGJpbGwgdG8gVGVuYWdhIE5hc2lvbmFsIEJlcmhhZA==', 'ODA=', 'MA==', 'MTAwMDA=', 'MjAyMy0wMy0xMw=='),
('MDAwMDAwMDI=', 'Mzg0NzI2NTc1NzQz', 'UGF5IGJpbGwgdG8gU0FJTlMgQWlyIE5lZ2VyaQ==', 'NTA=', 'MA==', 'MjA1MA==', 'MjAyMy0wMy0wNQ=='),
('MDAwMDAwMDk=', 'NzM5MjgzNzQ2NTgz', 'UGF5IGJpbGwgdG8gVGVuYWdhIE5hc2lvbmFsIEJlcmhhZA==', 'OTA=', 'MA==', 'MTAwOTA=', 'MjAyMy0wMy0xOA=='),
('MDAwMDAwMDM=', 'Mzg0NzI2NTc1NzQz', 'UGF5IGJpbGwgdG8gU0FJTlMgQWlyIE5lZ2VyaQ==', 'OTA=', 'MA==', 'MjE0MA==', 'MjAyMy0wMy0wOA=='),
('MDAwMDAwMDQ=', 'MjM4NDkyODM4Mzk5', 'UGF5IGJpbGwgdG8gTWF4aXMgQmVyaGFk', 'NTA=', 'MA==', 'MjUwMA==', 'MjAyMy0wMy0wOA=='),
('MDAwMDAwMDU=', 'MjM4NDkyODM4Mzk5', 'UGF5IGJpbGwgdG8gTWF4aXMgQmVyaGFk', 'NDA=', 'MA==', 'MjU0MA==', 'MjAyMy0wMy0xMg=='),
('MDAwMDAwMDY=', 'MjM4NDkyODM4Mzk5', 'UGF5IGJpbGwgdG8gTWF4aXMgQmVyaGFk', 'NDA=', 'MA==', 'MjU4MA==', 'MjAyMy0wMy0xMg=='),
('MDAwMDAwMTA=', 'NzM5MjgzNzQ2NTgz', 'UGF5IGJpbGwgdG8gVGVuYWdhIE5hc2lvbmFsIEJlcmhhZA==', 'NzA=', 'MA==', 'MTAxNjA=', 'MjAyMy0wMy0xOA=='),
('MjM1MjE0NzE=', 'MjgzOTQ4MTkyODM0', 'UGF5IGJpbGxzIHRvIElOVEkgSW50ZXJuYXRpb25hbCBVbml2ZX', 'MA==', '', 'NTAwMA==', ''),
('OTA0ODgyNDA=', 'MjgzOTQ4MTkyODM0', 'UGF5IGJpbGxzIHRvIElOVEkgSW50ZXJuYXRpb25hbCBVbml2ZX', 'MA==', 'MjA=', 'NDk4MA==', 'MjAyMy0wNC0xMg=='),
('OTAzODk2OTg=', 'MjgzOTQ4MTkyODM0', 'UGF5IGJpbGxzIHRvIElOVEkgSW50ZXJuYXRpb25hbCBVbml2ZX', 'MA==', 'MzA=', 'NDk3MA==', 'MjAyMy0wNC0xNw==');

-- --------------------------------------------------------

--
-- Table structure for table `personalaccount`
--

CREATE TABLE `personalaccount` (
  `accountNumber` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `hpNumber` varchar(50) NOT NULL,
  `ICNumber` varchar(50) NOT NULL,
  `DOB` varchar(50) NOT NULL,
  `address` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `personalaccount`
--

INSERT INTO `personalaccount` (`accountNumber`, `email`, `hpNumber`, `ICNumber`, `DOB`, `address`) VALUES
('MjgzOTQ4MjgzNDU1', 'YW5kcmV3cmVhQGdtYWlsLmNvbQ==', 'MDE4MjgyMzMzMw==', 'NzgwODEyMDQyODgz', 'MTk3OC0wOC0wMg==', 'NTQgU3BpY2UgQm91bGV2YXJk'),
('MjgzOTQ4MTkyODM0', 'aTIxMDIwMTg3QHN0dWRlbnQubmV3aW50aS5lZHUubXk=', 'MDE4MjkzNDU2Mg==', 'OTkwNTExMDU5Mjgz', 'MTk5OS0wNS0xMQ==', 'OTkgRHVuZGVyIE1pZmZsaW4'),
('MTgyOTM4NTUzNDIx', 'bWFyY3VzYnJvd25AZ21haWwuY29t', 'MDE4MjM0OTE4Mg==', 'ODgxMjAxMDIxMTIy', 'MTk4OC0xMi0wMQ==', 'NjkgU2lsaWNvbiBWYWxsZXk='),
('MTI4MzQ5MzgyOTM4', 'c3RldmVubGFrc2FtQGdtYWlsLmNvbQ==', 'MDE5MjgzNDkyMw==', 'ODcwNDExMDkyODI4', 'MTk4Ny0wNC0xMQ==', 'MzAgVGhlIENvdXJ0IA=='),
('MTkyODM5NDg1MzIy', 'bWVnYW5wZXRlckBnbWFpbC5jb20=', 'MDEyOTQ4Mjk1NQ==', 'OTgxMjA2MDM5Mzkz', 'MTk5OC0xMi0wNg==', 'NzcgTG9zIEFuZ2VsZXM='),
('NzE4MjMzODQ5NTIz', 'aTIwMDE5NzcxQHN0dWRlbnQubmV3aW50aS5lZHUubXk=', 'MDEyMzg1OTIzNA==', 'OTkwMTA5MDkyMzQ1', 'MTk5OS0wMS0wOQ==', 'NDUgRnJ1aXQgUm9hZA=='),
('OTI4Mzc0NzQ3NDcz', 'bWFyaWFhaG5AZ21haWwuY29t', 'MDExMjgzOTQ4NA==', 'ODkwNjIyMDUxODI3', 'MTk4OS0wNi0yMg==', 'MzggRmxvd2VyIEZpZWxk'),
('OTI4MzkxODI5Mzg0', 'aTIxMDIwMDYxQHN0dWRlbnQubmV3aW50aS5lZHUubXk=', 'MDEyMzQ1Njc4OQ==', 'MDIwMzA0NTU4Mjkz', 'MjAwMi0wMy0wNA==', 'NDUgUGFsbSBTdHJlZXQ=');

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `transID` varchar(50) NOT NULL,
  `accountNumber` varchar(50) NOT NULL,
  `description` varchar(50) NOT NULL,
  `credit` varchar(50) NOT NULL,
  `debit` varchar(50) NOT NULL,
  `balance` varchar(50) NOT NULL,
  `transDate` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`transID`, `accountNumber`, `description`, `credit`, `debit`, `balance`, `transDate`) VALUES
('MjgzNzQ4ODg=', 'MTI4MzQ5MzgyOTM4', 'c3BvcnRzIGVxdWlwbWVudA==', 'MA==', 'MTcw', 'NzYwMA==', 'MjAyMy0wMy0wOA=='),
('MjIzMTIzNDU=', 'OTI4MzkxODI5Mzg0', 'bHVuY2ggb3V0aW5n', 'MA==', 'ODA=', 'NTAwMA==', 'MjAyMy0wMy0wOA=='),
('MTcyODM0NzU=', 'Mzg0OTI4MzkyODM0', 'c2VudCBhbmcgcGF1', 'MA==', 'MTIw', 'MTAwMDA=', 'MjAyMy0wMy0wOA=='),
('MTcyODM3NDI=', 'Mzg0OTI4MzQ4MjM0', 'Z3JvY2VyaWVz', 'MA==', 'NDUw', 'MTI1MDA=', 'MjAyMy0wMy0wOA=='),
('MTgyNzM4Mjg=', 'NDg1OTM4NDU5MjM0', 'cmVjZWl2ZWQgZ2lmdA==', 'ODAw', 'MA==', 'MTMxMDA=', 'MjAyMy0wMy0wOA=='),
('MTgyOTMwNDM=', 'MjgzOTQ4MTkyODM0', 'cmVjZWl2ZWQgdm91Y2hlcg==', 'MjAw', 'MA==', 'NTUwMA==', 'MjAyMy0wMy0wOA=='),
('MTIzNDg1NzM=', 'Mzg0OTIwMzkzOQ==', 'cmVpbWJ1cnNlbWVudA==', 'OTAw', 'MA==', 'NDEwMDAw', 'MjAyMy0wMy0wOA=='),
('MTIzNTU0Nzc=', 'MTkyODM5NDg1MzIy', 'cGFpZCByZW50', 'MA==', 'NjAw', 'MzkwMA==', 'MjAyMy0wMy0wOA=='),
('MTkyODM3NDQ=', 'NzM5MjgzNzQ2NTgz', 'cmVpbWJ1cnNlbWVudA==', 'OTAw', 'MA==', 'MjIwMDAw', 'MjAyMy0wMy0wOA=='),
('MzQ0NDU3ODE=', 'MjgzOTQ4MjgzNDU1', 'YnJlYWtmYXN0', 'MA==', 'MjU=', 'NzMwMA==', 'MjAyMy0wMy0wOA=='),
('MzQ1Njc3MjM=', 'NzE4MjMzODQ5NTIz', 'ZGlubmVy', 'NTA=', 'MA==', 'NjAwMA==', 'MjAyMy0wMy0wOA=='),
('MzQ1NTY2MTE=', 'OTI4Mzc0NzQ3NDcz', 'cmVjZWl2ZSBnaWZ0', 'NDU=', 'MA==', 'MzYwMA==', 'MjAyMy0wMy0wOA=='),
('NDU2NzY3Njc=', 'MjM4NDkyODM4Mzk5', 'c3RhZmYgYm9udXM=', 'MA==', 'NTAwMA==', 'MjcwMDAw', 'MjAyMy0wMy0wOA=='),
('Njc2NTQzMjE=', 'MjkzNDgxOTIzNDU2', 'bHVuY2ggb3V0aW5n', 'MA==', 'NzA=', 'MTQzMDA=', 'MjAyMy0wMy0wOA=='),
('NjQ1NTk4OTg=', 'ODM1NzM5NTg0NDY2', 'c2VydmVyIG1haW50ZW5hbmNl', 'MA==', 'MzAwMA==', 'MzMwMDAw', 'MjAyMy0wMy0wOA=='),
('NTY3NjU0NDU=', 'MTgyOTM4NTUzNDIx', 'ZGlubmVyIHBhcnR5', 'MA==', 'NDIw', 'ODEwMA==', 'MjAyMy0wMy0wOA=='),
('Nzg5ODc2NTY=', 'MTgyOTM4NDkzOTIz', 'cmVjZWl2ZWQgYm9udXM=', 'MzAw', 'MA==', 'MTIwMDA=', 'MjAyMy0wMy0wOA=='),
('NzI4Mzk5MTE=', 'MjgzNzQ5NTEzNDg4', 'bWFpbnRhaW4gZ2FyZGVu', 'MA==', 'NDcw', 'MzIwMDAw', 'MjAyMy0wMy0wOA=='),
('NzI4OTU2NDQ=', 'MTgyOTM0NzM4Mjkz', 'ZG9uYXRpb24gdG8gb3JwaGFuYWdl', 'MA==', 'MTIwMA==', 'NTQwMDAw', 'MjAyMy0wMy0wOA=='),
('ODc2NjU4OQ==', 'Mzg0NzI2NTc1NzQz', 'bWFpbnRlbmFuY2UgZmVlcw==', 'MA==', 'Mzcw', 'MTU2MDAw', 'MjAyMy0wMy0wOA=='),
('OTg5ODk4OTg=', 'MzgyOTM4NDc1NjM3', 'cGFpZCBzYWxhcnk=', 'MA==', 'MjYwMA==', 'NDYwMDAw', 'MjAyMy0wMy0wOA==');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `accountNumber` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `securityQn` varchar(50) NOT NULL,
  `answer` varchar(50) NOT NULL,
  `accountStatus` varchar(50) NOT NULL,
  `accType` varchar(20) NOT NULL,
  `PIN` varchar(50) NOT NULL,
  `loginCount` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`accountNumber`, `name`, `username`, `password`, `securityQn`, `answer`, `accountStatus`, `accType`, `PIN`, `loginCount`) VALUES
('MjgzNzQ5NTEzNDg4', 'SU5USSBJbnRlcm5hdGlvbmFsIFVuaXZlcnNpdHk=', 'aW50aWl1MTAxMA==', 'aW50aXVuaXZlcnNpdHk=', 'MQ==', 'TmlsYWk=', 'MQ==', 'Mg==', 'NTU0NDU1', 'MA=='),
('MjgzOTQ4MjgzNDU1', 'QW5kcmV3IFJlYQ==', 'YW5kcmV3NDU=', 'Z29vZGZvb2Q=', 'Mg==', 'SW5zdGFudCBub29kbGU=', 'MA==', 'MQ==', 'NDA0MDQw', 'MA=='),
('MjgzOTQ4MTkyODM0', 'V2luYSBXb25n', 'd2luYXdweQ==', 'd2luYTIzMDM=', 'Mw==', 'U3Rhcg==', 'MQ==', 'MQ==', 'MDEwMzIz', 'MA=='),
('MjkzNDgxOTIzNDU2', 'Q2VsaW5lIEZhbmc=', 'Y2VsaW5lZm15', 'Y2VsaW5lMjkxMQ==', 'Mg==', 'UGl6emE=', 'MQ==', 'Mw==', 'MDMxMTI5', 'MA=='),
('MjM4NDkyODM4Mzk5', 'TWF4aXMgQmVyaGFk', 'bWF4aXMxMDEw', 'bWF4aXNwaG9uZQ==', 'MQ==', 'UGVyYWs=', 'MQ==', 'Mg==', 'MjM3NzMz', 'MA=='),
('MTgyOTM0NzM4Mjkz', 'U3Vud2F5IFVuaXZlcnNpdHk=', 'c3Vud2F5dW5p', 'YnJpZ2h0c3Vu', 'Mw==', 'U2hlbGx5', 'MA==', 'Mg==', 'MzQzNDM0', 'MA=='),
('MTgyOTM4NDkzOTIz', 'Q2luZHkgRmFuZw==', 'Y2luZHlmbXg=', 'Y2luZHkyOTEx', 'Mw==', 'VGFjbw==', 'MQ==', 'Mw==', 'MDMxMTI5', 'MA=='),
('MTgyOTM4NTUzNDIx', 'TWFyY3VzIEJyb3du', 'bWFyY3VzYg==', 'dGVjaG5vbG9neQ==', 'MQ==', 'U2FiYWg=', 'MA==', 'MQ==', 'NjU0MzIx', 'MA=='),
('MTI4MzQ5MzgyOTM4', 'U3RldmVuIExha3NhbQ==', 'c3RldmVubGFrc2Ft', 'Y3VycnltZWU=', 'MQ==', 'S2VsYW50YW4=', 'MA==', 'MQ==', 'MTEyMjMz', 'MA=='),
('MTkyODM5NDg1MzIy', 'TWVnYW4gUGV0ZXI=', 'bWVnYW5wZXRlcjEy', 'c3RhbGxpb24=', 'Mg==', 'TWVlIGdvcmVuZw==', 'MQ==', 'MQ==', 'NjU0MzIx', 'MA=='),
('Mzg0NzI2NTc1NzQz', 'U0FJTlMgQWlyIE5lZ2VyaQ==', 'c2FpbnN3YXRlcg==', 'bWludW1haXI=', 'MQ==', 'Sm9ob3I=', 'MA==', 'Mg==', 'NzY1NTY3', 'MA=='),
('Mzg0OTI4MzkyODM0', 'VG9tIFBvbGFuZA==', 'dG9tcG9sYW5k', 'c3BpZGVyd2Vicw==', 'MQ==', 'UGVuYW5n', 'MQ==', 'Mw==', 'MjM4NjUx', 'MA=='),
('Mzg0OTI4MzQ4MjM0', 'U2VyZW5hIFdpbGxhbXM=', 'c2VyZW5hdw==', 'bG92ZXRlbm5pcw==', 'Mw==', 'QmFybmV5', 'MQ==', 'Mw==', 'MTM0NjQz', 'MA=='),
('Mzg0OTIwMzkzOQ==', 'TWF5YmFuaw==', 'bWF5YmFuazJ1', 'aGFyaW1hdTg4', 'Mg==', 'SWNlIGNyZWFt', 'MQ==', 'Mg==', 'MTIzMzIx', 'MA=='),
('MzgyOTM4NDc1NjM3', 'Q0lNQiBCYW5rIEJlcmhhZA==', 'Y2ltYmJhbms=', 'bWVyY2hhbnQ3Nzc=', 'Mg==', 'Q2hpcHM=', 'MQ==', 'Mg==', 'NTQwMDIz', 'MA=='),
('NDg1OTM4NDU5MjM0', 'RGFuaWVsIENsaWZm', 'ZGFuaWVsMTIy', 'bWFnaWM=', 'MQ==', 'S3VhbGEgTHVtcHVy', 'MQ==', 'Mw==', 'MTM4NTM3', 'MA=='),
('NzE4MjMzODQ5NTIz', 'TWljaGVsbGUgRmFuZw==', 'bWljaGVsbGVmbWo=', 'bWljaGVsbGUwMzA0', 'Mg==', 'TWFydGFiYWs=', 'MQ==', 'MQ==', 'MDIwNDAz', 'MA=='),
('NzM5MjgzNzQ2NTgz', 'VGVuYWdhIE5hc2lvbmFsIEJlcmhhZA==', 'dGVuYWdhYmVyaGFk', 'ZW5lcmd5Y28=', 'MQ==', 'U2VyZW1iYW4=', 'MQ==', 'Mg==', 'NjU2NTU1', 'MA=='),
('ODM1NzM5NTg0NDY2', 'RGlnaSBNYWxheXNpYQ==', 'ZGlnaW1zaWE=', 'aXdpbGxmb2xsb3d5b3U=', 'Mg==', 'S0ZD', 'MQ==', 'Mg==', 'OTA5MDg4', 'MA=='),
('OTI4Mzc0NzQ3NDcz', 'TWFyaWEgQWhu', 'bWFyaWEw', 'Zmxvd2Vy', 'Mg==', 'Q2VuZG9s', 'MQ==', 'MQ==', 'NjY1NTQ0', 'MA=='),
('OTI4MzkxODI5Mzg0', 'S2F0aHJ5biBMaW0=', 'a2F0bHNl', 'S2F0aDEyMjM=', 'Mg==', 'VGFrb3lha2k=', 'MQ==', 'MQ==', 'OTcxMjIz', 'MA==');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adminaccount`
--
ALTER TABLE `adminaccount`
  ADD PRIMARY KEY (`accountNumber`);

--
-- Indexes for table `companyaccount`
--
ALTER TABLE `companyaccount`
  ADD PRIMARY KEY (`accountNumber`);

--
-- Indexes for table `favourites`
--
ALTER TABLE `favourites`
  ADD PRIMARY KEY (`faveID`),
  ADD KEY `accountNumber` (`accountNumber`),
  ADD KEY `faveAccNumber` (`faveAccNumber`);

--
-- Indexes for table `paybill`
--
ALTER TABLE `paybill`
  ADD PRIMARY KEY (`transID`);

--
-- Indexes for table `personalaccount`
--
ALTER TABLE `personalaccount`
  ADD PRIMARY KEY (`accountNumber`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`transID`,`accountNumber`),
  ADD KEY `account` (`accountNumber`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`accountNumber`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `adminaccount`
--
ALTER TABLE `adminaccount`
  ADD CONSTRAINT `adminaccount_ibfk_1` FOREIGN KEY (`accountNumber`) REFERENCES `user` (`accountNumber`);

--
-- Constraints for table `companyaccount`
--
ALTER TABLE `companyaccount`
  ADD CONSTRAINT `companyaccount_ibfk_1` FOREIGN KEY (`accountNumber`) REFERENCES `user` (`accountNumber`);

--
-- Constraints for table `personalaccount`
--
ALTER TABLE `personalaccount`
  ADD CONSTRAINT `personalaccount_ibfk_1` FOREIGN KEY (`accountNumber`) REFERENCES `user` (`accountNumber`);

--
-- Constraints for table `transaction`
--
ALTER TABLE `transaction`
  ADD CONSTRAINT `transaction_ibfk_1` FOREIGN KEY (`accountNumber`) REFERENCES `user` (`accountNumber`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
