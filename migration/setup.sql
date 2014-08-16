DROP TABLE `users`;

CREATE TABLE `users` (
	`id` int(11) AUTO_INCREMENT,
	`user_id` int(11),
	`user` VARCHAR(255),
	`date` int(11),
	`url` TEXT,
	PRIMARY KEY (id)
);