
CREATE DATABASE IF NOT EXISTS `projeto_mvc` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `projeto_mvc`;

-- Copiando estrutura para tabela om_cms_language.access_group
CREATE TABLE IF NOT EXISTS `access_group` (
  `idgroup` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(255) NOT NULL,
  `status` char(1) NOT NULL,
  PRIMARY KEY (`idgroup`),
  UNIQUE KEY `idgroup_UNIQUE` (`idgroup`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela om_cms_language.access_group: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `access_group` DISABLE KEYS */;
INSERT INTO `access_group` (`idgroup`, `description`, `status`) VALUES
	(1, 'Administrador', 'a');
/*!40000 ALTER TABLE `access_group` ENABLE KEYS */;

-- Copiando estrutura para tabela om_cms_language.access_menu
CREATE TABLE IF NOT EXISTS `access_menu` (
  `idmenu` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `page` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `level` varchar(50) NOT NULL DEFAULT '0',
  `order` int(11) NOT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `icon` varchar(255) NOT NULL,
  PRIMARY KEY (`idmenu`),
  UNIQUE KEY `idmenu_UNIQUE` (`idmenu`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela om_cms_language.access_menu: ~22 rows (aproximadamente)
/*!40000 ALTER TABLE `access_menu` DISABLE KEYS */;
INSERT INTO `access_menu` (`idmenu`, `title`, `page`, `alias`, `level`, `order`, `status`, `icon`) VALUES
	(1, 'Administração', '', 'administracao', '0', 5, 'a', 'fas fa-users-cog'),
	(2, 'Grupos de Acesso', 'grupoacesso', 'grupoacesso', '1', 1, 'a', 'fas fa-user-lock'),
	(3, 'Menus', 'menus', 'menus', '1', 2, 'a', 'fas fa-bars'),
	(4, 'Usuários', 'users', 'users', '1', 3, 'a', 'fa fa-user');
/*!40000 ALTER TABLE `access_menu` ENABLE KEYS */;

-- Copiando estrutura para tabela om_cms_language.access_menuxgroup
CREATE TABLE IF NOT EXISTS `access_menuxgroup` (
  `idgroup` int(11) NOT NULL,
  `idmenu` int(11) NOT NULL,
  PRIMARY KEY (`idgroup`,`idmenu`),
  KEY `fk_access_group_has_access_menu_access_menu1_idx` (`idmenu`),
  KEY `fk_access_group_has_access_menu_access_group1_idx` (`idgroup`),
  CONSTRAINT `fk_access_group_has_access_menu_access_group1` FOREIGN KEY (`idgroup`) REFERENCES `access_group` (`idgroup`),
  CONSTRAINT `fk_access_group_has_access_menu_access_menu1` FOREIGN KEY (`idmenu`) REFERENCES `access_menu` (`idmenu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela om_cms_language.access_menuxgroup: ~39 rows (aproximadamente)
/*!40000 ALTER TABLE `access_menuxgroup` DISABLE KEYS */;
INSERT INTO `access_menuxgroup` (`idgroup`, `idmenu`) VALUES
	(1, 1),
	(1, 2),
	(1, 3),
	(1, 4);
/*!40000 ALTER TABLE `access_menuxgroup` ENABLE KEYS */;

-- Copiando estrutura para tabela om_cms_language.access_user
CREATE TABLE IF NOT EXISTS `access_user` (
  `iduser` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `user` varchar(255) NOT NULL,
  `idgroup` int(11) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `date_create` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`iduser`),
  UNIQUE KEY `iduser_UNIQUE` (`iduser`),
  UNIQUE KEY `user_UNIQUE` (`user`),
  UNIQUE KEY `email_UNIQUE` (`email`),
  KEY `idgroup_idx` (`idgroup`),
  CONSTRAINT `idgroup` FOREIGN KEY (`idgroup`) REFERENCES `access_group` (`idgroup`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela om_cms_language.access_user: ~0 rows (aproximadamente)

/** senhafortesansao1324 */
/*!40000 ALTER TABLE `access_user` DISABLE KEYS */;
INSERT INTO `access_user` (`iduser`, `name`, `image`, `email`, `phone`, `status`, `user`, `idgroup`, `password`, `date_create`) VALUES
	(2, 'Administrador', NULL, 'contato@oseasmoreto.com', '(11) 99999-9999', 'a', 'useradmin', 1, '1ce38cb6140da91a9a7d8ce2cffff81d', CURRENT_TIMESTAMP());
/*!40000 ALTER TABLE `access_user` ENABLE KEYS */;

