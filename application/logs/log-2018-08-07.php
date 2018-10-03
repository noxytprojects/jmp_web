<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2018-08-07 06:33:00 --> Query error: Column 'td_contract' in field list is ambiguous - Invalid query: SELECT `inst`.`instru_contract`, `td_b`.`qtyb`, `td_b`.`bid`, `td_s`.`qtyo`, `td_s`.`offer`
FROM `agm_instrument` `inst`
JOIN (SELECT td_contract td_contract_b, td_last_qty qtyb,td_last_dealt_price bid FROM agm_trading_data td INNER JOIN (SELECT td_contract, MAX(td_last_dealt_time) td_last_dealt_time FROM agm_trading_data WHERE DATE(td_last_dealt_time) = '2018-08-04' AND td_last_action = 'B'GROUP By td_contract) last_td ON td.td_contract = last_td.td_contract AND td.td_last_dealt_time = last_td.td_last_dealt_time) td_b ON `td_b`.`td_contract_b` = `agm_ints`.`instru_contract`
JOIN (SELECT td_contract td_contract_s, td_last_qty qtyo,td_last_dealt_price offer FROM agm_trading_data td INNER JOIN (SELECT td_contract, MAX(td_last_dealt_time) td_last_dealt_time FROM agm_trading_data WHERE DATE(td_last_dealt_time) = '2018-08-04' AND td_last_action = 'S'GROUP By td_contract) last_td ON td.td_contract = last_td.td_contract AND td.td_last_dealt_time = last_td.td_last_dealt_time) td_s ON `td_s`.`td_contract_b` = `agm_ints`.`instru_contract`
JOIN (SELECT td_contract td_contract_a FROM agm_trading_data td INNER JOIN (SELECT td_contract, MAX(td_last_dealt_time) td_last_dealt_time FROM agm_trading_data WHERE DATE(td_last_dealt_time) = '2018-08-04'GROUP By td_contract) last_td ON td.td_contract = last_td.td_contract AND td.td_last_dealt_time = last_td.td_last_dealt_time) td_a ON `td_a`.`td_contract_b` = `agm_ints`.`instru_contract`
ERROR - 2018-08-07 06:33:04 --> Query error: Column 'td_contract' in field list is ambiguous - Invalid query: SELECT `inst`.`instru_contract`, `td_b`.`qtyb`, `td_b`.`bid`, `td_s`.`qtyo`, `td_s`.`offer`
FROM `agm_instrument` `inst`
JOIN (SELECT td_contract td_contract_b, td_last_qty qtyb,td_last_dealt_price bid FROM agm_trading_data td INNER JOIN (SELECT td_contract, MAX(td_last_dealt_time) td_last_dealt_time FROM agm_trading_data WHERE DATE(td_last_dealt_time) = '2018-08-04' AND td_last_action = 'B'GROUP By td_contract) last_td ON td.td_contract = last_td.td_contract AND td.td_last_dealt_time = last_td.td_last_dealt_time) td_b ON `td_b`.`td_contract_b` = `agm_ints`.`instru_contract`
JOIN (SELECT td_contract td_contract_s, td_last_qty qtyo,td_last_dealt_price offer FROM agm_trading_data td INNER JOIN (SELECT td_contract, MAX(td_last_dealt_time) td_last_dealt_time FROM agm_trading_data WHERE DATE(td_last_dealt_time) = '2018-08-04' AND td_last_action = 'S'GROUP By td_contract) last_td ON td.td_contract = last_td.td_contract AND td.td_last_dealt_time = last_td.td_last_dealt_time) td_s ON `td_s`.`td_contract_b` = `agm_ints`.`instru_contract`
JOIN (SELECT td_contract td_contract_a FROM agm_trading_data td INNER JOIN (SELECT td_contract, MAX(td_last_dealt_time) td_last_dealt_time FROM agm_trading_data WHERE DATE(td_last_dealt_time) = '2018-08-04'GROUP By td_contract) last_td ON td.td_contract = last_td.td_contract AND td.td_last_dealt_time = last_td.td_last_dealt_time) td_a ON `td_a`.`td_contract_b` = `agm_ints`.`instru_contract`
ERROR - 2018-08-07 06:33:10 --> Query error: Column 'td_contract' in field list is ambiguous - Invalid query: SELECT `inst`.`instru_contract`, `td_b`.`qtyb`, `td_b`.`bid`, `td_s`.`qtyo`, `td_s`.`offer`
FROM `agm_instrument` `inst`
JOIN (SELECT td_contract td_contract_b, td_last_qty qtyb,td_last_dealt_price bid FROM agm_trading_data td INNER JOIN (SELECT td_contract, MAX(td_last_dealt_time) td_last_dealt_time FROM agm_trading_data WHERE DATE(td_last_dealt_time) = '2018-08-04' AND td_last_action = 'B'GROUP By td_contract) last_td ON td.td_contract = last_td.td_contract AND td.td_last_dealt_time = last_td.td_last_dealt_time) td_b ON `td_b`.`td_contract_b` = `agm_ints`.`instru_contract`
JOIN (SELECT td_contract td_contract_s, td_last_qty qtyo,td_last_dealt_price offer FROM agm_trading_data td INNER JOIN (SELECT td_contract, MAX(td_last_dealt_time) td_last_dealt_time FROM agm_trading_data WHERE DATE(td_last_dealt_time) = '2018-08-04' AND td_last_action = 'S'GROUP By td_contract) last_td ON td.td_contract = last_td.td_contract AND td.td_last_dealt_time = last_td.td_last_dealt_time) td_s ON `td_s`.`td_contract_b` = `agm_ints`.`instru_contract`
JOIN (SELECT td_contract td_contract_a FROM agm_trading_data td INNER JOIN (SELECT td_contract, MAX(td_last_dealt_time) td_last_dealt_time FROM agm_trading_data WHERE DATE(td_last_dealt_time) = '2018-08-04'GROUP By td_contract) last_td ON td.td_contract = last_td.td_contract AND td.td_last_dealt_time = last_td.td_last_dealt_time) td_a ON `td_a`.`td_contract_b` = `agm_ints`.`instru_contract`
ERROR - 2018-08-07 06:33:26 --> Query error: Column 'td_contract' in field list is ambiguous - Invalid query: SELECT `inst`.`instru_contract`, `td_b`.`qtyb`, `td_b`.`bid`, `td_s`.`qtyo`, `td_s`.`offer`
FROM `agm_instrument` `inst`
JOIN (SELECT td_contract td_contract_b, td_last_qty qtyb,td_last_dealt_price bid FROM agm_trading_data td INNER JOIN (SELECT td_contract, MAX(td_last_dealt_time) td_last_dealt_time FROM agm_trading_data WHERE DATE(td_last_dealt_time) = '2018-08-04' AND td_last_action = 'B'GROUP By td_contract) last_td ON td.td_contract = last_td.td_contract AND td.td_last_dealt_time = last_td.td_last_dealt_time) td_b ON `td_b`.`td_contract_b` = `agm_ints`.`instru_contract`
JOIN (SELECT td_contract td_contract_s, td_last_qty qtyo,td_last_dealt_price offer FROM agm_trading_data td INNER JOIN (SELECT td_contract, MAX(td_last_dealt_time) td_last_dealt_time FROM agm_trading_data WHERE DATE(td_last_dealt_time) = '2018-08-04' AND td_last_action = 'S'GROUP By td_contract) last_td ON td.td_contract = last_td.td_contract AND td.td_last_dealt_time = last_td.td_last_dealt_time) td_s ON `td_s`.`td_contract_b` = `agm_ints`.`instru_contract`
JOIN (SELECT td_contract td_contract_a FROM agm_trading_data td INNER JOIN (SELECT td_contract, MAX(td_last_dealt_time) td_last_dealt_time FROM agm_trading_data WHERE DATE(td_last_dealt_time) = '2018-08-04'GROUP By td_contract) last_td ON td.td_contract = last_td.td_contract AND td.td_last_dealt_time = last_td.td_last_dealt_time) td_a ON `td_a`.`td_contract_b` = `agm_ints`.`instru_contract`
ERROR - 2018-08-07 06:33:42 --> Query error: Column 'td_contract' in field list is ambiguous - Invalid query: SELECT `inst`.`instru_contract`, `td_b`.`qtyb`, `td_b`.`bid`, `td_s`.`qtyo`, `td_s`.`offer`
FROM `agm_instrument` `inst`
JOIN (SELECT td_contract td_contract_b, td_last_qty qtyb,td_last_dealt_price bid FROM agm_trading_data td INNER JOIN (SELECT td_contract, MAX(td_last_dealt_time) td_last_dealt_time FROM agm_trading_data WHERE DATE(td_last_dealt_time) = '2018-08-04' AND td_last_action = 'B'GROUP By td_contract) last_td ON td.td_contract = last_td.td_contract AND td.td_last_dealt_time = last_td.td_last_dealt_time) td_b ON `td_b`.`td_contract_b` = `agm_ints`.`instru_contract`
JOIN (SELECT td_contract td_contract_s, td_last_qty qtyo,td_last_dealt_price offer FROM agm_trading_data td INNER JOIN (SELECT td_contract, MAX(td_last_dealt_time) td_last_dealt_time FROM agm_trading_data WHERE DATE(td_last_dealt_time) = '2018-08-04' AND td_last_action = 'S'GROUP By td_contract) last_td ON td.td_contract = last_td.td_contract AND td.td_last_dealt_time = last_td.td_last_dealt_time) td_s ON `td_s`.`td_contract_b` = `agm_ints`.`instru_contract`
JOIN (SELECT td_contract td_contract_a FROM agm_trading_data td INNER JOIN (SELECT td_contract, MAX(td_last_dealt_time) td_last_dealt_time FROM agm_trading_data WHERE DATE(td_last_dealt_time) = '2018-08-04'GROUP By td_contract) last_td ON td.td_contract = last_td.td_contract AND td.td_last_dealt_time = last_td.td_last_dealt_time) td_a ON `td_a`.`td_contract_b` = `agm_ints`.`instru_contract`
ERROR - 2018-08-07 06:33:50 --> Query error: Column 'td_contract' in field list is ambiguous - Invalid query: SELECT `inst`.`instru_contract`, `td_b`.`qtyb`, `td_b`.`bid`, `td_s`.`qtyo`, `td_s`.`offer`
FROM `agm_instrument` `inst`
JOIN (SELECT td_contract td_contract_b, td_last_qty qtyb,td_last_dealt_price bid FROM agm_trading_data td INNER JOIN (SELECT td_contract, MAX(td_last_dealt_time) td_last_dealt_time FROM agm_trading_data WHERE DATE(td_last_dealt_time) = '2018-08-04' AND td_last_action = 'B'GROUP By td_contract) last_td ON td.td_contract = last_td.td_contract AND td.td_last_dealt_time = last_td.td_last_dealt_time) td_b ON `td_b`.`td_contract_b` = `agm_ints`.`instru_contract`
JOIN (SELECT td_contract td_contract_s, td_last_qty qtyo,td_last_dealt_price offer FROM agm_trading_data td INNER JOIN (SELECT td_contract, MAX(td_last_dealt_time) td_last_dealt_time FROM agm_trading_data WHERE DATE(td_last_dealt_time) = '2018-08-04' AND td_last_action = 'S'GROUP By td_contract) last_td ON td.td_contract = last_td.td_contract AND td.td_last_dealt_time = last_td.td_last_dealt_time) td_s ON `td_s`.`td_contract_b` = `agm_ints`.`instru_contract`
JOIN (SELECT td_contract td_contract_a FROM agm_trading_data td INNER JOIN (SELECT td_contract, MAX(td_last_dealt_time) td_last_dealt_time FROM agm_trading_data WHERE DATE(td_last_dealt_time) = '2018-08-04'GROUP By td_contract) last_td ON td.td_contract = last_td.td_contract AND td.td_last_dealt_time = last_td.td_last_dealt_time) td_a ON `td_a`.`td_contract_b` = `agm_ints`.`instru_contract`
ERROR - 2018-08-07 06:34:03 --> Query error: Column 'td_contract' in field list is ambiguous - Invalid query: SELECT `inst`.`instru_contract`, `td_b`.`qtyb`, `td_b`.`bid`, `td_s`.`qtyo`, `td_s`.`offer`
FROM `agm_instrument` `inst`
JOIN (SELECT td_contract td_contract_b, td_last_qty qtyb,td_last_dealt_price bid FROM agm_trading_data td INNER JOIN (SELECT td_contract, MAX(td_last_dealt_time) td_last_dealt_time FROM agm_trading_data WHERE DATE(td_last_dealt_time) = '2018-08-04' AND td_last_action = 'B'GROUP By td_contract) last_td ON td.td_contract = last_td.td_contract AND td.td_last_dealt_time = last_td.td_last_dealt_time) td_b ON `td_b`.`td_contract_b` = `agm_ints`.`instru_contract`
JOIN (SELECT td_contract td_contract_s, td_last_qty qtyo,td_last_dealt_price offer FROM agm_trading_data td INNER JOIN (SELECT td_contract, MAX(td_last_dealt_time) td_last_dealt_time FROM agm_trading_data WHERE DATE(td_last_dealt_time) = '2018-08-04' AND td_last_action = 'S'GROUP By td_contract) last_td ON td.td_contract = last_td.td_contract AND td.td_last_dealt_time = last_td.td_last_dealt_time) td_s ON `td_s`.`td_contract_b` = `agm_ints`.`instru_contract`
JOIN (SELECT td_contract td_contract_a FROM agm_trading_data td INNER JOIN (SELECT td_contract, MAX(td_last_dealt_time) td_last_dealt_time FROM agm_trading_data WHERE DATE(td_last_dealt_time) = '2018-08-04'GROUP By td_contract) last_td ON td.td_contract = last_td.td_contract AND td.td_last_dealt_time = last_td.td_last_dealt_time) td_a ON `td_a`.`td_contract_b` = `agm_ints`.`instru_contract`
ERROR - 2018-08-07 06:34:53 --> Query error: Unknown column 'last_td.td_contract' in 'on clause' - Invalid query: SELECT `inst`.`instru_contract`, `td_b`.`qtyb`, `td_b`.`bid`, `td_s`.`qtyo`, `td_s`.`offer`
FROM `agm_instrument` `inst`
JOIN (SELECT td_contract td_contract_b, td_last_qty qtyb,td_last_dealt_price bid FROM agm_trading_data td INNER JOIN (SELECT  MAX(td_last_dealt_time) td_last_dealt_time FROM agm_trading_data WHERE DATE(td_last_dealt_time) = '2018-08-04' AND td_last_action = 'B'GROUP By td_contract) last_td ON td.td_contract = last_td.td_contract AND td.td_last_dealt_time = last_td.td_last_dealt_time) td_b ON `td_b`.`td_contract_b` = `agm_ints`.`instru_contract`
JOIN (SELECT td_contract td_contract_s, td_last_qty qtyo,td_last_dealt_price offer FROM agm_trading_data td INNER JOIN (SELECT  MAX(td_last_dealt_time) td_last_dealt_time FROM agm_trading_data WHERE DATE(td_last_dealt_time) = '2018-08-04' AND td_last_action = 'S'GROUP By td_contract) last_td ON td.td_contract = last_td.td_contract AND td.td_last_dealt_time = last_td.td_last_dealt_time) td_s ON `td_s`.`td_contract_b` = `agm_ints`.`instru_contract`
JOIN (SELECT td_contract td_contract_a FROM agm_trading_data td INNER JOIN (SELECT  MAX(td_last_dealt_time) td_last_dealt_time FROM agm_trading_data WHERE DATE(td_last_dealt_time) = '2018-08-04'GROUP By td_contract) last_td ON td.td_contract = last_td.td_contract AND td.td_last_dealt_time = last_td.td_last_dealt_time) td_a ON `td_a`.`td_contract_b` = `agm_ints`.`instru_contract`
ERROR - 2018-08-07 06:34:56 --> Query error: Unknown column 'last_td.td_contract' in 'on clause' - Invalid query: SELECT `inst`.`instru_contract`, `td_b`.`qtyb`, `td_b`.`bid`, `td_s`.`qtyo`, `td_s`.`offer`
FROM `agm_instrument` `inst`
JOIN (SELECT td_contract td_contract_b, td_last_qty qtyb,td_last_dealt_price bid FROM agm_trading_data td INNER JOIN (SELECT  MAX(td_last_dealt_time) td_last_dealt_time FROM agm_trading_data WHERE DATE(td_last_dealt_time) = '2018-08-04' AND td_last_action = 'B'GROUP By td_contract) last_td ON td.td_contract = last_td.td_contract AND td.td_last_dealt_time = last_td.td_last_dealt_time) td_b ON `td_b`.`td_contract_b` = `agm_ints`.`instru_contract`
JOIN (SELECT td_contract td_contract_s, td_last_qty qtyo,td_last_dealt_price offer FROM agm_trading_data td INNER JOIN (SELECT  MAX(td_last_dealt_time) td_last_dealt_time FROM agm_trading_data WHERE DATE(td_last_dealt_time) = '2018-08-04' AND td_last_action = 'S'GROUP By td_contract) last_td ON td.td_contract = last_td.td_contract AND td.td_last_dealt_time = last_td.td_last_dealt_time) td_s ON `td_s`.`td_contract_b` = `agm_ints`.`instru_contract`
JOIN (SELECT td_contract td_contract_a FROM agm_trading_data td INNER JOIN (SELECT  MAX(td_last_dealt_time) td_last_dealt_time FROM agm_trading_data WHERE DATE(td_last_dealt_time) = '2018-08-04'GROUP By td_contract) last_td ON td.td_contract = last_td.td_contract AND td.td_last_dealt_time = last_td.td_last_dealt_time) td_a ON `td_a`.`td_contract_b` = `agm_ints`.`instru_contract`
ERROR - 2018-08-07 06:35:01 --> Query error: Unknown column 'last_td.td_contract' in 'on clause' - Invalid query: SELECT `inst`.`instru_contract`, `td_b`.`qtyb`, `td_b`.`bid`, `td_s`.`qtyo`, `td_s`.`offer`
FROM `agm_instrument` `inst`
JOIN (SELECT td_contract td_contract_b, td_last_qty qtyb,td_last_dealt_price bid FROM agm_trading_data td INNER JOIN (SELECT  MAX(td_last_dealt_time) td_last_dealt_time FROM agm_trading_data WHERE DATE(td_last_dealt_time) = '2018-08-04' AND td_last_action = 'B'GROUP By td_contract) last_td ON td.td_contract = last_td.td_contract AND td.td_last_dealt_time = last_td.td_last_dealt_time) td_b ON `td_b`.`td_contract_b` = `agm_ints`.`instru_contract`
JOIN (SELECT td_contract td_contract_s, td_last_qty qtyo,td_last_dealt_price offer FROM agm_trading_data td INNER JOIN (SELECT  MAX(td_last_dealt_time) td_last_dealt_time FROM agm_trading_data WHERE DATE(td_last_dealt_time) = '2018-08-04' AND td_last_action = 'S'GROUP By td_contract) last_td ON td.td_contract = last_td.td_contract AND td.td_last_dealt_time = last_td.td_last_dealt_time) td_s ON `td_s`.`td_contract_b` = `agm_ints`.`instru_contract`
JOIN (SELECT td_contract td_contract_a FROM agm_trading_data td INNER JOIN (SELECT  MAX(td_last_dealt_time) td_last_dealt_time FROM agm_trading_data WHERE DATE(td_last_dealt_time) = '2018-08-04'GROUP By td_contract) last_td ON td.td_contract = last_td.td_contract AND td.td_last_dealt_time = last_td.td_last_dealt_time) td_a ON `td_a`.`td_contract_b` = `agm_ints`.`instru_contract`
ERROR - 2018-08-07 06:36:34 --> Query error: Unknown column 'agm_ints.instru_contract' in 'on clause' - Invalid query: SELECT `inst`.`instru_contract`, `td_b`.`qtyb`, `td_b`.`bid`, `td_s`.`qtyo`, `td_s`.`offer`
FROM `agm_instrument` `inst`
JOIN (SELECT td_contract td_contract_b, td_last_qty qtyb,td_last_dealt_price bid FROM agm_trading_data td INNER JOIN (SELECT td_contract td_contract_1, MAX(td_last_dealt_time) td_last_dealt_time FROM agm_trading_data WHERE DATE(td_last_dealt_time) = '2018-08-04' AND td_last_action = 'B'GROUP By td_contract) last_td ON td.td_contract = last_td.td_contract_1 AND td.td_last_dealt_time = last_td.td_last_dealt_time) td_b ON `td_b`.`td_contract_b` = `agm_ints`.`instru_contract`
JOIN (SELECT td_contract td_contract_s, td_last_qty qtyo,td_last_dealt_price offer FROM agm_trading_data td INNER JOIN (SELECT td_contract td_contract_2, MAX(td_last_dealt_time) td_last_dealt_time FROM agm_trading_data WHERE DATE(td_last_dealt_time) = '2018-08-04' AND td_last_action = 'S'GROUP By td_contract) last_td ON td.td_contract = last_td.td_contract_2 AND td.td_last_dealt_time = last_td.td_last_dealt_time) td_s ON `td_s`.`td_contract_b` = `agm_ints`.`instru_contract`
JOIN (SELECT td_contract td_contract_a FROM agm_trading_data td INNER JOIN (SELECT td_contract td_contract_3, MAX(td_last_dealt_time) td_last_dealt_time FROM agm_trading_data WHERE DATE(td_last_dealt_time) = '2018-08-04'GROUP By td_contract) last_td ON td.td_contract = last_td.td_contract_3 AND td.td_last_dealt_time = last_td.td_last_dealt_time) td_a ON `td_a`.`td_contract_b` = `agm_ints`.`instru_contract`
ERROR - 2018-08-07 06:36:38 --> Query error: Unknown column 'agm_ints.instru_contract' in 'on clause' - Invalid query: SELECT `inst`.`instru_contract`, `td_b`.`qtyb`, `td_b`.`bid`, `td_s`.`qtyo`, `td_s`.`offer`
FROM `agm_instrument` `inst`
JOIN (SELECT td_contract td_contract_b, td_last_qty qtyb,td_last_dealt_price bid FROM agm_trading_data td INNER JOIN (SELECT td_contract td_contract_1, MAX(td_last_dealt_time) td_last_dealt_time FROM agm_trading_data WHERE DATE(td_last_dealt_time) = '2018-08-04' AND td_last_action = 'B'GROUP By td_contract) last_td ON td.td_contract = last_td.td_contract_1 AND td.td_last_dealt_time = last_td.td_last_dealt_time) td_b ON `td_b`.`td_contract_b` = `agm_ints`.`instru_contract`
JOIN (SELECT td_contract td_contract_s, td_last_qty qtyo,td_last_dealt_price offer FROM agm_trading_data td INNER JOIN (SELECT td_contract td_contract_2, MAX(td_last_dealt_time) td_last_dealt_time FROM agm_trading_data WHERE DATE(td_last_dealt_time) = '2018-08-04' AND td_last_action = 'S'GROUP By td_contract) last_td ON td.td_contract = last_td.td_contract_2 AND td.td_last_dealt_time = last_td.td_last_dealt_time) td_s ON `td_s`.`td_contract_b` = `agm_ints`.`instru_contract`
JOIN (SELECT td_contract td_contract_a FROM agm_trading_data td INNER JOIN (SELECT td_contract td_contract_3, MAX(td_last_dealt_time) td_last_dealt_time FROM agm_trading_data WHERE DATE(td_last_dealt_time) = '2018-08-04'GROUP By td_contract) last_td ON td.td_contract = last_td.td_contract_3 AND td.td_last_dealt_time = last_td.td_last_dealt_time) td_a ON `td_a`.`td_contract_b` = `agm_ints`.`instru_contract`
ERROR - 2018-08-07 06:36:46 --> Query error: Unknown column 'agm_ints.instru_contract' in 'on clause' - Invalid query: SELECT `inst`.`instru_contract`, `td_b`.`qtyb`, `td_b`.`bid`, `td_s`.`qtyo`, `td_s`.`offer`
FROM `agm_instrument` `inst`
JOIN (SELECT td_contract td_contract_b, td_last_qty qtyb,td_last_dealt_price bid FROM agm_trading_data td INNER JOIN (SELECT td_contract td_contract_1, MAX(td_last_dealt_time) td_last_dealt_time FROM agm_trading_data WHERE DATE(td_last_dealt_time) = '2018-08-04' AND td_last_action = 'B'GROUP By td_contract) last_td ON td.td_contract = last_td.td_contract_1 AND td.td_last_dealt_time = last_td.td_last_dealt_time) td_b ON `td_b`.`td_contract_b` = `agm_ints`.`instru_contract`
JOIN (SELECT td_contract td_contract_s, td_last_qty qtyo,td_last_dealt_price offer FROM agm_trading_data td INNER JOIN (SELECT td_contract td_contract_2, MAX(td_last_dealt_time) td_last_dealt_time FROM agm_trading_data WHERE DATE(td_last_dealt_time) = '2018-08-04' AND td_last_action = 'S'GROUP By td_contract) last_td ON td.td_contract = last_td.td_contract_2 AND td.td_last_dealt_time = last_td.td_last_dealt_time) td_s ON `td_s`.`td_contract_b` = `agm_ints`.`instru_contract`
JOIN (SELECT td_contract td_contract_a FROM agm_trading_data td INNER JOIN (SELECT td_contract td_contract_3, MAX(td_last_dealt_time) td_last_dealt_time FROM agm_trading_data WHERE DATE(td_last_dealt_time) = '2018-08-04'GROUP By td_contract) last_td ON td.td_contract = last_td.td_contract_3 AND td.td_last_dealt_time = last_td.td_last_dealt_time) td_a ON `td_a`.`td_contract_b` = `agm_ints`.`instru_contract`
ERROR - 2018-08-07 06:36:51 --> Query error: Unknown column 'agm_ints.instru_contract' in 'on clause' - Invalid query: SELECT `inst`.`instru_contract`, `td_b`.`qtyb`, `td_b`.`bid`, `td_s`.`qtyo`, `td_s`.`offer`
FROM `agm_instrument` `inst`
JOIN (SELECT td_contract td_contract_b, td_last_qty qtyb,td_last_dealt_price bid FROM agm_trading_data td INNER JOIN (SELECT td_contract td_contract_1, MAX(td_last_dealt_time) td_last_dealt_time FROM agm_trading_data WHERE DATE(td_last_dealt_time) = '2018-08-04' AND td_last_action = 'B'GROUP By td_contract) last_td ON td.td_contract = last_td.td_contract_1 AND td.td_last_dealt_time = last_td.td_last_dealt_time) td_b ON `td_b`.`td_contract_b` = `agm_ints`.`instru_contract`
JOIN (SELECT td_contract td_contract_s, td_last_qty qtyo,td_last_dealt_price offer FROM agm_trading_data td INNER JOIN (SELECT td_contract td_contract_2, MAX(td_last_dealt_time) td_last_dealt_time FROM agm_trading_data WHERE DATE(td_last_dealt_time) = '2018-08-04' AND td_last_action = 'S'GROUP By td_contract) last_td ON td.td_contract = last_td.td_contract_2 AND td.td_last_dealt_time = last_td.td_last_dealt_time) td_s ON `td_s`.`td_contract_b` = `agm_ints`.`instru_contract`
JOIN (SELECT td_contract td_contract_a FROM agm_trading_data td INNER JOIN (SELECT td_contract td_contract_3, MAX(td_last_dealt_time) td_last_dealt_time FROM agm_trading_data WHERE DATE(td_last_dealt_time) = '2018-08-04'GROUP By td_contract) last_td ON td.td_contract = last_td.td_contract_3 AND td.td_last_dealt_time = last_td.td_last_dealt_time) td_a ON `td_a`.`td_contract_b` = `agm_ints`.`instru_contract`
ERROR - 2018-08-07 06:36:54 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 06:36:54 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 06:36:54 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 06:36:55 --> Query error: Unknown column 'agm_ints.instru_contract' in 'on clause' - Invalid query: SELECT `inst`.`instru_contract`, `td_b`.`qtyb`, `td_b`.`bid`, `td_s`.`qtyo`, `td_s`.`offer`
FROM `agm_instrument` `inst`
JOIN (SELECT td_contract td_contract_b, td_last_qty qtyb,td_last_dealt_price bid FROM agm_trading_data td INNER JOIN (SELECT td_contract td_contract_1, MAX(td_last_dealt_time) td_last_dealt_time FROM agm_trading_data WHERE DATE(td_last_dealt_time) = '2018-08-04' AND td_last_action = 'B'GROUP By td_contract) last_td ON td.td_contract = last_td.td_contract_1 AND td.td_last_dealt_time = last_td.td_last_dealt_time) td_b ON `td_b`.`td_contract_b` = `agm_ints`.`instru_contract`
JOIN (SELECT td_contract td_contract_s, td_last_qty qtyo,td_last_dealt_price offer FROM agm_trading_data td INNER JOIN (SELECT td_contract td_contract_2, MAX(td_last_dealt_time) td_last_dealt_time FROM agm_trading_data WHERE DATE(td_last_dealt_time) = '2018-08-04' AND td_last_action = 'S'GROUP By td_contract) last_td ON td.td_contract = last_td.td_contract_2 AND td.td_last_dealt_time = last_td.td_last_dealt_time) td_s ON `td_s`.`td_contract_b` = `agm_ints`.`instru_contract`
JOIN (SELECT td_contract td_contract_a FROM agm_trading_data td INNER JOIN (SELECT td_contract td_contract_3, MAX(td_last_dealt_time) td_last_dealt_time FROM agm_trading_data WHERE DATE(td_last_dealt_time) = '2018-08-04'GROUP By td_contract) last_td ON td.td_contract = last_td.td_contract_3 AND td.td_last_dealt_time = last_td.td_last_dealt_time) td_a ON `td_a`.`td_contract_b` = `agm_ints`.`instru_contract`
ERROR - 2018-08-07 06:37:00 --> Query error: Unknown column 'agm_ints.instru_contract' in 'on clause' - Invalid query: SELECT `inst`.`instru_contract`, `td_b`.`qtyb`, `td_b`.`bid`, `td_s`.`qtyo`, `td_s`.`offer`
FROM `agm_instrument` `inst`
JOIN (SELECT td_contract td_contract_b, td_last_qty qtyb,td_last_dealt_price bid FROM agm_trading_data td INNER JOIN (SELECT td_contract td_contract_1, MAX(td_last_dealt_time) td_last_dealt_time FROM agm_trading_data WHERE DATE(td_last_dealt_time) = '2018-08-04' AND td_last_action = 'B'GROUP By td_contract) last_td ON td.td_contract = last_td.td_contract_1 AND td.td_last_dealt_time = last_td.td_last_dealt_time) td_b ON `td_b`.`td_contract_b` = `agm_ints`.`instru_contract`
JOIN (SELECT td_contract td_contract_s, td_last_qty qtyo,td_last_dealt_price offer FROM agm_trading_data td INNER JOIN (SELECT td_contract td_contract_2, MAX(td_last_dealt_time) td_last_dealt_time FROM agm_trading_data WHERE DATE(td_last_dealt_time) = '2018-08-04' AND td_last_action = 'S'GROUP By td_contract) last_td ON td.td_contract = last_td.td_contract_2 AND td.td_last_dealt_time = last_td.td_last_dealt_time) td_s ON `td_s`.`td_contract_b` = `agm_ints`.`instru_contract`
JOIN (SELECT td_contract td_contract_a FROM agm_trading_data td INNER JOIN (SELECT td_contract td_contract_3, MAX(td_last_dealt_time) td_last_dealt_time FROM agm_trading_data WHERE DATE(td_last_dealt_time) = '2018-08-04'GROUP By td_contract) last_td ON td.td_contract = last_td.td_contract_3 AND td.td_last_dealt_time = last_td.td_last_dealt_time) td_a ON `td_a`.`td_contract_b` = `agm_ints`.`instru_contract`
ERROR - 2018-08-07 06:37:05 --> Query error: Unknown column 'agm_ints.instru_contract' in 'on clause' - Invalid query: SELECT `inst`.`instru_contract`, `td_b`.`qtyb`, `td_b`.`bid`, `td_s`.`qtyo`, `td_s`.`offer`
FROM `agm_instrument` `inst`
JOIN (SELECT td_contract td_contract_b, td_last_qty qtyb,td_last_dealt_price bid FROM agm_trading_data td INNER JOIN (SELECT td_contract td_contract_1, MAX(td_last_dealt_time) td_last_dealt_time FROM agm_trading_data WHERE DATE(td_last_dealt_time) = '2018-08-04' AND td_last_action = 'B'GROUP By td_contract) last_td ON td.td_contract = last_td.td_contract_1 AND td.td_last_dealt_time = last_td.td_last_dealt_time) td_b ON `td_b`.`td_contract_b` = `agm_ints`.`instru_contract`
JOIN (SELECT td_contract td_contract_s, td_last_qty qtyo,td_last_dealt_price offer FROM agm_trading_data td INNER JOIN (SELECT td_contract td_contract_2, MAX(td_last_dealt_time) td_last_dealt_time FROM agm_trading_data WHERE DATE(td_last_dealt_time) = '2018-08-04' AND td_last_action = 'S'GROUP By td_contract) last_td ON td.td_contract = last_td.td_contract_2 AND td.td_last_dealt_time = last_td.td_last_dealt_time) td_s ON `td_s`.`td_contract_b` = `agm_ints`.`instru_contract`
JOIN (SELECT td_contract td_contract_a FROM agm_trading_data td INNER JOIN (SELECT td_contract td_contract_3, MAX(td_last_dealt_time) td_last_dealt_time FROM agm_trading_data WHERE DATE(td_last_dealt_time) = '2018-08-04'GROUP By td_contract) last_td ON td.td_contract = last_td.td_contract_3 AND td.td_last_dealt_time = last_td.td_last_dealt_time) td_a ON `td_a`.`td_contract_b` = `agm_ints`.`instru_contract`
ERROR - 2018-08-07 06:38:09 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 06:38:09 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 06:38:09 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 06:38:09 --> Query error: Unknown column 'td_s.td_contract_b' in 'on clause' - Invalid query: SELECT `inst`.`instru_contract`, `td_b`.`qtyb`, `td_b`.`bid`, `td_s`.`qtyo`, `td_s`.`offer`
FROM `agm_instrument` `inst`
JOIN (SELECT td_contract td_contract_b, td_last_qty qtyb,td_last_dealt_price bid FROM agm_trading_data td INNER JOIN (SELECT td_contract td_contract_1, MAX(td_last_dealt_time) td_last_dealt_time FROM agm_trading_data WHERE DATE(td_last_dealt_time) = '2018-08-04' AND td_last_action = 'B'GROUP By td_contract) last_td ON td.td_contract = last_td.td_contract_1 AND td.td_last_dealt_time = last_td.td_last_dealt_time) td_b ON `td_b`.`td_contract_b` = `inst`.`instru_contract`
JOIN (SELECT td_contract td_contract_s, td_last_qty qtyo,td_last_dealt_price offer FROM agm_trading_data td INNER JOIN (SELECT td_contract td_contract_2, MAX(td_last_dealt_time) td_last_dealt_time FROM agm_trading_data WHERE DATE(td_last_dealt_time) = '2018-08-04' AND td_last_action = 'S'GROUP By td_contract) last_td ON td.td_contract = last_td.td_contract_2 AND td.td_last_dealt_time = last_td.td_last_dealt_time) td_s ON `td_s`.`td_contract_b` = `inst`.`instru_contract`
JOIN (SELECT td_contract td_contract_a FROM agm_trading_data td INNER JOIN (SELECT td_contract td_contract_3, MAX(td_last_dealt_time) td_last_dealt_time FROM agm_trading_data WHERE DATE(td_last_dealt_time) = '2018-08-04'GROUP By td_contract) last_td ON td.td_contract = last_td.td_contract_3 AND td.td_last_dealt_time = last_td.td_last_dealt_time) td_a ON `td_a`.`td_contract_b` = `inst`.`instru_contract`
ERROR - 2018-08-07 06:38:14 --> Query error: Unknown column 'td_s.td_contract_b' in 'on clause' - Invalid query: SELECT `inst`.`instru_contract`, `td_b`.`qtyb`, `td_b`.`bid`, `td_s`.`qtyo`, `td_s`.`offer`
FROM `agm_instrument` `inst`
JOIN (SELECT td_contract td_contract_b, td_last_qty qtyb,td_last_dealt_price bid FROM agm_trading_data td INNER JOIN (SELECT td_contract td_contract_1, MAX(td_last_dealt_time) td_last_dealt_time FROM agm_trading_data WHERE DATE(td_last_dealt_time) = '2018-08-04' AND td_last_action = 'B'GROUP By td_contract) last_td ON td.td_contract = last_td.td_contract_1 AND td.td_last_dealt_time = last_td.td_last_dealt_time) td_b ON `td_b`.`td_contract_b` = `inst`.`instru_contract`
JOIN (SELECT td_contract td_contract_s, td_last_qty qtyo,td_last_dealt_price offer FROM agm_trading_data td INNER JOIN (SELECT td_contract td_contract_2, MAX(td_last_dealt_time) td_last_dealt_time FROM agm_trading_data WHERE DATE(td_last_dealt_time) = '2018-08-04' AND td_last_action = 'S'GROUP By td_contract) last_td ON td.td_contract = last_td.td_contract_2 AND td.td_last_dealt_time = last_td.td_last_dealt_time) td_s ON `td_s`.`td_contract_b` = `inst`.`instru_contract`
JOIN (SELECT td_contract td_contract_a FROM agm_trading_data td INNER JOIN (SELECT td_contract td_contract_3, MAX(td_last_dealt_time) td_last_dealt_time FROM agm_trading_data WHERE DATE(td_last_dealt_time) = '2018-08-04'GROUP By td_contract) last_td ON td.td_contract = last_td.td_contract_3 AND td.td_last_dealt_time = last_td.td_last_dealt_time) td_a ON `td_a`.`td_contract_b` = `inst`.`instru_contract`
ERROR - 2018-08-07 06:39:21 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 06:39:21 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 06:39:21 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 06:39:21 --> Severity: Notice --> Undefined index: inst.instru_contract /Applications/MAMP/htdocs/agm/application/controllers/Market.php 30
ERROR - 2018-08-07 06:39:21 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /Applications/MAMP/htdocs/agm/system/core/Exceptions.php:271) /Applications/MAMP/htdocs/agm/system/core/Common.php 570
ERROR - 2018-08-07 06:39:21 --> Severity: Error --> Call to undefined method MarketModel::count_all_instrument() /Applications/MAMP/htdocs/agm/application/controllers/Market.php 48
ERROR - 2018-08-07 06:39:27 --> Severity: Notice --> Undefined index: inst.instru_contract /Applications/MAMP/htdocs/agm/application/controllers/Market.php 30
ERROR - 2018-08-07 06:39:27 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /Applications/MAMP/htdocs/agm/system/core/Exceptions.php:271) /Applications/MAMP/htdocs/agm/system/core/Common.php 570
ERROR - 2018-08-07 06:39:27 --> Severity: Error --> Call to undefined method MarketModel::count_all_instrument() /Applications/MAMP/htdocs/agm/application/controllers/Market.php 48
ERROR - 2018-08-07 06:39:55 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 06:39:55 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 06:39:55 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 06:39:55 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /Applications/MAMP/htdocs/agm/application/controllers/Market.php:48) /Applications/MAMP/htdocs/agm/system/core/Common.php 570
ERROR - 2018-08-07 06:39:55 --> Severity: Error --> Call to undefined method MarketModel::count_all_instrument() /Applications/MAMP/htdocs/agm/application/controllers/Market.php 48
ERROR - 2018-08-07 06:39:59 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /Applications/MAMP/htdocs/agm/application/controllers/Market.php:48) /Applications/MAMP/htdocs/agm/system/core/Common.php 570
ERROR - 2018-08-07 06:39:59 --> Severity: Error --> Call to undefined method MarketModel::count_all_instrument() /Applications/MAMP/htdocs/agm/application/controllers/Market.php 48
ERROR - 2018-08-07 06:42:04 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 06:42:04 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 06:42:04 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 06:42:04 --> Severity: Warning --> Missing argument 1 for MarketModel::count_all_instruments(), called in /Applications/MAMP/htdocs/agm/application/controllers/Market.php on line 48 and defined /Applications/MAMP/htdocs/agm/application/models/MarketModel.php 65
ERROR - 2018-08-07 06:42:04 --> Severity: Warning --> Missing argument 1 for MarketModel::count_filtered_instruments(), called in /Applications/MAMP/htdocs/agm/application/controllers/Market.php on line 49 and defined /Applications/MAMP/htdocs/agm/application/models/MarketModel.php 59
ERROR - 2018-08-07 06:42:04 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /Applications/MAMP/htdocs/agm/system/core/Exceptions.php:271) /Applications/MAMP/htdocs/agm/system/core/Common.php 570
ERROR - 2018-08-07 06:42:04 --> Severity: Error --> Call to undefined method MarketModel::_get_datatables_cds_accounts() /Applications/MAMP/htdocs/agm/application/models/MarketModel.php 60
ERROR - 2018-08-07 06:42:09 --> Severity: Warning --> Missing argument 1 for MarketModel::count_all_instruments(), called in /Applications/MAMP/htdocs/agm/application/controllers/Market.php on line 48 and defined /Applications/MAMP/htdocs/agm/application/models/MarketModel.php 65
ERROR - 2018-08-07 06:42:09 --> Severity: Warning --> Missing argument 1 for MarketModel::count_filtered_instruments(), called in /Applications/MAMP/htdocs/agm/application/controllers/Market.php on line 49 and defined /Applications/MAMP/htdocs/agm/application/models/MarketModel.php 59
ERROR - 2018-08-07 06:42:09 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /Applications/MAMP/htdocs/agm/system/core/Exceptions.php:271) /Applications/MAMP/htdocs/agm/system/core/Common.php 570
ERROR - 2018-08-07 06:42:09 --> Severity: Error --> Call to undefined method MarketModel::_get_datatables_cds_accounts() /Applications/MAMP/htdocs/agm/application/models/MarketModel.php 60
ERROR - 2018-08-07 06:42:39 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 06:42:39 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 06:42:39 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 06:42:39 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /Applications/MAMP/htdocs/agm/application/models/MarketModel.php:60) /Applications/MAMP/htdocs/agm/system/core/Common.php 570
ERROR - 2018-08-07 06:42:39 --> Severity: Error --> Call to undefined method MarketModel::_get_datatables_cds_accounts() /Applications/MAMP/htdocs/agm/application/models/MarketModel.php 60
ERROR - 2018-08-07 06:42:43 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /Applications/MAMP/htdocs/agm/application/models/MarketModel.php:60) /Applications/MAMP/htdocs/agm/system/core/Common.php 570
ERROR - 2018-08-07 06:42:43 --> Severity: Error --> Call to undefined method MarketModel::_get_datatables_cds_accounts() /Applications/MAMP/htdocs/agm/application/models/MarketModel.php 60
ERROR - 2018-08-07 06:42:53 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /Applications/MAMP/htdocs/agm/application/models/MarketModel.php:60) /Applications/MAMP/htdocs/agm/system/core/Common.php 570
ERROR - 2018-08-07 06:42:53 --> Severity: Error --> Call to undefined method MarketModel::_get_datatables_cds_accounts() /Applications/MAMP/htdocs/agm/application/models/MarketModel.php 60
ERROR - 2018-08-07 06:43:12 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 06:43:12 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 06:43:12 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 06:44:17 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 06:44:17 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 06:44:17 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 06:47:24 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 06:47:24 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 06:47:24 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 06:49:16 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 06:49:16 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 06:49:16 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 06:49:19 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 06:49:19 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 06:49:19 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 06:50:24 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 06:50:24 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 06:50:24 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 06:52:01 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 06:52:01 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 06:52:01 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 06:52:01 --> Severity: Notice --> Undefined index: search /Applications/MAMP/htdocs/agm/application/models/MarketModel.php 27
ERROR - 2018-08-07 06:52:01 --> Severity: Notice --> Undefined index: length /Applications/MAMP/htdocs/agm/application/models/MarketModel.php 52
ERROR - 2018-08-07 06:52:01 --> Severity: Notice --> Undefined index: length /Applications/MAMP/htdocs/agm/application/models/MarketModel.php 53
ERROR - 2018-08-07 06:52:01 --> Severity: Notice --> Undefined index: start /Applications/MAMP/htdocs/agm/application/models/MarketModel.php 53
ERROR - 2018-08-07 06:52:01 --> Severity: Notice --> Undefined index: draw /Applications/MAMP/htdocs/agm/application/controllers/Market.php 46
ERROR - 2018-08-07 06:52:01 --> Severity: Notice --> Undefined index: search /Applications/MAMP/htdocs/agm/application/models/MarketModel.php 27
ERROR - 2018-08-07 06:52:06 --> Severity: Notice --> Undefined index: search /Applications/MAMP/htdocs/agm/application/models/MarketModel.php 27
ERROR - 2018-08-07 06:52:06 --> Severity: Notice --> Undefined index: length /Applications/MAMP/htdocs/agm/application/models/MarketModel.php 52
ERROR - 2018-08-07 06:52:06 --> Severity: Notice --> Undefined index: length /Applications/MAMP/htdocs/agm/application/models/MarketModel.php 53
ERROR - 2018-08-07 06:52:06 --> Severity: Notice --> Undefined index: start /Applications/MAMP/htdocs/agm/application/models/MarketModel.php 53
ERROR - 2018-08-07 06:52:06 --> Severity: Notice --> Undefined index: draw /Applications/MAMP/htdocs/agm/application/controllers/Market.php 46
ERROR - 2018-08-07 06:52:06 --> Severity: Notice --> Undefined index: search /Applications/MAMP/htdocs/agm/application/models/MarketModel.php 27
ERROR - 2018-08-07 06:52:11 --> Severity: Notice --> Undefined index: search /Applications/MAMP/htdocs/agm/application/models/MarketModel.php 27
ERROR - 2018-08-07 06:52:11 --> Severity: Notice --> Undefined index: length /Applications/MAMP/htdocs/agm/application/models/MarketModel.php 52
ERROR - 2018-08-07 06:52:11 --> Severity: Notice --> Undefined index: length /Applications/MAMP/htdocs/agm/application/models/MarketModel.php 53
ERROR - 2018-08-07 06:52:11 --> Severity: Notice --> Undefined index: start /Applications/MAMP/htdocs/agm/application/models/MarketModel.php 53
ERROR - 2018-08-07 06:52:11 --> Severity: Notice --> Undefined index: draw /Applications/MAMP/htdocs/agm/application/controllers/Market.php 46
ERROR - 2018-08-07 06:52:11 --> Severity: Notice --> Undefined index: search /Applications/MAMP/htdocs/agm/application/models/MarketModel.php 27
ERROR - 2018-08-07 06:52:24 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 06:52:24 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 06:52:24 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 06:54:37 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /Applications/MAMP/htdocs/agm/application/controllers/Market.php:48) /Applications/MAMP/htdocs/agm/system/core/Common.php 570
ERROR - 2018-08-07 06:54:37 --> Severity: Parsing Error --> syntax error, unexpected ';', expecting ')' /Applications/MAMP/htdocs/agm/application/controllers/Market.php 48
ERROR - 2018-08-07 06:54:45 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 06:54:45 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 06:54:45 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 06:55:01 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 06:55:01 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 06:55:01 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 06:55:40 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 06:55:40 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 06:55:40 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 06:55:58 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 06:55:58 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 06:55:58 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 06:59:16 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 06:59:16 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 06:59:16 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 07:01:00 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 07:01:00 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 07:01:00 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 07:02:01 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 07:02:01 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 07:02:01 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 08:56:50 --> Query error: Column 'td_last_dealt_time' in field list is ambiguous - Invalid query: SELECT `inst`.`instru_contract`, `td_b`.`qtyb`, `td_b`.`bid`, `td_s`.`qtyo`, `td_s`.`offer`, `time`, `high`, `low`
FROM `agm_instrument` `inst`
LEFT OUTER JOIN (SELECT td_contract td_contract_b, td_last_qty qtyb,td_last_dealt_price bid FROM agm_trading_data td INNER JOIN (SELECT td_contract td_contract_1, MAX(td_last_dealt_time) td_last_dealt_time FROM agm_trading_data WHERE DATE(td_last_dealt_time) = '2018-08-04' AND td_last_action = 'B'GROUP By td_contract) last_td ON td.td_contract = last_td.td_contract_1 AND td.td_last_dealt_time = last_td.td_last_dealt_time) td_b ON `td_b`.`td_contract_b` = `inst`.`instru_contract`
LEFT OUTER JOIN (SELECT td_contract td_contract_s, td_last_qty qtyo,td_last_dealt_price offer FROM agm_trading_data td INNER JOIN (SELECT td_contract td_contract_2, MAX(td_last_dealt_time) td_last_dealt_time FROM agm_trading_data WHERE DATE(td_last_dealt_time) = '2018-08-04' AND td_last_action = 'S'GROUP By td_contract) last_td ON td.td_contract = last_td.td_contract_2 AND td.td_last_dealt_time = last_td.td_last_dealt_time) td_s ON `td_s`.`td_contract_s` = `inst`.`instru_contract`
LEFT OUTER JOIN (SELECT td_last_dealt_time time,td_high_price high,td_low_price low,td_contract td_contract_a FROM agm_trading_data td INNER JOIN (SELECT td_contract td_contract_3, MAX(td_last_dealt_time) td_last_dealt_time FROM agm_trading_data WHERE DATE(td_last_dealt_time) = '2018-08-04'GROUP By td_contract) last_td ON td.td_contract = last_td.td_contract_3 AND td.td_last_dealt_time = last_td.td_last_dealt_time) td_a ON `td_a`.`td_contract_a` = `inst`.`instru_contract`
ERROR - 2018-08-07 08:56:55 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 08:56:55 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 08:56:55 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 08:56:55 --> Query error: Column 'td_last_dealt_time' in field list is ambiguous - Invalid query: SELECT `inst`.`instru_contract`, `td_b`.`qtyb`, `td_b`.`bid`, `td_s`.`qtyo`, `td_s`.`offer`, `time`, `high`, `low`
FROM `agm_instrument` `inst`
LEFT OUTER JOIN (SELECT td_contract td_contract_b, td_last_qty qtyb,td_last_dealt_price bid FROM agm_trading_data td INNER JOIN (SELECT td_contract td_contract_1, MAX(td_last_dealt_time) td_last_dealt_time FROM agm_trading_data WHERE DATE(td_last_dealt_time) = '2018-08-04' AND td_last_action = 'B'GROUP By td_contract) last_td ON td.td_contract = last_td.td_contract_1 AND td.td_last_dealt_time = last_td.td_last_dealt_time) td_b ON `td_b`.`td_contract_b` = `inst`.`instru_contract`
LEFT OUTER JOIN (SELECT td_contract td_contract_s, td_last_qty qtyo,td_last_dealt_price offer FROM agm_trading_data td INNER JOIN (SELECT td_contract td_contract_2, MAX(td_last_dealt_time) td_last_dealt_time FROM agm_trading_data WHERE DATE(td_last_dealt_time) = '2018-08-04' AND td_last_action = 'S'GROUP By td_contract) last_td ON td.td_contract = last_td.td_contract_2 AND td.td_last_dealt_time = last_td.td_last_dealt_time) td_s ON `td_s`.`td_contract_s` = `inst`.`instru_contract`
LEFT OUTER JOIN (SELECT td_last_dealt_time time,td_high_price high,td_low_price low,td_contract td_contract_a FROM agm_trading_data td INNER JOIN (SELECT td_contract td_contract_3, MAX(td_last_dealt_time) td_last_dealt_time FROM agm_trading_data WHERE DATE(td_last_dealt_time) = '2018-08-04'GROUP By td_contract) last_td ON td.td_contract = last_td.td_contract_3 AND td.td_last_dealt_time = last_td.td_last_dealt_time) td_a ON `td_a`.`td_contract_a` = `inst`.`instru_contract`
ERROR - 2018-08-07 08:57:02 --> Query error: Column 'td_last_dealt_time' in field list is ambiguous - Invalid query: SELECT `inst`.`instru_contract`, `td_b`.`qtyb`, `td_b`.`bid`, `td_s`.`qtyo`, `td_s`.`offer`, `time`, `high`, `low`
FROM `agm_instrument` `inst`
LEFT OUTER JOIN (SELECT td_contract td_contract_b, td_last_qty qtyb,td_last_dealt_price bid FROM agm_trading_data td INNER JOIN (SELECT td_contract td_contract_1, MAX(td_last_dealt_time) td_last_dealt_time FROM agm_trading_data WHERE DATE(td_last_dealt_time) = '2018-08-04' AND td_last_action = 'B'GROUP By td_contract) last_td ON td.td_contract = last_td.td_contract_1 AND td.td_last_dealt_time = last_td.td_last_dealt_time) td_b ON `td_b`.`td_contract_b` = `inst`.`instru_contract`
LEFT OUTER JOIN (SELECT td_contract td_contract_s, td_last_qty qtyo,td_last_dealt_price offer FROM agm_trading_data td INNER JOIN (SELECT td_contract td_contract_2, MAX(td_last_dealt_time) td_last_dealt_time FROM agm_trading_data WHERE DATE(td_last_dealt_time) = '2018-08-04' AND td_last_action = 'S'GROUP By td_contract) last_td ON td.td_contract = last_td.td_contract_2 AND td.td_last_dealt_time = last_td.td_last_dealt_time) td_s ON `td_s`.`td_contract_s` = `inst`.`instru_contract`
LEFT OUTER JOIN (SELECT td_last_dealt_time time,td_high_price high,td_low_price low,td_contract td_contract_a FROM agm_trading_data td INNER JOIN (SELECT td_contract td_contract_3, MAX(td_last_dealt_time) td_last_dealt_time FROM agm_trading_data WHERE DATE(td_last_dealt_time) = '2018-08-04'GROUP By td_contract) last_td ON td.td_contract = last_td.td_contract_3 AND td.td_last_dealt_time = last_td.td_last_dealt_time) td_a ON `td_a`.`td_contract_a` = `inst`.`instru_contract`
ERROR - 2018-08-07 08:57:07 --> Query error: Column 'td_last_dealt_time' in field list is ambiguous - Invalid query: SELECT `inst`.`instru_contract`, `td_b`.`qtyb`, `td_b`.`bid`, `td_s`.`qtyo`, `td_s`.`offer`, `time`, `high`, `low`
FROM `agm_instrument` `inst`
LEFT OUTER JOIN (SELECT td_contract td_contract_b, td_last_qty qtyb,td_last_dealt_price bid FROM agm_trading_data td INNER JOIN (SELECT td_contract td_contract_1, MAX(td_last_dealt_time) td_last_dealt_time FROM agm_trading_data WHERE DATE(td_last_dealt_time) = '2018-08-04' AND td_last_action = 'B'GROUP By td_contract) last_td ON td.td_contract = last_td.td_contract_1 AND td.td_last_dealt_time = last_td.td_last_dealt_time) td_b ON `td_b`.`td_contract_b` = `inst`.`instru_contract`
LEFT OUTER JOIN (SELECT td_contract td_contract_s, td_last_qty qtyo,td_last_dealt_price offer FROM agm_trading_data td INNER JOIN (SELECT td_contract td_contract_2, MAX(td_last_dealt_time) td_last_dealt_time FROM agm_trading_data WHERE DATE(td_last_dealt_time) = '2018-08-04' AND td_last_action = 'S'GROUP By td_contract) last_td ON td.td_contract = last_td.td_contract_2 AND td.td_last_dealt_time = last_td.td_last_dealt_time) td_s ON `td_s`.`td_contract_s` = `inst`.`instru_contract`
LEFT OUTER JOIN (SELECT td_last_dealt_time time,td_high_price high,td_low_price low,td_contract td_contract_a FROM agm_trading_data td INNER JOIN (SELECT td_contract td_contract_3, MAX(td_last_dealt_time) td_last_dealt_time FROM agm_trading_data WHERE DATE(td_last_dealt_time) = '2018-08-04'GROUP By td_contract) last_td ON td.td_contract = last_td.td_contract_3 AND td.td_last_dealt_time = last_td.td_last_dealt_time) td_a ON `td_a`.`td_contract_a` = `inst`.`instru_contract`
ERROR - 2018-08-07 08:59:31 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 08:59:31 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 08:59:31 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 09:00:02 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 09:00:02 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 09:00:02 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 09:11:54 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'change FROM agm_trading_data td INNER JOIN (SELECT td_contract td_contract_3, MA' at line 5 - Invalid query: SELECT `inst`.`instru_contract`, `td_b`.`qtyb`, `td_b`.`bid`, `td_s`.`qtyo`, `td_s`.`offer`, `time`, `high`, `low`, `last`, `change`
FROM `agm_instrument` `inst`
LEFT OUTER JOIN (SELECT td_contract td_contract_b, td_last_qty qtyb,td_last_dealt_price bid FROM agm_trading_data td INNER JOIN (SELECT td_contract td_contract_1, MAX(td_last_dealt_time) td_last_dealt_time_b FROM agm_trading_data WHERE DATE(td_last_dealt_time) = '2018-08-04' AND td_last_action = 'B'GROUP By td_contract) last_td ON td.td_contract = last_td.td_contract_1 AND td.td_last_dealt_time = last_td.td_last_dealt_time_b) td_b ON `td_b`.`td_contract_b` = `inst`.`instru_contract`
LEFT OUTER JOIN (SELECT td_contract td_contract_s, td_last_qty qtyo,td_last_dealt_price offer FROM agm_trading_data td INNER JOIN (SELECT td_contract td_contract_2, MAX(td_last_dealt_time) td_last_dealt_time_s FROM agm_trading_data WHERE DATE(td_last_dealt_time) = '2018-08-04' AND td_last_action = 'S'GROUP By td_contract) last_td ON td.td_contract = last_td.td_contract_2 AND td.td_last_dealt_time = last_td.td_last_dealt_time_s) td_s ON `td_s`.`td_contract_s` = `inst`.`instru_contract`
LEFT OUTER JOIN (SELECT td_last_dealt_time time,td_last_traded_qty last,td_high_price high,td_low_price low,td_contract td_contract_a,td_change change FROM agm_trading_data td INNER JOIN (SELECT td_contract td_contract_3, MAX(td_last_dealt_time) td_last_dealt_time_a FROM agm_trading_data WHERE DATE(td_last_dealt_time) = '2018-08-04'GROUP By td_contract) last_td ON td.td_contract = last_td.td_contract_3 AND td.td_last_dealt_time = last_td.td_last_dealt_time_a) td_a ON `td_a`.`td_contract_a` = `inst`.`instru_contract`
ERROR - 2018-08-07 09:12:01 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'change FROM agm_trading_data td INNER JOIN (SELECT td_contract td_contract_3, MA' at line 5 - Invalid query: SELECT `inst`.`instru_contract`, `td_b`.`qtyb`, `td_b`.`bid`, `td_s`.`qtyo`, `td_s`.`offer`, `time`, `high`, `low`, `last`, `change`
FROM `agm_instrument` `inst`
LEFT OUTER JOIN (SELECT td_contract td_contract_b, td_last_qty qtyb,td_last_dealt_price bid FROM agm_trading_data td INNER JOIN (SELECT td_contract td_contract_1, MAX(td_last_dealt_time) td_last_dealt_time_b FROM agm_trading_data WHERE DATE(td_last_dealt_time) = '2018-08-04' AND td_last_action = 'B'GROUP By td_contract) last_td ON td.td_contract = last_td.td_contract_1 AND td.td_last_dealt_time = last_td.td_last_dealt_time_b) td_b ON `td_b`.`td_contract_b` = `inst`.`instru_contract`
LEFT OUTER JOIN (SELECT td_contract td_contract_s, td_last_qty qtyo,td_last_dealt_price offer FROM agm_trading_data td INNER JOIN (SELECT td_contract td_contract_2, MAX(td_last_dealt_time) td_last_dealt_time_s FROM agm_trading_data WHERE DATE(td_last_dealt_time) = '2018-08-04' AND td_last_action = 'S'GROUP By td_contract) last_td ON td.td_contract = last_td.td_contract_2 AND td.td_last_dealt_time = last_td.td_last_dealt_time_s) td_s ON `td_s`.`td_contract_s` = `inst`.`instru_contract`
LEFT OUTER JOIN (SELECT td_last_dealt_time time,td_last_traded_qty last,td_high_price high,td_low_price low,td_contract td_contract_a,td_change change FROM agm_trading_data td INNER JOIN (SELECT td_contract td_contract_3, MAX(td_last_dealt_time) td_last_dealt_time_a FROM agm_trading_data WHERE DATE(td_last_dealt_time) = '2018-08-04'GROUP By td_contract) last_td ON td.td_contract = last_td.td_contract_3 AND td.td_last_dealt_time = last_td.td_last_dealt_time_a) td_a ON `td_a`.`td_contract_a` = `inst`.`instru_contract`
ERROR - 2018-08-07 09:12:44 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 09:12:44 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 09:12:44 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 09:12:44 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'change FROM agm_trading_data td INNER JOIN (SELECT td_contract td_contract_3, MA' at line 5 - Invalid query: SELECT `inst`.`instru_contract`, `td_b`.`qtyb`, `td_b`.`bid`, `td_s`.`qtyo`, `td_s`.`offer`, `time`, `high`, `low`, `last`, `change`
FROM `agm_instrument` `inst`
LEFT OUTER JOIN (SELECT td_contract td_contract_b, td_last_qty qtyb,td_last_dealt_price bid FROM agm_trading_data td INNER JOIN (SELECT td_contract td_contract_1, MAX(td_last_dealt_time) td_last_dealt_time_b FROM agm_trading_data WHERE DATE(td_last_dealt_time) = '2018-08-04' AND td_last_action = 'B'GROUP By td_contract) last_td ON td.td_contract = last_td.td_contract_1 AND td.td_last_dealt_time = last_td.td_last_dealt_time_b) td_b ON `td_b`.`td_contract_b` = `inst`.`instru_contract`
LEFT OUTER JOIN (SELECT td_contract td_contract_s, td_last_qty qtyo,td_last_dealt_price offer FROM agm_trading_data td INNER JOIN (SELECT td_contract td_contract_2, MAX(td_last_dealt_time) td_last_dealt_time_s FROM agm_trading_data WHERE DATE(td_last_dealt_time) = '2018-08-04' AND td_last_action = 'S'GROUP By td_contract) last_td ON td.td_contract = last_td.td_contract_2 AND td.td_last_dealt_time = last_td.td_last_dealt_time_s) td_s ON `td_s`.`td_contract_s` = `inst`.`instru_contract`
LEFT OUTER JOIN (SELECT td_last_dealt_time time,td_last_traded_qty last,td_high_price high,td_low_price low,td_contract td_contract_a,td_change change FROM agm_trading_data td INNER JOIN (SELECT td_contract td_contract_3, MAX(td_last_dealt_time) td_last_dealt_time_a FROM agm_trading_data WHERE DATE(td_last_dealt_time) = '2018-08-04'GROUP By td_contract) last_td ON td.td_contract = last_td.td_contract_3 AND td.td_last_dealt_time = last_td.td_last_dealt_time_a) td_a ON `td_a`.`td_contract_a` = `inst`.`instru_contract`
ERROR - 2018-08-07 09:12:49 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'change FROM agm_trading_data td INNER JOIN (SELECT td_contract td_contract_3, MA' at line 5 - Invalid query: SELECT `inst`.`instru_contract`, `td_b`.`qtyb`, `td_b`.`bid`, `td_s`.`qtyo`, `td_s`.`offer`, `time`, `high`, `low`, `last`, `change`
FROM `agm_instrument` `inst`
LEFT OUTER JOIN (SELECT td_contract td_contract_b, td_last_qty qtyb,td_last_dealt_price bid FROM agm_trading_data td INNER JOIN (SELECT td_contract td_contract_1, MAX(td_last_dealt_time) td_last_dealt_time_b FROM agm_trading_data WHERE DATE(td_last_dealt_time) = '2018-08-04' AND td_last_action = 'B'GROUP By td_contract) last_td ON td.td_contract = last_td.td_contract_1 AND td.td_last_dealt_time = last_td.td_last_dealt_time_b) td_b ON `td_b`.`td_contract_b` = `inst`.`instru_contract`
LEFT OUTER JOIN (SELECT td_contract td_contract_s, td_last_qty qtyo,td_last_dealt_price offer FROM agm_trading_data td INNER JOIN (SELECT td_contract td_contract_2, MAX(td_last_dealt_time) td_last_dealt_time_s FROM agm_trading_data WHERE DATE(td_last_dealt_time) = '2018-08-04' AND td_last_action = 'S'GROUP By td_contract) last_td ON td.td_contract = last_td.td_contract_2 AND td.td_last_dealt_time = last_td.td_last_dealt_time_s) td_s ON `td_s`.`td_contract_s` = `inst`.`instru_contract`
LEFT OUTER JOIN (SELECT td_last_dealt_time time,td_last_traded_qty last,td_high_price high,td_low_price low,td_contract td_contract_a,td_change change FROM agm_trading_data td INNER JOIN (SELECT td_contract td_contract_3, MAX(td_last_dealt_time) td_last_dealt_time_a FROM agm_trading_data WHERE DATE(td_last_dealt_time) = '2018-08-04'GROUP By td_contract) last_td ON td.td_contract = last_td.td_contract_3 AND td.td_last_dealt_time = last_td.td_last_dealt_time_a) td_a ON `td_a`.`td_contract_a` = `inst`.`instru_contract`
ERROR - 2018-08-07 09:14:35 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 09:14:35 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 09:14:35 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 09:14:35 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'change, td_last_dealt_time time,td_last_traded_qty last,td_high_price high,td_lo' at line 5 - Invalid query: SELECT `inst`.`instru_contract`, `td_b`.`qtyb`, `td_b`.`bid`, `td_s`.`qtyo`, `td_s`.`offer`, `time`, `high`, `low`
FROM `agm_instrument` `inst`
LEFT OUTER JOIN (SELECT td_contract td_contract_b, td_last_qty qtyb,td_last_dealt_price bid FROM agm_trading_data td INNER JOIN (SELECT td_contract td_contract_1, MAX(td_last_dealt_time) td_last_dealt_time_b FROM agm_trading_data WHERE DATE(td_last_dealt_time) = '2018-08-04' AND td_last_action = 'B'GROUP By td_contract) last_td ON td.td_contract = last_td.td_contract_1 AND td.td_last_dealt_time = last_td.td_last_dealt_time_b) td_b ON `td_b`.`td_contract_b` = `inst`.`instru_contract`
LEFT OUTER JOIN (SELECT td_contract td_contract_s, td_last_qty qtyo,td_last_dealt_price offer FROM agm_trading_data td INNER JOIN (SELECT td_contract td_contract_2, MAX(td_last_dealt_time) td_last_dealt_time_s FROM agm_trading_data WHERE DATE(td_last_dealt_time) = '2018-08-04' AND td_last_action = 'S'GROUP By td_contract) last_td ON td.td_contract = last_td.td_contract_2 AND td.td_last_dealt_time = last_td.td_last_dealt_time_s) td_s ON `td_s`.`td_contract_s` = `inst`.`instru_contract`
LEFT OUTER JOIN (SELECT td_change change, td_last_dealt_time time,td_last_traded_qty last,td_high_price high,td_low_price low,td_contract td_contract_a FROM agm_trading_data td INNER JOIN (SELECT td_contract td_contract_3, MAX(td_last_dealt_time) td_last_dealt_time_a FROM agm_trading_data WHERE DATE(td_last_dealt_time) = '2018-08-04'GROUP By td_contract) last_td ON td.td_contract = last_td.td_contract_3 AND td.td_last_dealt_time = last_td.td_last_dealt_time_a) td_a ON `td_a`.`td_contract_a` = `inst`.`instru_contract`
ERROR - 2018-08-07 09:14:40 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'change, td_last_dealt_time time,td_last_traded_qty last,td_high_price high,td_lo' at line 5 - Invalid query: SELECT `inst`.`instru_contract`, `td_b`.`qtyb`, `td_b`.`bid`, `td_s`.`qtyo`, `td_s`.`offer`, `time`, `high`, `low`
FROM `agm_instrument` `inst`
LEFT OUTER JOIN (SELECT td_contract td_contract_b, td_last_qty qtyb,td_last_dealt_price bid FROM agm_trading_data td INNER JOIN (SELECT td_contract td_contract_1, MAX(td_last_dealt_time) td_last_dealt_time_b FROM agm_trading_data WHERE DATE(td_last_dealt_time) = '2018-08-04' AND td_last_action = 'B'GROUP By td_contract) last_td ON td.td_contract = last_td.td_contract_1 AND td.td_last_dealt_time = last_td.td_last_dealt_time_b) td_b ON `td_b`.`td_contract_b` = `inst`.`instru_contract`
LEFT OUTER JOIN (SELECT td_contract td_contract_s, td_last_qty qtyo,td_last_dealt_price offer FROM agm_trading_data td INNER JOIN (SELECT td_contract td_contract_2, MAX(td_last_dealt_time) td_last_dealt_time_s FROM agm_trading_data WHERE DATE(td_last_dealt_time) = '2018-08-04' AND td_last_action = 'S'GROUP By td_contract) last_td ON td.td_contract = last_td.td_contract_2 AND td.td_last_dealt_time = last_td.td_last_dealt_time_s) td_s ON `td_s`.`td_contract_s` = `inst`.`instru_contract`
LEFT OUTER JOIN (SELECT td_change change, td_last_dealt_time time,td_last_traded_qty last,td_high_price high,td_low_price low,td_contract td_contract_a FROM agm_trading_data td INNER JOIN (SELECT td_contract td_contract_3, MAX(td_last_dealt_time) td_last_dealt_time_a FROM agm_trading_data WHERE DATE(td_last_dealt_time) = '2018-08-04'GROUP By td_contract) last_td ON td.td_contract = last_td.td_contract_3 AND td.td_last_dealt_time = last_td.td_last_dealt_time_a) td_a ON `td_a`.`td_contract_a` = `inst`.`instru_contract`
ERROR - 2018-08-07 09:15:25 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 09:15:25 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 09:15:25 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 09:15:25 --> Severity: Notice --> Undefined index: last /Applications/MAMP/htdocs/agm/application/controllers/Market.php 35
ERROR - 2018-08-07 09:15:25 --> Severity: Notice --> Undefined index: last /Applications/MAMP/htdocs/agm/application/controllers/Market.php 35
ERROR - 2018-08-07 09:15:25 --> Severity: Notice --> Undefined index: last /Applications/MAMP/htdocs/agm/application/controllers/Market.php 35
ERROR - 2018-08-07 09:15:25 --> Severity: Notice --> Undefined index: last /Applications/MAMP/htdocs/agm/application/controllers/Market.php 35
ERROR - 2018-08-07 09:15:25 --> Severity: Notice --> Undefined index: last /Applications/MAMP/htdocs/agm/application/controllers/Market.php 35
ERROR - 2018-08-07 09:15:25 --> Severity: Notice --> Undefined index: last /Applications/MAMP/htdocs/agm/application/controllers/Market.php 35
ERROR - 2018-08-07 09:15:25 --> Severity: Notice --> Undefined index: last /Applications/MAMP/htdocs/agm/application/controllers/Market.php 35
ERROR - 2018-08-07 09:15:25 --> Severity: Notice --> Undefined index: last /Applications/MAMP/htdocs/agm/application/controllers/Market.php 35
ERROR - 2018-08-07 09:15:25 --> Severity: Notice --> Undefined index: last /Applications/MAMP/htdocs/agm/application/controllers/Market.php 35
ERROR - 2018-08-07 09:15:30 --> Severity: Notice --> Undefined index: last /Applications/MAMP/htdocs/agm/application/controllers/Market.php 35
ERROR - 2018-08-07 09:15:30 --> Severity: Notice --> Undefined index: last /Applications/MAMP/htdocs/agm/application/controllers/Market.php 35
ERROR - 2018-08-07 09:15:30 --> Severity: Notice --> Undefined index: last /Applications/MAMP/htdocs/agm/application/controllers/Market.php 35
ERROR - 2018-08-07 09:15:30 --> Severity: Notice --> Undefined index: last /Applications/MAMP/htdocs/agm/application/controllers/Market.php 35
ERROR - 2018-08-07 09:15:30 --> Severity: Notice --> Undefined index: last /Applications/MAMP/htdocs/agm/application/controllers/Market.php 35
ERROR - 2018-08-07 09:15:30 --> Severity: Notice --> Undefined index: last /Applications/MAMP/htdocs/agm/application/controllers/Market.php 35
ERROR - 2018-08-07 09:15:30 --> Severity: Notice --> Undefined index: last /Applications/MAMP/htdocs/agm/application/controllers/Market.php 35
ERROR - 2018-08-07 09:15:30 --> Severity: Notice --> Undefined index: last /Applications/MAMP/htdocs/agm/application/controllers/Market.php 35
ERROR - 2018-08-07 09:15:30 --> Severity: Notice --> Undefined index: last /Applications/MAMP/htdocs/agm/application/controllers/Market.php 35
ERROR - 2018-08-07 09:15:36 --> Severity: Notice --> Undefined index: last /Applications/MAMP/htdocs/agm/application/controllers/Market.php 35
ERROR - 2018-08-07 09:15:36 --> Severity: Notice --> Undefined index: last /Applications/MAMP/htdocs/agm/application/controllers/Market.php 35
ERROR - 2018-08-07 09:15:36 --> Severity: Notice --> Undefined index: last /Applications/MAMP/htdocs/agm/application/controllers/Market.php 35
ERROR - 2018-08-07 09:15:36 --> Severity: Notice --> Undefined index: last /Applications/MAMP/htdocs/agm/application/controllers/Market.php 35
ERROR - 2018-08-07 09:15:36 --> Severity: Notice --> Undefined index: last /Applications/MAMP/htdocs/agm/application/controllers/Market.php 35
ERROR - 2018-08-07 09:15:36 --> Severity: Notice --> Undefined index: last /Applications/MAMP/htdocs/agm/application/controllers/Market.php 35
ERROR - 2018-08-07 09:15:36 --> Severity: Notice --> Undefined index: last /Applications/MAMP/htdocs/agm/application/controllers/Market.php 35
ERROR - 2018-08-07 09:15:36 --> Severity: Notice --> Undefined index: last /Applications/MAMP/htdocs/agm/application/controllers/Market.php 35
ERROR - 2018-08-07 09:15:36 --> Severity: Notice --> Undefined index: last /Applications/MAMP/htdocs/agm/application/controllers/Market.php 35
ERROR - 2018-08-07 09:16:11 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 09:16:11 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 09:16:11 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 09:17:51 --> Severity: Notice --> Undefined index: volume /Applications/MAMP/htdocs/agm/application/controllers/Market.php 40
ERROR - 2018-08-07 09:17:51 --> Severity: Notice --> Undefined index: volume /Applications/MAMP/htdocs/agm/application/controllers/Market.php 40
ERROR - 2018-08-07 09:17:51 --> Severity: Notice --> Undefined index: volume /Applications/MAMP/htdocs/agm/application/controllers/Market.php 40
ERROR - 2018-08-07 09:17:51 --> Severity: Notice --> Undefined index: volume /Applications/MAMP/htdocs/agm/application/controllers/Market.php 40
ERROR - 2018-08-07 09:17:51 --> Severity: Notice --> Undefined index: volume /Applications/MAMP/htdocs/agm/application/controllers/Market.php 40
ERROR - 2018-08-07 09:17:51 --> Severity: Notice --> Undefined index: volume /Applications/MAMP/htdocs/agm/application/controllers/Market.php 40
ERROR - 2018-08-07 09:17:51 --> Severity: Notice --> Undefined index: volume /Applications/MAMP/htdocs/agm/application/controllers/Market.php 40
ERROR - 2018-08-07 09:17:51 --> Severity: Notice --> Undefined index: volume /Applications/MAMP/htdocs/agm/application/controllers/Market.php 40
ERROR - 2018-08-07 09:17:51 --> Severity: Notice --> Undefined index: volume /Applications/MAMP/htdocs/agm/application/controllers/Market.php 40
ERROR - 2018-08-07 09:17:54 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 09:17:54 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 09:17:54 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 09:17:55 --> Severity: Notice --> Undefined index: volume /Applications/MAMP/htdocs/agm/application/controllers/Market.php 40
ERROR - 2018-08-07 09:17:55 --> Severity: Notice --> Undefined index: volume /Applications/MAMP/htdocs/agm/application/controllers/Market.php 40
ERROR - 2018-08-07 09:17:55 --> Severity: Notice --> Undefined index: volume /Applications/MAMP/htdocs/agm/application/controllers/Market.php 40
ERROR - 2018-08-07 09:17:55 --> Severity: Notice --> Undefined index: volume /Applications/MAMP/htdocs/agm/application/controllers/Market.php 40
ERROR - 2018-08-07 09:17:55 --> Severity: Notice --> Undefined index: volume /Applications/MAMP/htdocs/agm/application/controllers/Market.php 40
ERROR - 2018-08-07 09:17:55 --> Severity: Notice --> Undefined index: volume /Applications/MAMP/htdocs/agm/application/controllers/Market.php 40
ERROR - 2018-08-07 09:17:55 --> Severity: Notice --> Undefined index: volume /Applications/MAMP/htdocs/agm/application/controllers/Market.php 40
ERROR - 2018-08-07 09:17:55 --> Severity: Notice --> Undefined index: volume /Applications/MAMP/htdocs/agm/application/controllers/Market.php 40
ERROR - 2018-08-07 09:17:55 --> Severity: Notice --> Undefined index: volume /Applications/MAMP/htdocs/agm/application/controllers/Market.php 40
ERROR - 2018-08-07 09:17:59 --> Severity: Notice --> Undefined index: volume /Applications/MAMP/htdocs/agm/application/controllers/Market.php 40
ERROR - 2018-08-07 09:17:59 --> Severity: Notice --> Undefined index: volume /Applications/MAMP/htdocs/agm/application/controllers/Market.php 40
ERROR - 2018-08-07 09:17:59 --> Severity: Notice --> Undefined index: volume /Applications/MAMP/htdocs/agm/application/controllers/Market.php 40
ERROR - 2018-08-07 09:17:59 --> Severity: Notice --> Undefined index: volume /Applications/MAMP/htdocs/agm/application/controllers/Market.php 40
ERROR - 2018-08-07 09:17:59 --> Severity: Notice --> Undefined index: volume /Applications/MAMP/htdocs/agm/application/controllers/Market.php 40
ERROR - 2018-08-07 09:17:59 --> Severity: Notice --> Undefined index: volume /Applications/MAMP/htdocs/agm/application/controllers/Market.php 40
ERROR - 2018-08-07 09:17:59 --> Severity: Notice --> Undefined index: volume /Applications/MAMP/htdocs/agm/application/controllers/Market.php 40
ERROR - 2018-08-07 09:17:59 --> Severity: Notice --> Undefined index: volume /Applications/MAMP/htdocs/agm/application/controllers/Market.php 40
ERROR - 2018-08-07 09:17:59 --> Severity: Notice --> Undefined index: volume /Applications/MAMP/htdocs/agm/application/controllers/Market.php 40
ERROR - 2018-08-07 09:18:20 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 09:18:20 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 09:18:20 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 09:20:27 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 09:20:27 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 09:20:27 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 09:23:30 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 09:23:30 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 09:23:30 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 09:30:35 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 09:30:35 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 09:30:35 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 09:32:48 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 09:32:48 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 09:32:48 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 09:35:18 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 09:35:18 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 09:35:18 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 09:35:25 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 09:35:25 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 09:35:25 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 09:36:02 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 09:36:02 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 09:36:02 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 09:43:16 --> Severity: Notice --> Undefined variable: user_fullname /Applications/MAMP/htdocs/agm/application/views/menu/view_sys_menu.php 7
ERROR - 2018-08-07 09:43:16 --> Severity: Notice --> Undefined variable: user_meeting_year_name /Applications/MAMP/htdocs/agm/application/views/menu/view_sys_menu.php 8
ERROR - 2018-08-07 09:43:16 --> Severity: Notice --> Undefined variable: user_role /Applications/MAMP/htdocs/agm/application/views/menu/view_sys_menu.php 9
ERROR - 2018-08-07 09:43:16 --> Severity: Notice --> Undefined variable: user_role /Applications/MAMP/htdocs/agm/application/views/menu/view_sys_menu.php 25
ERROR - 2018-08-07 09:43:16 --> Severity: Notice --> Undefined variable: user_role /Applications/MAMP/htdocs/agm/application/views/menu/view_sys_menu.php 38
ERROR - 2018-08-07 09:43:16 --> Severity: Notice --> Undefined variable: user_role /Applications/MAMP/htdocs/agm/application/views/menu/view_sys_menu.php 52
ERROR - 2018-08-07 09:43:16 --> Severity: Notice --> Undefined variable: user_role /Applications/MAMP/htdocs/agm/application/views/menu/view_sys_menu.php 65
ERROR - 2018-08-07 09:43:16 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 09:43:16 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 09:43:17 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 09:47:13 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 09:47:13 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 09:47:13 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 09:48:46 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 09:48:46 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 09:48:46 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 09:49:50 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 09:49:50 --> 404 Page Not Found: Assets/vendor
ERROR - 2018-08-07 09:49:50 --> 404 Page Not Found: Assets/vendor
