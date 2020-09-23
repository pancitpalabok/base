DROP PROCEDURE IF EXISTS sp_login;
DELIMITER $$
CREATE PROCEDURE sp_login(
	IN in_user_email VARCHAR(50)
) BEGIN
	SELECT
		*
	FROM atb_user a
	INNER JOIN atb_user_type b ON a.user_type = b.user_type
	INNER JOIN atb_user_access c ON a.user_id = c.user_id
	WHERE a.user_email = in_user_email OR a.user_name = in_user_email;

END $$
DELIMITER $$

CALL sp_login('admin@base.com')

