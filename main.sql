drop table skytrain;
drop table driver;
drop table bus2;
drop table bus1;
drop table vehicle;
drop table contains;
drop table route1;
drop table route2;
drop table customer;
drop table stopp;
drop table bus_loop;
drop table skytrain_station;
drop table bike_garage;
drop table junction;


create table route2(
    start_location varchar(20) not null,
    end_location varchar(20) not null,
    num_stops int not null,
    primary key (start_location, end_location)
);
grant select on route2 to public;

create table route1(
    routeID char(20),
    start_location varchar(20) not null,
    end_location varchar(20) not null,
    primary key (routeID),
    foreign key (start_location, end_location) references route2(start_location, end_location) ON DELETE CASCADE
);
grant select on route1 to public;

create table junction(
    junctionName varchar(20),
    location varchar(20) not null,
    isSkytrain char(1) not null,
    primary key(junctionName)
);
grant select on junction to public;

create table bike_garage(
    garageID char(20),
    junctionName varchar(20) not null,
    num_bikes int not null,
    primary key (garageID),
    foreign key (junctionName) references junction
);
grant select on bike_garage to public;

create table stopp (
    stoppID char(20),
    junctionName varchar(20),
    location varchar(20) not null,
    direction varchar(20),
    primary key (stoppID),
    foreign key (junctionName) references junction ON DELETE CASCADE
);
grant select on stopp to public;

create table customer (
    customerID char(20),
    customerName varchar(20) not null,
    stopID char(20),
    primary key (customerID),
    foreign key (stopID) references stopp
);
grant select on customer to public;

create table bus_loop (
    junctionName varchar(20),
    num_bus int not null,
    primary key (junctionName),
    foreign key (junctionName) references junction on delete cascade
);
grant select on bus_loop to public;

create table skytrain_station (
    junctionName varchar(20),
    num_bus int not null,
    primary key (junctionName),
    foreign key (junctionName) references junction on delete cascade
);
grant select on skytrain_station to public;

create table contains (
    stoppID char(20),
    routeID char(20),
    primary key (stoppID, routeID),
    foreign key (stoppID) references stopp,
    foreign key (routeID) references route1
);
grant select on contains to public;


create table vehicle(
    serialNumber char(20),
    junctionName varchar(20),
    routeID char(20),
    status varchar(20) not null,
    current_location varchar(20) not null,
    numPassengers int not null,
    primary key (serialNumber),
    foreign key (junctionName) references junction on delete set null,
    foreign key (routeID) references route1
);
grant select on vehicle to public;

create table bus1(
    serialNumber char(20),
    type char(20) not null,
    primary key (serialNumber),
    foreign key (serialNumber) references vehicle on delete cascade
);
grant select on bus1 to public;

create table bus2(
    serialNumber char(20),
    maxCapacity int not null,
    primary key (serialNumber),
    foreign key (serialNumber) references bus1 on delete cascade
);
grant select on bus2 to public;

create table driver(
    employeeID char(20) not null,
    driverName varchar(20) not null,
    serialNumber char(20),
    primary key (employeeID),
    foreign key (serialNumber) references bus1 on delete set null
);
grant select on driver to public;

create table skytrain(
    serialNumber char(20),
    line char(20) not null,
    primary key (serialNumber),
    foreign key (serialNumber) references vehicle on delete cascade
);
grant select on skytrain to public;

insert into junction values ('Waterfront', 'Vancouver', '1');
insert into junction values ('Joyce', 'Vancouver', '1');
insert into junction values ('MainStreet', 'Vancouver', '1');
insert into junction values ('Commericial', 'Vancouver', '1');
insert into junction values ('KingGeorge', 'Surrey', '1');
insert into junction values ('Metrotown', 'Burnaby', '1');
insert into junction values ('SFU', 'Burnaby', '0');
insert into junction values ('Northvan', 'Vancouver', '0');
insert into junction values ('Marpole', 'Vancouver', '0');
insert into junction values ('UBC', 'Vancouver', '0');
insert into junction values ('Newton', 'Surrey', '0');

insert into bike_garage values ('JoyceBike', 'Joyce', 25);
insert into bike_garage values ('MainStreetBike', 'MainStreet', 30);
insert into bike_garage values ('KingGeorgeBike', 'KingGeorge', 40);
insert into bike_garage values ('WaterfrontBike', 'Waterfront', 20);
insert into bike_garage values ('CommercialBike', 'Commericial', 50);

insert into bus_loop values ('SFU', 4);
insert into bus_loop values ('Northvan', 7);
insert into bus_loop values ('Marpole', 10);
insert into bus_loop values ('UBC', 7);
insert into bus_loop values ('Newton', 10);

insert into skytrain_station values ('MainStreet', 10);
insert into skytrain_station values ('Waterfront', 10);
insert into skytrain_station values ('KingGeorge', 20);
insert into skytrain_station values ('Joyce',15);
insert into skytrain_station values ('Commericial',10);

insert into stopp values ('79', 'Joyce', 'Vancouver', 'West');
insert into stopp values ('90', 'UBC', 'Vancouver', 'East');
insert into stopp values ('345', NULL, 'Burnaby', 'West');
insert into stopp values ('12', NULL, 'Burnaby', 'North');
insert into stopp values ('999', 'SFU', 'Burnaby', 'South');

insert into customer values ('100', 'Danny', '79');
insert into customer values ('156', 'Cartier', '90');
insert into customer values ('129', 'Ronald', NULL);
insert into customer values ('186', 'Bobby', NULL);

insert into route2 values ('Joyce', 'UBC', 5);
insert into route2 values ('UBC', 'Joyce', 5);
insert into route2 values ('Metrotown', 'MarineDrive', 11);
insert into route2 values ('Metrotown', 'Brentwood', 16);
insert into route2 values ('SFU', 'Metrotown', 6);

insert into route1 values ('1', 'Joyce', 'UBC');
insert into route1 values ('2', 'UBC', 'Joyce');
insert into route1 values ('3', 'Metrotown', 'MarineDrive');
insert into route1 values ('4', 'Metrotown', 'Brentwood');
insert into route1 values ('5', 'SFU', 'Metrotown');

insert into contains values ('79', '1');
insert into contains values ('90', '1');
insert into contains values ('345', '1');
insert into contains values ('12', '1');
insert into contains values ('999', '1');
insert into contains values ('345', '2');
insert into contains values ('12', '2');
insert into contains values ('345', '3');
insert into contains values ('12', '4');
insert into contains values ('999', '5');

insert into vehicle values ('v1', 'Joyce', '1', 'Running', 'Vancouver', 30);
insert into vehicle values ('v2', 'Joyce', '2', 'Running', 'Vancouver', 30);
insert into vehicle values ('v3', 'Commericial', NULL, 'Broken', 'Burnaby', 0);
insert into vehicle values ('v4', NULL, '4', 'Running', 'Burnaby', 30);
insert into vehicle values ('v5', 'SFU', '5', 'Running', 'Burnaby', 30);
insert into vehicle values ('v6', NULL, NULL, 'Broken', 'Vancouver', 30);
insert into vehicle values ('v7', 'Metrotown', '2', 'Running', 'Vancouver', 30);

insert into bus1 values ('v1', 'Rapid');
insert into bus1 values ('v2','Rapid');
insert into bus1 values ('v3', 'Regular');
insert into bus1 values ('v4','Regular');
insert into bus1 values ('v5','Regular');

insert into bus2 values ('v1', 50);
insert into bus2 values ('v2', 50);
insert into bus2 values ('v3', 30);
insert into bus2 values ('v4', 30);
insert into bus2 values ('v5', 30);

insert into skytrain values ('v6', 'Canada');
insert into skytrain values ('v7', 'Canada');

insert into driver values ('e4', 'Danny', 'v1' 
);
insert into driver values ('e8', 'Cartier', 'v2');
insert into driver values ('e99', 'Ronald', 'v3');
insert into driver values ('e34', 'Giannis', 'v4');
insert into driver values ('e0', 'Tatum', 'v4');
insert into driver values ('e69', 'Chad', NULL);
