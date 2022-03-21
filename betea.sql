-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 21 mars 2022 à 19:55
-- Version du serveur :  5.7.31
-- Version de PHP : 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `betea`
--

-- --------------------------------------------------------

--
-- Structure de la table `administrateur`
--

DROP TABLE IF EXISTS `administrateur`;
CREATE TABLE IF NOT EXISTS `administrateur` (
  `id_admin` int(11) NOT NULL AUTO_INCREMENT,
  `nom_admin` varchar(100) NOT NULL,
  `prenom_admin` varchar(100) NOT NULL,
  `mail_admin` varchar(255) NOT NULL,
  `mdp_admin` longtext NOT NULL,
  PRIMARY KEY (`id_admin`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `administrateur`
--

INSERT INTO `administrateur` (`id_admin`, `nom_admin`, `prenom_admin`, `mail_admin`, `mdp_admin`) VALUES
(1, 'Admin', 'Administrateur', 'test@test.fr', '58ad983135fe15c5a8e2e15fb5b501aedcf70dc2');

-- --------------------------------------------------------

--
-- Structure de la table `aide`
--

DROP TABLE IF EXISTS `aide`;
CREATE TABLE IF NOT EXISTS `aide` (
  `id_aide` int(11) NOT NULL AUTO_INCREMENT,
  `id_commande_aide` varchar(100) NOT NULL,
  `code_client_aide` varchar(20) NOT NULL,
  `commentaire` varchar(255) NOT NULL,
  PRIMARY KEY (`id_aide`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `aide`
--

INSERT INTO `aide` (`id_aide`, `id_commande_aide`, `code_client_aide`, `commentaire`) VALUES
(1, 'BT-3356781815711115', 'BT38637', 'Probleme avec un bubble tea'),
(2, 'BT-3356781815711115', 'BT38637', 'Il manquait un element dans la commande'),
(10, 'BT-3799479426926050', 'BT38637', 'Les points n\'ont pas été appliqués');

-- --------------------------------------------------------

--
-- Structure de la table `avantages`
--

DROP TABLE IF EXISTS `avantages`;
CREATE TABLE IF NOT EXISTS `avantages` (
  `id_avantages` int(11) NOT NULL AUTO_INCREMENT,
  `code_avantages` varchar(20) NOT NULL,
  `code_client_avantages` varchar(20) NOT NULL,
  `rang_avantages` varchar(20) NOT NULL,
  `date_expiration` date NOT NULL,
  PRIMARY KEY (`id_avantages`),
  KEY `code_client_avantages` (`code_client_avantages`,`rang_avantages`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `avantages`
--

INSERT INTO `avantages` (`id_avantages`, `code_avantages`, `code_client_avantages`, `rang_avantages`, `date_expiration`) VALUES
(31, 'OG16417', 'BT38637', 'Expert', '2022-06-17'),
(18, 'TT13984', 'BT598024', 'Classic', '2022-05-21'),
(25, 'KG22079', 'BT591249', 'Classic', '2022-06-14'),
(27, 'TT36101', 'BT487961', 'Classic', '2022-06-16'),
(32, 'TT67789', 'BT446229', 'Classic', '2022-06-20');

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

DROP TABLE IF EXISTS `categorie`;
CREATE TABLE IF NOT EXISTS `categorie` (
  `id_categorie` int(11) NOT NULL AUTO_INCREMENT,
  `libelle_categorie` varchar(30) NOT NULL,
  `nbr_point_categorie` int(11) NOT NULL,
  `img_categorie` longtext NOT NULL,
  PRIMARY KEY (`id_categorie`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`id_categorie`, `libelle_categorie`, `nbr_point_categorie`, `img_categorie`) VALUES
(1, 'Bubble Tea', 10, 'https://i0.wp.com/be-tea.fr/wp-content/uploads/2022/01/unnamed-20.png?fit=485%2C512&ssl=1'),
(2, 'Pâtisserie', 5, 'https://i0.wp.com/be-tea.fr/wp-content/uploads/2022/01/IMG_2242_Facetune_15-01-2022-09-51-03-_1_.jpg?resize=300%2C300&ssl=1'),
(3, 'Café', 0, 'https://i0.wp.com/be-tea.fr/wp-content/uploads/2021/05/cafe-template-menu-img-1.jpg?resize=300%2C300&ssl=1');

-- --------------------------------------------------------

--
-- Structure de la table `chatbot`
--

DROP TABLE IF EXISTS `chatbot`;
CREATE TABLE IF NOT EXISTS `chatbot` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `requetes` varchar(300) NOT NULL,
  `reponses` varchar(300) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `chatbot`
--

INSERT INTO `chatbot` (`id`, `requetes`, `reponses`) VALUES
(1, 'Salut|salut|Bonjour|hello|hey||bonsoir', 'Salut ! Je suis là pour<br> répondre à tes questions.'),
(2, 'Comment tu t\'appelles ?|Quel est ton nom ?|Qui es-tu ?|Comment tu t\'appelle', 'Je m\'appelle ChatBot. '),
(3, 'Au revoir|Bonne journée|Good bye|bonne soirée|bonne journee|bonne soiree|merci au revoir', 'J\'espère t\'avoir aider,<br> au revoir et à bientôt !'),
(4, 'j\'ai un probleme |j\'ai un soucis', 'Veuillez me décrire votre problème afin que je<br> puisse vous aider.'),
(5, 'c\'est quoi BeTea ?| Be tea', '<b>Be Tea</b> est un coffe shop qui te propose différents produits que tu ne<br> trouveras pas ailleurs !'),
(6, 'comment va-tu|comment va tu| comment ca va|comment tu va|cava|ca va', 'Je vais bien merci !');

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

DROP TABLE IF EXISTS `client`;
CREATE TABLE IF NOT EXISTS `client` (
  `id_client` int(11) NOT NULL AUTO_INCREMENT,
  `code_client` varchar(20) NOT NULL,
  `nom_client` varchar(100) NOT NULL,
  `prenom_client` varchar(100) NOT NULL,
  `mail_client` varchar(255) NOT NULL,
  `date_naiss_client` date NOT NULL,
  `tel_client` int(10) NOT NULL,
  `mdp_client` longtext NOT NULL,
  `nbr_point_client` int(11) NOT NULL DEFAULT '10',
  `chemin_qr_code` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_client`),
  KEY `code_client` (`code_client`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`id_client`, `code_client`, `nom_client`, `prenom_client`, `mail_client`, `date_naiss_client`, `tel_client`, `mdp_client`, `nbr_point_client`, `chemin_qr_code`) VALUES
(1, '1', 'Enzo', 'Sin', 'enzo.sin@gmail.com', '2022-01-14', 652789067, '58ad983135fe15c5a8e2e15fb5b501aedcf70dc2', 280, 'phpqrcode/qr_code/61e37dafde37a.png'),
(2, 'BTPOZBQL', 'Dupont', 'Jean', 'jean.dupont@gmail.com', '2022-01-10', 652567890, '58ad983135fe15c5a8e2e15fb5b501aedcf70dc2', 10, 'phpqrcode/qr_code/61e37e46068ac.png'),
(3, 'BTWNBVM', 'Marie', 'Dupont', 'marie.dupont@gmail.com', '2022-01-11', 656289066, '58ad983135fe15c5a8e2e15fb5b501aedcf70dc2', 100, 'phpqrcode/qr_code/61e37e8a26670.png'),
(8, 'BT38637', 'Grant', 'Oliver', 'oliver.grant@gmail.com', '2022-01-19', 652556789, '58ad983135fe15c5a8e2e15fb5b501aedcf70dc2', 320, 'phpqrcode/qr_code/61e348acafac2.png'),
(11, 'BT487961', 'test', 'test', 'test@ezhuj.eomf', '2022-03-22', 98789098, '58ad983135fe15c5a8e2e15fb5b501aedcf70dc2', 10, 'phpqrcode/qr_code62315376005a3.png'),
(12, 'BT446229', 'test', 'test', 'test@test.test', '2022-03-09', 1234567345, '58ad983135fe15c5a8e2e15fb5b501aedcf70dc2', 10, 'phpqrcode/qr_code62374c55d0749.png');

-- --------------------------------------------------------

--
-- Structure de la table `code_promotionnel`
--

DROP TABLE IF EXISTS `code_promotionnel`;
CREATE TABLE IF NOT EXISTS `code_promotionnel` (
  `id_code_promo` int(11) NOT NULL AUTO_INCREMENT,
  `nbr_utilisation` int(11) NOT NULL,
  `code_promo` varchar(10) NOT NULL,
  `reduction` int(11) NOT NULL,
  `valide` varchar(10) NOT NULL DEFAULT 'oui',
  PRIMARY KEY (`id_code_promo`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `code_promotionnel`
--

INSERT INTO `code_promotionnel` (`id_code_promo`, `nbr_utilisation`, `code_promo`, `reduction`, `valide`) VALUES
(1, 0, 'BETEA80', 80, 'oui'),
(2, 9, 'BETEA50', 50, 'oui'),
(3, 14, 'BETEA25', 25, 'oui'),
(4, 1, 'BETEA100', 100, 'oui'),
(5, 1, 'test', 1, 'oui');

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

DROP TABLE IF EXISTS `commande`;
CREATE TABLE IF NOT EXISTS `commande` (
  `id_commande` int(11) NOT NULL AUTO_INCREMENT,
  `code_commande` varchar(50) NOT NULL,
  `code_client_commande` varchar(30) NOT NULL,
  `commande` longtext NOT NULL,
  `prix_commande` double NOT NULL,
  `date_commande` datetime NOT NULL,
  `point_en_attente` int(11) NOT NULL DEFAULT '0',
  `statut_commande` varchar(30) NOT NULL DEFAULT 'En attente',
  PRIMARY KEY (`id_commande`),
  KEY `code_client_commande` (`code_client_commande`)
) ENGINE=InnoDB AUTO_INCREMENT=96 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `commande`
--

INSERT INTO `commande` (`id_commande`, `code_commande`, `code_client_commande`, `commande`, `prix_commande`, `date_commande`, `point_en_attente`, `statut_commande`) VALUES
(13, 'BT-7514833775405692', 'BT38637', '1 Cookie, ', 3.2, '2022-01-17 14:21:37', 0, 'Terminé'),
(28, 'BT-4713256524169872', '1', '1 Jasmin Tea, ', 6.8, '2022-01-17 15:01:51', 0, 'Terminé'),
(29, 'BT-4984666783697058', 'BT38637', '1 Brownie, ', 2, '2022-01-17 15:04:02', 0, 'Annulée'),
(30, 'BT-9968366535496884', '1', '1 Cookie, 1 Brownie, ', 5.2, '2022-01-17 15:04:59', 0, 'Annulée'),
(50, 'BT-6551237191654666', 'BT38637', '1 Jasmin Tea, 1 Bubble Tea Pêche, 1 Bubble Tea Litchi, ', 18.4, '2022-01-20 14:58:12', 0, 'Terminé'),
(58, 'BT-3799479426926050', 'BT38637', '1 Jasmin Tea, ', 6.8, '2022-01-20 22:12:34', 0, 'Terminé'),
(59, 'BT-6437665761338077', 'BT38637', '1 Allongé, 1 Espresso, ', 5.15, '2022-01-21 16:46:45', 0, 'Terminé'),
(76, 'BT-7191912411569726', '1', '1 Brownie, ', 2, '2022-02-08 16:08:46', 5, 'En attente'),
(78, 'BT-1631208334272474', 'BT38637', '1 Jasmine Green Tea, ', 4.5, '2022-02-14 14:49:34', 0, 'En attente'),
(81, 'BT-3356781815711115', 'BT38637', '1 Cookie, 1 Brookie, 1 Carrot Cake, 1 Banana Bread, ', 9.2, '2022-03-01 16:30:14', 20, 'En attente'),
(90, 'BT-3991785170713966', 'BT38637', '354 Cookie, 6 Taro Milk Tea , 4 Jasmine Green Tea, ', 1186.8, '2022-03-14 18:31:05', 0, 'En attente'),
(94, 'BT-6194244898867718', 'BT38637', '1 Jasmine Green Milk Tea, ', 4.8, '2022-03-15 14:26:49', 10, 'En cours'),
(95, 'BT-2246112415341888', 'BT38637', '1 Jasmine Green Milk Tea, 1 Black Milk Tea, 1 Cookie, ', 12.8, '2022-03-20 16:47:48', 25, 'Annulée');

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

DROP TABLE IF EXISTS `produit`;
CREATE TABLE IF NOT EXISTS `produit` (
  `id_produit` int(11) NOT NULL AUTO_INCREMENT,
  `libelle_produit` varchar(30) NOT NULL,
  `prix_produit` double NOT NULL,
  `img_produit` longtext,
  `disponibilite_produit` varchar(30) NOT NULL DEFAULT 'Indisponible',
  `id_categorie_produit` int(11) NOT NULL,
  `masquer_produit` varchar(10) DEFAULT 'Oui',
  PRIMARY KEY (`id_produit`),
  KEY `id_categorie_produit` (`id_categorie_produit`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `produit`
--

INSERT INTO `produit` (`id_produit`, `libelle_produit`, `prix_produit`, `img_produit`, `disponibilite_produit`, `id_categorie_produit`, `masquer_produit`) VALUES
(1, 'Jasmine Green Milk Tea', 4.8, 'ressource/images/bbt1.png', 'Disponible', 1, 'Non'),
(2, 'Cookie', 3.2, 'ressource/images/patiserie1.png', 'Disponible', 2, 'Non'),
(3, 'Brownie', 2, 'ressource/images/patiserie2.png', 'Disponible', 2, 'Non'),
(4, 'Ristretto - Espresso', 2.2, 'ressource/images/cafe1.png', 'Disponible', 3, 'Non'),
(5, 'Espresso macchiato', 2.5, 'ressource/images/cafe2.png', 'Disponible', 3, 'Non'),
(11, 'Black Milk Tea', 4.8, 'ressource/images/bbt2.png', 'Disponible', 1, 'Non'),
(12, 'Oolong Milk Tea', 5.8, 'ressource/images/bbt3.png', 'Disponible', 1, 'Non'),
(13, 'Taro Milk Tea ', 6, 'ressource/images/bbt4.png', 'Disponible', 1, 'Non'),
(14, 'Matcha Milk Tea', 6, 'ressource/images/bbt5.png', 'Indisponible', 1, 'Non'),
(15, 'Jasmine Green Tea', 4.5, 'ressource/images/bbt6.png', 'Disponible', 1, 'Non'),
(16, 'Black Tea', 4.5, 'ressource/images/bbt7.png', 'Indisponible', 1, 'Non'),
(17, 'Oolong Tea', 4.5, 'ressource/images/bbt8.png', 'Disponible', 1, 'Non'),
(18, 'Classic Brown Sugar', 6.5, 'ressource/images/bbt9.png', 'Disponible', 1, 'Non'),
(19, 'Matcha Brown Sugar', 6.8, 'ressource/images/bbt10.png', 'Disponible', 1, 'Non'),
(20, 'Espresso Brown Sugar', 6.8, 'ressource/images/bbt11.png', 'Disponible', 1, 'Non'),
(21, 'Signature Brown Sugar', 7.2, 'ressource/images/bbt12.png', 'Disponible', 1, 'Non'),
(22, 'Lime Tea', 6, 'ressource/images/bbt13.png', 'Disponible', 1, 'Non'),
(23, 'Citrus Tea', 6.5, 'ressource/images/bbt14.png', 'Disponible', 1, 'Non'),
(24, 'Grapefruit Tea', 6.5, 'ressource/images/bbt15.png', 'Indisponible', 1, 'Non'),
(25, 'Pineapple Tea', 6.5, 'ressource/images/bbt16.png', 'Disponible', 1, 'Non'),
(26, 'Kumquat Tea', 6.5, 'ressource/images/bbt17.png', 'Indisponible', 1, 'Oui'),
(27, 'Honey kumquat Tea', 6.8, 'ressource/images/bbt1.png', 'Disponible', 1, 'Non'),
(28, 'Honey Lemon Tea', 6.8, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSdldyoXINgFvdVp1DghB-odwWLIQvlmPPlMA&usqp=CAU', 'Disponible', 1, 'Non'),
(29, 'Passion Fruit Tea', 6.8, 'ressource/images/bbt5.png', 'Indisponible', 1, 'Non'),
(30, 'Lime Slush', 6, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRHHLkQszlI9FqQGTluu4EM1-B-LqH-hV6s_Q&usqp=CAU', 'Disponible', 1, 'Non'),
(31, 'Mango Slush', 6.8, 'data:image/jpeg;base64,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', 'Disponible', 1, 'Non'),
(32, 'Passion fruit slush', 6.8, 'ressource/images/bbt19.png', 'Indisponible', 1, 'Oui'),
(33, 'Grapefruit Slush', 6.8, 'ressource/images/bbt1.png', 'Disponible', 1, 'Non'),
(34, 'Red Grapes Slush', 6.8, 'ressource/images/bbt18.png', 'Indisponible', 1, 'Oui'),
(35, 'Strawberry Slush', 6.8, 'ressource/images/bbt2.png', 'Disponible', 1, 'Non'),
(36, ' Avocado Slush', 7, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRpp0nZEUn98fk64AW8Rd-DrL6QRQ-zaOdihA&usqp=CAU', 'Disponible', 1, 'Non'),
(37, 'Green Apple Slush', 6, 'ressource/images/bbt3.png', 'Disponible', 1, 'Non'),
(38, 'Americano', 2.5, 'ressource/images/cafe3.png', 'Disponible', 3, 'Non'),
(39, 'Cappuccino', 4.8, 'ressource/images/cafe4.png', 'Disponible', 3, 'Non'),
(40, 'Mocha', 4.8, 'ressource/images/cafe5.png', 'Disponible', 3, 'Non'),
(41, 'Hot Chocolate', 4.8, 'ressource/images/cafe6.png', 'Disponible', 3, 'Non'),
(42, 'Iced Coffee Signature', 5, 'ressource/images/cafe7.png', 'Disponible', 3, 'Non'),
(43, 'Brookie', 2, 'ressource/images/patiserie3.png', 'Disponible', 2, 'Non'),
(44, 'Banana Bread', 2, 'ressource/images/patiserie4.png', 'Disponible', 2, 'Non'),
(45, 'Carrot Cake', 2, 'ressource/images/patiserie5.png', 'Disponible', 2, 'Non'),
(46, 'Lemon Cake Pavo', 2, 'ressource/images/patiserie6.png', 'Indisponible', 2, 'Non');

-- --------------------------------------------------------

--
-- Structure de la table `rang`
--

DROP TABLE IF EXISTS `rang`;
CREATE TABLE IF NOT EXISTS `rang` (
  `id_rang` int(11) NOT NULL AUTO_INCREMENT,
  `libelle_rang` varchar(30) NOT NULL,
  `palier` int(11) NOT NULL,
  PRIMARY KEY (`id_rang`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `rang`
--

INSERT INTO `rang` (`id_rang`, `libelle_rang`, `palier`) VALUES
(1, 'Classic', 10),
(2, 'Medium', 150),
(3, 'Expert', 300);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commande`
--
ALTER TABLE `commande`
  ADD CONSTRAINT `commande_ibfk_1` FOREIGN KEY (`code_client_commande`) REFERENCES `client` (`code_client`);

--
-- Contraintes pour la table `produit`
--
ALTER TABLE `produit`
  ADD CONSTRAINT `produit_ibfk_1` FOREIGN KEY (`id_categorie_produit`) REFERENCES `categorie` (`id_categorie`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
