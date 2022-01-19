drop table junction;
drop table bike_garage;
/*
drop table bus_loop;
drop table sky_train;
drop table customer;
drop table stopp;
drop table contains;
drop table route1;
drop table route2;
drop table vehicle;
drop table bus1;
drop table bus2;
drop table skytrain;
drop table driver;

create table bus_loop
    (
        junctionName char(20) not null,
        num_bus int not null,
        primary key(junctionName),
        foreign key (junctionName) references junction ON DELETE CASCADE
    );
grant select on bus_loop to public;


create table sky_train
    (
        junctionName char(20) not null,
        primary key(junctionName),
        foreign key (junctionName) references junction ON DELETE CASCADE
    );
grant select on sky_train to public;

create table stopp
    (
        junctionName char(20),
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
        start_location char(20) not null,
        end_location char(20) not null,
        num_stops int not null,
        primary key(start_location, end_location),
        foreign key(start_location) references route1,
        foreign key(end_location) references route1
    );
grant select on route2 to public;

          ------------------------ Relationship
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
        junctionName char(20) not null,
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
        type char(20) not null,
        max_capacity int not null,
        primary key(type),
        foreign key(type) references bus1
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
*/

create table bike_garage
    (garageId varchar(20) not null,
    junctionName varchar(20) not null,
    num_bikes int not null,
    primary key(garageId),
    foreign key(junctionName) references junction
    );
grant select on bike_garage to public;


create table junction
    (
        junctionName varchar(20) not null,
        --location varchar(20) not null,
        isSkytrain char(1) not null,
        garageId varchar(20) unique,
        primary key(junctionName),
        foreign key (garageId) references bike_garage
    );
grant select on junction to public;

insert into junction    -- issue is the maximum column size
values( 'Waterfront' , 'Vancouver','1', 'WaterfrontBike');
insert into junction values (
'Joyce' , 'Vancouver','1', 'JoyceBike');
insert into junction values (
'Main Street' , 'Vancouver','1', 'MainStreetBike');
insert into junction values (
'Commercial' , 'Vancouver', '1', 'CommercialBike');
insert into junction values (
'KingGeorge' , 'Surrey','1', 'KingGeorgeBike');
insert into junction values (
'Metrotown' , 'Burnaby','1', NULL);
insert into junction values (
'SFU' , 'Burnaby','0', NULL);
insert into junction values (
'Marine Drive' , 'Vancouver','0', NULL);
insert into junction values (
'Marin' , 'Vancouver','0', 'NULL');

insert into bike_garage
values ( -- doesnt show the junction in the table (too many values?!?!?)
   'JoyceBike','Joyce', 25);
insert into bike_garage values (
    'MainStreetBike','Main Street', 30);
insert into bike_garage values (
    'KingGeorgeBike','KingGeorge', 40);
insert into bike_garage values (
   'WaterfrontBike','Waterfront', 20);
insert into bike_garage values (
    'CommercialBike','Commercial' , 50);

select * from bike_garage;
select * from junction;

/*
insert into bus_loop values ( -- parent key not found, need to figure out junction
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
select * from bus_loop;


insert into sky_train values (
'Main Street'
);
insert into sky_train values (
'Waterfront'
);
insert into sky_train values (
'King George'
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
    '79', 'Danny', '100'
);
insert into customer values (
    '90', 'Cartier', '156'
);
insert into customer values (
    '345', 'Ronald', '126'
);
insert into customer values (
    '12', 'Another Cartier', '186'
);
insert into customer values (
    '999', 'Another Ronald', '200'
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
    'Joyce', 'UBC', 20
);
insert into route2 values (
    'UBC', 'Joyce', 20
);
insert into route2 values (
    'Metrotown', 'Marine Drive', 15
);
insert into route2 values (
    'Metrotown', 'Brentwood', 16
);
insert into route2 values (
    'SFU', 'Metrotown', 18
);

insert into vehicle values (
    'Joyce', 'v1', '1', 'Running', 'Vancouver', 30
);
insert into vehicle values (
    'Joyce', 'v2', '2', 'Running', 'Vancouver', 30
);
insert into vehicle values (
    'Commercial', 'v3', 'NULL', 'Broken', 'Burnaby', 0
);
insert into vehicle values (
    'Metrotown', 'v4', '4', 'Running', 'Burnaby', 30
);
insert into vehicle values (
    'SFU', 'v5', '5', 'Running', 'Burnaby', 30
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
    'Rapid', 50
);
insert into bus2 values (
    'Rapid', 50
);
insert into bus2 values (
    'Regular', 30
);
insert into bus2 values (
    'Regular', 30
);
insert into bus2 values (
    'Regular', 30
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



select * from junction;
select * from bike_garage;
select * from sky_train;
select * from bus_loop;
select * from stopp;
select * from customer;
select * from contains;
select * from route1;
select * from route2;
select * from vehicle;
select * from bus1;
select * from bus2;
select * from skytrain;
select * from driver;

*/
