--
-- Table structure for table anagrafica
--

DROP TABLE IF EXISTS contacts;

CREATE TABLE contacts (
  id int(10) unsigned NOT NULL auto_increment,
  firstname varchar(255) NOT NULL,
  lastname varchar(255) NOT NULL,
  phone varchar(255) NOT NULL,
  mobile varchar(255) NOT NULL,
  PRIMARY KEY  (id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table anagrafica
--

LOCK TABLES contacts WRITE;
INSERT INTO contacts (firstname, lastname, phone, mobile) VALUES ('Jacopo', 'Romei', '0543123543', '34012345');
INSERT INTO contacts (firstname, lastname, phone, mobile) VALUES ('Francesco', 'Trucchia', '12345', '234 12345');
UNLOCK TABLES;

