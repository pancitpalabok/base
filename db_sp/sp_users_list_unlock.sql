DROP PROCEDURE IF EXISTS sp_users_list_unlock;
DELIMITER $$
CREATE PROCEDURE sp_users_list_unlock(
	IN in_user_id INT
) BEGIN
	UPDATE atb_user SET user_locked = 0 WHERE user_id = in_user_id;
	SELECT 'User Unlocked' h, 'You have successfully unlocked the user' m, 'success' s;
END $$
DELIMITER $$