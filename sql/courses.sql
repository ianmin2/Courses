SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE `students` (
  `id` bigint(255) NOT NULL,
  `stud_name` varchar(100) NOT NULL,
  `stud_inst` bigint(255) NOT NULL,
  `stud_major` bigint(255) NOT NULL,
  `stud_minor` bigint(255) NOT NULL,
  `stud_identification` varchar(10) NOT NULL,
  `stud_passkey` text NOT NULL,
  `stud_country` int(255) NOT NULL,
  `stud_school` int(255) NOT NULL,
  `stud_email` text NOT NULL,
  `stud_dept` int(255) NOT NULL,
  `stud_twitter` text NOT NULL,
  `stud_google` text NOT NULL,
  `stud_yahoo` text NOT NULL,
  `stud_live` text NOT NULL,
  `stud_facebook` text NOT NULL,
  `stud_linkedin` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `students` (`id`, `stud_name`, `stud_inst`, `stud_major`, `stud_minor`, `stud_identification`, `stud_passkey`, `stud_country`, `stud_school`, `stud_email`, `stud_dept`, `stud_twitter`, `stud_google`, `stud_yahoo`, `stud_live`, `stud_facebook`, `stud_linkedin`) VALUES
(1, 'IAN INNOCENT MBAE', 1, 1, 0, 'SKAMIA1321', 'rpWoZFyoj9aliZqH', 112, 1, 'ianmin2@live.com', 1, '', '', '', '', '', '');


ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `stud_inst` (`stud_inst`,`stud_identification`);


ALTER TABLE `students`
  MODIFY `id` bigint(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
