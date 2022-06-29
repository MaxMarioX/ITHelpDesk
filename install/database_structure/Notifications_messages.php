<?php

$CreateTable_notifications_msg = "
					CREATE TABLE `Notifications_msg` (
                      `ID_Notification_msg` INT(11) NOT NULL AUTO_INCREMENT UNIQUE,
					  `text` TEXT NOT NULL,
                      `date` DATE NOT NULL,
					  `time` TIME NOT NULL,
                      `ID_ACCOUNT` INT(11) NOT NULL,
                      `ID_Notification` INT(11) NOT NULL,
                      PRIMARY KEY (`ID_Notification_msg`),
                      FOREIGN KEY (ID_ACCOUNT) REFERENCES Accounts(ID_ACCOUNT),
                      FOREIGN KEY (ID_Notification) REFERENCES Notifications(ID_Notification)
					) ENGINE = InnoDB;
					"
					;
?>