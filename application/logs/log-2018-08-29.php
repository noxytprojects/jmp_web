<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

AGM - 2018-08-29 08:35:05 --> user/submitLogin - sangam -> ::1Attempting to login
AGM - 2018-08-29 08:35:07 --> user/submitMultipleLoginAttempt - sangam -> ::1Exchang user browser
AGM - 2018-08-29 08:35:07 --> user/submitMultipleLoginAttempt - michel.sanga@noxyt.com -> ::1Exchanging browser
ERROR - 2018-08-29 08:41:33 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 08:41:33 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 08:41:33 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 08:42:28 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 08:42:29 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 08:42:29 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 08:43:05 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 08:43:05 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 08:43:05 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 08:43:09 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 08:43:09 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 08:43:09 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 09:03:32 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 09:03:32 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 09:03:32 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 09:04:57 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 09:04:57 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 09:04:57 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 09:07:03 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 09:07:03 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 09:07:03 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 09:07:37 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 09:07:37 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 09:07:37 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 09:10:17 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 09:10:17 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 09:10:18 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 09:11:44 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 09:11:44 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 09:11:44 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 09:11:57 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 09:11:57 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 09:11:57 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 09:12:28 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 09:12:28 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 09:12:28 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 09:13:26 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 09:13:26 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 09:13:26 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 09:17:17 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 09:17:17 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 09:17:17 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 09:17:37 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 09:17:37 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 09:17:38 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 09:17:45 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 09:17:45 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 09:17:45 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 15:16:15 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'td_update_time) = '2018-08-29' AND td_last_action = 'BUY'GROUP By td_contract_na' at line 3 - Invalid query: SELECT `inst`.`instru_contract`, `inst`.`instru_name`, `td_b`.`qtyb`, `td_b`.`bid`, `td_s`.`qtyo`, `td_s`.`offer`, `time`, `high`, `low`, `last`, `lchange`, `volume`, `lchanges`, `lchangeb`, `market_cap`
FROM `agm_instrument` `inst`
LEFT OUTER JOIN (SELECT td_change lchangeb,td_contract_name td_contract_b, td_last_qty qtyb,td_last_dealt_price bid FROM agm_trading_data td INNER JOIN (SELECT td_contract_name td_contract_1, MAX(td_id) td_last_dealt_time_b FROM agm_trading_data WHERE CONVERT(date,td_update_time) = '2018-08-29' AND td_last_action = 'BUY'GROUP By td_contract_name) last_td ON td.td_contract_name = last_td.td_contract_1 AND td.td_id = last_td.td_last_dealt_time_b) td_b ON `td_b`.`td_contract_b` = `inst`.`instru_contract`
LEFT OUTER JOIN (SELECT td_change lchanges, td_contract_name td_contract_s, td_last_qty qtyo,td_last_dealt_price offer FROM agm_trading_data td INNER JOIN (SELECT td_contract_name td_contract_2, MAX(td_id) td_last_dealt_time_s FROM agm_trading_data WHERE CONVERT(date,td_update_time) = '2018-08-29' AND td_last_action = 'SELL'GROUP By td_contract_name) last_td ON td.td_contract_name = last_td.td_contract_2 AND td.td_id = last_td.td_last_dealt_time_s) td_s ON `td_s`.`td_contract_s` = `inst`.`instru_contract`
LEFT OUTER JOIN (SELECT td_market_cap market_cap, td_day_volume volume,td_change lchange, td_update_time time,td_last_traded_qty last,td_high_price high,td_low_price low,td_contract_name td_contract_a FROM agm_trading_data td INNER JOIN (SELECT td_contract_name td_contract_3, MAX(td_id) td_last_dealt_time_a FROM agm_trading_data WHERE CONVERT(date,td_update_time) = '2018-08-29'GROUP By td_contract_name) last_td ON td.td_contract_name = last_td.td_contract_3 AND td.td_id = last_td.td_last_dealt_time_a) td_a ON `td_a`.`td_contract_a` = `inst`.`instru_contract`
ORDER BY `td_b`.`qtyb` DESC, `td_s`.`qtyo` DESC
ERROR - 2018-08-29 15:16:18 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'td_update_time) = '2018-08-29' AND td_last_action = 'BUY'GROUP By td_contract_na' at line 3 - Invalid query: SELECT `inst`.`instru_contract`, `inst`.`instru_name`, `td_b`.`qtyb`, `td_b`.`bid`, `td_s`.`qtyo`, `td_s`.`offer`, `time`, `high`, `low`, `last`, `lchange`, `volume`, `lchanges`, `lchangeb`, `market_cap`
FROM `agm_instrument` `inst`
LEFT OUTER JOIN (SELECT td_change lchangeb,td_contract_name td_contract_b, td_last_qty qtyb,td_last_dealt_price bid FROM agm_trading_data td INNER JOIN (SELECT td_contract_name td_contract_1, MAX(td_id) td_last_dealt_time_b FROM agm_trading_data WHERE CONVERT(date,td_update_time) = '2018-08-29' AND td_last_action = 'BUY'GROUP By td_contract_name) last_td ON td.td_contract_name = last_td.td_contract_1 AND td.td_id = last_td.td_last_dealt_time_b) td_b ON `td_b`.`td_contract_b` = `inst`.`instru_contract`
LEFT OUTER JOIN (SELECT td_change lchanges, td_contract_name td_contract_s, td_last_qty qtyo,td_last_dealt_price offer FROM agm_trading_data td INNER JOIN (SELECT td_contract_name td_contract_2, MAX(td_id) td_last_dealt_time_s FROM agm_trading_data WHERE CONVERT(date,td_update_time) = '2018-08-29' AND td_last_action = 'SELL'GROUP By td_contract_name) last_td ON td.td_contract_name = last_td.td_contract_2 AND td.td_id = last_td.td_last_dealt_time_s) td_s ON `td_s`.`td_contract_s` = `inst`.`instru_contract`
LEFT OUTER JOIN (SELECT td_market_cap market_cap, td_day_volume volume,td_change lchange, td_update_time time,td_last_traded_qty last,td_high_price high,td_low_price low,td_contract_name td_contract_a FROM agm_trading_data td INNER JOIN (SELECT td_contract_name td_contract_3, MAX(td_id) td_last_dealt_time_a FROM agm_trading_data WHERE CONVERT(date,td_update_time) = '2018-08-29'GROUP By td_contract_name) last_td ON td.td_contract_name = last_td.td_contract_3 AND td.td_id = last_td.td_last_dealt_time_a) td_a ON `td_a`.`td_contract_a` = `inst`.`instru_contract`
ORDER BY `td_b`.`qtyb` DESC, `td_s`.`qtyo` DESC
ERROR - 2018-08-29 15:16:21 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'td_update_time) = '2018-08-29' AND td_last_action = 'BUY'GROUP By td_contract_na' at line 3 - Invalid query: SELECT `inst`.`instru_contract`, `inst`.`instru_name`, `td_b`.`qtyb`, `td_b`.`bid`, `td_s`.`qtyo`, `td_s`.`offer`, `time`, `high`, `low`, `last`, `lchange`, `volume`, `lchanges`, `lchangeb`, `market_cap`
FROM `agm_instrument` `inst`
LEFT OUTER JOIN (SELECT td_change lchangeb,td_contract_name td_contract_b, td_last_qty qtyb,td_last_dealt_price bid FROM agm_trading_data td INNER JOIN (SELECT td_contract_name td_contract_1, MAX(td_id) td_last_dealt_time_b FROM agm_trading_data WHERE CONVERT(date,td_update_time) = '2018-08-29' AND td_last_action = 'BUY'GROUP By td_contract_name) last_td ON td.td_contract_name = last_td.td_contract_1 AND td.td_id = last_td.td_last_dealt_time_b) td_b ON `td_b`.`td_contract_b` = `inst`.`instru_contract`
LEFT OUTER JOIN (SELECT td_change lchanges, td_contract_name td_contract_s, td_last_qty qtyo,td_last_dealt_price offer FROM agm_trading_data td INNER JOIN (SELECT td_contract_name td_contract_2, MAX(td_id) td_last_dealt_time_s FROM agm_trading_data WHERE CONVERT(date,td_update_time) = '2018-08-29' AND td_last_action = 'SELL'GROUP By td_contract_name) last_td ON td.td_contract_name = last_td.td_contract_2 AND td.td_id = last_td.td_last_dealt_time_s) td_s ON `td_s`.`td_contract_s` = `inst`.`instru_contract`
LEFT OUTER JOIN (SELECT td_market_cap market_cap, td_day_volume volume,td_change lchange, td_update_time time,td_last_traded_qty last,td_high_price high,td_low_price low,td_contract_name td_contract_a FROM agm_trading_data td INNER JOIN (SELECT td_contract_name td_contract_3, MAX(td_id) td_last_dealt_time_a FROM agm_trading_data WHERE CONVERT(date,td_update_time) = '2018-08-29'GROUP By td_contract_name) last_td ON td.td_contract_name = last_td.td_contract_3 AND td.td_id = last_td.td_last_dealt_time_a) td_a ON `td_a`.`td_contract_a` = `inst`.`instru_contract`
ORDER BY `td_b`.`qtyb` DESC, `td_s`.`qtyo` DESC
ERROR - 2018-08-29 15:16:24 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'td_update_time) = '2018-08-29' AND td_last_action = 'BUY'GROUP By td_contract_na' at line 3 - Invalid query: SELECT `inst`.`instru_contract`, `inst`.`instru_name`, `td_b`.`qtyb`, `td_b`.`bid`, `td_s`.`qtyo`, `td_s`.`offer`, `time`, `high`, `low`, `last`, `lchange`, `volume`, `lchanges`, `lchangeb`, `market_cap`
FROM `agm_instrument` `inst`
LEFT OUTER JOIN (SELECT td_change lchangeb,td_contract_name td_contract_b, td_last_qty qtyb,td_last_dealt_price bid FROM agm_trading_data td INNER JOIN (SELECT td_contract_name td_contract_1, MAX(td_id) td_last_dealt_time_b FROM agm_trading_data WHERE CONVERT(date,td_update_time) = '2018-08-29' AND td_last_action = 'BUY'GROUP By td_contract_name) last_td ON td.td_contract_name = last_td.td_contract_1 AND td.td_id = last_td.td_last_dealt_time_b) td_b ON `td_b`.`td_contract_b` = `inst`.`instru_contract`
LEFT OUTER JOIN (SELECT td_change lchanges, td_contract_name td_contract_s, td_last_qty qtyo,td_last_dealt_price offer FROM agm_trading_data td INNER JOIN (SELECT td_contract_name td_contract_2, MAX(td_id) td_last_dealt_time_s FROM agm_trading_data WHERE CONVERT(date,td_update_time) = '2018-08-29' AND td_last_action = 'SELL'GROUP By td_contract_name) last_td ON td.td_contract_name = last_td.td_contract_2 AND td.td_id = last_td.td_last_dealt_time_s) td_s ON `td_s`.`td_contract_s` = `inst`.`instru_contract`
LEFT OUTER JOIN (SELECT td_market_cap market_cap, td_day_volume volume,td_change lchange, td_update_time time,td_last_traded_qty last,td_high_price high,td_low_price low,td_contract_name td_contract_a FROM agm_trading_data td INNER JOIN (SELECT td_contract_name td_contract_3, MAX(td_id) td_last_dealt_time_a FROM agm_trading_data WHERE CONVERT(date,td_update_time) = '2018-08-29'GROUP By td_contract_name) last_td ON td.td_contract_name = last_td.td_contract_3 AND td.td_id = last_td.td_last_dealt_time_a) td_a ON `td_a`.`td_contract_a` = `inst`.`instru_contract`
ORDER BY `td_b`.`qtyb` DESC, `td_s`.`qtyo` DESC
ERROR - 2018-08-29 15:16:44 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 15:16:44 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 15:16:44 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 15:17:25 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 15:17:25 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 15:17:25 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 15:19:14 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 15:19:14 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 15:19:14 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 15:19:23 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 15:19:23 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 15:19:23 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 15:20:33 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 15:20:33 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 15:20:33 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 15:28:11 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 15:28:11 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 15:28:11 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 15:28:40 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 15:28:40 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 15:28:40 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 15:28:47 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 15:28:48 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 15:28:48 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 15:29:05 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 15:29:06 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 15:29:06 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 15:29:24 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 15:29:24 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 15:29:24 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 15:34:23 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 15:34:59 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 15:34:59 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 15:47:35 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 15:47:47 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 15:47:47 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 15:47:55 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 15:47:56 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 15:47:56 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 15:48:11 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 15:48:11 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 15:48:11 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 15:48:47 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 15:48:48 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 15:48:48 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 15:50:44 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 15:50:46 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 15:50:46 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 15:50:51 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 15:50:51 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 15:50:51 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 15:52:50 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 15:52:51 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 15:52:51 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 15:53:30 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 15:53:31 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 15:53:31 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 15:58:42 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 15:58:42 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 15:58:42 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 15:58:52 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 15:58:52 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 15:58:52 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 15:58:54 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 15:58:55 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-29 15:58:55 --> 404 Page Not Found: Assets/vendor
