PRAGMA foreign_keys=OFF;
BEGIN TRANSACTION;
CREATE TABLE Item(id Integer PRIMARY KEY AUTOINCREMENT, name varchar(255), quantity Integer, capacity Integer, last_updated DATETIME, first_added DATETIME, removed boolean);
CREATE TABLE Member_Position (id INTEGER PRIMARY KEY AUTOINCREMENT, position varchar(255), privilege INTEGER, description text, first_added DATETIME, last_updated DATETIME, email_address varchar(255));
INSERT INTO Member_Position VALUES(1,'Development Director',0,'Works on grant writing, meeting with people who are interested in large monetary donations, setting up profit shares, going to Aggie Moms Club meetings, Sully donations, and help work towards making sure the 12th Can is financially secure','2019-09-22','2019-09-22','12thcan.development@gmail.com');
INSERT INTO Member_Position VALUES(2,'Public Relations Director',0,'Works on communication and marketing for the 12th Can through various methods such as distributing mass emails, promoting on social media, and designing promotional materials.','2019-09-22','2019-09-22','12thcan.publicrelations@gmail.com');
CREATE TABLE Member (id INTEGER PRIMARY KEY AUTOINCREMENT, first_name varchar(255), last_name varchar(255), position_id INTEGER, phone_num varchar(255), email_address varchar(255), username varchar(255), password varchar(255), current_member BOOLEAN, CONSTRAINT fk_positions FOREIGN KEY (position_id) REFERENCES Member_Position(id));
CREATE TABLE Order_Transaction(member_id INTEGER, item_id INTEGER, item_quantity_change, transaction_date DATETIME, comment TEXT, CONSTRAINT fk_member_id FOREIGN KEY (member_id) REFERENCES Member(id), CONSTRAINT fk_item_id FOREIGN KEY (item_id) REFERENCES Item(id));
DELETE FROM sqlite_sequence;
INSERT INTO sqlite_sequence VALUES('Member_Position',2);
COMMIT;
2
2
