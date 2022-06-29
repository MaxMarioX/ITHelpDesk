<?php

$CreateTable_notifications = "
					CREATE TABLE `Notifications` (
                      `ID_Notification` INT(11) NOT NULL AUTO_INCREMENT UNIQUE,
					  `closed` BIT NOT NULL,
					  `free` BIT NOT NULL,
					  `ID_ACCOUNT_REG` INT(11) NOT NULL,
					  `ID_ACCOUNT` INT(11) NOT NULL,
					  PRIMARY KEY (`ID_Notification`),
					  FOREIGN KEY (ID_ACCOUNT_REG) REFERENCES Accounts(ID_ACCOUNT),
                      FOREIGN KEY (ID_ACCOUNT) REFERENCES Accounts(ID_ACCOUNT)
					) ENGINE = InnoDB;
					"
					;
?>