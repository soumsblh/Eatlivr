CREATE TABLE IF NOT EXISTS `PREFIX_eatlivr` (
  `id_eatlivr` int(11) NOT NULL ,
  `id_carrier` int(11) NOT NULL ,
  `postcode` int(11) NOT NULL,
  `county` int(11) NOT NULL,
  `id_shop` int(11) NOT NULL,
  `available` int(11) NOT NULL,
  `livraison` tinyint(1) NOT NULL,
  `emporter` tinyint(1) NOT NULL,
  `temps_estimation_client` time NOT NULL,
  `address` varchar(256) NOT NULL,
  `departement_deservi` varchar(256) NOT NULL,
  `zone_livrable` varchar(256) NOT NULL,
  `temps_prepa_emporter` time NOT NULL,
  `temps_prepa_livraison` time NOT NULL,
  `temps_commande_emporter` time NOT NULL,
  `temps_commande_livraison` time NOT NULL,
  `horaire_ouverture_semaine_matin` datetime NOT NULL,
  `horaire_ouverture_semaine_soir` datetime NOT NULL,
  `horaire_ouverture_weekend_matin` datetime NOT NULL,
  `horaire_ouverture_weekend_soir` datetime NOT NULL,
  `horaire_fermeture_semaine_matin` datetime NOT NULL,
  `horaire_fermeture_semaine_soir` datetime NOT NULL,
  `horaire_fermeture_weekend_matin` datetime NOT NULL,
  `horaire_fermeture_weekend_soir` datetime NOT NULL,
  `horaire_ouverture_excp_matin` datetime NOT NULL,
  `horaire_ouverture_excp_soir` datetime NOT NULL,
  `horaire_fermeture_excp_matin` datetime NOT NULL,
  `horaire_fermeture_excp_soir` datetime NOT NULL,
  `maximun_commande` int(11) NOT NULL,
  `minimun_commande` int(11) NOT NULL,
  `frais_livraison` int(11) NOT NULL,
  `frais_kilometrique` int(11) NOT NULL,
  `date_add` datetime NOT NULL,
  PRIMARY KEY (`id_eatlivr`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;



CREATE TABLE IF NOT EXISTS `PREFIX_eatdeliv` (
            `id_eatdeliv` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
            `id_carrier` INT(10) NOT NULL ,
            `code_postaux` TEXT NOT NULL ,
            `county` TEXT NOT NULL ,
            `available` TINYINT(1) NOT NULL,
            `id_shop` INT(10) NOT NULL
            ) ;

CREATE TABLE  IF NOT EXISTS `PREFIX_eatdeliv_range` (
            `id_carrier` INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
            `from` VARCHAR(20) NOT NULL ,
            `to` VARCHAR(20) NOT NULL
            ) ;

CREATE TABLE IF NOT EXISTS `PREFIX_order_delivery_time` (
    `id_order` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `delivery_time` DATETIME NOT NULL
    );

CREATE TABLE IF NOT EXISTS `PREFIX_cart_delivery_time` (
      `id_cart` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
      `delivery_time` VARCHAR(50) NOT NULL
      );