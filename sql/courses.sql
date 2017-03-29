
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE IF NOT EXISTS `country` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `coun_name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE IF NOT EXISTS `courses` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `cour_name` varchar(100) NOT NULL,
  `cour_dept`  bigint(255) NOT NULL,
  `cour_code`  varchar(25) NOT NULL,
  `cour_weight` bigint(1),
  `cour_major` bigint(255),
  `cour_inst` bigint(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE IF NOT EXISTS `grades` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `ap` smallint(3) NOT NULL,
  `a` smallint(3) NOT NULL,  
  `am` smallint(3) NOT NULL,
  `bp` smallint(3) NOT NULL,
  `b` smallint(3) NOT NULL,
  `bm` smallint(3) NOT NULL,
  `cp` smallint(3) NOT NULL,
  `c` smallint(3) NOT NULL,
  `cm` smallint(3) NOT NULL,
  `dp` smallint(3) NOT NULL,
  `d` smallint(3) NOT NULL,
  `dm` smallint(3) NOT NULL,
  `grades_inst` bigint(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE IF NOT EXISTS `department` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `dept_name` varchar(100) NOT NULL,
  `dept_school` bigint(255) NOT NULL,
  `dept_inst` bigint(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `institution`
--

CREATE TABLE IF NOT EXISTS `institution` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `inst_name` varchar(100) NOT NULL,
  `inst_country` bigint(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `majors`
--

CREATE TABLE IF NOT EXISTS `majors` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `majr_name` varchar(100) NOT NULL,
  `majr_dept` bigint(255) NOT NULL,
  `majr_inst` bigint(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `progress`
--

CREATE TABLE IF NOT EXISTS `progress` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `prog_student` bigint(255) NOT NULL,
  `prog_course` bigint(255) NOT NULL,
  `prog_grade` varchar(2) NOT NULL,
  `prog_aim` varchar(2) NOT NULL,
  `prog_comment` varchar(50) NOT NULL,
  `prog_date` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `merger`
--

CREATE TABLE IF NOT EXISTS `merger` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `merg_inst` bigint(255) NOT NULL,
  `merg_maj` bigint(255) NOT NULL,
  `merg_course` bigint(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `school`
--

CREATE TABLE IF NOT EXISTS `school` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `scho_name` varchar(100) NOT NULL,
  `scho_inst` bigint(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

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
