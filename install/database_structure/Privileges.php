<?php

$CreateTable_privileges = "
					CREATE TABLE `Privileges` (
                      `ID_Privileges` INT(11) NOT NULL AUTO_INCREMENT UNIQUE,
					  `w0` BIT NOT NULL,
					  `r0` BIT NOT NULL,				  
					  `m0` BIT NOT NULL,
					  `a0` BIT NOT NULL,
					  `b0` BIT NOT NULL,
					  `ID_ACCOUNT` INT(11) NOT NULL,
                      PRIMARY KEY (`ID_Privileges`),
                      FOREIGN KEY (ID_ACCOUNT) REFERENCES Accounts(ID_ACCOUNT)
					) ENGINE = InnoDB;
					"
					;
?>