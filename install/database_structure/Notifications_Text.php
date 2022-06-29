<?php
$CreateTable_notifications_text = "
					CREATE TABLE `Notifications_Text` (
                      `ID_Notification_Text` INT(11) NOT NULL AUTO_INCREMENT UNIQUE,
					  `title` VARCHAR(30) NOT NULL,
					  `text` TEXT NOT NULL,
					  `ID_Notification` INT(11) NOT NULL,
                      PRIMARY KEY (`ID_Notification_Text`),
                      FOREIGN KEY (ID_Notification) REFERENCES Notifications(ID_Notification)
					) ENGINE = InnoDB;
					"
					;
?>