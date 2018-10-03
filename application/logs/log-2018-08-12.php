<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

AGM - 2018-08-12 07:13:05 --> user/submitLogin - sangam -> ::1Attempting to login
AGM - 2018-08-12 07:13:08 --> user/submitOtp - michel.sanga@noxyt.com -> ::1Sumitting OTP
AGM - 2018-08-12 07:13:08 --> user/submitOtp - michel.sanga@noxyt.com -> Logged in successfully with OTP
AGM - 2018-08-12 07:24:50 --> shareholder/submitAddAttendance - michel.sanga@noxyt.com -> ::1registered new attendee. att_id : 6
ERROR - 2018-08-12 07:46:40 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'td_update_time) = '2018-08-12' AND td_last_action = 'BUY'GROUP By td_contract_na' at line 3 - Invalid query: SELECT `inst`.`instru_contract`, `inst`.`instru_name`, `td_b`.`qtyb`, `td_b`.`bid`, `td_s`.`qtyo`, `td_s`.`offer`, `time`, `high`, `low`, `last`, `lchange`, `volume`, `lchanges`, `lchangeb`, `market_cap`
FROM `agm_instrument` `inst`
LEFT OUTER JOIN (SELECT td_change lchangeb,td_contract_name td_contract_b, td_last_qty qtyb,td_last_dealt_price bid FROM agm_trading_data td INNER JOIN (SELECT td_contract_name td_contract_1, MAX(td_id) td_last_dealt_time_b FROM agm_trading_data WHERE CONVERT(date,td_update_time) = '2018-08-12' AND td_last_action = 'BUY'GROUP By td_contract_name) last_td ON td.td_contract_name = last_td.td_contract_1 AND td.td_id = last_td.td_last_dealt_time_b) td_b ON `td_b`.`td_contract_b` = `inst`.`instru_contract`
LEFT OUTER JOIN (SELECT td_change lchanges, td_contract_name td_contract_s, td_last_qty qtyo,td_last_dealt_price offer FROM agm_trading_data td INNER JOIN (SELECT td_contract_name td_contract_2, MAX(td_id) td_last_dealt_time_s FROM agm_trading_data WHERE CONVERT(date,td_update_time) = '2018-08-12' AND td_last_action = 'SELL'GROUP By td_contract_name) last_td ON td.td_contract_name = last_td.td_contract_2 AND td.td_id = last_td.td_last_dealt_time_s) td_s ON `td_s`.`td_contract_s` = `inst`.`instru_contract`
LEFT OUTER JOIN (SELECT td_market_cap market_cap, td_day_volume volume,td_change lchange, td_update_time time,td_last_traded_qty last,td_high_price high,td_low_price low,td_contract_name td_contract_a FROM agm_trading_data td INNER JOIN (SELECT td_contract_name td_contract_3, MAX(td_id) td_last_dealt_time_a FROM agm_trading_data WHERE CONVERT(date,td_update_time) = '2018-08-12'GROUP By td_contract_name) last_td ON td.td_contract_name = last_td.td_contract_3 AND td.td_id = last_td.td_last_dealt_time_a) td_a ON `td_a`.`td_contract_a` = `inst`.`instru_contract`
ORDER BY `td_b`.`qtyb` DESC, `td_s`.`qtyo` DESC
ERROR - 2018-08-12 07:46:46 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'td_update_time) = '2018-08-12' AND td_last_action = 'BUY'GROUP By td_contract_na' at line 3 - Invalid query: SELECT `inst`.`instru_contract`, `inst`.`instru_name`, `td_b`.`qtyb`, `td_b`.`bid`, `td_s`.`qtyo`, `td_s`.`offer`, `time`, `high`, `low`, `last`, `lchange`, `volume`, `lchanges`, `lchangeb`, `market_cap`
FROM `agm_instrument` `inst`
LEFT OUTER JOIN (SELECT td_change lchangeb,td_contract_name td_contract_b, td_last_qty qtyb,td_last_dealt_price bid FROM agm_trading_data td INNER JOIN (SELECT td_contract_name td_contract_1, MAX(td_id) td_last_dealt_time_b FROM agm_trading_data WHERE CONVERT(date,td_update_time) = '2018-08-12' AND td_last_action = 'BUY'GROUP By td_contract_name) last_td ON td.td_contract_name = last_td.td_contract_1 AND td.td_id = last_td.td_last_dealt_time_b) td_b ON `td_b`.`td_contract_b` = `inst`.`instru_contract`
LEFT OUTER JOIN (SELECT td_change lchanges, td_contract_name td_contract_s, td_last_qty qtyo,td_last_dealt_price offer FROM agm_trading_data td INNER JOIN (SELECT td_contract_name td_contract_2, MAX(td_id) td_last_dealt_time_s FROM agm_trading_data WHERE CONVERT(date,td_update_time) = '2018-08-12' AND td_last_action = 'SELL'GROUP By td_contract_name) last_td ON td.td_contract_name = last_td.td_contract_2 AND td.td_id = last_td.td_last_dealt_time_s) td_s ON `td_s`.`td_contract_s` = `inst`.`instru_contract`
LEFT OUTER JOIN (SELECT td_market_cap market_cap, td_day_volume volume,td_change lchange, td_update_time time,td_last_traded_qty last,td_high_price high,td_low_price low,td_contract_name td_contract_a FROM agm_trading_data td INNER JOIN (SELECT td_contract_name td_contract_3, MAX(td_id) td_last_dealt_time_a FROM agm_trading_data WHERE CONVERT(date,td_update_time) = '2018-08-12'GROUP By td_contract_name) last_td ON td.td_contract_name = last_td.td_contract_3 AND td.td_id = last_td.td_last_dealt_time_a) td_a ON `td_a`.`td_contract_a` = `inst`.`instru_contract`
ORDER BY `td_b`.`qtyb` DESC, `td_s`.`qtyo` DESC
AGM - 2018-08-12 10:19:05 --> user/submitLogin - sangam -> ::1Attempting to login
AGM - 2018-08-12 10:20:21 --> user/validateAd - michel.sanga@noxyt.com ::1Failed to login user to AD
AGM - 2018-08-12 10:20:21 --> user/submitLogin - sangam -> ::1User Login failed
AGM - 2018-08-12 10:22:51 --> user/submitLogin - sangam -> ::1Attempting to login
AGM - 2018-08-12 10:24:06 --> user/validateAd - michel.sanga@noxyt.com ::1Failed to login user to AD
AGM - 2018-08-12 10:24:06 --> user/submitLogin - sangam -> ::1User Login failed
AGM - 2018-08-12 10:29:39 --> user/submitLogin - sangam -> ::1Attempting to login
AGM - 2018-08-12 10:29:52 --> user/submitOtp - michel.sanga@noxyt.com -> ::1Sumitting OTP
AGM - 2018-08-12 10:29:52 --> user/submitOtp - michel.sanga@noxyt.com -> Logged in successfully with OTP
ERROR - 2018-08-12 12:27:42 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-12 12:27:42 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-12 12:27:42 --> 404 Page Not Found: Assets/vendor
AGM - 2018-08-12 12:31:19 --> shareholder/submitImportCdsAccounts - michel.sanga@noxyt.com -> ::1imported  CDS Accounts from excel.
ERROR - 2018-08-12 12:31:19 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-12 12:31:19 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-12 12:31:19 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-12 12:31:22 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-12 12:31:22 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-12 12:31:22 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-12 12:32:14 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-12 12:32:14 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-12 12:32:14 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-12 12:32:54 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-12 12:32:54 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-12 12:32:54 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-12 12:33:11 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-12 12:33:11 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-12 12:33:12 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-12 12:33:21 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-12 12:33:21 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-12 12:33:21 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-12 12:33:29 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-12 12:33:29 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-12 12:33:29 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-12 12:34:01 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-12 12:34:01 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-12 12:34:01 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-12 12:34:36 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-12 12:34:36 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-12 12:34:36 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-12 12:34:49 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-12 12:34:49 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-12 12:34:49 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-12 12:34:53 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-12 12:34:53 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-12 12:34:53 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-12 12:35:59 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-12 12:35:59 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-12 12:35:59 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-12 12:37:27 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-12 12:37:27 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-12 12:37:27 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-12 12:40:05 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-12 12:40:05 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-12 12:40:05 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-12 12:40:07 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-12 12:40:07 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-12 12:40:07 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-12 12:40:14 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-12 12:40:14 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-12 12:40:14 --> 404 Page Not Found: Assets/vendor
