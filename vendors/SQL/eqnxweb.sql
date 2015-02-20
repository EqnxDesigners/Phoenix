-- phpMyAdmin SQL Dump
-- version 4.2.10
-- http://www.phpmyadmin.net
--
-- Client :  localhost:8889
-- Généré le :  Ven 20 Février 2015 à 09:21
-- Version du serveur :  5.5.38
-- Version de PHP :  5.6.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données :  `eqnxweb`
--

-- --------------------------------------------------------

--
-- Structure de la table `categories_medias`
--

CREATE TABLE `categories_medias` (
`id` int(10) unsigned NOT NULL,
  `categorie` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `categories_medias`
--

INSERT INTO `categories_medias` (`id`, `categorie`) VALUES
(1, 'Documents'),
(2, 'Newsletters'),
(3, 'Présentations'),
(4, 'Programmes'),
(5, 'Tutoriels'),
(6, 'Quickys');

-- --------------------------------------------------------

--
-- Structure de la table `clients`
--

CREATE TABLE `clients` (
`id` int(10) unsigned NOT NULL,
  `societe` varchar(255) NOT NULL,
  `titre` varchar(25) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telephone` varchar(25) NOT NULL,
  `fax` varchar(25) NOT NULL,
  `mobile` varchar(25) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `clients`
--

INSERT INTO `clients` (`id`, `societe`, `titre`, `nom`, `prenom`, `email`, `telephone`, `fax`, `mobile`, `password`) VALUES
(1, 'Equinoxe MIS Developpment', 'M.', 'Clerc', 'Jérôme', 'jclerc@eqnx.ch', '+41 21 693 89 38', '', '+41 79 649 64 64', '67efa23e1adf4678683c41302c88d88a'),
(2, 'Pink Lama Crew', 'Mme', 'Pfänder', 'Aline', 'ap@eqnx.ch', '', '', '', ''),
(3, 'SuperBox SA', 'Mme', 'Unetelle', 'Maria', 'super@mail.com', '0218003411', '079 649 64 64', '', ''),
(18, 'MaBoite', 'M.', 'Bolomet', 'Paul', 'mon@mail.ch', '021 800 37 11', '', '079 649 64 64', ''),
(20, 'NouvelleSociete SA', 'Mme', 'Pahud', 'Micheline', 'super@mail.com', '021 800 37 11', '021 800 37 12', '079 649 64 64', '81dc9bdb52d04dc20036dbd8313ed055');

-- --------------------------------------------------------

--
-- Structure de la table `clients_tokens`
--

CREATE TABLE `clients_tokens` (
`id` int(10) unsigned NOT NULL,
  `id_client` int(10) unsigned NOT NULL,
  `token` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `clients_tokens`
--

INSERT INTO `clients_tokens` (`id`, `id_client`, `token`) VALUES
(14, 18, 'z5pASTnASrjquUW29HS0xCz5LGr8WA7lsjLb3XzIeGXxpHone5nAvMu7hJ24');

-- --------------------------------------------------------

--
-- Structure de la table `clients_videos_docs`
--

CREATE TABLE `clients_videos_docs` (
`id` int(10) unsigned NOT NULL,
  `id_client` int(10) unsigned NOT NULL,
  `id_media` int(10) unsigned NOT NULL,
  `type_media` varchar(25) NOT NULL COMMENT 'vid ou doc'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `docs`
--

CREATE TABLE `docs` (
`id` int(10) unsigned NOT NULL,
  `id_categorie` int(10) unsigned NOT NULL,
  `doc` varchar(255) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `descriptif` text NOT NULL,
  `date_publi` datetime NOT NULL,
  `active` int(10) unsigned NOT NULL,
  `private` int(10) unsigned NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `docs`
--

INSERT INTO `docs` (`id`, `id_categorie`, `doc`, `titre`, `descriptif`, `date_publi`, `active`, `private`) VALUES
(1, 1, 'TestTrajets.pdf', 'Test de trajets', 'Test des différents itinéraires pour se rendre au travail', '2015-01-16 00:00:00', 1, 0),
(2, 2, 'PDF_Test.pdf', 'Un doc test', 'Lorem ipsum dolor', '2015-01-20 07:01:42', 1, 1),
(3, 2, 'PDF_Test.pdf', 'Un doc test', 'Lorem ipsum dolor', '2015-01-20 07:01:11', 1, 0),
(4, 2, 'PDF_Test.pdf', 'Un doc test', 'Lorem ipsum dolor', '2015-01-20 07:01:28', 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `langues`
--

CREATE TABLE `langues` (
`id` int(10) unsigned NOT NULL,
  `langue` varchar(255) NOT NULL,
  `langue_abrev` varchar(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `langues`
--

INSERT INTO `langues` (`id`, `langue`, `langue_abrev`) VALUES
(1, 'Français', 'fr'),
(2, 'Deutsch', 'de'),
(3, 'English', 'en'),
(4, 'Italiano', 'it');

-- --------------------------------------------------------

--
-- Structure de la table `news`
--

CREATE TABLE `news` (
`id` int(10) unsigned NOT NULL,
  `date_publi` datetime NOT NULL,
  `date_start` datetime NOT NULL,
  `date_end` datetime NOT NULL,
  `date_update` datetime NOT NULL,
  `status` int(11) NOT NULL COMMENT '0 = inactif / 1 = actif / 2 = archive / 3 = supprime / 4 = brouillon'
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `news`
--

INSERT INTO `news` (`id`, `date_publi`, `date_start`, `date_end`, `date_update`, `status`) VALUES
(9, '2015-01-06 11:01:34', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2015-01-06 15:01:59', 1),
(11, '2015-01-06 13:01:00', '0000-00-00 00:00:00', '2008-01-20 15:00:00', '2015-01-06 15:01:06', 1),
(12, '2015-01-06 13:01:51', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2015-01-06 13:01:51', 1),
(13, '2015-01-06 13:01:44', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2015-01-06 13:01:44', 1);

-- --------------------------------------------------------

--
-- Structure de la table `news_trad`
--

CREATE TABLE `news_trad` (
`id` int(10) unsigned NOT NULL,
  `id_news` int(10) unsigned NOT NULL,
  `id_lang` int(10) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `sub_title` varchar(255) NOT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `news_trad`
--

INSERT INTO `news_trad` (`id`, `id_news`, `id_lang`, `title`, `sub_title`, `content`) VALUES
(24, 9, 1, 'API Google Map pour IS-Academia', 'Un sous-titre trop génial', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed sagittis porttitor diam in tincidunt. Maecenas feugiat arcu a iaculis pharetra. Nam faucibus turpis non enim gravida commodo. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam vulputate fringilla lobortis. Phasellus ac ipsum ac metus tincidunt efficitur. Maecenas ac aliquet nibh. Mauris porttitor purus quam, ac pretium orci ultricies sed. Donec commodo sem et accumsan semper. Fusce blandit commodo lectus sit amet fermentum. Donec vel pellentesque est. Integer justo sapien, dictum ut ipsum sit amet, aliquam volutpat nisi. Nunc non aliquet dui, quis ornare ex.</p>\r\n<p>Ut vitae eros eu metus tincidunt tristique. Integer viverra turpis quis ligula facilisis, eu volutpat felis dignissim. Etiam ultrices ante ac est molestie, non venenatis diam pellentesque. Quisque vel velit a ligula egestas dapibus vitae vitae erat. Duis congue est nec quam imperdiet, non scelerisque augue molestie. Praesent magna mi, consequat et gravida quis, mollis vitae augue. Vivamus et velit sit amet diam ullamcorper ornare ut pulvinar odio.</p>'),
(25, 9, 2, 'API Google Maps für IS-Academia', 'Zu groß Untertitel', '<p>Milk, brewed aromatic gal&atilde;o aroma grinder roast ristretto cinnamon trifecta. Affogato mug extraction plunger pot milk that arabica brewed. Plunger pot cinnamon single origin white french press redeye cappuccino. Lungo extraction, affogato grounds caffeine acerbic latte. Robusta brewed ristretto americano half and half acerbic frappuccino eu and trifecta turkish.</p>\r\n<p>Roast iced, beans ristretto plunger pot barista and irish crema to go steamed. Fair trade roast coffee caffeine latte black java. Affogato, aromatic coffee skinny chicory americano, a decaffeinated id et sugar variety. Brewed caf&eacute; au lait, macchiato, wings caf&eacute; au lait cup caffeine white foam. Whipped, kopi-luwak filter, redeye organic acerbic arabica plunger pot seasonal pumpkin spice brewed black.</p>'),
(26, 9, 3, 'API GOOGLE MAPS FOR IS-ACADEMIA', 'Too great subtitle', '<p>If I make this comeback, I''ll buy you a hundred George Michaels that you can teach to drive! I prematurely shot my wad on what was supposed to be a dry run..so now I''m afraid I have something of a mess on my hands. One of the guys told me to take my head out of my BOTTOM and get back to work&hellip;my BOTTOM!</p>\r\n<p>You''re losing blood, aren''t you? Probably, my socks are wet. Even though so many people in this office are begging for it. You are a worse psychiatrist than you are a son-in-law and you will never get work as an actor because you have no talent. So did you see the new Poof? His name''s Gary, and we don''t need anymore lawsuits. For the same reason you should believe a hundred dollar bill is no more than a hundred pennies! You can always tell a Milford man.</p>'),
(27, 9, 4, 'API Google Maps per IS-ACADEMIA', 'Troppo grande sottotitolo', '<p class="paragraph ng-attr-widget"><span class="ng-directive ng-binding">Marzipan chocolate cake oat cake unerdwear.com donut bonbon tart pastry topping. Sweet roll dessert chocolate lollipop halvah. Applicake fruitcake toffee sweet roll. Souffl&eacute; tart chocolate muffin chocolate apple pie bonbon tart. Sugar plum cake lollipop. Chocolate lemon drops chocolate cake jujubes gummi bears wafer.</span></p>\r\n<p class="paragraph ng-attr-widget"><span class="ng-directive ng-binding">Danish tootsie roll gummi bears oat cake donut pudding candy. Candy pie jelly beans jelly beans sweet roll jelly. Cheesecake donut cookie tart candy croissant. Pie caramels jelly fruitcake. Gummies tart pastry oat cake cookie bonbon carrot cake croissant brownie. Liquorice biscuit croissant candy bear claw jelly beans brownie tiramisu. Croissant cheesecake lollipop applicake bonbon donut gummi bears pudding. Unerdwear.com caramels gingerbread gummi bears. Pastry toffee sweet roll.</span></p>'),
(28, 11, 1, 'Tenez vos utilisateurs IS-Academia informés', 'Un sous-titre original', '<p>Collaboratively administrate empowered markets via plug-and-play networks. Dynamically procrastinate B2C users after installed base benefits. Dramatically visualize customer directed convergence without revolutionary ROI.</p>\r\n<p>Efficiently unleash cross-media information without cross-media value. Quickly maximize timely deliverables for real-time schemas. Dramatically maintain clicks-and-mortar solutions without functional solutions.</p>'),
(29, 11, 2, 'Halten Sie Ihre Benutzer über IS-Academia', 'Ein Original-Untertitel', '<p>Zombies reversus ab inferno, nam malum cerebro. De carne animata corpora quaeritis. Summus sit??, morbo vel maleficia? De Apocalypsi undead dictum mauris. Hi mortuis soulless creaturas, imo monstra adventus vultus comedat cerebella viventium.</p>\r\n<p>Qui offenderit rapto, terribilem incessu. The voodoo sacerdos suscitat mortuos comedere carnem. Search for solum oculi eorum defunctis cerebro. Nescio an Undead zombies. Sicut malus movie horror.</p>'),
(30, 11, 3, 'Keep your users informed IS-Academia', 'An original subtitle', '<p>Trust fund shabby chic Schlitz, disrupt Vice kogi biodiesel. Incididunt sint ex, organic beard four loko narwhal sunt nulla viral. Banh mi anim craft beer odio. Bespoke kitsch kogi, Austin narwhal single-origin coffee exercitation consequat sint pickled gastropub Portland asymmetrical.</p>\r\n<p>Ennui letterpress retro meggings farm-to-table, listicle next level Austin forage proident American Apparel. 8-bit selfies ennui jean shorts anim tousled, farm-to-table aute cillum synth placeat. Esse enim Echo Park irure, wayfarers you probably haven''t heard of them meggings.</p>'),
(31, 11, 4, 'Tenete gli utenti informati IS-Academia', 'Un sottotitolo originale', '<p>Pommy ipsum some mothers do ''ave ''em doolally, driving a mini gutted. In the jacksy jammy git baffled bull dog bugger curtain twitching pie-eyed Geordie challenge you to a duel, down the village green bull dog cheesed off rumpy pumpy knee high to a grasshopper i''ll be a monkey''s uncle real ale terribly.</p>\r\n<p>Unhand me sir ask your mother if gobsmacked Doctor Who one feels that, 10 pence mix treacle challenge you to a duel it''s nicked, cheesed off pork dripping daft cow. Cottage pie sod''s law horses for courses one would like cockney come hither, accordingly naff the fuzz stiff upper lip. Supper in the jacksy a tad I''d reet fancy a have a gander well fit in a pickle, unhand me sir Sherlock copped a bollocking marvelous half-inch it. - See more at: http://www.pommyipsum.com/#sthash.JoeHoyhD.dpuf</p>'),
(32, 12, 1, 'IS-Academia passe à la vitesse supérieure !', '', '<p>Fromage frais brie emmental. Cheddar everyone loves pepper jack taleggio the big cheese emmental airedale queso. Gouda cheese triangles swiss airedale fromage rubber cheese edam fromage frais. Queso fondue red leicester dolcelatte.</p>\r\n<p>Cheeseburger edam lancashire. Cheesy grin bocconcini croque monsieur cheese slices dolcelatte cheesy grin bavarian bergkase cheese on toast. Airedale cottage cheese cheese on toast croque monsieur smelly cheese bocconcini goat cheesy feet. Cheddar croque monsieur pepper jack danish fontina.</p>\r\n<p>Stinking bishop macaroni cheese cheese triangles. Chalk and cheese mascarpone edam taleggio port-salut manchego cut the cheese brie. Pecorino cheddar cheeseburger jarlsberg cheesy grin hard cheese croque monsieur fromage frais. Bocconcini monterey jack monterey jack.</p>\r\n<p>Edam melted cheese cheesecake. When the cheese comes out everybody''s happy port-salut cheese slices queso cheesecake cheese strings cheddar feta. Cheese strings halloumi cow boursin blue castello melted cheese cauliflower cheese cheesecake. Cheese slices dolcelatte squirty cheese the big cheese cheesy grin.</p>\r\n<p>Halloumi fromage frais emmental. Cheese and biscuits lancashire airedale goat fondue chalk and cheese fromage frais fondue. Cheese triangles dolcelatte jarlsberg taleggio cheese and wine cottage cheese feta say cheese. Cow mozzarella everyone loves paneer blue castello stinking bishop.</p>'),
(33, 12, 2, 'IS-Academia passe à la vitesse supérieure !', '', '<p>Fromage frais brie emmental. Cheddar everyone loves pepper jack taleggio the big cheese emmental airedale queso. Gouda cheese triangles swiss airedale fromage rubber cheese edam fromage frais. Queso fondue red leicester dolcelatte.</p>\r\n<p>Cheeseburger edam lancashire. Cheesy grin bocconcini croque monsieur cheese slices dolcelatte cheesy grin bavarian bergkase cheese on toast. Airedale cottage cheese cheese on toast croque monsieur smelly cheese bocconcini goat cheesy feet. Cheddar croque monsieur pepper jack danish fontina.</p>\r\n<p>Stinking bishop macaroni cheese cheese triangles. Chalk and cheese mascarpone edam taleggio port-salut manchego cut the cheese brie. Pecorino cheddar cheeseburger jarlsberg cheesy grin hard cheese croque monsieur fromage frais. Bocconcini monterey jack monterey jack.</p>\r\n<p>Edam melted cheese cheesecake. When the cheese comes out everybody''s happy port-salut cheese slices queso cheesecake cheese strings cheddar feta. Cheese strings halloumi cow boursin blue castello melted cheese cauliflower cheese cheesecake. Cheese slices dolcelatte squirty cheese the big cheese cheesy grin.</p>\r\n<p>Halloumi fromage frais emmental. Cheese and biscuits lancashire airedale goat fondue chalk and cheese fromage frais fondue. Cheese triangles dolcelatte jarlsberg taleggio cheese and wine cottage cheese feta say cheese. Cow mozzarella everyone loves paneer blue castello stinking bishop.</p>'),
(34, 12, 3, 'IS-Academia passe à la vitesse supérieure !', '', '<p>Fromage frais brie emmental. Cheddar everyone loves pepper jack taleggio the big cheese emmental airedale queso. Gouda cheese triangles swiss airedale fromage rubber cheese edam fromage frais. Queso fondue red leicester dolcelatte.</p>\r\n<p>Cheeseburger edam lancashire. Cheesy grin bocconcini croque monsieur cheese slices dolcelatte cheesy grin bavarian bergkase cheese on toast. Airedale cottage cheese cheese on toast croque monsieur smelly cheese bocconcini goat cheesy feet. Cheddar croque monsieur pepper jack danish fontina.</p>\r\n<p>Stinking bishop macaroni cheese cheese triangles. Chalk and cheese mascarpone edam taleggio port-salut manchego cut the cheese brie. Pecorino cheddar cheeseburger jarlsberg cheesy grin hard cheese croque monsieur fromage frais. Bocconcini monterey jack monterey jack.</p>\r\n<p>Edam melted cheese cheesecake. When the cheese comes out everybody''s happy port-salut cheese slices queso cheesecake cheese strings cheddar feta. Cheese strings halloumi cow boursin blue castello melted cheese cauliflower cheese cheesecake. Cheese slices dolcelatte squirty cheese the big cheese cheesy grin.</p>\r\n<p>Halloumi fromage frais emmental. Cheese and biscuits lancashire airedale goat fondue chalk and cheese fromage frais fondue. Cheese triangles dolcelatte jarlsberg taleggio cheese and wine cottage cheese feta say cheese. Cow mozzarella everyone loves paneer blue castello stinking bishop.</p>'),
(35, 12, 4, 'IS-Academia passe à la vitesse supérieure !', '', '<p>Fromage frais brie emmental. Cheddar everyone loves pepper jack taleggio the big cheese emmental airedale queso. Gouda cheese triangles swiss airedale fromage rubber cheese edam fromage frais. Queso fondue red leicester dolcelatte.</p>\r\n<p>Cheeseburger edam lancashire. Cheesy grin bocconcini croque monsieur cheese slices dolcelatte cheesy grin bavarian bergkase cheese on toast. Airedale cottage cheese cheese on toast croque monsieur smelly cheese bocconcini goat cheesy feet. Cheddar croque monsieur pepper jack danish fontina.</p>\r\n<p>Stinking bishop macaroni cheese cheese triangles. Chalk and cheese mascarpone edam taleggio port-salut manchego cut the cheese brie. Pecorino cheddar cheeseburger jarlsberg cheesy grin hard cheese croque monsieur fromage frais. Bocconcini monterey jack monterey jack.</p>\r\n<p>Edam melted cheese cheesecake. When the cheese comes out everybody''s happy port-salut cheese slices queso cheesecake cheese strings cheddar feta. Cheese strings halloumi cow boursin blue castello melted cheese cauliflower cheese cheesecake. Cheese slices dolcelatte squirty cheese the big cheese cheesy grin.</p>\r\n<p>Halloumi fromage frais emmental. Cheese and biscuits lancashire airedale goat fondue chalk and cheese fromage frais fondue. Cheese triangles dolcelatte jarlsberg taleggio cheese and wine cottage cheese feta say cheese. Cow mozzarella everyone loves paneer blue castello stinking bishop.</p>'),
(36, 13, 3, 'New stuff in IS-Academia', '', '<p><span class="first-sentence">Backing innovator investor partnership product management.</span> Seed round growth hacking scrum project customer alpha paradigm shift user experience partnership product management seed money early adopters research &amp; development focus crowdsource. Business model canvas assets leverage buzz handshake advisor alpha first mover advantage churn rate pivot. Venture analytics supply chain influencer network effects channels. Angel investor leverage focus responsive web design churn rate validation return on investment release success holy grail. Bootstrapping user experience business plan.</p>\r\n<p>Market strategy venture. Market series A financing equity strategy network effects iPhone leverage partnership freemium niche market www.discoverartisans.com. Accelerator www.discoverartisans.com virality twitter. Ecosystem MVP seed money crowdsource scrum project deployment niche market twitter research &amp; development lean startup paradigm shift. Backing seed round partnership MVP long tail partner network entrepreneur startup traction business plan prototype churn rate. Stealth crowdfunding first mover advantage churn rate metrics.</p>\r\n<p>Product management venture entrepreneur series A financing value proposition. Buzz gamification seed money return on investment focus. Technology launch party branding gen-z return on investment. Prototype return on investment low hanging fruit learning curve branding iPad. Mass market market creative startup venture www.discoverartisans.com crowdsource social media analytics assets non-disclosure agreement low hanging fruit. Virality bandwidth ecosystem infographic business model canvas scrum project influencer mass market interaction design vesting period gen-z branding holy grail.</p>');

-- --------------------------------------------------------

--
-- Structure de la table `options`
--

CREATE TABLE `options` (
`id` int(10) unsigned NOT NULL,
  `label` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `options`
--

INSERT INTO `options` (`id`, `label`, `type`, `value`, `code`) VALUES
(4, 'Affichage des alertes JOBS', 'bool', '0', 'DISPLAY_JOB_ALERT'),
(5, 'Affichage des alertes VIDEOS', 'bool', '0', 'DISPLAY_VIDEOS_ALERT');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
`id` int(10) unsigned NOT NULL,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `level` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `login`, `password`, `user_name`, `email`, `level`) VALUES
(1, 'admin', '8cc5ad3bc45f8f15dd3cb34ffd279e32', 'Pink Lama Unicorn Crew', 'jclerc@eqnx.ch', 0),
(2, 'sven', '81dc9bdb52d04dc20036dbd8313ed055', 'Sven PLUG', 'sp@eqnx.ch', 1);

-- --------------------------------------------------------

--
-- Structure de la table `videos`
--

CREATE TABLE `videos` (
`id` int(10) unsigned NOT NULL,
  `id_categorie` int(10) unsigned NOT NULL,
  `video` varchar(255) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `descriptif` text NOT NULL,
  `date_publi` datetime NOT NULL,
  `active` int(10) unsigned NOT NULL,
  `private` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `categories_medias`
--
ALTER TABLE `categories_medias`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `clients`
--
ALTER TABLE `clients`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `clients_tokens`
--
ALTER TABLE `clients_tokens`
 ADD PRIMARY KEY (`id`), ADD KEY `id_client` (`id_client`);

--
-- Index pour la table `clients_videos_docs`
--
ALTER TABLE `clients_videos_docs`
 ADD PRIMARY KEY (`id`), ADD KEY `id_client` (`id_client`,`id_media`);

--
-- Index pour la table `docs`
--
ALTER TABLE `docs`
 ADD PRIMARY KEY (`id`), ADD KEY `id_categorie` (`id_categorie`);

--
-- Index pour la table `langues`
--
ALTER TABLE `langues`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `news`
--
ALTER TABLE `news`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `news_trad`
--
ALTER TABLE `news_trad`
 ADD PRIMARY KEY (`id`), ADD KEY `id_news` (`id_news`,`id_lang`);

--
-- Index pour la table `options`
--
ALTER TABLE `options`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `videos`
--
ALTER TABLE `videos`
 ADD PRIMARY KEY (`id`), ADD KEY `id_categorie` (`id_categorie`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `categories_medias`
--
ALTER TABLE `categories_medias`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT pour la table `clients`
--
ALTER TABLE `clients`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT pour la table `clients_tokens`
--
ALTER TABLE `clients_tokens`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT pour la table `clients_videos_docs`
--
ALTER TABLE `clients_videos_docs`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `docs`
--
ALTER TABLE `docs`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `langues`
--
ALTER TABLE `langues`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `news`
--
ALTER TABLE `news`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT pour la table `news_trad`
--
ALTER TABLE `news_trad`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=37;
--
-- AUTO_INCREMENT pour la table `options`
--
ALTER TABLE `options`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `videos`
--
ALTER TABLE `videos`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;