-- phpMyAdmin SQL Dump
-- version 4.2.10
-- http://www.phpmyadmin.net
--
-- Client :  localhost:8889
-- Généré le :  Lun 30 Mars 2015 à 15:05
-- Version du serveur :  5.5.38
-- Version de PHP :  5.6.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données :  `eqnxweb`
--

--
-- Contenu de la table `news`
--

INSERT INTO `news` (`id`, `date_publi`, `date_start`, `date_end`, `date_update`, `status`, `imageUrl`) VALUES
(24, '2014-01-13 09:03:27', '2014-01-13 13:03:45', '0000-00-00 00:00:00', '2015-03-30 13:03:45', 1, NULL),
(25, '2014-05-02 09:03:18', '2014-05-02 12:03:25', '0000-00-00 00:00:00', '2015-03-30 12:03:25', 1, '1427714905.jpg'),
(26, '2014-06-26 09:03:52', '2014-06-26 09:03:09', '0000-00-00 00:00:00', '2015-03-30 09:03:09', 1, NULL),
(27, '2014-08-08 09:03:58', '2014-08-08 09:03:12', '0000-00-00 00:00:00', '2015-03-30 09:03:12', 1, '1427705472.jpg'),
(28, '2014-09-03 09:03:06', '2014-09-03 09:03:22', '0000-00-00 00:00:00', '2015-03-30 09:03:22', 1, '1427705362.jpg'),
(29, '2014-11-05 09:03:46', '2014-11-05 09:03:46', '0000-00-00 00:00:00', '2015-03-30 09:03:46', 1, NULL);

--
-- Contenu de la table `news_trad`
--

INSERT INTO `news_trad` (`id`, `id_news`, `id_lang`, `title`, `sub_title`, `content`) VALUES
(50, 24, 1, 'Générez vos statistiques directement dans IS-Academia', '', '<p>Un nouveau module enti&egrave;rement d&eacute;di&eacute; &agrave; l''analyse de donn&eacute;es est maintenant &agrave; votre disposition. Ces nouvelles fonctionnalit&eacute;s font parties de la version ISA-1402.</p>\r\n<ul>\r\n<li>D&eacute;finition de diff&eacute;rentes sources de donn&eacute;es</li>\r\n<li>Cr&eacute;ation de tableaux &agrave; deux niveaux</li>\r\n<li>D&eacute;finition de diff&eacute;rentes repr&eacute;sentations graphiques</li>\r\n</ul>\r\n<p>A la fois simple d''utilisation et extr&ecirc;mement convivial, ce nouvel environnement d''analyse de donn&eacute;es, compl&egrave;tera avantageusement votre syst&egrave;me IS-Academia.</p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>'),
(51, 24, 2, 'Statistiken mit IS-Academia ', '', '<p>Ein neues Register widmet sich der Erzeugung von Statistiken, direkt durch IS-Academia, steht jetzt zur Verf&uuml;gung. Diese neuen Funktionen sind in der IS-Academia Version 1402 verf&uuml;hgbar.</p>\r\n<p>Ein neues Register f&uuml;r die Datenanalyse wird zurzeit getestet. Diese neuen Funktionalit&auml;ten werden mit der Version 1402 ver&ouml;ffentlicht.</p>\r\n<ul>\r\n<li>Definieren der verschiedenen Datenquellen</li>\r\n<li>Erstellen von 2-stufigen Tabellen</li>\r\n<li>Definieren von verschiedenen graphischen Darstellungen</li>\r\n</ul>\r\n<p>&nbsp;</p>'),
(52, 24, 3, '', '', ''),
(53, 24, 4, '', '', ''),
(54, 25, 1, 'Le design web, partie intégrante de vos projets ', '', '<p><span class="contentText">Depuis le mois d''avril 2014, deux web designer ont rejoint notre soci&eacute;t&eacute; avec pour objectif d''int&eacute;grer la dimension Design et graphisme directement dans vos projets de mise en place des fonctionnalit&eacute;s d''IS-Academia. L''objectif vis&eacute; ici est de compl&egrave;tement profiler IS-Academia ou tout autre impl&eacute;mentation informatique, &agrave; votre propre identit&eacute; visuelle.</span></p>'),
(55, 25, 3, 'Web Design, full part of all your projects', '', '<p>Since April 2014, two web designer joined our company with the objective of integrating the Design and graphic dimension directly into your implementation projects and in particular with IS-Academia. The objective here is to completely streamline IS-Academia or any other IT implementation at your own visual identity.</p>'),
(56, 26, 1, 'La facturation revisitée', '', '<p>Un nouveau module enti&egrave;rement d&eacute;di&eacute; &agrave; la facturation des d&eacute;bours de vos &eacute;tudiants est &agrave; votre disposition. Ces nouvelles fonctionnalit&eacute;s font parties de la version ISA-1405.</p>\r\n<ul>\r\n<li>D&eacute;finition de diff&eacute;rents mod&egrave;les de facturation</li>\r\n<li>D&eacute;finition illimit&eacute;e de lignes de factures, g&eacute;r&eacute;es par r&egrave;gle</li>\r\n<li>Association par glisser/lacher (drag &amp; drop), de la population de personnes &agrave; un mod&egrave;le de facturation</li>\r\n<li>et bien plus encore.</li>\r\n</ul>\r\n<p>De plus, pour les &eacute;coles qui souhaitent lier les &eacute;l&eacute;ments factur&eacute;s &agrave; leur syst&egrave;me comptable (par ex. SAP), ce module pr&eacute;voit &eacute;galement la possibilit&eacute; de d&eacute;finir par param&eacute;trisation, toutes les donn&eacute;es &agrave; transf&eacute;rer vers le syst&egrave;me externe ou les donn&eacute;es &agrave; recevoir en retour. L&agrave; aussi, chaque donn&eacute;e de l''interface peut &ecirc;tre dot&eacute;e de r&egrave;gles de gestion et/ou de contr&ocirc;le.&nbsp;</p>\r\n<p>A la fois simple d''utilisation et extr&ecirc;mement convivial, ce nouvel environnement de facturation, compl&egrave;tera avantageusement votre syst&egrave;me IS-Academia.</p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>'),
(57, 27, 1, 'API Google Maps pour IS-Academia ', '', '<p>Il est maintenant possible d&rsquo;alimenter IS-Academia par l&rsquo;interm&eacute;diaire d&rsquo;API Google afin d&rsquo;optimiser la gestion des distances et des temps de parcours des &eacute;tudiants.</p>\r\n<p>Quelques exemples pratiques:</p>\r\n<p>Dans la gestion des stages,&nbsp; un administrateur peut consulter la distance ou le temps de parcours (&agrave; pied, en v&eacute;hicule priv&eacute; ou par les transports publics) entre le domicile d&rsquo;un &eacute;tudiant et un lieu de stage.</p>\r\n<p>Dans la gestion des classes des &eacute;coles publiques du canton du Tessin, un administrateur peut afficher une carte g&eacute;ographique qui indique le lieu de domicile des &eacute;l&egrave;ves par rapport &agrave; l&rsquo;adresse d&rsquo;une l&rsquo;&eacute;cole.</p>'),
(58, 28, 1, 'Tenez vos utilisateurs IS-Academia informés ', '', '<p>IS-Academia vous offre maintenant la possibilit&eacute; de g&eacute;rer des news et des informations de tout ordre et en fonction du profil de vos utilisateurs, qui peuvent les consulter directement depuis leur portail IS-Academia.</p>\r\n<p>Les news peuvent &ecirc;tre agr&eacute;ment&eacute;es d''une image et &eacute;galement &ecirc;tre g&eacute;r&eacute;es par degr&eacute; d''importance.&nbsp;</p>\r\n<p>Qu''il s''agisse d''informer vos utilisateurs sur un &eacute;v&egrave;nement particulier ou tout simplement pour informer une vol&eacute;e d''&eacute;tudiants d''un changement de salle de derni&egrave;re minute, le module News vous permet de g&eacute;rer ces communications de fa&ccedil;on simple et conviviale.</p>'),
(59, 29, 1, 'Une aide séquentielle accessible par un simple clic ', '', '<p>IS-Academia vous offre maintenant la possibilit&eacute; d''int&eacute;grer une aide interactive s&eacute;quentielle, directement sur les &eacute;l&eacute;ments qui composent vos onglets et cellules et par simple param&eacute;trage.<span class="contentText"></span></p>\r\n<p>Documentez vous-m&ecirc;me, chaque fois que cela est jug&eacute; n&eacute;cessaire, n''importe quel &eacute;l&eacute;ment visible dans vos portails et rendez ainsi l''utilisation d''IS-Academia encore plus ais&eacute;e.</p>');
