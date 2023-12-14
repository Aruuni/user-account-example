CREATE TABLE IF NOT EXISTS `accounts` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
  	`username` varchar(50) NOT NULL,
  	`password` varchar(255) NOT NULL,
  	`email` varchar(100) NOT NULL,
    `phone` VARCHAR(20) NOT NULL,
	`activation_token` varchar(100) NULL,
	`activation_token_timestamp` datetime NULL,
	`password_request_timestamp` datetime NULL,
	`fast_fails` int(11) NOT NULL DEFAULT '0',
	`locked_until` datetime NULL,
<<<<<<< HEAD
	`confirmed` tinyint(1) NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`)
=======
	`is_admin` tinyint(1) NOT NULL DEFAULT '0',
	`confirmed` tinyint(1) NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;   

INSERT INTO accounts (id, username, password, email, phone, is_admin) VALUES (69696969, 'admin', 'doesnt_matter', 'admin@admin.boss', '+44 4444 444444', '1');

CREATE TABLE IF NOT EXISTS `images` (
	`id` int(11) NOT NULL,
  	`file_name` varchar(50) NOT NULL,
  	`comment` varchar(255) NOT NULL, 
	`contact` varchar(255) NOT NULL
>>>>>>> 036e34286d71425867018f1f999a10dd661ae328
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;   