DROP PROCEDURE IF EXISTS sp_users_type_data;
DELIMITER $$
CREATE PROCEDURE sp_users_type_data() BEGIN
	 SELECT
		a.*,
		COUNT(b.user_id) user_type_count
	FROM atb_user_type a
	LEFT JOIN atb_user b ON a.user_type = b.user_type AND b.user_deleted = 0
	GROUP BY a.user_type,a.user_type_name;
END $$
DELIMITER $$

CALL sp_users_type_data()