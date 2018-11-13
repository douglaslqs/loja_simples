CREATE DATABASE  IF NOT EXISTS `db_loja_simples` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `db_loja_simples`;
-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: db_loja_simples
-- ------------------------------------------------------
-- Server version	5.7.14

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `caracteristica`
--

DROP TABLE IF EXISTS `caracteristica`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `caracteristica` (
  `nome` varchar(128) NOT NULL,
  `descricao` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`nome`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `caracteristica`
--

LOCK TABLES `caracteristica` WRITE;
/*!40000 ALTER TABLE `caracteristica` DISABLE KEYS */;
INSERT INTO `caracteristica` VALUES ('Altura','Altura do produto'),('Comprimento','Comprimento do produto'),('Cor','Cor do produto'),('Largura','Largura do Produto'),('Peso','Peso do produto');
/*!40000 ALTER TABLE `caracteristica` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categoria`
--

DROP TABLE IF EXISTS `categoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categoria` (
  `nome` varchar(64) NOT NULL,
  PRIMARY KEY (`nome`),
  UNIQUE KEY `nome_UNIQUE` (`nome`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categoria`
--

LOCK TABLES `categoria` WRITE;
/*!40000 ALTER TABLE `categoria` DISABLE KEYS */;
INSERT INTO `categoria` VALUES ('Banheiro'),('Cozinha'),('Jardim'),('Quarto'),('Sala');
/*!40000 ALTER TABLE `categoria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cliente`
--

DROP TABLE IF EXISTS `cliente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cliente` (
  `email` varchar(128) NOT NULL,
  `senha` varchar(45) NOT NULL,
  `nome` varchar(128) NOT NULL,
  `telefone` varchar(45) NOT NULL,
  `cep` varchar(45) NOT NULL,
  `endereco` varchar(45) NOT NULL,
  `cidade` varchar(45) NOT NULL,
  `estado` varchar(45) NOT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cliente`
--

LOCK TABLES `cliente` WRITE;
/*!40000 ALTER TABLE `cliente` DISABLE KEYS */;
INSERT INTO `cliente` VALUES ('atual@gmail.com','karen1504','Karen Rapini','11985468579','0265585','rua kdaksdad','itapevi','SP'),('dev1@mediaw.com.br','132432434','Douglas','1156451564','05315154','endereco','itapevi','SC'),('dev2@mediaw.com.br','123','Douglas','1156451564','05315154','endereco','itapevi','SC');
/*!40000 ALTER TABLE `cliente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `endereco_entrega`
--

DROP TABLE IF EXISTS `endereco_entrega`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `endereco_entrega` (
  `endereco` varchar(45) NOT NULL,
  `cliente_email` varchar(128) NOT NULL,
  `cidade` varchar(45) DEFAULT NULL,
  `estado` varchar(45) DEFAULT NULL,
  `cep` varchar(45) DEFAULT NULL,
  `pedido_id` int(11) NOT NULL,
  PRIMARY KEY (`endereco`),
  KEY `fk_endereco_entrega_cliente1_idx` (`cliente_email`),
  KEY `fk_endereco_entrega_pedido1_idx` (`pedido_id`),
  CONSTRAINT `fk_endereco_entrega_cliente1` FOREIGN KEY (`cliente_email`) REFERENCES `cliente` (`email`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_endereco_entrega_pedido1` FOREIGN KEY (`pedido_id`) REFERENCES `pedido` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `endereco_entrega`
--

LOCK TABLES `endereco_entrega` WRITE;
/*!40000 ALTER TABLE `endereco_entrega` DISABLE KEYS */;
INSERT INTO `endereco_entrega` VALUES ('','dev1@mediaw.com.br','','','',41),('teste','dev1@mediaw.com.br','teste','BA','0545405045',40);
/*!40000 ALTER TABLE `endereco_entrega` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `item_pedido`
--

DROP TABLE IF EXISTS `item_pedido`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `item_pedido` (
  `produto_id` int(11) NOT NULL,
  `pedido_id` int(11) NOT NULL,
  `qtd` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`produto_id`,`pedido_id`),
  KEY `fk_produto_has_pedido_pedido1_idx` (`pedido_id`),
  KEY `fk_produto_has_pedido_produto1_idx` (`produto_id`),
  CONSTRAINT `fk_produto_has_pedido_pedido1` FOREIGN KEY (`pedido_id`) REFERENCES `pedido` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_produto_has_pedido_produto1` FOREIGN KEY (`produto_id`) REFERENCES `produto` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `item_pedido`
--

LOCK TABLES `item_pedido` WRITE;
/*!40000 ALTER TABLE `item_pedido` DISABLE KEYS */;
INSERT INTO `item_pedido` VALUES (1,23,3),(1,27,2),(1,31,1),(1,32,1),(1,33,1),(1,34,1),(1,35,1),(1,36,1),(1,37,1),(1,38,1),(1,39,1),(1,40,1),(2,23,1),(2,24,1),(2,28,1),(2,41,1),(3,26,1),(3,30,2),(5,27,1),(6,25,2),(6,26,2),(6,29,1);
/*!40000 ALTER TABLE `item_pedido` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pedido`
--

DROP TABLE IF EXISTS `pedido`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pedido` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cliente_email` varchar(128) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_pedido_cliente1_idx` (`cliente_email`),
  CONSTRAINT `fk_pedido_cliente1` FOREIGN KEY (`cliente_email`) REFERENCES `cliente` (`email`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pedido`
--

LOCK TABLES `pedido` WRITE;
/*!40000 ALTER TABLE `pedido` DISABLE KEYS */;
INSERT INTO `pedido` VALUES (25,'atual@gmail.com'),(26,'atual@gmail.com'),(27,'atual@gmail.com'),(30,'atual@gmail.com'),(23,'dev1@mediaw.com.br'),(24,'dev1@mediaw.com.br'),(28,'dev1@mediaw.com.br'),(29,'dev1@mediaw.com.br'),(31,'dev1@mediaw.com.br'),(32,'dev1@mediaw.com.br'),(33,'dev1@mediaw.com.br'),(34,'dev1@mediaw.com.br'),(35,'dev1@mediaw.com.br'),(36,'dev1@mediaw.com.br'),(37,'dev1@mediaw.com.br'),(38,'dev1@mediaw.com.br'),(39,'dev1@mediaw.com.br'),(40,'dev1@mediaw.com.br'),(41,'dev1@mediaw.com.br');
/*!40000 ALTER TABLE `pedido` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `produto`
--

DROP TABLE IF EXISTS `produto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `produto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(128) NOT NULL,
  `descricao` text NOT NULL,
  `imagem` varchar(45) NOT NULL,
  `preco` double(11,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_nome` (`nome`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `produto`
--

LOCK TABLES `produto` WRITE;
/*!40000 ALTER TABLE `produto` DISABLE KEYS */;
INSERT INTO `produto` VALUES (1,'Mesa de Jantar Madeira Com 4 Cadeiras','Feita com madeira e acompanha 4 cadeiras com acento em tecido','mesa-4-cadeiras.jpg',500.00),(2,'Guarda Roupa Casal','Guarda Roupa feito em madeira com puxadores de alumínio','guarda-roupa-madeira.jpg',1500.00),(3,'Cadeira de Madeira','Cadeira de cozinha ou jardim com acabamento brilhoso','cadeira-madeira.jpg',85.00),(4,'Sofá em Couro','Sofá 2 lugares em couro legítimo liso e encosto acolchoado com pés de alumínio','sofa.jpg',980.00),(5,'Penteadeira de MDF','Penteadeira em MDF com espelho e gavetas','penteadeira.jpg',556.99),(6,'Espelho de Parede','Espelho de parede com fino acabamento em alumínio escovado e brilhoso','espelho',44.99);
/*!40000 ALTER TABLE `produto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `produto_caracteristica`
--

DROP TABLE IF EXISTS `produto_caracteristica`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `produto_caracteristica` (
  `produto_id` int(11) NOT NULL,
  `caracteristica_nome` varchar(128) NOT NULL,
  `valor` varchar(45) NOT NULL,
  PRIMARY KEY (`produto_id`,`caracteristica_nome`),
  KEY `fk_produto_has_caracteristica_caracteristica1_idx` (`caracteristica_nome`),
  KEY `fk_produto_has_caracteristica_produto1_idx` (`produto_id`),
  CONSTRAINT `fk_produto_has_caracteristica_caracteristica1` FOREIGN KEY (`caracteristica_nome`) REFERENCES `caracteristica` (`nome`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_produto_has_caracteristica_produto1` FOREIGN KEY (`produto_id`) REFERENCES `produto` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `produto_caracteristica`
--

LOCK TABLES `produto_caracteristica` WRITE;
/*!40000 ALTER TABLE `produto_caracteristica` DISABLE KEYS */;
INSERT INTO `produto_caracteristica` VALUES (1,'Altura','60 cm'),(1,'Comprimento','120 cm'),(1,'Largura','120 cm'),(2,'Altura','190 cm'),(2,'Comprimento','120 cm'),(2,'Cor','Madeira Envelhecida'),(2,'Largura','120 cm'),(2,'Peso','25 kilos'),(3,'Altura','50 cm'),(3,'Comprimento','20 cm'),(3,'Cor','Madeira Natural'),(3,'Largura','20 cm'),(4,'Comprimento','160 cm'),(4,'Cor','Marron'),(4,'Largura','80 cm'),(5,'Altura','145 cm'),(5,'Cor','Branca'),(5,'Largura','80 cm'),(6,'Altura','80 cm'),(6,'Largura','40 cm'),(6,'Peso','2 kilos');
/*!40000 ALTER TABLE `produto_caracteristica` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `produto_categoria`
--

DROP TABLE IF EXISTS `produto_categoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `produto_categoria` (
  `produto_id` int(11) NOT NULL,
  `categoria_nome` varchar(64) NOT NULL,
  PRIMARY KEY (`produto_id`,`categoria_nome`),
  KEY `fk_produto_has_categoria_categoria1_idx` (`categoria_nome`),
  KEY `fk_produto_has_categoria_produto_idx` (`produto_id`),
  CONSTRAINT `fk_produto_has_categoria_categoria1` FOREIGN KEY (`categoria_nome`) REFERENCES `categoria` (`nome`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_produto_has_categoria_produto` FOREIGN KEY (`produto_id`) REFERENCES `produto` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `produto_categoria`
--

LOCK TABLES `produto_categoria` WRITE;
/*!40000 ALTER TABLE `produto_categoria` DISABLE KEYS */;
INSERT INTO `produto_categoria` VALUES (1,'Cozinha'),(2,'Quarto'),(3,'Cozinha'),(3,'Jardim'),(4,'Sala'),(5,'Quarto'),(6,'Banheiro'),(6,'Quarto'),(6,'Sala');
/*!40000 ALTER TABLE `produto_categoria` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-11-13  3:28:06
