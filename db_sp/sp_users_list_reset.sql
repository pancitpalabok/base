DROP PROCEDURE IF EXISTS sp_users_list_reset;
DELIMITER $$
CREATE PROCEDURE sp_users_list_reset(
	IN in_user_id INT,
    IN in_new_password VARCHAR(255)
) BEGIN
	UPDATE atb_user SET user_password = in_new_password, user_change_password = NOW()  WHERE user_id = in_user_id;
	SELECT 'User Reset' h, "You have successfully reset the user's password" m, 'success' s;

END $$
DELIMITER $$