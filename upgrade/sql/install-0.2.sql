ALTER TABLE `PREFIX_eatlivr`
ADD `firstname` VARCHAR(255) NOT NULL AFTER `id_product`,
ADD `lastname` VARCHAR(255) NOT NULL AFTER `firstname`,
ADD `email` VARCHAR(255) NOT NULL AFTER `lastname`;