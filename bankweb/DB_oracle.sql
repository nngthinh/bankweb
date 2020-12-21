CREATE TABLE Branch
( 
bName VARCHAR(20) PRIMARY KEY,
bPhoneNum VARCHAR(15) ,
faxNo VARCHAR(15) ,
email VARCHAR(320),
addressNo INT,
addressStreet VARCHAR(30),
addressDistrict VARCHAR(30),
addressCity VARCHAR(15),
region VARCHAR(15),
essn VARCHAR(9) NOT NULL
);

CREATE TABLE Employee
(
essn VARCHAR(9) PRIMARY KEY,
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
CONSTRAINT 	fk_emp_branch_bname FOREIGN KEY (bname)
        REFERENCES Branch(bname) 
		ON DELETE SET NULL	
);

ALTER TABLE Branch
ADD CONSTRAINT	fk_branch_emp_dno FOREIGN KEY (essn)
				REFERENCES Employee(essn)
				ON DELETE SET NULL DEFERRABLE;

CREATE TABLE Customer
(
cssn VARCHAR(9) PRIMARY KEY,
fname VARCHAR(15) NOT NULL,
lName VARCHAR(15) NOT NULL,
homeAddr VARCHAR(30),
officeAddr VARCHAR(30),
phoneNum VARCHAR(15),
email VARCHAR(320),
servedDate DATE,
essn VARCHAR(9) NOT NULL,
CONSTRAINT 	fk_cus_essn FOREIGN KEY (essn)
        REFERENCES Employee(essn) 
		ON DELETE SET NULL
);

CREATE TABLE CustomerAccount
(
accountID VARCHAR(9) PRIMARY KEY,
cssn VARCHAR(9) NOT NULL,
CONSTRAINT 	fk_cusacc_cus FOREIGN KEY (cssn)
        REFERENCES Customer(cssn) 
		ON DELETE SET NULL
);

CREATE TABLE SavingAccount
(
accountID VARCHAR(9) PRIMARY KEY,
balance DECIMAL(15,2),
interestRate DECIMAL(5,2),
openDate DATE,
FOREIGN KEY (accountid) REFERENCES customeraccount(accountid)
);

CREATE TABLE CheckingAccount
(
accountID VARCHAR(9) PRIMARY KEY,
balance DECIMAL(15,2),
openDate DATE,
FOREIGN KEY (accountid) REFERENCES customeraccount(accountid)
);

CREATE TABLE Loan
(
accountID VARCHAR(9) PRIMARY KEY,
dateTaken DATE,
interestRate DECIMAL(5,2),
balanceDue DECIMAL(15,2),
FOREIGN KEY (accountid) REFERENCES customeraccount(accountid)
);
-------------------------Insert data------------------------------------
SET CONSTRAINTS  fk_branch_emp_dno DEFERRED;
ALTER SESSION SET NLS_DATE_FORMAT = 'DD-MM-YYYY';
INSERT INTO Branch VALUES ('Thu Duc','0908595818','1900636936','branchThuDuc@bank.com',5,'Ngo Quyen','Thu Duc','Ho Chi Minh','Viet Nam','156589349');
INSERT INTO Branch VALUES ('Quan 10','0903581835','1900645864','branchQ10@bank.com',143,'Ly Thuong Kiet','Quan 10','Ho Chi Minh','Viet Nam','103893493');
INSERT INTO Branch VALUES ('Tan Binh','0901055103','1900318531','branchTanBinh@bank.com',236,'Truong Chinh','Tan Binh','Ho Chi Minh','Viet Nam','116519349');
INSERT INTO Branch VALUES ('Quan 7','0901519591','1900156515','branchQ7@bank.com',154,'Nguyen Van Linh','Quan 7','Ho Chi Minh','Viet Nam','178934923');

INSERT INTO Employee VALUES ('178934923','Nguyen Van','Mot','09-01-1985','0937597123','nguyenvan1@gmail.com',119,'Nguyen Truong To','Quan 1','Ho Chi Minh','Quan 7');
INSERT INTO Employee VALUES ('156589349','Nguyen Van','B','08-04-1973','0937857115','nguyenvanb@gmail.com',21,'Hung Vuong','Thu Duc','Ho Chi Minh','Thu Duc');
INSERT INTO Employee VALUES ('183594358','Nguyen Van','C','21-12-1982','0932889723','nguyenvanc@gmail.com',65,'Nguyen Hue','Quan 7','Ho Chi Minh','Quan 7');
INSERT INTO Employee VALUES ('103893493','Nguyen Van','D','13-01-1985','0937257123','nguyenvand@gmail.com',112,'Nguyen Trai','Quan 11','Ho Chi Minh','Quan 10');
INSERT INTO Employee VALUES ('116519349','Nguyen Van','E','15-06-1990','0937159458','nguyenvane@gmail.com',91,'Phu Tho','Quan 3','Ho Chi Minh','Tan Binh');
INSERT INTO Employee VALUES ('176293495','Nguyen Van','F','29-07-1993','0937457145','nguyenvanf@gmail.com',16,'Nguyen Trung Truc','Quan 10','Ho Chi Minh','Quan 10');
INSERT INTO Employee VALUES ('187651786','Nguyen Van','G','09-06-1991','0931597123','nguyenvang@gmail.com',12,'Nguyen Binh Khiem','Quan 3','Ho Chi Minh','Thu Duc');
INSERT INTO Employee VALUES ('100776327','Nguyen Van','H','11-04-1983','0931277115','nguyenvanh@gmail.com',91,'Dien Bien Phu','Quan 3','Ho Chi Minh','Quan 10');
INSERT INTO Employee VALUES ('177291951','Nguyen Van','I','11-02-1992','0932882393','nguyenvani@gmail.com',55,'Ham Nghi','Quan 10','Ho Chi Minh','Quan 7');
INSERT INTO Employee VALUES ('156797211','Nguyen Van','J','23-08-1975','0937252563','nguyenvanj@gmail.com',12,'Hoang Sa','Quan 1','Ho Chi Minh','Tan Binh');
INSERT INTO Employee VALUES ('140249290','Nguyen Van','K','16-07-1990','0937154558','nguyenvank@gmail.com',16,'Cao Thang','Quan 3','Ho Chi Minh','Tan Binh');
INSERT INTO Employee VALUES ('191075291','Nguyen Van','L','25-08-1996','0937498545','nguyenvanl@gmail.com',198,'Ly Tu Trong','Quan 1','Ho Chi Minh','Quan 10');
COMMIT;

ALTER SESSION SET NLS_DATE_FORMAT = 'DD-MM-YYYY';
INSERT INTO Customer VALUES ('101729631','Nguyen Van','A','Thu Duc, Ho Chi Minh City','Quan 10, Ho Chi Minh City','090858616','nguyenvana@gmail.com','11-09-2020','156589349');
INSERT INTO Customer VALUES ('108017753','Nguyen Van','Hai','Tan Binh, Ho Chi Minh City','Quan 7, Ho Chi Minh City','090328615','nguyenvan2@gmail.com','01-09-2020','178934923');
INSERT INTO Customer VALUES ('115906026','Nguyen Van','Ba','Binh Thanh, Ho Chi Minh City','Quan 1, Ho Chi Minh City','090323932','nguyenvan3@gmail.com','10-06-2020','10-06-2020','103893493');
INSERT INTO Customer VALUES ('111112417','Nguyen Van','Bon','Quan 3, Ho Chi Minh City','Quan 10, Ho Chi Minh City','090156415','nguyenvan4@gmail.com','03-12-2020','183594358');
INSERT INTO Customer VALUES ('139689115','Nguyen Van','Nam','Quan 11, Ho Chi Minh City','Quan 2, Ho Chi Minh City','090912291','nguyenvan5@gmail.com','21-10-2020','103893493');
INSERT INTO Customer VALUES ('152625751','Nguyen Van','Sau','Binh Thanh, Ho Chi Minh City','Quan 1, Ho Chi Minh City','090115565','nguyenvan6@gmail.com','17-05-2020','156589349');
INSERT INTO Customer VALUES ('149447544','Nguyen Van','Bay','Quan 10, Ho Chi Minh City','Quan 1, Ho Chi Minh City','090152215','nguyenvan7@gmail.com','01-06-2020','116519349');
INSERT INTO Customer VALUES ('102999603','Nguyen Van','Tam','Quan 7, Ho Chi Minh City','Quan 9, Ho Chi Minh City','090455445','nguyenvan8@gmail.com','07-10-2020','176293495');
INSERT INTO Customer VALUES ('146121430','Nguyen Van','Chin','Thu Duc, Ho Chi Minh City','Quan 10, Ho Chi Minh City','090858616','nguyenvan9@gmail.com','15-02-2020','140249290');
INSERT INTO Customer VALUES ('110965925','Nguyen Van','Muoi','Tan Binh, Ho Chi Minh City','Quan 7, Ho Chi Minh City','090328615','nguyenvan10@gmail.com','09-02-2020','191075291');
INSERT INTO Customer VALUES ('129068281','Tran Van','Mot','Binh Thanh, Ho Chi Minh City','Quan 1, Ho Chi Minh City','090323932','tranvan1@gmail.com','25-10-2020','187651786');
INSERT INTO Customer VALUES ('148878218','Tran Van','Hai','Quan 3, Ho Chi Minh City','Quan 10, Ho Chi Minh City','090156415','tranvan2@gmail.com','15-11-2020','100776327');
INSERT INTO Customer VALUES ('164122698','Tran Van','Ba','Quan 11, Ho Chi Minh City','Quan 2, Ho Chi Minh City','090912291','tranvan3@gmail.com','21-02-2020','191075291');
INSERT INTO Customer VALUES ('107109745','Tran Van','Bon','Binh Thanh, Ho Chi Minh City','Quan 1, Ho Chi Minh City','090115565','tranvan4@gmail.com','02-05-2020','156797211');
INSERT INTO Customer VALUES ('194640877','Tran Van','Nam','Quan 10, Ho Chi Minh City','Quan 1, Ho Chi Minh City','090152215','tranvan5@gmail.com','23-09-2020','140249290');
INSERT INTO Customer VALUES ('199691250','Tran Van','Sau','Quan 7, Ho Chi Minh City','Quan 9, Ho Chi Minh City','090455445','tranvan6@gmail.com','20-11-2020','100776327');

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

INSERT INTO savingaccount VALUES ('790717108',125955455.32,0.25,'01-09-2020');
INSERT INTO savingaccount VALUES ('896085362',290513035.52,0.50,'03-12-2020');
INSERT INTO savingaccount VALUES ('711091636',55575236.23,0.30,'21-10-2020');
INSERT INTO savingaccount VALUES ('653031246',38459857.50,0.25,'10-06-2020');
INSERT INTO savingaccount VALUES ('114018509',68522615.30,0.15,'17-05-2020');
INSERT INTO savingaccount VALUES ('122044119',20556550.21,0.40,'09-11-2020');
INSERT INTO savingaccount VALUES ('211770190',266554125.36,0.21,'01-06-2019');
INSERT INTO savingaccount VALUES ('612206541',259859265.96,0.15,'07-10-2020');
INSERT INTO savingaccount VALUES ('243379585',587556556.21,0.13,'11-11-2019');
INSERT INTO savingaccount VALUES ('739068721',595925252.96,0.13,'23-09-2020');
INSERT INTO savingaccount VALUES ('158827919',5454525252.96,0.13,'11-09-2020');


INSERT INTO checkingaccount VALUES ('513376374',1256549.25,'21-02-2017');
INSERT INTO checkingaccount VALUES ('514065437',5153035.12,'09-12-2015');
INSERT INTO checkingaccount VALUES ('234033751',5575236.93,'15-02-2018');
INSERT INTO checkingaccount VALUES ('156940707',3455497.12,'10-07-2017');
INSERT INTO checkingaccount VALUES ('260050925',6522615.33,'11-03-2016');
INSERT INTO checkingaccount VALUES ('878070831',1556550.21,'20-11-2016');
INSERT INTO checkingaccount VALUES ('839018961',2651415.36,'01-06-2018');
INSERT INTO checkingaccount VALUES ('729217503',7566265.96,'02-10-2015');
INSERT INTO checkingaccount VALUES ('763240832',3599556.11,'15-11-2017');
INSERT INTO checkingaccount VALUES ('815014929',5125252.26,'29-09-2019');
INSERT INTO checkingaccount VALUES ('325114784',2131465.86,'25-10-2020');
INSERT INTO checkingaccount VALUES ('209675584',5598956.21,'12-11-2017');
INSERT INTO checkingaccount VALUES ('110012761',151465.86,'21-10-2018');


INSERT INTO loan VALUES ('719253892','21-02-2020',0.05,123333354.21);
INSERT INTO loan VALUES ('893426626','12-12-2019',0.08,232673254.11);
INSERT INTO loan VALUES ('702512636','15-02-2019',0.12,351643588.53);
INSERT INTO loan VALUES ('210875818','01-06-2020',0.21,463691343.61);
INSERT INTO loan VALUES ('113106532','09-07-2019',0.07,156783378.29);
INSERT INTO loan VALUES ('536638277','20-11-2020',0.05,595899699.91);
INSERT INTO loan VALUES ('791659095','01-07-2018',0.11,521681374.34);
INSERT INTO loan VALUES ('120230919','11-09-2018',0.03,125453350.21);
INSERT INTO loan VALUES ('533076818','15-07-2018',0.04,256559992.17);
INSERT INTO loan VALUES ('210878796','04-05-2019',0.09,659554815.63);
INSERT INTO loan VALUES ('312078147','15-10-2018',0.10,215944815.99);
INSERT INTO loan VALUES ('755946728','05-03-2018',0.10,251884855.22);


-----Cau 1
create or replace trigger decrease_rate
after insert or update of opendate
on savingaccount 
for each row 
declare
    pragma autonomous_transaction;
begin 
    if   (extract (day from :new.opendate) >= 1  and 
          extract (month from :new.opendate) >= 9 and
          extract (year from :new.opendate) >= 2020) then 
            update savingaccount 
            set interestrate = interestrate - interestrate * 0.1
            where opendate = :new.opendate;
            commit;
    end if;
end;
---cau 2-----
SELECT CHECKINGACCOUNT.ACCOUNTID, CHECKINGACCOUNT.BALANCE, CHECKINGACCOUNT.OPENDATE
FROM CHECKINGACCOUNT JOIN CUSTOMERACCOUNT on checkingaccount.accountid = customeraccount.accountid
where (SELECT CSSN FROM CUSTOMER
    WHERE FNAME = 'Nguyen Van' and LNAME = 'A') = CUSTOMERACCOUNT.CSSN;
    
SELECT sa.ACCOUNTID, sa.BALANCE, sa.INTERESTRATE, sa.OPENDATE
FROM SAVINGACCOUNT sa JOIN CUSTOMERACCOUNT on sa.accountid = customeraccount.accountid
where (SELECT CSSN FROM CUSTOMER
    WHERE FNAME = 'Nguyen Van' and LNAME = 'A') = CUSTOMERACCOUNT.CSSN ;

SELECT l.ACCOUNTID, l.BALANCEDUE, l.INTERESTRATE, l.DATETAKEN
FROM LOAN l JOIN CUSTOMERACCOUNT on l.accountid = customeraccount.accountid
where (SELECT CSSN FROM CUSTOMER
    WHERE FNAME = 'Nguyen Van' and LNAME = 'A') = CUSTOMERACCOUNT.CSSN;
    

----Cau 3-------    
create or replace type t_record as object (
  Account_Type varchar2(50),
  Total_Balance varchar2(30)
);

create or replace type t_table as table of t_record;

create or replace function return_table (cssn_id int)
return t_table 
as  v_ret   t_table;
    total_saving number (15,2) :=0;
    total_checking number (15,2) := 0;
    total_loan number (15,2) := 0;
begin
    
    v_ret  := t_table();
    select sum(sa.balance) into total_saving
    from savingaccount sa join customeraccount on sa.accountid = customeraccount.accountid
    where customeraccount.cssn = cssn_id;
    
    select sum(ca.balance) into total_checking
    from checkingaccount ca join customeraccount on ca.accountid = customeraccount.accountid
    where customeraccount.cssn = cssn_id;
    
    select sum(l.balancedue) into total_loan
    from loan l join customeraccount on l.accountid = customeraccount.accountid
    where customeraccount.cssn = cssn_id;
    

    v_ret.extend; v_ret(v_ret.count) := t_record('Saving Account', total_saving );
    v_ret.extend; v_ret(v_ret.count) := t_record('Checking Account', total_checking );
    v_ret.extend; v_ret(v_ret.count) := t_record('Loan', total_loan);

    return v_ret;

end return_table;

select * from table(return_table(107109745));

drop type     t_table;
drop type     t_record;
drop function return_table;
drop function return_objects;

----------Cau 4------------
create or replace procedure CustomerInfo
(start_date date, end_date date)
as
begin
    dbms_output.put_line('ESSN'||'        '||'TotalCustomerServed');
    
    for row in (SELECT ESSN, COUNT(*) as total
    FROM  CUSTOMER c
    WHERE c.serveddate >= start_date and  c.serveddate <= end_date
    GROUP BY ESSN
    ORDER BY total desc)
    loop
    dbms_output.put_line(row.ESSN||'   '||row.total);
    end loop;
    
end CustomerInfo;

execute CustomerInfo('10-DEC-20','17-DEC-20');
 
