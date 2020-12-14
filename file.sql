create database railway_tickets;
use railway_tickets;

create table train_details(trainnum int(5) not NULL,date_of_journey date not NULL,accoachnum int(5) not NULL,sleepercoachnum int(5) not NULL,PRIMARY KEY(trainnum,date_of_journey));

create table ac_seats_availability(trainnum int(5) not NULL,date_of_journey date not NULL,current_seat int(5) not NULL,current_coach int(5),seats_available int(5) not NULL,PRIMARY KEY(trainnum,date_of_journey),FOREIGN KEY (trainnum,date_of_journey) References train_details(trainnum,date_of_journey));

create table sleeper_seats_availability(trainnum int(5) not NULL,date_of_journey date not NULL,current_seat int(5) not NULL,current_coach int(5),seats_available int(5) not NULL,PRIMARY KEY(trainnum,date_of_journey),FOREIGN KEY (trainnum,date_of_journey) References train_details(trainnum,date_of_journey));

create table booking_agent(name varchar(20) not NULL,credit_cardno bigint(16) not NULL,email varchar(50) not NULL,PRIMARY KEY(email));

create table agent_bookings(email varchar(50) not NULL, pnr_booked varchar(20) not NULL, PRIMARY KEY(email, pnr_booked),FOREIGN KEY (email) References booking_agent(email));

create table ticket_details(pnr varchar(20) not NULL,trainnum int(5) not NULL,date_of_journey date not NULL,name varchar(20) not NULL,age int(3) not NULL,gender char(1) not NULL, class varchar(7) not NULL, coach_no int(10) not NULL, seat_no int(10) not NULL, berth varchar(10) not NULL,PRIMARY KEY(trainnum,date_of_journey, class, coach_no, seat_no), FOREIGN KEY (trainnum,date_of_journey) References train_details(trainnum,date_of_journey));

DELIMITER $$
CREATE TRIGGER ac_seat_check BEFORE UPDATE ON ac_seats_availability
FOR EACH ROW 
begin
if new.seats_available<0 then 
SIGNAL SQLSTATE '45000'
SET MESSAGE_TEXT = 'Seats not available';
end if;
end
$$
DELIMITER ;

DELIMITER $$
CREATE TRIGGER sleeper_seat_check BEFORE UPDATE ON sleeper_seats_availability
FOR EACH ROW 
begin
if new.seats_available<0 then 
SIGNAL SQLSTATE '45000'
SET MESSAGE_TEXT='Seats not available';
end if;
end
$$
DELIMITER ;

DELIMITER $$
CREATE TRIGGER train_check BEFORE INSERT ON train_details
FOR EACH ROW
begin
if datediff(new.date_of_journey,curdate())<30 then
SIGNAL SQLSTATE '45000'
SET MESSAGE_TEXT='Date of journey entered lies within 30 days';
end if;
end
$$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE ticket_booking (in name varchar(20),in train_no int,in doj date,in class varchar(7),in gender char(1),in age int(3),inout pnr varchar(20))
BEGIN
Declare berth varchar(10);
Declare coach_no int;
Declare seat_no int;
Declare num_of_seats int;
if class='AC' then
select current_seat,current_coach into seat_no,coach_no from ac_seats_availability where trainnum=train_no and date_of_journey=doj;
set seat_no=seat_no%18+1;
update ac_seats_availability set current_seat=current_seat+1 where trainnum=train_no and date_of_journey=doj; 
if seat_no=18 then
update ac_seats_availability set current_coach=current_coach+1 where trainnum=train_no and date_of_journey=doj;
end if;
if MOD(seat_no,6)=1 or MOD(seat_no,6)=2 then
set berth="LB";
elseif MOD(seat_no,6)=3 or MOD(seat_no,6)=4 then
set berth="UB";
elseif MOD(seat_no,6)=5 then
set berth="SL";
elseif MOD(seat_no,6)=0 then 
set berth="SU";
end if;

elseif class='Sleeper' then
select current_seat,current_coach into seat_no,coach_no from sleeper_seats_availability where trainnum=train_no and date_of_journey=doj;
set seat_no=seat_no%24+1;
update sleeper_seats_availability set current_seat=current_seat+1 where trainnum=train_no and date_of_journey=doj;  
if seat_no=24 then
update sleeper_seats_availability set current_coach=current_coach+1 where trainnum=train_no and date_of_journey=doj;
end if;
if MOD(seat_no,8)=1 or MOD(seat_no,8)=4 then
set berth="LB";
elseif MOD(seat_no,8)=2 or MOD(seat_no,8)=5 then
set berth="MB";
elseif MOD(seat_no,8)=3 or MOD(seat_no,8)=6 then
set berth="UB";
elseif MOD(seat_no,8)=7 then
set berth="SL";
elseif MOD(seat_no,8)=0 then 
set berth="SU";
end if;
end if;
insert into ticket_details values(pnr,train_no,doj,name,age,gender,class,coach_no,seat_no,berth);
END$$
DELIMITER ; 

DELIMITER $$
CREATE Procedure pnr_generation(train_no int,doj date,class varchar(7),inout pnr varchar(20))
BEGIN
Declare pnr_no varchar(20); 
Declare coach_no int; 
Declare seat_no int(2) zerofill; 
Declare class_type int; 
if class='AC' then set class_type=0; 
select current_seat,current_coach into seat_no,coach_no from ac_seats_availability where trainnum=train_no and date_of_journey=doj; 
set seat_no=seat_no%18+1; 
elseif class='Sleeper' then set class_type=1; 
select current_seat,current_coach into seat_no,coach_no from sleeper_seats_availability where trainnum=train_no and date_of_journey=doj; 
set seat_no=seat_no%24+1; 
end if;
set pnr_no=concat(train_no,class_type); 
set pnr_no=concat(pnr_no,coach_no); 
set pnr_no=concat(pnr_no,seat_no); 
set pnr_no=concat(pnr_no,UNIX_TIMESTAMP(doj)); 
set pnr=pnr_no; 
END$$

DELIMITER ;

DELIMITER $$
CREATE Procedure train_entry(train_no int,doj date,accoachnum int,sleepercoachnum int)
BEGIN
Declare ac_seats int;
Declare sleeper_seats int;
Insert into train_details values(train_no,doj,accoachnum,sleepercoachnum);
set ac_seats=accoachnum*18;
set sleeper_seats=sleepercoachnum*24;
Insert into ac_seats_availability values(train_no,doj,0,1,ac_seats);
Insert into sleeper_seats_availability values(train_no,doj,0,1,sleeper_seats);
END$$

DELIMITER ;

DELIMITER $$
CREATE Procedure pnr_retrieve(inout pnr varchar(20))
BEGIN
SELECT pnr;
END$$
DELIMITER ;
