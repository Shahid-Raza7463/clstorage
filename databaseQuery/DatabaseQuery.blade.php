{{-- * Database working --}}
1 current working database is vsa = 27-03-24
2 before it vsaold

{{-- * regarding  --}}
{{--  Start Hare --}}
{{--  Start Hare --}}
{{-- * regarding  --}}
{{--  Start Hare --}}
{{--  Start Hare --}}
{{-- * regarding  --}}
{{--  Start Hare --}}
{{--  Start Hare --}}
{{-- * regarding  --}}
{{--  Start Hare --}}
{{--  Start Hare --}}
{{-- * regarding  --}}
{{--  Start Hare --}}
{{--  Start Hare --}}
CREATE TABLE `user_staffcode_history` (
`id` INT(11) NOT NULL AUTO_INCREMENT,
`teammember_id` INT(10) NOT NULL,
`role_id` INT(11) NOT NULL,
`staff_code` VARCHAR(20) NOT NULL,
`staffcodenumber` INT(11) NOT NULL,
`change_type` ENUM('promotion','rejoining_same_post','rejoining_other_post') NOT NULL,
`effective_from` DATE NOT NULL,
`effective_to` DATE DEFAULT NULL,
`created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
`updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
PRIMARY KEY (`id`)
);


<pre>
  | id | teammember_id | role_id | staff_code | change_type          | effective_from | effective_to |
| -- | ------------- | ------- | ---------- | -------------------- | -------------- | ------------ |
| 1  | 780           | 15      | S1014      | rejoining_same_post  | 2024-05-01     | 2024-12-01   |
| 2  | 780           | 14      | M1094      | promotion            | 2024-12-02     | 2025-10-19   |
| 3  | 780           | 13      | P1005      | rejoining_other_post | 2025-10-20     | NULL         |

</pre>
{{-- * regarding max value   --}}
{{--  Start Hare --}}
{{--  Start Hare --}}
type int
SELECT MAX(filesize) AS max_filesize
FROM assignmentfolderfiles;

type varchar
SELECT MAX(CAST(filesize AS DECIMAL(20,2))) AS max_filesize
FROM assignmentfolderfiles;


type varchar
SELECT MAX(filesize + 0) AS max_filesize
FROM assignmentfolderfiles;
{{-- * regarding indexing / index   --}}
{{--  no index on that case --}}
for check index exit aur not

EXPLAIN
SELECT u.id, t.id, l.id
FROM users u
LEFT JOIN timesheetusers t ON u.id = t.createdby
LEFT JOIN applyleaves l ON u.id = l.createdby
WHERE u.id = 783;


output will be like

id | select_type | table | type | possible_keys | key | key_len | ref | rows | Extra
---+-------------+-------+------+---------------+-----+---------+------+--------+----------------
1 | SIMPLE | u | const| PRIMARY | PRIMARY | 4 | const | 1 | Using index
1 | SIMPLE | t | ALL | NULL | NULL | NULL | NULL | 20000 | Using where
1 | SIMPLE | l | ALL | NULL | NULL | NULL | NULL | 5000 | Using where



{{--  with index --}}
for check index exit aur not

EXPLAIN
SELECT u.id, t.id, l.id
FROM users u
LEFT JOIN timesheetusers t ON u.id = t.createdby
LEFT JOIN applyleaves l ON u.id = l.createdby
WHERE u.id = 783;

output will be like

id | select_type | table | type | possible_keys | key | key_len | ref | rows | Extra
---+-------------+-------+------+---------------+-----------+---------+-------+------+--------------
1 | SIMPLE | u | const| PRIMARY | PRIMARY | 4 | const | 1 | Using index
1 | SIMPLE | t | ref | createdby | createdby | 5 | const | 161 | Using index
1 | SIMPLE | l | ref | createdby | createdby | 5 | const | 6 | Using index


{{-- Create index --}}

1st way
go to table and click stucture and
select column jis per index lagana hai and
click index button


2nd ways

-- USERS table
ALTER TABLE users
ADD PRIMARY KEY (id),
ADD UNIQUE INDEX idx_users_email (email);

-- TIMESHEET_USERS table
ALTER TABLE timesheet_users
ADD INDEX idx_timesheet_createdby (created_by),
ADD INDEX idx_timesheet_date (date),
ADD INDEX idx_timesheet_createdby_date (created_by, date);

-- APPLY_LEAVES table
ALTER TABLE apply_leaves
ADD INDEX idx_leaves_teamid (team_id),
ADD INDEX idx_leaves_fromdate (from_date),
ADD INDEX idx_leaves_teamid_fromdate (team_id, from_date);



$query = DB::table('users as u')
->leftJoin('timesheet_users as t', 'u.id', '=', 't.created_by')
->leftJoin('apply_leaves as l', 'u.id', '=', 'l.team_id')
->where('u.id', 5)
->whereBetween('t.date', ['2025-08-01', '2025-08-22'])
->where('l.from_date', '>=', '2025-08-01');

$explain = DB::select('EXPLAIN ' . $query->toSql(), $query->getBindings());

dd($explain);



{{--  Start Hare --}}
{{-- * regarding phpmyadmin /regarding mysql You probably tried to upload a file that is too large. Please refer to documentation for a workaround for this limit.  --}}
{{--  Start Hare --}}
{{-- i am uploading 284mb file after that ye error message aa raha hai mujhe ise fix karna hai phpmyadmin --}}
Locate and edit your php.ini file (check your XAMPP/WAMP/LAMP or server PHP folder).

upload_max_filesize = 512M
post_max_size = 512M
max_execution_time = 300
max_input_time = 300
memory_limit = 512M


Your MySQL version does not support the collation
Find and replace all:
utf8mb4_0900_ai_ci
with
utf8mb4_general_ci



Fatal error: Maximum execution time of 300 seconds exceeded in C:\xampp\phpMyAdmin\libraries\classes\Dbal\DbiMysqli.php
on line 209
C:\xampp\php\php.ini

max_execution_time = 1800 ; (30 minutes)
max_input_time = 1800
memory_limit = 1024M

Option 1: Import via Command Line (Best for Big Files)
Open Command Prompt (CMD).
Use this command:

Option 2: Import Remaining Tables Using Command Line with --skip-create-options or Edit Manually
This is useful if:


✅ Option 3: Use a SQL Splitter Tool (For Very Large Files)
Use an online tool like:

🔗 https://sqlsplitter.net/
https://sqlsplitter.com/
https://sqldump.splitter.online/

It splits the large .sql file into multiple small ones per table. Then:

Delete the already imported ones.

Import the remaining smaller SQL files one-by-one or combine them.

{{-- mysqldump --insert-ignore -u root -p database_name > backup.sql --}}
{{-- 1.mysql -u root vdrlive < "C:\xampp\htdocs\vdrlive.sql"  --}}

✅ OPTION 3: ⚙️ Use INSERT IGNORE and IF NOT EXISTS in SQL
If the file is auto-generated, you can:

And replace:
CREATE TABLE `table_name`
with
CREATE TABLE IF NOT EXISTS `table_name`

{{--  Start Hare --}}
{{-- * regarding database import using Cmd / regarding import / regarding phpmyadmin  --}}
{{--  Start Hare --}}

{{--  Database connect with cmd --}}
open cmd with administrate

cd C:\xampp\mysql\bin
C:\xampp\mysql\bin> mysql -u root -p
Enter password: yahan password likhein ya blank chhod kar Enter dabayein
SHOW DATABASES;

Aapko phpMyAdmin mein jo bhi database hai uski list dikh jayegi!



{{--  Start Hare --}}
1.Database import using command / regarding import database
cd C:\xampp\mysql\bin folder me cmd open kare using adminstrate
{{-- 1.mysql -u root vsalive < "C:\xampp\htdocs\database\vsalive.sql"  --}}

check databse and tables
mysql -u root kgsdemo
SHOW TABLES;

ERROR 1153 (08S01) at line 1233884: Got a packet bigger than 'max_allowed_packet' bytes
C:\xampp\mysql\bin\my.ini

If not found, add it under [mysqld] section: ya serach sort_buffer_size=512K above this line you can see
max_allowed_packet
[mysqld]
max_allowed_packet=512M



2.Database ka backup le using command
{{-- 2.mysqldump -u root myapp > "D:\xampp_backups\myapp_backup.sql" --}}

{{-- * regarding xampp error / regarding xampp / phpmyadmin  --}}
{{--  Start Hare --}}
{{--  when you get error during start mysql in xampp on that case follow these steps --}}
Note: jab aap C:\xampp\mysql folder me backup folder se data ko data folder me paste karte ho to aapka mysql run ho
jayega
NOte : aapka agar database and database ka tables and tables ka data agar loss ho jata hai to bhi aap fully data recover
kar sakte ho
Note : jab bhi C:\xampp\mysql folder me copy paste ya kuchh bhi configure karte ho to xampp ke sabhi service ko stop
karde like apache and mysql ko


Steps 1 :
1.C:\xampp\mysql yaha mysql folder ko copy karke backup ke taur par rakhle
1.C:\xampp\mysql is folder me jaye
2.data folder ka backup rakhle like data foder ko data_old name se rename kar de
3.ab data name se folder create kare
4.mysql folders ko copy kare C:\xampp\mysql\backup folder se uske baad C:\xampp\mysql\data folder me paste karde
5.In the XAMPP Control Panel, ab mysql start kare yaha start ho jayega ok the issue is resolved but sabhi database
delete rahega to ab databse ko backup lene ki baari hai

#AB DATABASE BACKUP LENA HAI
6.performance_schema, phpmyadmin, test folders ko copy kare C:\xampp\mysql\backup folder se uske baad
C:\xampp\mysql\data folder me paste karde

7.expertaff, vsalive, vsademo etc folders ko copy kare C:\xampp\mysql\data_old folder se uske baad
C:\xampp\mysql\data folder me paste karde sirf us database ko paste na kare jis ke karan se error aaya tha ok ab yaha
hamara sabhi database ka database and tables aa jayega but abhi bhi tables me data nahi aaya hoga use fix karne ke liye
next step 8

8.ibdata1, ib_logfile1, ib_logfile0, ib_buffer_pool, aria_log_control, aria_log.00000001 folders ko copy kare
C:\xampp\mysql\data_old folder se uske baad
C:\xampp\mysql\data folder me paste karde yaha aapka sabhi table me bhi data aa jayega ok yaha pahle ibdata1 file ko
copy karke paste kare pahle agar data aa gya to thik hai otherwise ye sabhi folder co copy karke paste kar de data aa
jayega tables me ibdata1, ib_logfile1, ib_logfile0, ib_buffer_pool, aria_log_control, aria_log.00000001


{{-- * regarding database configure / regarding phpmyadmin panel configure /  regarding phpmyadmin configure   --}}
{{--  Start Hare --}}
{{--  show all tables in databse without page number --}}
C:\xampp\phpMyAdmin\libraries\config.default.php
find $cfg['MaxTableList'] and replace 250 to 500
$cfg['MaxTableList'] = 500;


C:\xampp\phpMyAdmin\config.inc.php
add this below line end of the in this file
$cfg['MaxTableList'] = 500;

{{-- * regarding join / regarding left join  --}}
{{--  Start Hare --}}


{{--  Start Hare --}}


{{-- *merge database    --}}
{{--  Start Hare --}}
INSERT INTO attendances
SELECT * FROM attendances1212;

INSERT INTO attendances
SELECT * FROM attendancescopy1;

SELECT * FROM attendances_400
UNION ALL
SELECT * FROM attendances_600;

1350

1351 nahi hona chahiye


{{--  Start Hare --}}
{{-- * regarding database time / regarding sql  --}}
{{--  Start Hare --}}
{{--  Start Hare --}}
SQL Server COALESCE() Function

1.
{{-- SELECT COALESCE(NULL, NULL, NULL, 'W3Schools.com', NULL, 'Example.com');
 output W3Schools.com

2.
SELECT COALESCE(NULL, 1, 2, 'W3Schools.com');
  output 1 --}}
{{--  Start Hare --}}
// SELECT email
// FROM users
// GROUP BY email
// HAVING COUNT(*) > 1;


// SELECT DISTINCT email, teammember_id
// FROM users
// WHERE email IN (
// SELECT email
// FROM users
// GROUP BY email
// HAVING COUNT(*) > 1
// );

SELECT teammember_id, email FROM users GROUP BY email HAVING COUNT(*) > 1;
{{--  Start Hare --}}
C:\xampp\php\php.ini

some mandatery modification in
find text one by one

max_execution_time=-1
hare -1 is unlimited

max_execution_time=240
hare 240 is 2 minutes


below all field will be edit
max_execution_time=360
max_input_time=360

default_socket_timeout=360
memory_limit = 1024M


max_execution_time=-1
max_input_time=-1


{{--  Start Hare --}}
{{-- * regarding work item    --}}
{{--  Start Hare --}}
April excell.......
Work item May
june ka excell ..........
july Daily Work item july from client send folder ,,,,,,,,,,,,
August Work item aug
september Work item aug
{{--  Start Hare --}}
{{-- *regarding beetween  --}}
{{--  Start Hare --}}
SELECT * FROM `timesheetusers` WHERE `date` BETWEEN '2024-07-10' AND '2024-07-20' AND `createdby` = 932
{{--  Start Hare --}}
using search tab using date column
2024-07-10,2024-07-20
{{-- * teammembers table   --}}
{{--  Start Hare --}}

$users = DB::table('teammembers')
->where('', 887)
->first();
dd($users);

$users = (object) [
'id' => 887,
'staffcode' => "P10010",
'staffcodenumber' => "10010",
'mentor_id' => null,
'title_id' => null,
'team_member' => "NA",
'entity' => " ",
'employment_status' => null,
'mobile_no' => "11111111",
'emailid' => "na@vsa.co.in",
'department' => null,
'personalemail' => null,
'profilepic' => null,
'fathername' => null,
'dateofbirth' => "2023-09-06",
'pancardno' => null,
'emergencycontactnumber' => null,
'adharcardnumber' => null,
'aadharupload' => null,
'nameasperbank' => null,
'nameofbank' => null,
'bankaccountnumber' => null,
'ifsccode' => null,
'cancelcheque' => null,
'mothername' => null,
'mothernumber' => null,
'fathernumber' => null,
'panupload' => null,
'address_proof' => null,
'designation' => null,
'addressupload' => null,
'role_id' => 13,
'teamlead' => null,
'qualification' => null,
'appointment_letter' => null,
'nda' => null,
'permanentaddress' => null,
'communicationaddress' => null,
'joining_date' => "2023-09-06",
'rejoining_date' => null,
'leavingdate' => null,
'reasonofleaving' => null,
'dateofresign' => null,
'created_by' => 485,
'location' => null,
'gender' => "Male",
'linkedin' => null,
'about' => null,
'status' => 0,
'verify' => null,
'relievingstatus' => null,
'category' => null,
'cost_hour' => null,
'salary_range' => "0",
'monthly_gross_salary' => 0,
'pf_applicable' => null,
'timesheet_applicable' => null,
'taxtds' => null,
'taxgrosssalary' => null,
'taxpf' => null,
];

DB::table('teammembers')->insert([
'id' => $users->id,
'staffcode' => $users->staffcode,
'staffcodenumber' => $users->staffcodenumber,
'mentor_id' => $users->mentor_id,
'title_id' => $users->title_id,
'team_member' => $users->team_member,
'entity' => $users->entity,
'employment_status' => $users->employment_status,
'mobile_no' => $users->mobile_no,
'emailid' => $users->emailid,
'department' => $users->department,
'personalemail' => $users->personalemail,
'profilepic' => $users->profilepic,
'fathername' => $users->fathername,
'dateofbirth' => $users->dateofbirth,
'pancardno' => $users->pancardno,
'emergencycontactnumber' => $users->emergencycontactnumber,
'adharcardnumber' => $users->adharcardnumber,
'aadharupload' => $users->aadharupload,
'nameasperbank' => $users->nameasperbank,
'nameofbank' => $users->nameofbank,
'bankaccountnumber' => $users->bankaccountnumber,
'ifsccode' => $users->ifsccode,
'cancelcheque' => $users->cancelcheque,
'mothername' => $users->mothername,
'mothernumber' => $users->mothernumber,
'fathernumber' => $users->fathernumber,
'panupload' => $users->panupload,
'address_proof' => $users->address_proof,
'designation' => $users->designation,
'addressupload' => $users->addressupload,
'role_id' => $users->role_id,
'teamlead' => $users->teamlead,
'qualification' => $users->qualification,
'appointment_letter' => $users->appointment_letter,
'nda' => $users->nda,
'permanentaddress' => $users->permanentaddress,
'communicationaddress' => $users->communicationaddress,
'joining_date' => $users->joining_date,
'rejoining_date' => $users->rejoining_date,
'leavingdate' => $users->leavingdate,
'reasonofleaving' => $users->reasonofleaving,
'dateofresign' => $users->dateofresign,
'created_by' => $users->created_by,
'location' => $users->location,
'gender' => $users->gender,
'linkedin' => $users->linkedin,
'about' => $users->about,
'status' => $users->status,
'verify' => $users->verify,
'relievingstatus' => $users->relievingstatus,
'category' => $users->category,
'cost_hour' => $users->cost_hour,
'salary_range' => $users->salary_range,
'monthly_gross_salary' => $users->monthly_gross_salary,
'pf_applicable' => $users->pf_applicable,
'timesheet_applicable' => $users->timesheet_applicable,
'taxtds' => $users->taxtds,
'taxgrosssalary' => $users->taxgrosssalary,
'taxpf' => $users->taxpf,
'created_at' => now(),
'updated_at' => now(),
]);

##############################################



INSERT INTO `teammembers` (
`id`, `staffcode`, `staffcodenumber`, `mentor_id`, `title_id`, `team_member`,
`entity`, `employment_status`, `mobile_no`, `emailid`, `department`, `personalemail`,
`profilepic`, `fathername`, `dateofbirth`, `pancardno`, `emergencycontactnumber`,
`adharcardnumber`, `aadharupload`, `nameasperbank`, `nameofbank`, `bankaccountnumber`,
`ifsccode`, `cancelcheque`, `mothername`, `mothernumber`, `fathernumber`, `panupload`,
`address_proof`, `designation`, `addressupload`, `role_id`, `teamlead`, `qualification`,
`appointment_letter`, `nda`, `permanentaddress`, `communicationaddress`, `joining_date`,
`rejoining_date`, `leavingdate`, `reasonofleaving`, `dateofresign`, `created_by`,
`location`, `gender`, `linkedin`, `about`, `status`, `verify`, `relievingstatus`,
`category`, `cost_hour`, `salary_range`, `monthly_gross_salary`, `pf_applicable`,
`timesheet_applicable`, `taxtds`, `taxgrosssalary`, `taxpf`, `created_at`, `updated_at`
) VALUES (
887, 'P10010', '10010', NULL, NULL, 'NA', NULL, '11111111', 'na@vsa.co.in', NULL,
NULL, NULL, NULL, '2023-09-06', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL,
NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 13, NULL, NULL, NULL, NULL,
NULL, '2023-09-06', NULL, NULL, NULL, NULL, '485', NULL, 'Male', NULL, NULL, 0,
NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, '2023-09-06 12:06:54', '2023-11-23 17:13:02'
);

{{--  Start Hare --}}
{{-- *insert data into table / insert data / client table    --}}
{{--  Start Hare --}}

INSERT INTO `clients` (
`id`, `parent_id`, `client_name`, `name`, `clientdesignation`, `client_code`,
`kind_attention`, `emailid`, `password`, `c_address`, `scopeofwork`, `c_state`,
`mobileno`, `associatedfrom`, `leadpartner`, `panno`, `legalstatus`, `tanno`,
`gstno`, `dateofincorporation`, `otherpartner`, `companygroup`, `engagementpartner`,
`clientdob`, `createdbyadmin_id`, `updatedbyadmin_id`, `status`, `classification`,
`otherclassification`, `capital`, `borrowings`, `networth`, `created_at`, `updated_at`
) VALUES (
134, NULL, 'Leave', NULL, NULL, '10091', NULL, NULL, NULL, NULL, NULL, NULL, NULL,
NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0,
NULL, NULL, NULL, NULL, NULL, '2023-09-20 06:25:19', NULL
);

{{--  Start Hare --}}



{{-- * regarding chatgpt text    --}}
{{--  Start Hare --}}
{{-- give me all LIKE related quey with uses description 
in form of table like  1 column heading will be query and 2 column will be description 
i want to copy above table and paste inside vs code  --}}

{{-- Start hare --}}
mujhe ye sab ek frame do so that mai ek baar me hi copy karke vs code me paste kar saku
{{-- Start hare --}}
mujhe sabhi query chahiye jisme return redirect() aata ho in laravel
{{--  Start Hare --}}
give me content <p>content</p> basically mai yaha aap ko site ke baare me bta raha hu fir iske aacording content dena ok
basically This project is
a related tracking url yaha user koi bhi link ko test kar sakta hai ki is url me kitna redirection url hai aur us
redirection url ko result section me display karta hai aur fir ek url genrate karta hai so that us url se us result koi
koi bhi dekh sakta hai jab vo url share karega kisi ke saath
{{--  Start Hare --}}
{{-- * my sql search using like  --}}
{{--  Start Hare --}}
{{--  Start Hare --}}
<pre>
LIKE:          Used for pattern matching using wildcard characters (% for zero or more characters, _ for a single character).
LIKE %...%:    Similar to LIKE, but with placeholders for text that can be matched anywhere within the column value.
NOT LIKE:       Opposite of LIKE, used to exclude rows that match a certain pattern.
NOT LIKE %...%:   Similar to NOT LIKE, but with placeholders for text that should not be matched anywhere within the column value.
=:                Checks for exact equality.
!=:              Checks for inequality.
REGEXP:          Used for pattern matching using regular expressions.
REGEXP ^...$:    Similar to REGEXP, but matches the entire column value against the provided regular expression pattern.
NOT REGEXP:      Opposite of REGEXP, used to exclude rows that match a certain regular expression pattern.
= '':            Checks if the column value is an empty string.
!= '':           Checks if the column value is not an empty string.
IN (...):        Checks if the column value is within a specified list of values.
NOT IN (...):    Checks if the column value is not within a specified list of values.
BETWEEN:         Checks if the column value is within a specified range.
NOT BETWEEN:     Checks if the column value is not within a specified range.
IS NULL:         Checks if the column value is NULL.
IS NOT NULL:     Checks if the column value is not NULL.
</pre>
{{--  Start Hare --}}
{{-- * regarding regular experation --}}
{{--  Start Hare --}}
<pre>
------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
#                                                Query                                             #                Heading Point                #                                      Explanation                                       #
------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
#  SELECT * FROM table WHERE column REGEXP 'pattern';                                                #              Basic Pattern Matching:             #  Select rows where a specific column matches a pattern.                                     #
#  SELECT * FROM table WHERE column REGEXP BINARY 'pattern';                                         #           Case-Insensitive Matching:            #  Select rows where a column matches a pattern regardless of case.                              #
#  SELECT * FROM table WHERE column REGEXP '.abc';                                                    #             Matching Any Character:              #  Select rows where a column contains any character followed by 'abc'.                           #
#  SELECT * FROM table WHERE column REGEXP '[ab]';                                                    #          Matching Specific Characters:          #  Select rows where a column contains 'a' or 'b'.                                               #
#  SELECT * FROM table WHERE column REGEXP '[0-9]abc';                                                #         Matching Ranges of Characters:         #  Select rows where a column contains any digit followed by 'abc'.                               #
#  SELECT * FROM table WHERE column REGEXP 'a{3}';                                                    #             Matching Repetitions:              #  Select rows where a column contains 'a' repeated 3 times.                                      #
#  SELECT * FROM table WHERE column NOT REGEXP 'abc';                                                 #               Negating Matches:                #  Select rows where a column does not contain 'abc'.                                              #
#  SELECT * FROM table WHERE column REGEXP '^abc';                                                    #      Anchoring Matches to Start/End:       #  Select rows where a column starts with 'abc'.                                                    #
#  SELECT * FROM table WHERE column REGEXP 'abc$';                                                    #      Anchoring Matches to Start/End:       #  Select rows where a column ends with 'abc'.                                                      #
#  SELECT * FROM table WHERE column REGEXP '^a.*z$';                                                  #           Combining Conditions:            #  Select rows where a column starts with 'a' and ends with 'z'.                                   #
------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

</pre>

{{-- * regarding like query --}}
<pre>
    ---------------------------------------------------------------------------------------------------------------------------------------------------------------------
    #    Query                                                        #                     Description                                                                     #
    ---------------------------------------------------------------------------------------------------------------------------------------------------------------------
    #  1. `SELECT * FROM table WHERE column LIKE 'pattern';`           #  Selects all rows from the specified table where the specified column matches the given pattern  #
    #  2. `SELECT * FROM table WHERE column LIKE 'prefix%';`           #  Selects all rows from the specified table where the specified column starts with the given prefix.#
    #  3. `SELECT * FROM table WHERE column LIKE '%suffix';`           #  Selects all rows from the specified table where the specified column ends with the given suffix.  #
    #  4. `SELECT * FROM table WHERE column LIKE '%pattern%';`         #  Selects all rows from the specified table where the specified column contains the given pattern anywhere within the column value.  #
    #  5. `SELECT * FROM table WHERE column LIKE 'pattern' COLLATE utf8_general_ci;` # Performs a case-insensitive match by specifying a case-insensitive collation. Selects all rows where the column matches the pattern without considering case. #
    #  6. `SELECT * FROM table WHERE column LIKE '_x%';`              #  Selects all rows from the specified table where the specified column starts with any character followed by 'x' and then any sequence of characters.  #
    ---------------------------------------------------------------------------------------------------------------------------------------------------------------------
</pre>
{{--  Start Hare --}}
SELECT * FROM `assignmentbudgetings` WHERE `assignmentgenerate_id` LIKE 'JES100152';
SELECT * FROM `assignmentbudgetings` WHERE `created_at` BETWEEN '2024-01-01 16:45:30.000000' AND '2024-03-20
16:45:30.000000' ORDER BY `id` DESC




{{--  Start Hare --}}
{{-- *regarding recording / regarding record --}}
1. For Windows 10/11 (Using Xbox Game Bar):
Shortcut Keys: Windows Key + Alt + R
This will start and stop screen recording using the built-in Xbox Game Bar.
{{-- *regarding trigger --}}
{{--  Start Hare create trigger using sql tab --}}
{{-- 1.create users table 
2.create answer table  --}}
CREATE TRIGGER `hello` AFTER UPDATE ON `users`
FOR EACH ROW INSERT INTO `answers`(`is_correct_answer`)
VALUES(
'1'
)
{{--  Start Hare create trigger using sql tab --}}
CREATE TRIGGER `new` AFTER UPDATE ON `admins`
FOR EACH ROW INSERT INTO `answers`(`is_correct_answer`)
VALUES(
'1'
)
{{--  Start Hare using trigger tab  --}}
{{-- go to Definition row and paste this code  --}}

INSERT INTO `answers`(`is_correct_answer`)
VALUES(
'1'
)
{{--  Start Hare --}}

{{-- * regarding REGEXP --}}
{{--  Start Hare --}}
SELECT * FROM `assignmentbudgetings` WHERE `assignmentgenerate_id` REGEXP 'SRI';
{{--  Start Hare --}}

{{-- * regarding ORDER BY --}}
{{--  Start Hare --}}
SELECT * FROM `assignmentbudgetings` ORDER BY `id` DESC
INSERT INTO `activitylogs` (`id`, `user_id`, `activitytitle`, `description`, `ip_address`, `created_at`, `updated_at`)
VALUES (NULL, NULL, NULL, NULL, NULL, NULL, NULL)
TRUNCATE `activitylogs`

"DROP TABLE `activitylogs`

CREATE TABLE `vsaclient` (
`id` int(11) DEFAULT NULL,
`client_name` varchar(42) DEFAULT NULL,
`c_address` varchar(130) DEFAULT NULL,
`legalstatus` varchar(13) DEFAULT NULL,
`panno` varchar(11) DEFAULT NULL,
`tanno` varchar(10) DEFAULT NULL,
`gstno` varchar(15) DEFAULT NULL,
`status` int(11) DEFAULT NULL,
`classification` int(11) DEFAULT NULL,
`client_code` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci

INSERT INTO `admins`(`name`, `email`, `password`)
VALUES(
'shahid',
'shahid@example.com',
'password123'
);

UPDATE `admins`
SET `password` = 'shshis345'
WHERE `id` = 2;

UPDATE `admins`
SET `password` = 'new_password'
WHERE `id` = 2;


DELETE FROM `users` WHERE 0
{{--  Start Hare --}}

{{--  Start Hare --}}
SELECT * FROM `timesheetusers` WHERE `date` BETWEEN '2023-10-09' AND '2023-10-16';
{{--  Start Hare --}}
SELECT * FROM `timesheetusers` WHERE `date` BETWEEN '2023-10-09' AND '2023-10-16' AND `client_id` = 267 AND
`assignment_id` = 191 AND `partner` = 844;

SELECT * FROM `timesheetusers` WHERE `date` BETWEEN '2024-03-08' AND '2024-03-20' AND `client_id` = 68 AND
`assignment_id` = 220;

SELECT * FROM `timesheetusers` WHERE `date` BETWEEN '2024-02-16' AND '2024-03-20' AND `client_id`= 237 AND
`assignment_id` = 217;


SELECT * FROM `timesheetusers` WHERE `date` BETWEEN '2024-03-02' AND '2024-03-20' AND `client_id` = 78 AND
`assignment_id` = 193 AND `createdby` = 867;


SELECT * FROM `timesheetusers` WHERE `date` BETWEEN '2023-11-09' AND '2024-03-20' AND `client_id` = 237 AND
`assignment_id` = 217;



UPDATE `timesheetusers`
SET `assignmentgenerate_id` = 'RSW100481'
WHERE `date` BETWEEN '2024-02-26 ' AND '2024-03-20'
AND `client_id` = 267
AND `assignment_id` = 191
AND `partner` = 844;
{{--  Start Hare --}}





UPDATE `timesheetusers`
SET `assignmentgenerate_id` = 'RSW100481'
WHERE `date` BETWEEN '2024-03-02' AND '2024-03-20'
AND `client_id` = 78
AND `assignment_id` = 193
AND `createdby` = 814;

UPDATE `timesheetusers`
SET `assignmentgenerate_id` = 'DAL100024'
WHERE `date` BETWEEN '2023-09-16' AND '2024-01-06'
AND `client_id` = 78
AND `assignment_id` = 193;

UPDATE `timesheetusers`
SET `assignmentgenerate_id` = 'CEN100066'
WHERE `date` BETWEEN '2023-09-22' AND '2024-02-07'
AND `client_id` = 149
AND `assignment_id` = 194
AND `createdby` = 841;

UPDATE `timesheetusers`
SET `assignmentgenerate_id` = 'PAT100401'
WHERE `date` BETWEEN '2024-01-08 ' AND '2024-03-20'
AND `client_id` = 152
AND `assignment_id` = 211
AND `partner` = 839;

UPDATE `timesheetusers`
SET `assignmentgenerate_id` = 'THC100473'
WHERE `date` BETWEEN '2024-02-22 ' AND '2024-03-20'
AND `client_id` = 108
AND `assignment_id` = 220
AND `partner` = 836;


UPDATE `timesheetusers`
SET `assignmentgenerate_id` = 'THC100224'
WHERE `date` BETWEEN '2023-11-09' AND '2024-03-20'
AND `client_id` = 108
AND `assignment_id` = 201
AND `partner` = 837;

WHERE `date` BETWEEN '2024-02-26 ' AND '2024-03-20'

SELECT * FROM `timesheetusers` WHERE `date` BETWEEN '2024-02-29' AND '2024-03-20' AND `client_id` = 178 AND
`assignment_id` = 220;



SELECT * FROM `timesheetusers`WHERE `date` BETWEEN '2024-02-22 ' AND '2024-03-20' AND `client_id` = 108 AND
`assignment_id` = 220 AND `partner` = 836;

SELECT * FROM `timesheetusers` WHERE `date` BETWEEN '2023-11-09' AND '2024-03-20' AND `client_id` = 237 AND
`assignment_id` = 217 AND `partner` = 841;

AND `createdby` = 867

SELECT * FROM `timesheetusers` WHERE `date` BETWEEN '2024-02-16' AND '2024-03-20' AND `client_id` = 237 AND
`assignment_id` = 217;



SELECT *
FROM timesheetusers
WHERE createdby = 819
AND date BETWEEN '2023-11-13' AND '2023-11-18';
{{-- * --}}
SELECT
partner,
SUM(hour) as total_hours,
COUNT(DISTINCT timesheetid) as row_count
FROM
timesheetusers
WHERE
createdby = (SELECT teammember_id FROM users WHERE id = 819)
AND date BETWEEN 13-11-2023 AND 18-11-2023
GROUP BY
partner;

{{-- * select table heading like id,name,city etc --}}

//change hare only table name

SELECT COLUMN_NAME
FROM INFORMATION_SCHEMA.COLUMNS
WHERE TABLE_NAME = 'notifications';


{{-- *serach key in phpmyadmin --}}
create table `timesheetuser
INSERT INTO `timesheetusers
{{-- * database error --}}
TRUNCATE TABLE timesheetusers;
DROP TABLE timesheetusers;

1.password
office_1966
{{-- * database error /regarding database error --}}
performanceevaluationforms
{{-- * count in database --}}
SELECT COUNT(*) FROM assignmentbudgetings WHERE status = 0;

{{-- * count in database --}}
SELECT COUNT(*) as count FROM `assignmentbudgetings` WHERE `closedby` = 844;

{{-- ###################################################################### --}}
{{--  --------------------- 29 sep 2023 joining date--------------- --}}
