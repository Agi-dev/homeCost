#------------------------------------------------------------
#        Script MySQL.
#------------------------------------------------------------


#------------------------------------------------------------
# Table: bank
#------------------------------------------------------------
DROP TABLE IF EXISTS bank;
CREATE TABLE bank(
  id             int (11) Auto_increment  NOT NULL ,
  date_operation Date NOT NULL ,
  label          Varchar (255) NOT NULL ,
  amount         Decimal (25,2) ,
  date_created   Datetime ,
  PRIMARY KEY (id ) ,
  INDEX (label )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: cost
#------------------------------------------------------------
DROP TABLE IF EXISTS cost;
CREATE TABLE cost(
  id          int (11) Auto_increment  NOT NULL ,
  amount      Decimal (25,2) ,
  id_category Int NOT NULL ,
  id_bank     Int NOT NULL ,
  PRIMARY KEY (id )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: category
#------------------------------------------------------------
DROP TABLE IF EXISTS category;
CREATE TABLE category(
  id    int (11) Auto_increment  NOT NULL ,
  label Varchar (45) ,
  tag   Varchar (10) ,
  PRIMARY KEY (id ) ,
  INDEX (tag )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: subcategory
#------------------------------------------------------------
DROP TABLE IF EXISTS subcategory;
CREATE TABLE subcategory(
  id          Int NOT NULL ,
  id_category Int NOT NULL ,
  PRIMARY KEY (id ,id_category )
)ENGINE=InnoDB;
