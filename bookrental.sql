-- -- Drop Database bookrental;
-- -- create Database bookrental;
-- -- \c bookrental


-- --assertion on the book availability of deactivated accounts 
-- --never delete data. Set the user's deleted flag to 1

-- --user cannot delete an account before the current cycle is complete
-- create table  users
-- 	(
-- 		user_id varchar(10) primary key,
-- 		user_name varchar(30),
-- 		pw varchar(20),
-- 		dob varchar(15),
-- 		fullname varchar(20),
-- 		phone_number varchar(15),
-- 		email_id varchar(40),
-- 		sex varchar(10),
-- 		deleted_flag boolean
-- 		);
-- create table useraddress
-- 	(
-- 		user_id varchar(10) ,
-- 		flat_no varchar(10),
-- 		street_name varchar(20),
-- 		locality varchar(20),
-- 		city varchar(20),
-- 		state varchar(20),
-- 		country varchar(20),
-- 		zip_code varchar(10),
-- 		foreign key(user_id) references users(user_id) on delete cascade on update cascade
-- 	);
-- create table customer
-- 	(
-- 		cust_id varchar(10) primary key,
-- 		user_id varchar(10),
-- 		foreign key(user_id) references users(user_id) on delete cascade on update cascade 
-- 	);
-- create table owner
-- 	(
-- 		owner_id varchar(10) primary key,
-- 		user_id varchar(10),
-- 		foreign key(user_id) references users(user_id) on delete cascade on update cascade
-- 	);
-- create table status(
		
-- 		status_id int primary key,	
-- 		status_name varchar(50)
-- );
-- --contains all the books put up by the owner
-- create table book
-- (
-- 	book_id varchar(10) primary key,
-- 	book_name varchar(100),
-- 	book_type varchar(20),
-- 	book_price int,
-- 	lend_duration int,
-- 	owner_id varchar(10),
-- 	author_name varchar(50),
-- 	availability integer check(availability>=0 and availability<=2),
-- 	foreign key(owner_id) references owner(owner_id) on update cascade
--    -- foreign key(author_id) references author
-- );
-- 	create table orders
-- 	(
-- 		order_id varchar(10) primary key,
-- 		time_of_order timestamp,
-- 		cost int,
-- 		due_date date,
-- 		deliver_date date,
		
-- 		cust_id varchar(10), 
-- 		status_id int,
-- 		book_id varchar(20),
-- 		--delivery_charges varchar(30),
-- 		foreign key(cust_id) references customer(cust_id) on update cascade,
-- 		foreign key(status_id) references status on update cascade,
-- 		foreign key(book_id) references book on update cascade 
-- 	);

	

-- create table employee
-- (
-- 		employee_id varchar(10) primary key,
-- 		employee_name varchar(20),
-- 		doj date,
-- 		dob date,
-- 		contact_number bigint,
-- 		salary bigint
-- );
-- create table employeeaddress
-- 	(
-- 		employee_id varchar(10) primary key,
-- 		flat_no varchar(10),
-- 		street_name varchar(20),
-- 		locality varchar(20),
-- 		city varchar(20),
-- 		state varchar(20),
-- 		country varchar(20),
-- 		zip_code bigint,
-- 		foreign key(employee_id) references employee(employee_id) on update cascade
-- );



-- create table fulfill
-- 	(
-- 		order_id varchar(10),
-- 		employee_id varchar(10),
-- 		status_id int,
		
-- 		foreign key(order_id) references orders on update cascade on delete cascade,
-- 		foreign key(employee_id) references employee on update cascade,
-- 		foreign key(status_id) references status on update cascade
-- 	);
-- create table revenue(
-- 	order_id varchar(10) primary key,
-- 	delivery_charges float,
-- 	foreign key(order_id) references orders on update cascade on delete cascade
-- );

-- create table reviews(
-- 	book_id varchar(10),
-- 	order_id varchar(10),
-- 	cust_id varchar(10),
-- 	rating int ,
-- 	comments varchar(100) default ' ',
-- 	primary key(book_id,order_id),
-- 	constraint check_rating check (rating < 6 AND rating > 0),
-- 	foreign key (order_id) references orders on update cascade,
-- 	foreign key (book_id) references book on update cascade

-- );

-- --change availability to 0 when the owner's account gets deleted
-- CREATE OR REPLACE FUNCTION validate_avail() RETURNS TRIGGER as
-- $$BEGIN
-- 	--select * from book;
-- 	if(new.deleted_flag)
-- 			then UPDATE book set availability=0 where owner_id in (select owner_id from owner where user_id=old.user_id);
-- 	end if;
-- 	--raise notice 'trigger fired %d',new.deleted_flag
-- 	--print 'after update trigger fired';
-- 	RETURN NEW;
-- END;
-- $$LANGUAGE plpgsql;
-- CREATE TRIGGER CHECK_AVAIL after update on users for each row EXECUTE PROCEDURE validate_avail();

-- --update the availability to 1 when status becomes zero
-- CREATE OR REPLACE FUNCTION validate_status_zero() RETURNS TRIGGER AS
-- $$BEGIN
-- 	if(new.status_id=0)
-- 		then update book set availability=1 where book_id in (select book_id from orders where new.book_id=book_id);
-- 	end if;
-- 	return new;	
-- END;
-- $$LANGUAGE plpgsql;
-- CREATE TRIGGER check_status_zero after insert on orders for each row EXECUTE procedure validate_status_zero();

-- --update the availability to true when status become four
-- CREATE OR REPLACE FUNCTION validate_status_four() RETURNS TRIGGER AS
-- $$BEGIN
-- 	if(new.status_id=4)
-- 		then update book set availability=2 where book_id in (select book_id from orders where new.book_id=book_id);
-- 	end if;
-- 	return new;	
-- END;
-- $$LANGUAGE plpgsql;
-- CREATE TRIGGER check_status_four after update on orders for each row EXECUTE procedure validate_status_four();

-- --after insertion into fulfill, update orders table accordingly
-- CREATE OR REPLACE FUNCTION update_status_order() RETURNS TRIGGER AS
-- $$BEGIN
-- 	update orders set status_id=new.status_id where order_id=new.order_id;
-- 	return new;	
-- END;
-- $$LANGUAGE plpgsql;
-- CREATE TRIGGER insert_into_fulfill after insert on fulfill for each row EXECUTE procedure update_status_order();


-- INSERT into users values('uaa001', 'Tejas_P' , 'tejurocks' , '01-03-1998' , 'Tejas Prashanth' , '9930291339' , 'tejuprash@gmail.com','M',false);
-- INSERT into users values('uaa002', 'Megvya' , 'meg1999' , '26-02-1999' , 'Meghana Vyakaranam' , '9930294339' , 'meghanavs@gmail.com','F',false);
-- INSERT into users values('uaa003', 'taruni' , 'truni45' , '14-05-1998' , 'Taruni Sunder' , '9968292339' , 'tarunisunder@gmail.com','F',false);
-- INSERT into users values('uaa004', 'tanmudu' , 'tambooks123' , '01-07-1998' , 'Tanmaya Ududpa' , '9834291337' , 'tanmayup@gmail.com','M',false);
-- INSERT into users values('uaa005', 'vidhuroj' , 'dbmsftw' , '01-03-1979' , 'Vidhita Rojin' , '9936791354' , 'vr@gmail.com','F',false);
-- INSERT into users values('uaa006', 'dilkum' , 'musicsoul' , '30-07-1998' , 'Dilip Kumar' , '9935551330' ,'dilipk@gmail.com', 'M',false);
-- INSERT into users values('uaa007', 'ashwini' , 'dancer107' , '27-07-1998' , 'Ashwini Deshpande' , '8730291336' , 'ashdes@gmail.com','F',false);
-- INSERT into users values('uaa008', 'nidhi' , 'nidhrocks' , '08-03-1998' , 'Nidhi Singh' , '9930254317' ,'nidhi@gmail.com', 'F',false);
-- INSERT into users values('uaa009', 'nitin' , 'timetoread' , '11-06-1998' , 'Nitin Rao' , '9930267890' ,'nitin@gmail.com', 'M',false);
-- INSERT into users values('uaa010', 'nikhil' , 'password' , '01-03-1988' , 'Nikhil Gupta' , '993123439' , 'nikhil@gmail.com','M',false);
-- INSERT into users values('uaa011', 'priya' , 'pppqqq' , '01-09-1999' , 'Priya Rajan' , '9930291839' , 'priya@gmail.com','F',false);
-- INSERT into users values('uaa012', 'sunder' , 'suninsun' , '17-09-1968' , 'Sunder Chakravarty' , '8730297396' ,'sunderc@gmail.com', 'M',false);
-- INSERT into users values('uaa013', 'prabha' , 'prabsun' , '03-03-1970' , 'Prabha Sunder' , '9938791351' , 'prabha@gmail.com','F',false);
-- INSERT into users values('uaa014', 'ramita' , 'ramzshar' , '10-05-1996' , 'Ramita Sharma' , '9450291365' , 'ramita@gmail.com','F',false);
-- INSERT into users values('uaa015', 'Yashas' , 'yashurocks' , '01-03-1998' , 'Yashas Prashanth' , '9930278339' , 'yashas@gmail.com','M',false);

-- INSERT into useraddress values('uaa001', '23' , 'lavelle road' , 'gandhinagar' , 'Bangalore' , 'Karnataka' , 'India' ,'560001');
-- INSERT into useraddress values('uaa002', '63' , 'malleshwaram road' , 'malleshwaram' , 'Bangalore' , 'Karnataka' , 'India' ,'560011');
-- INSERT into useraddress values('uaa003', '78' , 'richmond road' , 'jayanagar' , 'Bangalore' , 'Karnataka' , 'India' ,'560041');
-- INSERT into useraddress values('uaa004', '23' , 'wilson road' , 'koramangala' , 'Bangalore' , 'Karnataka' , 'India' ,'560078');
-- INSERT into useraddress values('uaa005', '23' , 'kempegowda road' , 'indiranagar' , 'Bangalore' , 'Karnataka' , 'India' ,'560088');
-- INSERT into useraddress values('uaa006', '23' , 'mekhri road' , 'gandhinagar' , 'Bangalore' , 'Karnataka' , 'India' ,'560001');
-- INSERT into useraddress values('uaa007', '23' , 'bellandur road' , 'bellandur' , 'Bangalore' , 'Karnataka' , 'India' ,'560087');
-- INSERT into useraddress values('uaa008', '23' , 'marathahalli road' , 'marathahalli' , 'Bangalore' , 'Karnataka' , 'India' ,'560037');
-- INSERT into useraddress values('uaa009', '23' , 'mg road' , 'brookfields' , 'Bangalore' , 'Karnataka' , 'India' ,'560091');
-- INSERT into useraddress values('uaa010', '23' , 'whitefield road' , 'whitefield' , 'Bangalore' , 'Karnataka' , 'India' ,'560051');
-- INSERT into useraddress values('uaa011', '23' , 'church road' , 'girinagar' , 'Bangalore' , 'Karnataka' , 'India' ,'560089');
-- INSERT into useraddress values('uaa012', '23' , 'sarjapur road' , 'sarjapur' , 'Bangalore' , 'Karnataka' , 'India' ,'560060');
-- INSERT into useraddress values('uaa013',  '23' , 'sarjapur road' , 'sarjapur' , 'Bangalore' , 'Karnataka' , 'India' ,'560060');
-- INSERT into useraddress values('uaa004', '23' , 'HAL road' , 'banashankari' , 'Bangalore' , 'Karnataka' , 'India' ,'560085');
-- INSERT into useraddress values('uaa005', '23' , 'lavelle road' , 'gandhinagar' , 'Bangalore' , 'Karnataka' , 'India' ,'560001');

-- INSERT into customer values('caa001' , 'uaa001');
-- INSERT into customer values('caa002' , 'uaa002');
-- INSERT into customer values('caa003' , 'uaa003');
-- INSERT into customer values('caa004' , 'uaa004');
-- INSERT into customer values('caa005' , 'uaa005');
-- INSERT into customer values('caa006' , 'uaa006');
-- INSERT into customer values('caa007' , 'uaa007');
-- INSERT into customer values('caa008' , 'uaa008');
-- INSERT into customer values('caa009' , 'uaa009');
-- INSERT into customer values('caa010' , 'uaa010');
-- INSERT into customer values('caa011' , 'uaa011');
-- INSERT into customer values('caa012' , 'uaa012');
-- INSERT into customer values('caa013' , 'uaa013');
-- INSERT into customer values('caa014' , 'uaa014');
-- INSERT into customer values('caa015' , 'uaa015');

-- INSERT into owner values('owaa001' , 'uaa001');
-- INSERT into owner values('owaa002' , 'uaa002');
-- INSERT into owner values('owaa003' , 'uaa003');
-- INSERT into owner values('owaa004' , 'uaa004');
-- INSERT into owner values('owaa005' , 'uaa005');
-- INSERT into owner values('owaa006' , 'uaa006');
-- INSERT into owner values('owaa007' , 'uaa007');
-- INSERT into owner values('owaa008' , 'uaa008');
-- INSERT into owner values('owaa009' , 'uaa009');
-- INSERT into owner values('owaa010' , 'uaa010');
-- INSERT into owner values('owaa011' , 'uaa011');
-- INSERT into owner values('owaa012' , 'uaa012');
-- INSERT into owner values('owaa013' , 'uaa013');
-- INSERT into owner values('owaa014' , 'uaa014');
-- INSERT into owner values('owaa015' , 'uaa015');

-- INSERT into status values( '0' , 'ordered');
-- INSERT into status values( '1' , 'collected_from_owner');
-- INSERT into status values( '2' , 'delivered_to_customer');
-- INSERT into status values( '3' , 'collected_from_customer');
-- INSERT into status values( '4' , 'returned_to_owner');

-- INSERT into book values('baa001', 'Hold Tight', 'paperback', '50', '14', 'owaa001','Harlen Coben',2);
-- INSERT into book values('baa002', 'Bloodline', 'paperback', '50', '14', 'owaa002','Sidney Sheldon',2);
-- INSERT into book values('baa003', 'Hold Tight', 'paperback', '50', '14', 'owaa003','Harlan Coben',2);
-- INSERT into book values('baa004', 'Inferno', 'hardbound', '50', '14', 'owaa004','Dan Brown',2);
-- INSERT into book values('baa005', 'Sparkling Cyanide', 'paperback', '50', '14','owaa005','Agatha Christe',2);
-- INSERT into book values('baa006', 'Promise Me', 'hardbound', '50', '14', 'owaa006', 'Harlan Coben',2);
-- INSERT into book values('baa007', 'Gone Girl', 'paperback', '50', '14', 'owaa007', 'Gillian Flynn',2);
-- INSERT into book values('baa008', 'Tom Sawyer', 'paperback', '50', '14', 'owaa008', 'Mark Twain',2);
-- INSERT into book values('baa009', 'Mutation', 'paperback', '50', '14', 'owaa009','Robin Cook',2);
-- INSERT into book values('baa010', 'Invasion', 'paperback', '50', '14', 'owaa010','Robin Cook',2);
-- INSERT into book values('baa011', 'The Broker', 'paperback', '50', '14', 'owaa011', 'John Grisham',2);
-- INSERT into book values('baa012', 'Malgudi Days', 'paperback', '50', '14', 'owaa012', 'RK Narayan',2);
-- INSERT into book values('baa013', 'The Street Lawyer', 'paperback', '50', '14', 'owaa013', 'John Grisham',2);
-- INSERT into book values('baa014', '1984', 'hardbound', '50', '14', 'owaa014' ,'George Orwell',2);
-- INSERT into book values('baa015', 'The bell jar', 'paperback', '50', '14', 'owaa015', 'Sylvia Plath',2);


-- INSERT into orders values('oraa001' ,'2018-02-28 00:00-01' , '50' , '2018-02-28' , '2018-03-14', 'caa002' , '0', 'baa001');
-- INSERT into orders values('oraa002' ,'2018-03-28 00:00:01' , '50' , '2018-03-28' , '2018-04-14', 'caa006' , '0','baa005');
-- INSERT into orders values('oraa003' ,'2018-03-28 00:00:01' , '50' , '2018-03-28' , '2018-04-14', 'caa007' , '0','baa004');
-- INSERT into orders values('oraa004' ,'2018-02-28 00:00:01' , '50' , '2018-02-28' , '2018-03-14', 'caa009' , '0','baa008');
-- INSERT into orders values('oraa005' ,'2017-05-28 00:00:01' , '50' , '2017-05-28' , '2018-06-14', 'caa012' , '0','baa002');
-- INSERT into orders values('oraa006' ,'2017-07-28 00:00:01' , '50' , '2017-07-28' , '2018-07-14', 'caa002' , '0','baa009');


-- INSERT into employee values('ea001' , 'Rahul Kashyap' , '2017-06-07' , '1988-08-09' , '9900090870' , '250000');
-- INSERT into employee values('ea002' , 'Vinit Gopi' , '2017-06-07' , '1989-07-10' , '9765290870' , '250000');
-- INSERT into employee values('ea003' , 'Karthik Seth' , '2017-06-07' , '1985-10-09' , '9978090870' , '250000');
-- INSERT into employee values('ea004' , 'Swamy Menon' , '2017-05-07' , '1986-08-11' , '9986090877' , '250000');
-- INSERT into employee values('ea005' , 'Dhruv Swami' , '2017-06-07' , '1988-07-09' , '9900097654' , '250000');

-- INSERT into employeeaddress values('ea001' , '67' , 'Banerghatta Road', 'Banerghatta' , 'Bangalore', 'Karnataka' , 'India' , '560081');
-- INSERT into employeeaddress values('ea002' , '67' , 'Banerghatta Road', 'Banerghatta' , 'Bangalore', 'Karnataka' , 'India' , '560081');
-- INSERT into employeeaddress values('ea003' , '45' , 'Munekalola Road', 'Munekalola' , 'Bangalore', 'Karnataka' , 'India' , '560076');
-- INSERT into employeeaddress values('ea004' , '45' , 'Munekalola Road', 'Munekalola' , 'Bangalore', 'Karnataka' , 'India' , '560076');
-- INSERT into employeeaddress values('ea005' , '34' , 'Hulimavu Road', 'Bommanahalli' , 'Bangalore', 'Karnataka' , 'India' , '560080');


-- INSERT into fulfill values('oraa001' , 'ea001' , '1');
-- INSERT into fulfill values('oraa002' , 'ea002' , '3');
-- INSERT into fulfill values('oraa003' , 'ea003' , '3');
-- INSERT into fulfill values('oraa004' , 'ea002' , '3');
-- INSERT into fulfill values('oraa005' , 'ea004' , '1');
-- INSERT into fulfill values('oraa006' , 'ea005' , '1');

-- INSERT INTO revenue values('oraa001',50.23);
-- INSERT INTO revenue values('oraa002',20.22);
-- INSERT INTO revenue values('oraa003',21.56);
-- INSERT INTO revenue values('oraa004',32.12);
-- INSERT INTO revenue values('oraa005',45.98);
-- INSERT INTO revenue values('oraa006',12.78);

-- select * from book;

Drop Database bookrental;
create Database bookrental;
\c bookrental


--assertion on the book availability of deactivated accounts 
--never delete data. Set the user's deleted flag to 1

--user cannot delete an account before the current cycle is complete
create table  users
	(
		user_id varchar(10) primary key,
		user_name varchar(30),
		pw varchar(20),
		dob varchar(15),
		fullname varchar(20),
		phone_number varchar(15),
		email_id varchar(40),
		sex varchar(10),
		deleted_flag boolean
		);
create table useraddress
	(
		user_id varchar(10) ,
		flat_no varchar(10),
		street_name varchar(20),
		locality varchar(20),
		city varchar(20),
		state varchar(20),
		country varchar(20),
		zip_code varchar(10),
		foreign key(user_id) references users(user_id) on delete cascade on update cascade
	);
create table customer
	(
		cust_id varchar(10) primary key,
		user_id varchar(10),
		foreign key(user_id) references users(user_id) on delete cascade on update cascade 
	);
create table owner
	(
		owner_id varchar(10) primary key,
		user_id varchar(10),
		foreign key(user_id) references users(user_id) on delete cascade on update cascade
	);
create table status(
		
		status_id int primary key,	
		status_name varchar(50)
);
--contains all the books put up by the owner
create table book
(
	book_id varchar(10) primary key,
	book_name varchar(100),
	book_type varchar(20),
	book_price int,
	lend_duration int,
	owner_id varchar(10),
	author_name varchar(50),
	availability integer check(availability>=0 and availability<=2),
	foreign key(owner_id) references owner(owner_id) on update cascade
   -- foreign key(author_id) references author
);
	create table orders
	(
		order_id varchar(10) primary key,
		time_of_order timestamp,
		cost int,
		due_date date,
		deliver_date date,
		
		cust_id varchar(10), 
		status_id int,
		book_id varchar(20),
		--delivery_charges varchar(30),
		foreign key(cust_id) references customer(cust_id) on update cascade,
		foreign key(status_id) references status on update cascade,
		foreign key(book_id) references book on update cascade 
	);

	

create table employee
(
		employee_id varchar(10) primary key,
		employee_name varchar(20),
		doj date,
		dob date,
		contact_number bigint,
		salary bigint,
		no_task int check(no_task>=0 and no_task<=5)
);
create table employeeaddress
	(
		employee_id varchar(10) primary key,
		flat_no varchar(10),
		street_name varchar(20),
		locality varchar(20),
		city varchar(20),
		state varchar(20),
		country varchar(20),
		zip_code bigint,
		foreign key(employee_id) references employee(employee_id) on update cascade
);



create table fulfill
	(
		order_id varchar(10),
		employee_id varchar(10),
		status_id int,
		
		foreign key(order_id) references orders on update cascade on delete cascade,
		foreign key(employee_id) references employee on update cascade,
		foreign key(status_id) references status on update cascade
	);
create table revenue(
	order_id varchar(10) primary key,
	delivery_charges float,
	foreign key(order_id) references orders on update cascade on delete cascade
);

create table reviews(
	book_id varchar(10),
	order_id varchar(10),
	cust_id varchar(10),
	rating int ,
	comments varchar(100) default ' ',
	primary key(book_id,order_id),
	constraint check_rating check (rating < 6 AND rating > 0),
	foreign key (order_id) references orders on update cascade,
	foreign key (book_id) references book on update cascade

);


create table assigned(
	employee_id varchar(10),
	order_id varchar(10),
	status_id varchar(10),
	acceptance int,
	-- rimary key(book_id,order_id),
	
	foreign key (order_id) references orders,
	foreign key (employee_id) references employee
	foreign key(status_id) references status
);

--change availability to 0 when the owner's account gets deleted
CREATE OR REPLACE FUNCTION validate_avail() RETURNS TRIGGER as
$$BEGIN
	--select * from book;
	if(new.deleted_flag)
			then UPDATE book set availability=0 where owner_id in (select owner_id from owner where user_id=old.user_id);
	end if;
	--raise notice 'trigger fired %d',new.deleted_flag
	--print 'after update trigger fired';
	RETURN NEW;
END;
$$LANGUAGE plpgsql;
CREATE TRIGGER CHECK_AVAIL after update on users for each row EXECUTE PROCEDURE validate_avail();

--update the availability to 1 when status becomes zero
CREATE OR REPLACE FUNCTION validate_status_zero() RETURNS TRIGGER AS
$$BEGIN
	if(new.status_id=0)
		then update book set availability=1 where book_id in (select book_id from orders where new.book_id=book_id);
	end if;
	return new;	
END;
$$LANGUAGE plpgsql;
CREATE TRIGGER check_status_zero after insert on orders for each row EXECUTE procedure validate_status_zero();

--update the availability to true when status become four
CREATE OR REPLACE FUNCTION validate_status_four() RETURNS TRIGGER AS
$$BEGIN
	if(new.status_id=4)
		then update book set availability=2 where book_id in (select book_id from orders where new.book_id=book_id);
	end if;
	return new;	
END;
$$LANGUAGE plpgsql;
CREATE TRIGGER check_status_four after update on orders for each row EXECUTE procedure validate_status_four();

--after insertion into fulfill, update orders table accordingly
CREATE OR REPLACE FUNCTION update_status_order() RETURNS TRIGGER AS
$$BEGIN
	update orders set status_id=new.status_id where order_id=new.order_id;
	return new;	
END;
$$LANGUAGE plpgsql;
CREATE TRIGGER insert_into_fulfill after insert on fulfill for each row EXECUTE procedure update_status_order();


INSERT into users values('uaa001', 'Tejas_P' , 'tejurocks' , '01-03-1998' , 'Tejas Prashanth' , '9930291339' , 'tejuprash@gmail.com','M',false);
INSERT into users values('uaa002', 'Megvya' , 'meg1999' , '26-02-1999' , 'Meghana Vyakaranam' , '9930294339' , 'meghanavs@gmail.com','F',false);
INSERT into users values('uaa003', 'taruni' , 'truni45' , '14-05-1998' , 'Taruni Sunder' , '9968292339' , 'tarunisunder@gmail.com','F',false);
INSERT into users values('uaa004', 'tanmudu' , 'tambooks123' , '01-07-1998' , 'Tanmaya Ududpa' , '9834291337' , 'tanmayup@gmail.com','M',false);
INSERT into users values('uaa005', 'vidhuroj' , 'dbmsftw' , '01-03-1979' , 'Vidhita Rojin' , '9936791354' , 'vr@gmail.com','F',false);
INSERT into users values('uaa006', 'dilkum' , 'musicsoul' , '30-07-1998' , 'Dilip Kumar' , '9935551330' ,'dilipk@gmail.com', 'M',false);
INSERT into users values('uaa007', 'ashwini' , 'dancer107' , '27-07-1998' , 'Ashwini Deshpande' , '8730291336' , 'ashdes@gmail.com','F',false);
INSERT into users values('uaa008', 'nidhi' , 'nidhrocks' , '08-03-1998' , 'Nidhi Singh' , '9930254317' ,'nidhi@gmail.com', 'F',false);
INSERT into users values('uaa009', 'nitin' , 'timetoread' , '11-06-1998' , 'Nitin Rao' , '9930267890' ,'nitin@gmail.com', 'M',false);
INSERT into users values('uaa010', 'nikhil' , 'password' , '01-03-1988' , 'Nikhil Gupta' , '993123439' , 'nikhil@gmail.com','M',false);
INSERT into users values('uaa011', 'priya' , 'pppqqq' , '01-09-1999' , 'Priya Rajan' , '9930291839' , 'priya@gmail.com','F',false);
INSERT into users values('uaa012', 'sunder' , 'suninsun' , '17-09-1968' , 'Sunder Chakravarty' , '8730297396' ,'sunderc@gmail.com', 'M',false);
INSERT into users values('uaa013', 'prabha' , 'prabsun' , '03-03-1970' , 'Prabha Sunder' , '9938791351' , 'prabha@gmail.com','F',false);
INSERT into users values('uaa014', 'ramita' , 'ramzshar' , '10-05-1996' , 'Ramita Sharma' , '9450291365' , 'ramita@gmail.com','F',false);
INSERT into users values('uaa015', 'Yashas' , 'yashurocks' , '01-03-1998' , 'Yashas Prashanth' , '9930278339' , 'yashas@gmail.com','M',false);

INSERT into useraddress values('uaa001', '23' , 'lavelle road' , 'gandhinagar' , 'Bangalore' , 'Karnataka' , 'India' ,'560001');
INSERT into useraddress values('uaa002', '63' , 'malleshwaram road' , 'malleshwaram' , 'Bangalore' , 'Karnataka' , 'India' ,'560011');
INSERT into useraddress values('uaa003', '78' , 'richmond road' , 'jayanagar' , 'Bangalore' , 'Karnataka' , 'India' ,'560041');
INSERT into useraddress values('uaa004', '23' , 'wilson road' , 'koramangala' , 'Bangalore' , 'Karnataka' , 'India' ,'560078');
INSERT into useraddress values('uaa005', '23' , 'kempegowda road' , 'indiranagar' , 'Bangalore' , 'Karnataka' , 'India' ,'560088');
INSERT into useraddress values('uaa006', '23' , 'mekhri road' , 'gandhinagar' , 'Bangalore' , 'Karnataka' , 'India' ,'560001');
INSERT into useraddress values('uaa007', '23' , 'bellandur road' , 'bellandur' , 'Bangalore' , 'Karnataka' , 'India' ,'560087');
INSERT into useraddress values('uaa008', '23' , 'marathahalli road' , 'marathahalli' , 'Bangalore' , 'Karnataka' , 'India' ,'560037');
INSERT into useraddress values('uaa009', '23' , 'mg road' , 'brookfields' , 'Bangalore' , 'Karnataka' , 'India' ,'560091');
INSERT into useraddress values('uaa010', '23' , 'whitefield road' , 'whitefield' , 'Bangalore' , 'Karnataka' , 'India' ,'560051');
INSERT into useraddress values('uaa011', '23' , 'church road' , 'girinagar' , 'Bangalore' , 'Karnataka' , 'India' ,'560089');
INSERT into useraddress values('uaa012', '23' , 'sarjapur road' , 'sarjapur' , 'Bangalore' , 'Karnataka' , 'India' ,'560060');
INSERT into useraddress values('uaa013',  '23' , 'sarjapur road' , 'sarjapur' , 'Bangalore' , 'Karnataka' , 'India' ,'560060');
INSERT into useraddress values('uaa004', '23' , 'HAL road' , 'banashankari' , 'Bangalore' , 'Karnataka' , 'India' ,'560085');
INSERT into useraddress values('uaa005', '23' , 'lavelle road' , 'gandhinagar' , 'Bangalore' , 'Karnataka' , 'India' ,'560001');

INSERT into customer values('caa001' , 'uaa001');
INSERT into customer values('caa002' , 'uaa002');
INSERT into customer values('caa003' , 'uaa003');
INSERT into customer values('caa004' , 'uaa004');
INSERT into customer values('caa005' , 'uaa005');
INSERT into customer values('caa006' , 'uaa006');
INSERT into customer values('caa007' , 'uaa007');
INSERT into customer values('caa008' , 'uaa008');
INSERT into customer values('caa009' , 'uaa009');
INSERT into customer values('caa010' , 'uaa010');
INSERT into customer values('caa011' , 'uaa011');
INSERT into customer values('caa012' , 'uaa012');
INSERT into customer values('caa013' , 'uaa013');
INSERT into customer values('caa014' , 'uaa014');
INSERT into customer values('caa015' , 'uaa015');

INSERT into owner values('owaa001' , 'uaa001');
INSERT into owner values('owaa002' , 'uaa002');
INSERT into owner values('owaa003' , 'uaa003');
INSERT into owner values('owaa004' , 'uaa004');
INSERT into owner values('owaa005' , 'uaa005');
INSERT into owner values('owaa006' , 'uaa006');
INSERT into owner values('owaa007' , 'uaa007');
INSERT into owner values('owaa008' , 'uaa008');
INSERT into owner values('owaa009' , 'uaa009');
INSERT into owner values('owaa010' , 'uaa010');
INSERT into owner values('owaa011' , 'uaa011');
INSERT into owner values('owaa012' , 'uaa012');
INSERT into owner values('owaa013' , 'uaa013');
INSERT into owner values('owaa014' , 'uaa014');
INSERT into owner values('owaa015' , 'uaa015');

INSERT into status values( '0' , 'ordered');
INSERT into status values( '1' , 'collected_from_owner');
INSERT into status values( '2' , 'delivered_to_customer');
INSERT into status values( '3' , 'collected_from_customer');
INSERT into status values( '4' , 'returned_to_owner');

INSERT into book values('baa001', 'Hold Tight', 'paperback', '50', '14', 'owaa001','Harlen Coben',2);
INSERT into book values('baa002', 'Bloodline', 'paperback', '50', '14', 'owaa002','Sidney Sheldon',2);
INSERT into book values('baa003', 'Hold Tight', 'paperback', '50', '14', 'owaa003','Harlan Coben',2);
INSERT into book values('baa004', 'Inferno', 'hardbound', '50', '14', 'owaa004','Dan Brown',2);
INSERT into book values('baa005', 'Sparkling Cyanide', 'paperback', '50', '14','owaa005','Agatha Christe',2);
INSERT into book values('baa006', 'Promise Me', 'hardbound', '50', '14', 'owaa006', 'Harlan Coben',2);
INSERT into book values('baa007', 'Gone Girl', 'paperback', '50', '14', 'owaa007', 'Gillian Flynn',2);
INSERT into book values('baa008', 'Tom Sawyer', 'paperback', '50', '14', 'owaa008', 'Mark Twain',2);
INSERT into book values('baa009', 'Mutation', 'paperback', '50', '14', 'owaa009','Robin Cook',2);
INSERT into book values('baa010', 'Invasion', 'paperback', '50', '14', 'owaa010','Robin Cook',2);
INSERT into book values('baa011', 'The Broker', 'paperback', '50', '14', 'owaa011', 'John Grisham',2);
INSERT into book values('baa012', 'Malgudi Days', 'paperback', '50', '14', 'owaa012', 'RK Narayan',2);
INSERT into book values('baa013', 'The Street Lawyer', 'paperback', '50', '14', 'owaa013', 'John Grisham',2);
INSERT into book values('baa014', '1984', 'hardbound', '50', '14', 'owaa014' ,'George Orwell',2);
INSERT into book values('baa015', 'The bell jar', 'paperback', '50', '14', 'owaa015', 'Sylvia Plath',2);


INSERT into orders values('oraa001' ,'2018-02-28 00:00-01' , '50' , '2018-02-28' , '2018-03-14', 'caa002' , '0', 'baa001');
INSERT into orders values('oraa002' ,'2018-03-28 00:00:01' , '50' , '2018-03-28' , '2018-04-14', 'caa006' , '0','baa005');
INSERT into orders values('oraa003' ,'2018-03-28 00:00:01' , '50' , '2018-03-28' , '2018-04-14', 'caa007' , '0','baa004');
INSERT into orders values('oraa004' ,'2018-02-28 00:00:01' , '50' , '2018-02-28' , '2018-03-14', 'caa009' , '0','baa008');
INSERT into orders values('oraa005' ,'2017-05-28 00:00:01' , '50' , '2017-05-28' , '2018-06-14', 'caa012' , '0','baa002');
INSERT into orders values('oraa006' ,'2017-07-28 00:00:01' , '50' , '2017-07-28' , '2018-07-14', 'caa002' , '0','baa009');


INSERT into employee values('ea001' , 'Rahul Kashyap' , '2017-06-07' , '1988-08-09' , '9900090870' , '250000',2);
INSERT into employee values('ea002' , 'Vinit Gopi' , '2017-06-07' , '1989-07-10' , '9765290870' , '250000',5);
INSERT into employee values('ea003' , 'Karthik Seth' , '2017-06-07' , '1985-10-09' , '9978090870' , '250000',4);
INSERT into employee values('ea004' , 'Swamy Menon' , '2017-05-07' , '1986-08-11' , '9986090877' , '250000',0);
INSERT into employee values('ea005' , 'Dhruv Swami' , '2017-06-07' , '1988-07-09' , '9900097654' , '250000',3);

INSERT into employeeaddress values('ea001' , '67' , 'Banerghatta Road', 'Banerghatta' , 'Bangalore', 'Karnataka' , 'India' , '560081');
INSERT into employeeaddress values('ea002' , '67' , 'Banerghatta Road', 'Banerghatta' , 'Bangalore', 'Karnataka' , 'India' , '560081');
INSERT into employeeaddress values('ea003' , '45' , 'Munekalola Road', 'Munekalola' , 'Bangalore', 'Karnataka' , 'India' , '560076');
INSERT into employeeaddress values('ea004' , '45' , 'Munekalola Road', 'Munekalola' , 'Bangalore', 'Karnataka' , 'India' , '560076');
INSERT into employeeaddress values('ea005' , '34' , 'Hulimavu Road', 'Bommanahalli' , 'Bangalore', 'Karnataka' , 'India' , '560080');


INSERT into fulfill values('oraa001' , 'ea001' , '1');
INSERT into fulfill values('oraa002' , 'ea002' , '3');
INSERT into fulfill values('oraa003' , 'ea003' , '3');
INSERT into fulfill values('oraa004' , 'ea002' , '3');
INSERT into fulfill values('oraa005' , 'ea004' , '1');
INSERT into fulfill values('oraa006' , 'ea005' , '1');

INSERT INTO revenue values('oraa001',50.23);
INSERT INTO revenue values('oraa002',20.22);
INSERT INTO revenue values('oraa003',21.56);
INSERT INTO revenue values('oraa004',32.12);
INSERT INTO revenue values('oraa005',45.98);
INSERT INTO revenue values('oraa006',12.78);

-- select * from book;



