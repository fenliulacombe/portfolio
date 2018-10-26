-- phpMyAdmin SQL Dump
-- version 4.1.4
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Dim 23 Septembre 2018 à 04:51
-- Version du serveur :  5.6.15-log
-- Version de PHP :  5.5.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `conference`
--

-- --------------------------------------------------------

--
-- Structure de la table `presentation`
--

CREATE TABLE IF NOT EXISTS `presentation` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `thematique` varchar(255) DEFAULT NULL,
  `date_presentation` date DEFAULT NULL,
  `heure_debut` time DEFAULT NULL,
  `heure_fin` time DEFAULT NULL,
  `salle` varchar(255) DEFAULT NULL,
  `presentateur` varchar(255) DEFAULT NULL,
  `institution` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=41 ;

--
-- Contenu de la table `presentation`
--

INSERT INTO `presentation` (`id`, `title`, `description`, `thematique`, `date_presentation`, `heure_debut`, `heure_fin`, `salle`, `presentateur`, `institution`) VALUES
(1, 'Freedom rising', 'From the Arab Spring to the emerging democracies of Eastern Europe, a new generation of freedom fighters ( entrepreneurs, journalists, activists ) shares powerful stories of resistance against dictatorships and oppression.', 'Activism', '2018-09-13', '00:00:00', '00:00:00', '401', 'Wael Ghonim', 'University de Montreal'),
(2, 'How language changes over time', 'Language is not set in stone. It changes all the time (and in turn, our language changes us). These talks explore how new words come to be.', 'Culture', '2018-08-01', '00:00:00', '00:00:00', '501', 'John Mcwhorter', 'UQAM'),
(3, 'Time warp', 'Time is measured in seconds, minutes and hours. But these talks show it''s not always so simple.', 'Histoire', '2018-09-01', '00:00:00', '00:00:00', '450', 'Yuval Noah', 'University de Montreal'),
(4, 'What separates us from chimpanzees', 'Jane Goodall has not found the missing link, but she is come closer than nearly anyone else. The primatologist says the only real difference between humans and chimps is our sophisticated language. She urges us to start using it to change the world.', 'Histoire', '2018-09-01', '00:00:00', '00:00:00', '320', 'Jane Goodall', 'University de New York'),
(5, 'Climate change: Oh, it is real. modififer456', 'We still have a lot to learn about climate change, about why it is happening and what that means. But one thing is clear= It is real, alright. These talks provide a primer on the issue of our times.', 'Activism', '0000-00-00', '00:00:00', '10:00:00', '420', 'Mary Robinson', 'University of Montreal'),
(29, 'le petit prince', 'une histoire de gentillesse', 'Activism', '0000-00-00', NULL, '00:00:00', 'chez Dodo', 'Dodo', 'Fen SA'),
(31, 'le petit prince', 'testfull', 'Histoire', '2018-09-22', NULL, '00:00:00', 'salle dodo', 'Dodo', 'Psychiatrique'),
(38, 'testhaha', 'une histoire de gentillesse', 'Activism', '0000-00-00', '00:00:00', '00:00:00', 'chez Dodo', 'Dodo', 'University of Montreal'),
(39, 'dodo1', 'We still have a lot to learn about climate change, about why it is happening and what that means. But one thing is clear= It is real, alright. These talks provide a primer on the issue of our times.', 'Arts', '0000-00-00', '00:00:00', '00:00:00', 'salle dodo', 'Dodo', 'University of Montreal'),
(40, 'test1', 'une histoire de gentillesse', 'Activism', '0000-00-00', '12:47:00', '12:48:00', 'salle dodo', 'Dodo', 'University of Montreal');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
