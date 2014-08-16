DROP TABLE `users`;

CREATE TABLE `users` (
	`id` int(11) AUTO_INCREMENT,
	`user_id` int(11),
	`user` TEXT,
	`date` TEXT,
	`url` TEXT,
	PRIMARY KEY (id)
);