drop table contains;
alter table driver drop column serialNumber;
drop table driver;
alter table skytrain drop column serialNumber;
drop table skytrain;
alter table bus2 drop column serialNumber;
drop table bus2;
alter table bus1 drop column serialNumber;
drop table bus1;
alter table customer drop column stopID;
drop table customer;
alter table stopp drop column junctionName;
drop table stopp;
drop table sky_train;
alter table vehicle drop column junctionName;
alter table vehicle drop column routeId;
drop table vehicle;
alter table bus_loop drop column junctionName;
drop table bus_loop;
alter table bike_garage drop column junctionName;
drop table bike_garage;
drop table junction;
drop table route2;
drop table route1;


create table junction
    (
        junctionName varchar(20) not null,
        location varchar(20) not null,
        isSkytrain char(1) not null,
        primary key(junctionName)
    );
grant select on junction to public;

create table bike_garage
    (garageId varchar(20) not null,
    junctionName varchar(20) not null,
    num_bikes int not null,
    primary key(garageId),
    foreign key(junctionName) references junction
    );
grant select on bike_garage to public;


create table bus_loop
    (
        junctionName varchar(20) not null,
        num_bus int not null,
        primary key(junctionName),
        foreign key (junctionName) references junction ON DELETE CASCADE
    );
grant select on bus_loop to public;


create table sky_train
    (
        junctionName varchar(20) not null,
        primary key(junctionName),
        foreign key (junctionName) references junction ON DELETE CASCADE
    );
grant select on sky_train to public;

create table stopp
    (
        junctionName varchar(20),
        stopId char(20) not null,
        location char(20) not null,
        direction char(20),
        primary key(stopId),
        foreign key(junctionName) references junction ON DELETE CASCADE
    );
grant select on stopp to public;

create table customer
    (
        customerID char(20),
        customerName char(20) not null,
        stopId char(20),
        primary key(customerID),
        foreign key(stopID) references stopp
    );
grant select on customer to public;

create table route1
    (
        routeId char(20) not null,
        start_location char(20) not null,
        end_location char(20) not null,
        primary key(routeId)
    );
grant select on route1 to public;

create table route2
    (
        routeId char(20) not null,
        num_stops int not null,
        primary key(routeId),
        foreign key(routeId) references route1
    );
grant select on route2 to public;

create table contains
    (
        stopId char(20) not null,
        routeId char(20) not null,
        primary key(routeId, stopId),
        foreign key (routeId) references route1,
        foreign key (stopId) references stopp
    );
grant select on contains to public;

create table vehicle
    (
        junctionName varchar(20),
        serialNumber char(20) not null,
        routeId char(20),
        status char(20) not null,
        current_location char(20) not null,
        numPassengers int,
        primary key(serialNumber),
        foreign key (junctionName) references junction ON DELETE SET NULL,
        foreign key(routeID) references route1
    );
grant select on vehicle to public;

create table bus1
    (
        serialNumber char(20) not null,
        type char(20) not null,
        primary key(serialNumber),
        foreign key(serialNumber) references vehicle
    );
grant select on bus1 to public;

create table driver
    (
        employeeID char(20) not null,
        driverName char(20) not null,
        serialNumber char(20),
        primary key(employeeID),
        foreign key(serialNumber) references bus1
    );
grant select on driver to public;

create table bus2
    (
        serialNumber char(20) not null,
        max_capacity int not null,
        primary key(serialNumber),
        foreign key(serialNumber) references bus1
    );
grant select on bus2 to public;

create table skytrain
    (
        serialNumber char(20) not null,
        line char(20) not null,
        primary key(serialNumber),
        foreign key(serialNumber) references vehicle
    );
grant select on skytrain to public;

insert into junction
values( 'Waterfront' , 'Vancouver','1');
insert into junction values (
'Joyce' , 'Vancouver','1');
insert into junction values (
'Main Street' , 'Vancouver','1');
insert into junction values (
'Commercial' , 'Vancouver', '1');
insert into junction values (
'KingGeorge' , 'Surrey','1');
insert into junction values (
'Metrotown' , 'Burnaby','1');
insert into junction values (
'SFU' , 'Burnaby','0');
insert into junction values (
'Marine Drive' , 'Vancouver','0');
insert into junction values (
'Marin' , 'Vancouver','0');
insert into junction values (
'UBC' , 'Vancouver','0');


insert into bike_garage
values (
   'JoyceBike','Joyce', 25);
insert into bike_garage values (
    'MainStreetBike','Main Street', 30);
insert into bike_garage values (
    'KingGeorgeBike','KingGeorge', 40);
insert into bike_garage values (
   'WaterfrontBike','Waterfront', 20);
insert into bike_garage values (
    'CommercialBike','Commercial' , 50);

insert into bus_loop values (
'KingGeorge' , 4
);
insert into bus_loop values (
'Commercial', 7
);
insert into bus_loop values (
'Main Street' , 10
);
insert into bus_loop values (
'Joyce' , 7
);
insert into bus_loop values (
'Waterfront' , 10
);


insert into sky_train values (
'Main Street'
);
insert into sky_train values (
'Waterfront'
);
insert into sky_train values (
'KingGeorge'
);
insert into sky_train values (
'Joyce'
);
insert into sky_train values (
'Commercial'
);

insert into stopp values (
    'Joyce', '79', 'Vancouver', 'West'
);
insert into stopp values (
    'UBC', '90', 'Vancouver', 'East'
);
insert into stopp values (
    'Metrotown', '345', 'Burnaby', 'West'
);
insert into stopp values (
    'Metrotown', '12', 'Burnaby', 'North'
);
insert into stopp values (
    'SFU', '999', 'Burnaby', 'South'
);


insert into customer values (
    '100', 'Danny', '79'
);
insert into customer values (
    '156', 'Cartier', '90'
);
insert into customer values (
    '125', 'Ronald', '345'
);
insert into customer values (
    '186', 'Another Cartier', '12'
);
insert into customer values (
    '200', 'Another Ronald', '999'
);

insert into route1 values (
    '1', 'Joyce', 'UBC'
);
insert into route1 values (
    '2', 'UBC', 'Joyce'
);
insert into route1 values (
    '3', 'Metrotown', 'Marine Drive'
);
insert into route1 values (
    '4', 'Metrotown', 'Brentwood'
);
insert into route1 values (
    '5', 'SFU', 'Metrotown'
);

insert into route2 values (
    '1', 20
);
insert into route2 values (
    '2', 20
);
insert into route2 values (
    '3', 15
);
insert into route2 values (
    '4', 16
);
insert into route2 values (
    '5',18
);


insert into contains values (
    '79', '1'
);
insert into contains values (
    '90', '2'
);
insert into contains values (
    '345', '3'
);
insert into contains values (
    '12', '4'
);
insert into contains values (
    '999', '5'
);


insert into vehicle values (
    'Joyce', 'v1', '1', 'Running', 'Vancouver', 30
);
insert into vehicle values (
    'Joyce', 'v2', '2', 'Running', 'Vancouver', 30
);
insert into vehicle values (
    'Commercial', 'v3', NULL, 'Broken', 'Burnaby', 0
);
insert into vehicle values (
    'Metrotown', 'v4', '4', 'Running', 'Burnaby', 30
);
insert into vehicle values (
    'SFU', 'v5', '5', 'Running', 'Burnaby', 30
);
insert into vehicle values (
    NULL, 'v6', '1', 'Running', 'Vancouver', 30
);
insert into vehicle values (
    NULL, 'v7', '2', 'Running', 'Vancouver', 30
);
insert into vehicle values (
    NULL, 'v8', NULL, 'Broken', 'Burnaby', 0
);
insert into vehicle values (
    NULL, 'v9', '4', 'Running', 'Burnaby', 30
);
insert into vehicle values (
    NULL, 'v10', '5', 'Running', 'Burnaby', 30
);


insert into bus1 values (
    'v1', 'Rapid'
);
insert into bus1 values (
    'v2','Rapid'
);
insert into bus1 values (
    'v3', 'Regular'
);
insert into bus1 values (
    'v4','Regular'
);
insert into bus1 values (
    'v5','Regular'
);

insert into bus2 values (
    'v1', 50
);
insert into bus2 values (
    'v2', 50
);
insert into bus2 values (
    'v3', 30
);
insert into bus2 values (
    'v4', 30
);
insert into bus2 values (
    'v5', 30
);


insert into skytrain values (
    'v6', 'Canada'
);
insert into skytrain values (
    'v7', 'Canada'
);
insert into skytrain values (
    'v8', 'Expo'
);
insert into skytrain values (
    'v9', 'Evergreen'
);
insert into skytrain values (
    'v10', 'Millenium'
);

insert into driver values (
    'e4', 'Danny', 'v1' 
);
insert into driver values (
    'e8', 'Cartier', 'v2' 
);
insert into driver values (
    'e99', 'Ronald', 'v3' 
);
insert into driver values (
    'e34', 'Giannis', 'v4' 
);
insert into driver values (
    'e0', 'Tatum', 'v4' 
);

