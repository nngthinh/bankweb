CREATE TABLE Branch
( 
bName VARCHAR(20) NOT NULL,
bPhoneNum VARCHAR(15) ,
faxNo VARCHAR(15) ,
email VARCHAR(320), 
addressNo INT,
addressStreet VARCHAR(30),
addressDistrict VARCHAR(30),
addressCity VARCHAR(15),
region VARCHAR(15),
essn VARCHAR(9),
PRIMARY KEY (bName)
);


CREATE TABLE Employee
(
essn VARCHAR(9) NOT NULL,
fName VARCHAR(15) NOT NULL,
lName VARCHAR(15) NOT NULL,
bDate DATE,
phoneNum VARCHAR(15),
email VARCHAR(320),
addressNo INT,
addressStreet VARCHAR(30),
addressDistrict VARCHAR(30),
addressCity VARCHAR(15),
bName VARCHAR(20),
PRIMARY KEY (essn),
CONSTRAINT 	fk_emp_branch_bname FOREIGN KEY (bname)
        REFERENCES Branch(bname) 
		ON DELETE SET NULL	
);
				

CREATE TABLE Customer
(
cssn VARCHAR(9) NOT NULL,
fname VARCHAR(15) NOT NULL,
lName VARCHAR(15) NOT NULL,
homeAddr VARCHAR(30),
officeAddr VARCHAR(30),
phoneNum VARCHAR(15),
email VARCHAR(320),
essn VARCHAR(9),
PRIMARY KEY (cssn),
CONSTRAINT 	fk_cus_essn FOREIGN KEY (essn)
        REFERENCES Employee(essn) 
);

CREATE TABLE CustomerAccount
(
accountID VARCHAR(9) NOT NULL,
cssn VARCHAR(9) NOT NULL,
PRIMARY KEY (accountID),
CONSTRAINT 	fk_cusacc_cus FOREIGN KEY (cssn)
        REFERENCES Customer(cssn) 
		
);

CREATE TABLE SavingAccount
(
accountID VARCHAR(9) NOT NULL,
balance DECIMAL(15,2),
interestRate DECIMAL(5,2),
openDate DATE,
PRIMARY KEY (accountID),
FOREIGN KEY (accountid) REFERENCES customeraccount(accountid)
);

CREATE TABLE CheckingAccount
(
accountID VARCHAR(9) NOT NULL,
balance DECIMAL(15,2),
openDate DATE,
PRIMARY KEY (accountID),
FOREIGN KEY (accountid) REFERENCES customeraccount(accountid)
);

CREATE TABLE Loan
(
accountID VARCHAR(9) NOT NULL,
balance DECIMAL(15,2),
interestRate DECIMAL(5,2),
openDate DATE,
PRIMARY KEY (accountID),
FOREIGN KEY (accountid) REFERENCES customeraccount(accountid)
);


INSERT INTO Branch VALUES ('ThuDuc','0908595818','1900636936','branchThuDuc@bank.com',5,'Ngo Quyen','Thu Duc','Ho Chi Minh','Viet Nam','156589349');
INSERT INTO Branch VALUES ('Quan10','0903581835','1900645864','branchQ10@bank.com',143,'Ly Thuong Kiet','Quan 10','Ho Chi Minh','Viet Nam','103893493');
INSERT INTO Branch VALUES ('TanBinh','0901055103','1900318531','branchTanBinh@bank.com',236,'Truong Chinh','Tan Binh','Ho Chi Minh','Viet Nam','116519349');
INSERT INTO Branch VALUES ('Quan7','0901519591','1900156515','branchQ7@bank.com',154,'Nguyen Van Linh','Quan 7','Ho Chi Minh','Viet Nam','178934923');

INSERT INTO Employee VALUES ('178934923','Nguyen Van','A','1985-01-09','0937597123','nguyenvana@gmail.com',119,'Nguyen Truong To','Quan 1','Ho Chi Minh','Quan7');
INSERT INTO Employee VALUES ('156589349','Nguyen Van','B','1973-04-08','0937857115','nguyenvanb@gmail.com',21,'Hung Vuong','Thu Duc','Ho Chi Minh','ThuDuc');
INSERT INTO Employee VALUES ('183594358','Nguyen Van','C','1982-12-21','0932889723','nguyenvanc@gmail.com',65,'Nguyen Hue','Quan 7','Ho Chi Minh','Quan7');
INSERT INTO Employee VALUES ('103893493','Nguyen Van','D','1985-01-13','0937257123','nguyenvand@gmail.com',112,'Nguyen Trai','Quan 11','Ho Chi Minh','Quan10');
INSERT INTO Employee VALUES ('116519349','Nguyen Van','E','1990-06-15','0937159458','nguyenvane@gmail.com',91,'Phu Tho','Quan 3','Ho Chi Minh','TanBinh');
INSERT INTO Employee VALUES ('176293495','Nguyen Van','F','1993-07-29','0937457145','nguyenvanf@gmail.com',16,'Nguyen Trung Truc','Quan 10','Ho Chi Minh','Quan10');
INSERT INTO Employee VALUES ('187651786','Nguyen Van','G','1991-06-09','0931597123','nguyenvang@gmail.com',12,'Nguyen Binh Khiem','Quan 3','Ho Chi Minh','ThuDuc');
INSERT INTO Employee VALUES ('100776327','Nguyen Van','H','1983-04-11','0931277115','nguyenvanh@gmail.com',91,'Dien Bien Phu','Quan 3','Ho Chi Minh','Quan10');
INSERT INTO Employee VALUES ('177291951','Nguyen Van','I','1992-02-11','0932882393','nguyenvani@gmail.com',55,'Ham Nghi','Quan 10','Ho Chi Minh','Quan7');
INSERT INTO Employee VALUES ('156797211','Nguyen Van','J','1975-08-23','0937252563','nguyenvanj@gmail.com',12,'Hoang Sa','Quan 1','Ho Chi Minh','TanBinh');
INSERT INTO Employee VALUES ('140249290','Nguyen Van','K','1990-07-16','0937154558','nguyenvank@gmail.com',16,'Cao Thang','Quan 3','Ho Chi Minh','TanBinh');
INSERT INTO Employee VALUES ('191075291','Nguyen Van','L','1996-08-25','0937498545','nguyenvanl@gmail.com',198,'Ly Tu Trong','Quan 1','Ho Chi Minh','Quan10');
COMMIT;


INSERT INTO Customer VALUES ('101729631','Nguyen Van','Mot','Thu Duc, Ho Chi Minh City','Quan 10, Ho Chi Minh City','090858616','nguyenvan1@gmail.com','156589349');
INSERT INTO Customer VALUES ('108017753','Nguyen Van','Hai','Tan Binh, Ho Chi Minh City','Quan 7, Ho Chi Minh City','090328615','nguyenvan2@gmail.com','178934923');
INSERT INTO Customer VALUES ('115906026','Nguyen Van','Ba','Binh Thanh, Ho Chi Minh City','Quan 1, Ho Chi Minh City','090323932','nguyenvan3@gmail.com','103893493');
INSERT INTO Customer VALUES ('111112417','Nguyen Van','Bon','Quan 3, Ho Chi Minh City','Quan 10, Ho Chi Minh City','090156415','nguyenvan4@gmail.com','183594358');
INSERT INTO Customer VALUES ('139689115','Nguyen Van','Nam','Quan 11, Ho Chi Minh City','Quan 2, Ho Chi Minh City','090912291','nguyenvan5@gmail.com','103893493');
INSERT INTO Customer VALUES ('152625751','Nguyen Van','Sau','Binh Thanh, Ho Chi Minh City','Quan 1, Ho Chi Minh City','090115565','nguyenvan6@gmail.com','156589349');
INSERT INTO Customer VALUES ('149447544','Nguyen Van','Bay','Quan 10, Ho Chi Minh City','Quan 1, Ho Chi Minh City','090152215','nguyenvan7@gmail.com','116519349');
INSERT INTO Customer VALUES ('102999603','Nguyen Van','Tam','Quan 7, Ho Chi Minh City','Quan 9, Ho Chi Minh City','090455445','nguyenvan8@gmail.com','176293495');
INSERT INTO Customer VALUES ('146121430','Nguyen Van','Chin','Thu Duc, Ho Chi Minh City','Quan 10, Ho Chi Minh City','090858616','nguyenvan9@gmail.com','140249290');
INSERT INTO Customer VALUES ('110965925','Nguyen Van','Muoi','Tan Binh, Ho Chi Minh City','Quan 7, Ho Chi Minh City','090328615','nguyenvan10@gmail.com','191075291');
INSERT INTO Customer VALUES ('129068281','Tran Van','Mot','Binh Thanh, Ho Chi Minh City','Quan 1, Ho Chi Minh City','090323932','tranvan1@gmail.com','187651786');
INSERT INTO Customer VALUES ('148878218','Tran Van','Hai','Quan 3, Ho Chi Minh City','Quan 10, Ho Chi Minh City','090156415','tranvan2@gmail.com','100776327');
INSERT INTO Customer VALUES ('164122698','Tran Van','Ba','Quan 11, Ho Chi Minh City','Quan 2, Ho Chi Minh City','090912291','tranvan3@gmail.com','191075291');
INSERT INTO Customer VALUES ('107109745','Tran Van','Bon','Binh Thanh, Ho Chi Minh City','Quan 1, Ho Chi Minh City','090115565','tranvan4@gmail.com','156797211');
INSERT INTO Customer VALUES ('194640877','Tran Van','Nam','Quan 10, Ho Chi Minh City','Quan 1, Ho Chi Minh City','090152215','tranvan5@gmail.com','140249290');
INSERT INTO Customer VALUES ('199691250','Tran Van','Sau','Quan 7, Ho Chi Minh City','Quan 9, Ho Chi Minh City','090455445','tranvan6@gmail.com','100776327');

INSERT INTO customeraccount VALUES ('158827919','101729631');
INSERT INTO customeraccount VALUES ('790717108','108017753');
INSERT INTO customeraccount VALUES ('896085362','111112417');
INSERT INTO customeraccount VALUES ('711091636','139689115');
INSERT INTO customeraccount VALUES ('110012761','101729631');
INSERT INTO customeraccount VALUES ('653031246','115906026');
INSERT INTO customeraccount VALUES ('114018509','152625751');
INSERT INTO customeraccount VALUES ('312078147','101729631');
INSERT INTO customeraccount VALUES ('122044119','115906026');
INSERT INTO customeraccount VALUES ('211770190','149447544');
INSERT INTO customeraccount VALUES ('612206541','102999603');
INSERT INTO customeraccount VALUES ('243379585','152625751');
INSERT INTO customeraccount VALUES ('739068721','194640877');
INSERT INTO customeraccount VALUES ('513376374','164122698');
INSERT INTO customeraccount VALUES ('514065437','110965925');
INSERT INTO customeraccount VALUES ('234033751','146121430');
INSERT INTO customeraccount VALUES ('156940707','102999603');
INSERT INTO customeraccount VALUES ('260050925','101729631');
INSERT INTO customeraccount VALUES ('878070831','199691250');
INSERT INTO customeraccount VALUES ('839018961','194640877');
INSERT INTO customeraccount VALUES ('729217503','107109745');
INSERT INTO customeraccount VALUES ('763240832','164122698');
INSERT INTO customeraccount VALUES ('815014929','148878218');
INSERT INTO customeraccount VALUES ('325114784','129068281');
INSERT INTO customeraccount VALUES ('209675584','110965925');
INSERT INTO customeraccount VALUES ('719253892','148878218');
INSERT INTO customeraccount VALUES ('893426626','107109745');
INSERT INTO customeraccount VALUES ('702512636','194640877');
INSERT INTO customeraccount VALUES ('210875818','199691250');
INSERT INTO customeraccount VALUES ('113106532','129068281');
INSERT INTO customeraccount VALUES ('536638277','146121430');
INSERT INTO customeraccount VALUES ('791659095','199691250');
INSERT INTO customeraccount VALUES ('120230919','107109745');
INSERT INTO customeraccount VALUES ('533076818','129068281');
INSERT INTO customeraccount VALUES ('210878796','107109745');
INSERT INTO customeraccount VALUES ('755946728','129068281');

INSERT INTO savingaccount VALUES ('790717108',125955455.32,0.25,'2020-09-01');
INSERT INTO savingaccount VALUES ('896085362',290513035.52,0.50,'2020-12-03');
INSERT INTO savingaccount VALUES ('711091636',55575236.23,0.30,'2020-10-21');
INSERT INTO savingaccount VALUES ('653031246',38459857.50,0.25,'2020-06-10');
INSERT INTO savingaccount VALUES ('114018509',68522615.30,0.15,'2020-05-17');
INSERT INTO savingaccount VALUES ('122044119',20556550.21,0.40,'2020-11-19');
INSERT INTO savingaccount VALUES ('211770190',266554125.36,0.21,'2019-06-01');
INSERT INTO savingaccount VALUES ('612206541',259859265.96,0.15,'2020-10-07');
INSERT INTO savingaccount VALUES ('243379585',587556556.21,0.13,'2019-11-11');
INSERT INTO savingaccount VALUES ('739068721',595925252.96,0.13,'2020-09-23');

INSERT INTO checkingaccount VALUES ('513376374',1256549.25,'2017-02-21');
INSERT INTO checkingaccount VALUES ('514065437',5153035.12,'2015-12-08');
INSERT INTO checkingaccount VALUES ('234033751',5575236.93,'2018-02-15');
INSERT INTO checkingaccount VALUES ('156940707',3455497.12,'2017-07-10');
INSERT INTO checkingaccount VALUES ('260050925',6522615.33,'2016-03-11');
INSERT INTO checkingaccount VALUES ('878070831',1556550.21,'2016-11-21');
INSERT INTO checkingaccount VALUES ('839018961',2651415.36,'2018-06-01');
INSERT INTO checkingaccount VALUES ('729217503',7566265.96,'2015-10-02');
INSERT INTO checkingaccount VALUES ('763240832',3599556.11,'2017-11-15');
INSERT INTO checkingaccount VALUES ('815014929',5125252.26,'2020-09-29');
INSERT INTO checkingaccount VALUES ('325114784',2131465.86,'2020-10-20');
INSERT INTO checkingaccount VALUES ('209675584',5598956.21,'2017-2-11');

INSERT INTO loan VALUES ('719253892','2020-02-21',0.05,123333354.21);
INSERT INTO loan VALUES ('893426626','2019-12-12',0.08,232673254.11);
INSERT INTO loan VALUES ('702512636','2019-02-15',0.12,351643588.53);
INSERT INTO loan VALUES ('210875818','2020-06-01',0.21,463691343.61);
INSERT INTO loan VALUES ('113106532','2019-07-09',0.07,156783378.29);
INSERT INTO loan VALUES ('536638277','2020-11-20',0.05,595899699.91);
INSERT INTO loan VALUES ('791659095','2018-07-01',0.11,521681374.34);
INSERT INTO loan VALUES ('120230919','2018-09-11',0.03,125453350.21);
INSERT INTO loan VALUES ('533076818','2018-07-15',0.04,256559992.17);
INSERT INTO loan VALUES ('210878796','2019-05-04',0.09,659554815.63);
INSERT INTO loan VALUES ('755946728','2018-10-15',0.10,215944815.99);
