<?php

$CreateTable_owners = "
					CREATE TABLE `Owners` (
                      `ID_Owner` INT(11) NOT NULL AUTO_INCREMENT UNIQUE,
					  `name` VARCHAR(10) NOT NULL,
					  `surname` VARCHAR(15) NOT NULL,				  
					  `email` VARCHAR(30) NOT NULL,
					  `ID_ACCOUNT` INT(11) NOT NULL,
                      PRIMARY KEY (`ID_Owner`),
                      FOREIGN KEY (ID_ACCOUNT) REFERENCES Accounts(ID_ACCOUNT)
					) ENGINE = InnoDB;
					"
					;
?>