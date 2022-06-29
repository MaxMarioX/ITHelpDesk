<?php

$CreateTable_notifications_detail = "
					CREATE TABLE `Notifications_Detail` (
                      `ID_Notification_Detail` INT(11) NOT NULL AUTO_INCREMENT UNIQUE,
					  `user` VARCHAR(30) NOT NULL,
					  `date` DATE NOT NULL,
					  `time` TIME NOT NULL,
					  `date_end` DATE NULL,
					  `acc_end` INT(11) NULL,
					  `company` VARCHAR(30) NULL,
					  `system` VARCHAR(30) NULL,
					  `ID_Notification` INT(11) NOT NULL,
                      PRIMARY KEY (`ID_Notification_Detail`),
                      FOREIGN KEY (ID_Notification) REFERENCES Notifications(ID_Notification)
					) ENGINE = InnoDB;
					"
					;
?>