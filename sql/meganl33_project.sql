-- phpMyAdmin SQL Dump
-- version 4.7.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 14, 2017 at 11:35 AM
-- Server version: 5.6.36-82.1-log
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `meganl33_project`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`meganl33`@`localhost` PROCEDURE `getCountryAbbreviationFromId` (IN `countryId` INT)  NO SQL
select abbreviation, countryName from country where country.id = countryId$$

CREATE DEFINER=`meganl33`@`localhost` PROCEDURE `getCountryIdFromAbbreviation` (IN `countryAbbreviation` VARCHAR(255))  NO SQL
select id from country where country.abbreviation = countryAbbreviation$$

CREATE DEFINER=`meganl33`@`localhost` PROCEDURE `getStateAbbreviationFromId` (IN `stateId` INT)  select state.abbreviation from state where state.id = stateId$$

CREATE DEFINER=`meganl33`@`localhost` PROCEDURE `getStateIdFromAbbreviation` (IN `stateAbbreviation` VARCHAR(20))  NO SQL
select state.id from state where state.abbreviation = stateAbbreviation$$

--
-- Functions
--
CREATE DEFINER=`meganl33`@`localhost` FUNCTION `formatPhoneNumber` (`unformattedPhone` VARCHAR(32), `formatString` VARCHAR(32)) RETURNS CHAR(32) CHARSET utf8 BEGIN
# Declare variables
DECLARE inputLength TINYINT;
DECLARE outputLength TINYINT;
DECLARE temporaryChar CHAR;

# Initialize variables
# Set input length to the length of the unformatted phone
SET inputLength = LENGTH(unformattedPhone);
# Set the output length to the length of the string that
# defines the formatting
SET outputLength = LENGTH(formatString);

# Count down from outputLength to 0, inserting the temporary
# char into the format string whenever that position is a '#'
WHILE ( outputLength > 0 ) DO

# temporaryChar is first set to the 0th position of the formatString
# Each loop after, it is incremented
SET temporaryChar = SUBSTR(formatString, outputLength, 1);

# If temporaryChar is a #
IF ( temporaryChar = '#' ) THEN
# If there is still input
IF ( inputLength > 0 ) THEN

# Take the char from unformattedPhone and insert it into
# formatString - replace the # that is there
SET formatString = INSERT(formatString, outputLength, 1, SUBSTR(unformattedPhone, inputLength, 1));

# Decrement the inputLength for substring indexing
SET inputLength = inputLength - 1;

# Else there is no more input
ELSE
SET formatString = INSERT(formatString, outputLength, 1, '0');
END IF;

# We only look at temporaryChar if it is a # - no ELSE
END IF;

# Decremement the outputLength
SET outputLength = outputLength - 1;
END WHILE;

# Return the new formatString
RETURN formatString;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `accountSettings`
-- (See below for the actual view)
--
CREATE TABLE `accountSettings` (
`id` int(11)
,`firstName` varchar(255)
,`lastName` varchar(255)
,`username` varchar(255)
,`currentPassword` varchar(255)
,`userTypeDescription` varchar(255)
,`addressId` int(11)
,`addressBlock` varchar(255)
,`city` varchar(255)
,`stateAbbreviation` varchar(255)
,`postCode` varchar(255)
,`countryAbbreviation` varchar(255)
,`countryName` varchar(255)
,`addressDescription` varchar(255)
,`email` varchar(255)
,`phone` varchar(255)
);

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `userId` int(11) DEFAULT NULL,
  `addressId` int(11) NOT NULL,
  `addressBlock` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `stateId` int(11) DEFAULT NULL,
  `countryId` int(11) DEFAULT NULL,
  `postCode` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`userId`, `addressId`, `addressBlock`, `city`, `stateId`, `countryId`, `postCode`, `description`) VALUES
(1, 1, '32 New Street', 'Berkley', 4, 1, '92381', '32 New Street,<br />\n Berkley, CA 92381'),
(1, 5, '5 Fancy Land', 'New York', 31, 1, '11023', '5 Fancy Land,<br />\n New York, NY 11023');

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `userId` int(11) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`userId`, `phone`, `email`) VALUES
(2, '(231) 231-2312', 'boo@gmail.com'),
(1, '(231) 231-2312', 'megan@gmail.com'),
(8, '', 'pbyrd@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE `country` (
  `id` int(11) NOT NULL DEFAULT '0',
  `countryName` varchar(255) DEFAULT NULL,
  `abbreviation` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `country`
--

INSERT INTO `country` (`id`, `countryName`, `abbreviation`) VALUES
(1, 'United States of America', 'USA');

-- --------------------------------------------------------

--
-- Stand-in structure for view `findChildren`
-- (See below for the actual view)
--
CREATE TABLE `findChildren` (
`userId` int(11)
,`childFirstName` varchar(255)
,`childLastName` varchar(255)
,`childId` int(11)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `findMessages`
-- (See below for the actual view)
--
CREATE TABLE `findMessages` (
`receiverId` int(11)
,`senderId` int(11)
,`senderFirstName` varchar(255)
,`senderLastName` varchar(255)
,`messageId` int(11)
,`message` blob
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `findParents`
-- (See below for the actual view)
--
CREATE TABLE `findParents` (
`userId` int(11)
,`parentFirstName` varchar(255)
,`parentLastName` varchar(255)
,`parentId` int(11)
);

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `userId` int(11) DEFAULT NULL,
  `username` varchar(255) NOT NULL DEFAULT '',
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`userId`, `username`, `password`) VALUES
(2, 'boodle', 'boo'),
(1, 'meganlandau', 'boodle'),
(8, 'Pbyrd2009', 'laswat77');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `senderId` int(11) DEFAULT NULL,
  `receiverId` int(11) DEFAULT NULL,
  `message` blob
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `senderId`, `receiverId`, `message`) VALUES
(1, 1, 2, 0x486920746865726520686f772061726520796f753f),
(2, 1, 2, 0x6d6573736167652032),
(3, 1, 2, 0x6d6573736167652033),
(5, 2, 1, 0x486920746865726520686f772061726520796f753f),
(22, 1, 2, 0x486920746865726521);

-- --------------------------------------------------------

--
-- Table structure for table `relationship`
--

CREATE TABLE `relationship` (
  `childId` int(11) DEFAULT NULL,
  `parentId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `relationship`
--

INSERT INTO `relationship` (`childId`, `parentId`) VALUES
(1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `state`
--

CREATE TABLE `state` (
  `id` int(11) NOT NULL DEFAULT '0',
  `stateName` varchar(255) DEFAULT NULL,
  `abbreviation` varchar(255) DEFAULT NULL,
  `countryId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `state`
--

INSERT INTO `state` (`id`, `stateName`, `abbreviation`, `countryId`) VALUES
(0, 'Alabama', 'AL', 1),
(1, 'Alaska', 'AK', 1),
(2, 'Arizona', 'AZ', 1),
(3, 'Arkansas', 'AR', 1),
(4, 'California', 'CA', 1),
(5, 'Colorado', 'CO', 1),
(6, 'Connecticut', 'CT', 1),
(7, 'Delaware', 'DE', 1),
(8, 'Florida', 'FL', 1),
(9, 'Georgia', 'GA', 1),
(10, 'Hawaii', 'HI', 1),
(11, 'Idaho', 'ID', 1),
(12, 'Illinois', 'IL', 1),
(13, 'Indiana', 'IN', 1),
(14, 'Iowa', 'IA', 1),
(15, 'Kansas', 'KS', 1),
(16, 'Kentucky', 'KY', 1),
(17, 'Louisiana', 'LA', 1),
(18, 'Maine', 'ME', 1),
(19, 'Maryland', 'MD', 1),
(20, 'Massachusetts', 'MA', 1),
(21, 'Michigan', 'MI', 1),
(22, 'Minnesota', 'MN', 1),
(23, 'Mississippi', 'MS', 1),
(24, 'Missouri', 'MO', 1),
(25, 'Montana', 'MT', 1),
(26, 'Nebraska', 'NE', 1),
(27, 'Nevada', 'NV', 1),
(28, 'New Hampshire', 'NH', 1),
(29, 'New Jersey', 'NJ', 1),
(30, 'New Mexico', 'NM', 1),
(31, 'New York', 'NY', 1),
(32, 'North Carolina', 'NC', 1),
(33, 'North Dakota', 'ND', 1),
(34, 'Ohio', 'OH', 1),
(35, 'Oklahoma', 'OK', 1),
(36, 'Oregon', 'OR', 1),
(37, 'Pennsylvania', 'PA', 1),
(38, 'Rhode Island', 'RI', 1),
(39, 'South Carolina', 'SC', 1),
(40, 'South Dakota', 'SD', 1),
(41, 'Tennessee', 'TN', 1),
(42, 'Texas', 'TX', 1),
(43, 'Utah', 'UT', 1),
(44, 'Vermont', 'VT', 1),
(45, 'Virginia', 'VA', 1),
(46, 'Washington', 'WA', 1),
(47, 'West Virginia', 'WV', 1),
(48, 'Wisconsin', 'WI', 1),
(49, 'Wyoming', 'WY', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `firstName` varchar(255) DEFAULT NULL,
  `lastName` varchar(255) DEFAULT NULL,
  `userType` int(11) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `hometown` varchar(255) DEFAULT NULL,
  `shortBio` blob
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `firstName`, `lastName`, `userType`, `age`, `hometown`, `shortBio`) VALUES
(1, 'Megan', 'Landau', 1, 5, 'Johannesburg, SA', 0x5468697320697320616d617a696e67212054686973206973206d792070726f66696c6520706167652e),
(2, 'Alison', 'Long', 2, 33, NULL, NULL),
(8, 'Phil', 'Byrd', 2, 27, NULL, NULL);

--
-- Triggers `user`
--
DELIMITER $$
CREATE TRIGGER `deleteUser` BEFORE DELETE ON `user` FOR EACH ROW BEGIN
    DELETE FROM address WHERE address.userId = OLD.id;
    DELETE FROM contact WHERE contact.userId = OLD.id;
	DELETE FROM relationship WHERE relationship.childId = OLD.id;
    DELETE FROM relationship WHERE relationship.parentId = OLD.id;
    DELETE FROM login WHERE login.userId = OLD.id;
    DELETE FROM messages WHERE messages.receiverId = OLD.id;
    DELETE FROM messages WHERE messages.senderId = OLD.id;
  END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `userType`
--

CREATE TABLE `userType` (
  `userTypeId` int(11) NOT NULL DEFAULT '1',
  `userType` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `userType`
--

INSERT INTO `userType` (`userTypeId`, `userType`) VALUES
(1, 'Child'),
(2, 'Parent');

-- --------------------------------------------------------

--
-- Structure for view `accountSettings`
--
DROP TABLE IF EXISTS `accountSettings`;

CREATE ALGORITHM=UNDEFINED DEFINER=`meganl33`@`localhost` SQL SECURITY DEFINER VIEW `accountSettings`  AS  select `u`.`id` AS `id`,`u`.`firstName` AS `firstName`,`u`.`lastName` AS `lastName`,`l`.`username` AS `username`,`l`.`password` AS `currentPassword`,`ut`.`userType` AS `userTypeDescription`,`a`.`addressId` AS `addressId`,`a`.`addressBlock` AS `addressBlock`,`a`.`city` AS `city`,`s`.`abbreviation` AS `stateAbbreviation`,`a`.`postCode` AS `postCode`,`ctry`.`abbreviation` AS `countryAbbreviation`,`ctry`.`countryName` AS `countryName`,`a`.`description` AS `addressDescription`,`c`.`email` AS `email`,`c`.`phone` AS `phone` from ((((((`user` `u` left join `address` `a` on((`u`.`id` = `a`.`userId`))) left join `contact` `c` on((`c`.`userId` = `u`.`id`))) join `login` `l` on((`l`.`userId` = `u`.`id`))) left join `userType` `ut` on((`u`.`userType` = `ut`.`userTypeId`))) left join `state` `s` on(((`a`.`userId` = `u`.`id`) and (`s`.`id` = `a`.`stateId`)))) left join `country` `ctry` on(((`a`.`userId` = `u`.`id`) and (`ctry`.`id` = `a`.`countryId`)))) ;

-- --------------------------------------------------------

--
-- Structure for view `findChildren`
--
DROP TABLE IF EXISTS `findChildren`;

CREATE ALGORITHM=UNDEFINED DEFINER=`meganl33`@`localhost` SQL SECURITY DEFINER VIEW `findChildren`  AS  select `relationship`.`parentId` AS `userId`,`user`.`firstName` AS `childFirstName`,`user`.`lastName` AS `childLastName`,`relationship`.`childId` AS `childId` from (`user` join `relationship` on((`user`.`id` = `relationship`.`childId`))) ;

-- --------------------------------------------------------

--
-- Structure for view `findMessages`
--
DROP TABLE IF EXISTS `findMessages`;

CREATE ALGORITHM=UNDEFINED DEFINER=`meganl33`@`localhost` SQL SECURITY DEFINER VIEW `findMessages`  AS  select `m`.`receiverId` AS `receiverId`,`m`.`senderId` AS `senderId`,`u`.`firstName` AS `senderFirstName`,`u`.`lastName` AS `senderLastName`,`m`.`id` AS `messageId`,`m`.`message` AS `message` from (`messages` `m` join `user` `u` on((`u`.`id` = `m`.`senderId`))) ;

-- --------------------------------------------------------

--
-- Structure for view `findParents`
--
DROP TABLE IF EXISTS `findParents`;

CREATE ALGORITHM=UNDEFINED DEFINER=`meganl33`@`localhost` SQL SECURITY DEFINER VIEW `findParents`  AS  select `relationship`.`childId` AS `userId`,`user`.`firstName` AS `parentFirstName`,`user`.`lastName` AS `parentLastName`,`relationship`.`parentId` AS `parentId` from (`user` join `relationship` on((`user`.`id` = `relationship`.`parentId`))) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`addressId`),
  ADD KEY `userId` (`userId`),
  ADD KEY `stateId` (`stateId`),
  ADD KEY `countryId` (`countryId`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`email`),
  ADD KEY `userId` (`userId`);

--
-- Indexes for table `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`username`),
  ADD KEY `userId` (`userId`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `senderId` (`senderId`),
  ADD KEY `receiverId` (`receiverId`);

--
-- Indexes for table `relationship`
--
ALTER TABLE `relationship`
  ADD KEY `childId` (`childId`),
  ADD KEY `parentId` (`parentId`);

--
-- Indexes for table `state`
--
ALTER TABLE `state`
  ADD PRIMARY KEY (`id`),
  ADD KEY `countryId` (`countryId`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userType` (`userType`);

--
-- Indexes for table `userType`
--
ALTER TABLE `userType`
  ADD PRIMARY KEY (`userTypeId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `addressId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `contact`
--
ALTER TABLE `contact`
  ADD CONSTRAINT `contact_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`id`);

--
-- Constraints for table `login`
--
ALTER TABLE `login`
  ADD CONSTRAINT `login_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`id`);

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`senderId`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`receiverId`) REFERENCES `user` (`id`);

--
-- Constraints for table `relationship`
--
ALTER TABLE `relationship`
  ADD CONSTRAINT `relationship_ibfk_1` FOREIGN KEY (`childId`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `relationship_ibfk_2` FOREIGN KEY (`parentId`) REFERENCES `user` (`id`);

--
-- Constraints for table `state`
--
ALTER TABLE `state`
  ADD CONSTRAINT `state_ibfk_1` FOREIGN KEY (`countryId`) REFERENCES `country` (`id`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`userType`) REFERENCES `userType` (`userTypeId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
