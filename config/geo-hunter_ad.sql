-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 10 juin 2022 à 13:44
-- Version du serveur : 10.4.21-MariaDB
-- Version de PHP : 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `geo-hunter`
--

/*DELIMITER $$
--
-- Fonctions
--
CREATE DEFINER=`geo-hunt`@`mysql-geo-hunt.alwaysdata.net` FUNCTION `getAvailableHunt_ID` () RETURNS INT(11) BEGIN
    DECLARE id INT;
SELECT COALESCE(MIN(h1.hunt_id+1),1) INTO id
FROM Hunts h1 LEFT JOIN Hunts h2 ON h1.hunt_id+1 = h2.hunt_id
WHERE h2.hunt_id IS NULL;
RETURN id;
END$$

CREATE DEFINER=`geo-hunt`@`mysql-geo-hunt.alwaysdata.net` FUNCTION `getAvailableTeam_ID` () RETURNS INT(11) BEGIN
    DECLARE id INT;
SELECT COALESCE(MIN(t1.team_id+1),1) INTO id
FROM Teams t1 LEFT JOIN Teams t2 ON t1.team_id+1 = t2.team_id
WHERE t2.team_id IS NULL;
RETURN id;
END$$

CREATE DEFINER=`geo-hunt`@`mysql-geo-hunt.alwaysdata.net` FUNCTION `getAvailableUser_ID` () RETURNS INT(11) BEGIN
    DECLARE id INT;
    SELECT COALESCE(MIN(u1.user_id+1),1) INTO id
    FROM User u1 LEFT JOIN User u2 ON u1.user_id+1 = u2.user_id
    WHERE u2.user_id IS NULL;
RETURN id;
END$$

DELIMITER ;*/;

-- --------------------------------------------------------

--
-- Structure de la table `access`
--

CREATE TABLE `access` (
  `hunt_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `attempts`
--

CREATE TABLE `attempts` (
  `attempt_id` int(11) NOT NULL,
  `hunt_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `attempt_time` time NOT NULL,
  `attempt_date` date NOT NULL,
  `score` int(11) NOT NULL,
  `win` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `attempts`
--

INSERT INTO `attempts` (`attempt_id`, `hunt_id`, `user_id`, `attempt_time`, `attempt_date`, `score`, `win`) VALUES
(1, 1, 1, '23:39:53', '2022-03-01', 100, 1),
(2, 1, 1, '11:40:40', '2022-03-01', 80, 1),
(3, 1, 1, '24:40:40', '2022-03-01', 80, 1);

-- --------------------------------------------------------

--
-- Structure de la table `hunts`
--

CREATE TABLE `hunts` (
  `hunt_id` int(11) NOT NULL,
  `hunt_title` varchar(128) NOT NULL,
  `privacy` tinyint(1) NOT NULL,
  `lat` double NOT NULL,
  `lon` double NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `hunts`
--

INSERT INTO `hunts` (`hunt_id`, `hunt_title`, `privacy`, `lat`, `lon`, `user_id`) VALUES
(1, 'dublin hunt', 1, 0, 0, 1),
(2, 'tttt', 0, 43.13806682281793, 6.018054390589043, 4);

-- --------------------------------------------------------

--
-- Structure de la table `hunt_qu_list`
--

CREATE TABLE `hunt_qu_list` (
  `qu_id` int(11) NOT NULL,
  `hunt_id` int(11) NOT NULL,
  `qu_num` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `questions`
--

CREATE TABLE `questions` (
  `qu_id` int(11) NOT NULL,
  `qu_title` varchar(128) NOT NULL,
  `qu_text` varchar(2048) NOT NULL,
  `privacy` tinyint(1) NOT NULL,
  `lat` double NOT NULL,
  `lon` double NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `teams`
--

CREATE TABLE `teams` (
  `team_id` int(11) NOT NULL,
  `team_name` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `teams`
--

INSERT INTO `teams` (`team_id`, `team_name`) VALUES
(3, 'testteam2');

-- --------------------------------------------------------

--
-- Structure de la table `teams_user`
--

CREATE TABLE `teams_user` (
  `team_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rank` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `teams_user`
--

INSERT INTO `teams_user` (`team_id`, `user_id`, `rank`) VALUES
(3, 1, 1),
(3, 3, 0);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `username` varchar(32) NOT NULL,
  `email` varchar(128) NOT NULL,
  `password` varchar(256) NOT NULL,
  `join_date` date NOT NULL,
  `profile_pic` varchar(4096) NOT NULL,
  `description` varchar(2048) NOT NULL,
  `admin` tinyint(1) NOT NULL,
  `token` varchar(32) NOT NULL,
  `enabled` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`user_id`, `username`, `email`, `password`, `join_date`, `profile_pic`, `description`, `admin`, `token`, `enabled`) VALUES
(1, 'CSoler', 'clement.soler2000@gmail.com', '6ec52c720a1c524c3483fd30103b4cbd93dabab4ebd8b9e3c33d2670ba7ed590', '2022-03-11', '', '', 1, 'verified', 1),
(2, 'thomas', 'ephad@miramas.com', 'fc4737943f85023eef59eb5d7437c463806d5766377ffecc593b6f090e967243', '2022-06-02', '', '', 0, 'verified', 1),
(3, 'yvan', 'yvan@leptivieux.com', '2e026315d2c333bced8b0da9e46f99c9ec77adf883d7378a676ffcb037321623', '2022-06-09', '', '', 0, 'verified', 1),
(4, 'test', 'test@mail.com', '4df291b0d64b62a0d48afb3d2a556f38197a1ccff2e40cba228d57511aef2dca', '2022-06-10', '', '', 0, 'verified', 1);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `access`
--
ALTER TABLE `access`
  ADD PRIMARY KEY (`hunt_id`,`user_id`),
  ADD KEY `User_Access_fk` (`user_id`);

--
-- Index pour la table `attempts`
--
ALTER TABLE `attempts`
  ADD PRIMARY KEY (`attempt_id`),
  ADD KEY `User_Attempts_fk` (`user_id`),
  ADD KEY `Hunts_Attempts_fk` (`hunt_id`);

--
-- Index pour la table `hunts`
--
ALTER TABLE `hunts`
  ADD PRIMARY KEY (`hunt_id`),
  ADD KEY `User_Hunts_fk` (`user_id`);

--
-- Index pour la table `hunt_qu_list`
--
ALTER TABLE `hunt_qu_list`
  ADD PRIMARY KEY (`qu_id`,`hunt_id`),
  ADD KEY `Hunts_Hunt_qu_fk` (`hunt_id`);

--
-- Index pour la table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`qu_id`),
  ADD KEY `User_Questions_fk` (`user_id`);

--
-- Index pour la table `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`team_id`);

--
-- Index pour la table `teams_user`
--
ALTER TABLE `teams_user`
  ADD PRIMARY KEY (`team_id`,`user_id`),
  ADD KEY `User_Teams_User_fk` (`user_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `access`
--
ALTER TABLE `access`
  ADD CONSTRAINT `Hunts_Access_fk` FOREIGN KEY (`hunt_id`) REFERENCES `hunts` (`hunt_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `User_Access_fk` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `attempts`
--
ALTER TABLE `attempts`
  ADD CONSTRAINT `Hunts_Attempts_fk` FOREIGN KEY (`hunt_id`) REFERENCES `hunts` (`hunt_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `User_Attempts_fk` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `hunts`
--
ALTER TABLE `hunts`
  ADD CONSTRAINT `User_Hunts_fk` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `hunt_qu_list`
--
ALTER TABLE `hunt_qu_list`
  ADD CONSTRAINT `Hunts_Hunt_qu_fk` FOREIGN KEY (`hunt_id`) REFERENCES `hunts` (`hunt_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `Questions_Hunt_qu_fk` FOREIGN KEY (`qu_id`) REFERENCES `questions` (`qu_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `User_Questions_fk` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `teams_user`
--
ALTER TABLE `teams_user`
  ADD CONSTRAINT `Teams_Teams_User_fk` FOREIGN KEY (`team_id`) REFERENCES `teams` (`team_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `User_Teams_User_fk` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
