create table rayku_coupons (
	id int(11) NOT NULL AUTO_INCREMENT, 
	coupon varchar(12) NOT NULL,
	expiration_date date NULL,
	expiration_count int(11) NULL,
	use_count int(11) NOT NULL,
	rayku_points int(11) NOT NULL,
	PRIMARY KEY (id)
);

INSERT INTO rayku_coupons (coupon, expiration_count, use_count, rayku_points) VALUES ('spring38', '20', '0', '1000');

create table rayku_reviews (
	id int(11) NOT NULL AUTO_INCREMENT,
	s_id int(11) NOT NULL,
	t_id int(11) NOT NULL,
	review varchar(255), 
	PRIMARY KEY(id),
	FOREIGN KEY (s_id) REFERENCES (fos_user_user),
	FOREIGN KEY (t_id) REFERENCES (fos_user_user)
);