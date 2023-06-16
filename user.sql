create table  `user`(
    `id` int(11) not null auto_increment,
    `name` varchar(100) not null,
    `gender` int(10) not null,
    `address` varchar(255) not null,
    PRIMARY KEY(`id`)

)ENGINE = InnoDB DEFAULT CHARSET = latin1 auto_increment = 4;
