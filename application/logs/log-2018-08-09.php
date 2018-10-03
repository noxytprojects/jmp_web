<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

AGM - 2018-08-09 12:00:46 --> user/submitLogin - sangam -> ::1Attempting to login
ERROR - 2018-08-09 12:00:46 --> Query error: Failed to read auto-increment value from storage engine - Invalid query: INSERT INTO `MessageOut` (`MessageTo`, `MessageFrom`, `MessageText`, `IsRead`, `IsSent`) VALUES ('+255764192010', '15300', 'Hello, Your YCC OTP is 7421', 0, 0)
AGM - 2018-08-09 12:01:48 --> user/submitLogin - sangam -> ::1Attempting to login
ERROR - 2018-08-09 12:01:48 --> Query error: Failed to read auto-increment value from storage engine - Invalid query: INSERT INTO `MessageOut` (`MessageTo`, `MessageFrom`, `MessageText`, `IsRead`, `IsSent`) VALUES ('+255764192010', '15300', 'Hello, Your YCC OTP is 3164', 0, 0)
AGM - 2018-08-09 12:01:52 --> user/submitLogin - sangam -> ::1Attempting to login
ERROR - 2018-08-09 12:01:52 --> Query error: Failed to read auto-increment value from storage engine - Invalid query: INSERT INTO `MessageOut` (`MessageTo`, `MessageFrom`, `MessageText`, `IsRead`, `IsSent`) VALUES ('+255764192010', '15300', 'Hello, Your YCC OTP is 7486', 0, 0)
AGM - 2018-08-09 12:09:18 --> user/submitLogin - sangam -> ::1Attempting to login
ERROR - 2018-08-09 12:09:18 --> Query error: Failed to read auto-increment value from storage engine - Invalid query: INSERT INTO `MessageOut` (`MessageTo`, `MessageFrom`, `MessageText`, `IsRead`, `IsSent`) VALUES ('+255764192010', '15300', 'Hello, Your YCC OTP is 2243', 0, 0)
AGM - 2018-08-09 12:13:44 --> user/submitLogin - sangam -> ::1Attempting to login
AGM - 2018-08-09 12:13:59 --> user/submitOtp - michel.sanga@noxyt.com -> ::1Sumitting OTP
AGM - 2018-08-09 12:13:59 --> user/submitOtp - michel.sanga@noxyt.com -> Logged in successfully with OTP
AGM - 2018-08-09 12:21:42 --> shareholder/submitAddAttendance - michel.sanga@noxyt.com -> ::1registered new attendee. att_id : 1
AGM - 2018-08-09 12:21:56 --> shareholder/submitAddAttendance - michel.sanga@noxyt.com -> ::1registered new attendee. att_id : 2
AGM - 2018-08-09 12:22:28 --> shareholder/submitAddAttendance - michel.sanga@noxyt.com -> ::1registered new attendee. att_id : 4
ERROR - 2018-08-09 12:53:47 --> Query error: Table 'agm.agm_cds_attendanc' doesn't exist - Invalid query: SELECT `catt`.`cds_att_acc_number`
FROM `agm_cds_attendanc` `catt`
INNER JOIN `agm_cds_accounts` `cacc` ON `cacc`.`cds_acc_number` = `catt`.`cds_att_acc_number`
INNER JOIN `agm_attendants` `att` ON `att`.`att_id` = `catt`.`cds_att_att_id`
INNER JOIN `agm_attendants` `rep` ON `rep`.`att_id` = `catt`.`cds_att_rep_id`
WHERE `catt`.`cds_att_year_id` = '1'
AND `catt`.`cds_att_type` = 'SELECT'
AND `att`.`att_attends_as` = 'SHAREHOLDER'
ORDER BY `catt`.`cds_att_timestamp` DESC
AGM - 2018-08-09 13:26:42 --> user/logout - michel.sanga@noxyt.com -> ::1Logout successfully
AGM - 2018-08-09 13:29:05 --> user/submitLogin - sangam -> ::1Attempting to login
