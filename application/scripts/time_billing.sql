/*time_billing table*/
create table time_rate (
	id int primary key not null AUTO_INCREMENT,
    type varchar(50) not null,
    period float not null default 1,
    rate double not null DEFAULT 10000
);