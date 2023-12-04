CREATE TABLE IF NOT EXISTS `accounts` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
  	`username` varchar(50) NOT NULL,
  	`password` varchar(255) NOT NULL,
  	`email` varchar(100) NOT NULL,
    `phone` VARCHAR(20) NOT NULL,
	`activation_token` varchar(100) NULL,
	`activation_token_timestamp` datetime NULL,
	`password_reset_request` tinyint(1) NOT NULL DEFAULT '0',
	`password_request_timestamp` datetime NULL,
	`confirmed` tinyint(1) NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;        <input type="submit" value="Reset Password" class="g-recaptcha" data-sitekey="6LeeNCEpAAAAACjAcEUxAEKzRPGkN4Odwveq8Fh_"  onclick="redirectToAnotherPage()" data-callback='onSubmit' data-action='submit'>