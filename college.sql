-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 29, 2018 at 02:21 PM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `college`
--

-- --------------------------------------------------------

--
-- Table structure for table `administrators`
--

CREATE TABLE `administrators` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(80) NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL,
  `phone` tinytext NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(200) NOT NULL,
  `image_link` varchar(1500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `administrators`
--

INSERT INTO `administrators` (`id`, `name`, `role_id`, `phone`, `email`, `password`, `image_link`) VALUES
(1, 'Elrond', 1, '0507777777', 'elrond@gmail.com', '$2y$10$AXoWUZWWmU9BHfLMAcw/J.WDV.7E4ZRXPtrd5p0Q/5Z4yT7DSTDey', 'images/elrond.jpg'),
(2, 'Peregrin', 2, '0548259632', 'peregrin@gmail.com', '$2y$10$sxxUtDOZNZVoYVGAkQijreH2A0vu7Y8sBy.iGDGHC544rZiju4/FC', 'images/peregrin.jpg'),
(3, 'Frodo', 2, '0502369874', 'frodo@gmail.com', '$2y$10$MvAAfJ1Ok089CwZmsDFCtOXu1h./oeotLbl6XQc2FUvRxajFlu7p6', 'images/Frodo.jpg'),
(4, 'Meriadoc', 3, '0503698521', 'meriadoc@gmail.com', '$2y$10$1jU.OIbUo/LqCzPFcNMOoOzScA8S2j3jg1BPKYYKXK68wvyrgpR3G', 'images/meriadoc.jpg'),
(5, 'Gollum', 3, '0542225874', 'gollum@gmail.com', '$2y$10$5FtzX267YpRt2aLaVqmMIeg662s50u3esyLBJU4xAWqfa3u9xD49u', 'images/gollum.png'),
(9, 'Sauron', 2, '0532225441', 'sauron@gmail.com', '$2y$10$02h5/V8byWTdvXzdJs.SD.2mnajp.5P9J/uiWxmh4s55ChjfsXZPy', 'images/sauron.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(80) NOT NULL,
  `description` varchar(800) NOT NULL,
  `image_link` varchar(1500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `name`, `description`, `image_link`) VALUES
(5, 'The History of the One Ring', 'The \"One Ring\" was one of the most powerful artifacts ever created in Middle-earth. It was crafted by the Dark Lord Sauron in the fire of Orodruin, also known as Mount Doom during the Second Age. Sauron\'s intent was to enhance his own power, and to exercise control over the other Rings of Power, which had been made by Celebrimbor and his people with Sauron\'s assistance. In this way, he hoped to gain lordship over the Elves and all of the other races in Middle-earth. In this course we will learn about the history of that ring.', 'images/ring.jpg'),
(7, 'The Maps of Middle-Earth', 'Lord of the Rings Project, commonly shortened LotrProject, is a creative web project dedicated to the works of J.R.R. Tolkien. It is perhaps most known for the extensive and ever updating genealogy, the historical timeline of Middle-Earth and the statistics of the population of Middle-Earth. In this specific course we will learn how to read the maps that the writer created.', 'images/map.jpg'),
(8, 'The Pandas of Valinor', 'learn about pandas', 'images/panda.jpg'),
(9, 'The White Macaques of the Frozen Lands', 'The Middle-Earth macaque also known as the snow monkey, is a terrestrial Old World monkey species that is native to Middle-Earth. They get their name \"snow monkey\" because they live in areas where snow covers the ground for months each year â€“ no other nonhuman primate is more northern-living, nor lives in a colder climate.\r\nIn this course we learn about their lives and how with their help Gandalf the wizard uses dark magic for the Istari Order. ', 'images/A1831J0024_13.jpg'),
(28, 'The History of the Elves', 'The Elves, who called themselves the Quendi, and who in lore are commonly referred to as the Eldar (adj. Eldarin), were the first and eldest of the Children of IlÃºvatar, and are considered to be the fairest and wisest of any race of Arda given sapience.\r\n\r\nSome, known afterwards as the Calaquendi (Elves of the Light), were brought by the Valar from Middle-earth to Valinor across the Sea, where they were taught by the Ainur. But after the Silmarils were stolen by Melkor, some of the Elves returned to Middle-earth, where they remained until the end of the Third Age', 'images/Elves.jpg'),
(87, 'Tails from Gondor', 'Gondor was the prominent kingdom of Men in Middle-earth, bordered by Rohan to the north, Harad to the south, the cape of Andrast and the Sea to the west, and Mordor to the east. Its first capital was Osgiliath, moved to Minas Tirith in TA 1640. The city of Minas Tirith remained the capital of Gondor for the rest of the Third Age and into years of the Fourth Age; other major fortresses include Dol Amroth in Belfalas and Osgiliath, which was a city on the Anduin.', 'images/Gondor.jpg'),
(93, 'Stories from Rivendell', 'Rivendell, also known as Imladris, was an Elven town and the house of Elrond located in Middle-earth. It is described as \"The Last Homely House East of the Sea\", referencing towards Valinor, which is west of the Great Sea in Aman.\r\nThe peaceful, sheltered town of Rivendell was located at the edge of a narrow gorge of the river Bruinen (one of the main approaches to Rivendell comes from the nearby Ford of Bruinen), but well hidden in the moorlands and foothills of the Misty Mountains.', 'images/rivendell.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `enrollment`
--

CREATE TABLE `enrollment` (
  `id` int(10) UNSIGNED NOT NULL,
  `course_id` int(10) UNSIGNED NOT NULL,
  `student_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `enrollment`
--

INSERT INTO `enrollment` (`id`, `course_id`, `student_id`) VALUES
(110, 5, 1),
(92, 5, 3),
(11, 5, 8),
(122, 7, 2),
(97, 7, 3),
(116, 9, 2),
(99, 9, 6),
(14, 9, 7),
(109, 28, 1),
(96, 28, 3),
(95, 87, 3),
(91, 87, 6),
(13, 87, 7),
(118, 87, 8),
(119, 93, 1),
(121, 93, 7),
(117, 93, 8);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `role` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role`) VALUES
(1, 'Owner'),
(2, 'Manager'),
(3, 'Sales');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(80) NOT NULL,
  `phone` tinytext NOT NULL,
  `email` varchar(100) NOT NULL,
  `image_link` varchar(1500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `name`, `phone`, `email`, `image_link`) VALUES
(1, 'Aragorn', '+972-54-7773227', 'aragorn@gmail.com', 'images/Aragorn.png'),
(2, 'Galadriel', '+972-53-3254244', 'galadriel@gmail.com', 'images/galadriel.png'),
(3, 'Gandalf', '0506252744', 'gandalf@gmail.com', 'images/gandalf.png'),
(5, 'Arwen', '0546967888', 'arwen@gamil.com', 'images/Arwen.jpg'),
(6, 'Sam', '0527776852', 'samwise@gmail.com', 'images/sam.jpg'),
(7, 'Gimli', '0503637441', 'gimli@gmail.com', 'images/gimli.jpg'),
(8, 'Legolas', '0542223698', 'legolas@gmail.com', 'images/Legolas.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administrators`
--
ALTER TABLE `administrators`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `role` (`role_id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name_idx` (`name`);

--
-- Indexes for table `enrollment`
--
ALTER TABLE `enrollment`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_index` (`course_id`,`student_id`),
  ADD KEY `enrollment_ibfk_2` (`student_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `administrators`
--
ALTER TABLE `administrators`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT for table `enrollment`
--
ALTER TABLE `enrollment`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=130;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `administrators`
--
ALTER TABLE `administrators`
  ADD CONSTRAINT `administrators_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `enrollment`
--
ALTER TABLE `enrollment`
  ADD CONSTRAINT `enrollment_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `enrollment_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
