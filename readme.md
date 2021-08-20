CREATE VIEW `view_form4_latest_2019`
AS  select 
  claim_case_opponents.id as claim_case_opponent_id,
  claim_case_opponents.claim_case_id,
  form4.form4_id
   from claim_case_opponents
  join form4 on (form4.claim_case_opponent_id = claim_case_opponents.id
  and form4.form4_id = (
  	select 
  	form4b.form4_id
  	-- max(form4b.form4_id) 
  	from form4 form4b 
  	where form4b.claim_case_opponent_id = claim_case_opponents.id
  	order by form4b.form4_id desc
  	limit 1
  	)
  );



CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_report23_2019`
AS SELECT
   `form1`.`filing_date` AS `filing_date`,
   `master_branch`.`branch_state_id` AS `state_id`,
   `claim_case`.`case_status_id` AS `case_status_id`
FROM ((`claim_case` join `form1` on((`form1`.`form1_id` = `claim_case`.`form1_id`))) join `master_branch` on((`claim_case`.`branch_id` = `master_branch`.`branch_id`))) where ((`form1`.`form_status_id` = 17) and (not((`claim_case`.`case_no` like '%--%'))));



INSERT INTO `permissions` (`id`, `name`, `display_name`, `description`, `created_at`, `updated_at`)
VALUES
	(58, 'admin-ks', 'Admin-KS', 'KS administration', '2017-10-24 20:11:34', '2017-10-24 20:11:34');


/* 12:23:24 kpdn-tribunal-stag etribunalV2 */ UPDATE `master_claim_classification` SET `is_active` = '0' WHERE `claim_classification_id` = '39';
/* 12:23:34 kpdn-tribunal-stag etribunalV2 */ UPDATE `master_claim_classification` SET `is_active` = '0' WHERE `claim_classification_id` = '45';
/* 12:23:45 kpdn-tribunal-stag etribunalV2 */ UPDATE `master_claim_classification` SET `is_active` = '0' WHERE `claim_classification_id` = '42';
/* 12:23:51 kpdn-tribunal-stag etribunalV2 */ UPDATE `master_claim_classification` SET `is_active` = '0' WHERE `claim_classification_id` = '43';
/* 12:23:59 kpdn-tribunal-stag etribunalV2 */ UPDATE `master_claim_classification` SET `is_active` = '0' WHERE `claim_classification_id` = '57';
/* 12:24:07 kpdn-tribunal-stag etribunalV2 */ UPDATE `master_claim_classification` SET `is_active` = '0' WHERE `claim_classification_id` = '46';
/* 12:24:13 kpdn-tribunal-stag etribunalV2 */ UPDATE `master_claim_classification` SET `is_active` = '0' WHERE `claim_classification_id` = '51';
/* 12:24:24 kpdn-tribunal-stag etribunalV2 */ UPDATE `master_claim_classification` SET `is_active` = '0' WHERE `claim_classification_id` = '47';
/* 12:24:31 kpdn-tribunal-stag etribunalV2 */ UPDATE `master_claim_classification` SET `is_active` = '0' WHERE `claim_classification_id` = '50';
/* 12:25:25 kpdn-tribunal-stag etribunalV2 */ INSERT INTO `master_claim_classification` (`claim_classification_id`, `classification_en`, `classification_my`, `category_id`, `rcy_id`, `v1_code`, `is_active`, `created_at`, `updated_at`) VALUES (NULL, 'Rent House Deposite', 'Deposit Sewa Rumah', '2', 'K42', 'K45', '0', '2017-08-15 11:07:37', '2017-08-15 11:07:37');
/* 12:25:48 kpdn-tribunal-stag etribunalV2 */ UPDATE `master_claim_classification` SET `classification_my` = 'IPTS' WHERE `claim_classification_id` = '19';
/* 12:25:50 kpdn-tribunal-stag etribunalV2 */ UPDATE `master_claim_classification` SET `classification_en` = 'IPTS' WHERE `claim_classification_id` = '19';
/* 12:26:14 kpdn-tribunal-stag etribunalV2 */ UPDATE `master_claim_classification` SET `classification_my` = 'Perkhidmatan Pengangkutan Awam' WHERE `claim_classification_id` = '26';
/* 12:26:18 kpdn-tribunal-stag etribunalV2 */ UPDATE `master_claim_classification` SET `classification_en` = 'Civil Transport Service' WHERE `claim_classification_id` = '26';

INSERT INTO `master_oppo_statuses` (`id`, `name`, `deleted_at`, `created_at`, `updated_at`)
VALUES
	(1, 'Unfinish', NULL, '2019-08-27 09:46:09', '2019-08-27 09:46:09'),
	(2, 'Finish', NULL, '2019-08-27 09:46:09', '2019-08-27 09:46:09');
