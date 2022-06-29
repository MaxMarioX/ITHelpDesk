<?php

$CreateTable_accounts = "
					CREATE TABLE `Accounts` (
                      `ID_ACCOUNT` INT(11) NOT NULL AUTO_INCREMENT UNIQUE,
					  `login` VARCHAR(10) NOT NULL UNIQUE,
					  `password` VARCHAR(255) NOT NULL,				  
					  `date` DATE NOT NULL,
                      PRIMARY KEY (`ID_ACCOUNT`)
					) ENGINE = InnoDB;
					"
					;
?>