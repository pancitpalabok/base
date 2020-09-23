DROP PROCEDURE IF EXISTS sp_users_list_lock;
DELIMITER $$
CREATE PROCEDURE sp_users_list_lock(
	IN in_user_id INT
) BEGIN
	UPDATE atb_user SET user_locked = 1 WHERE user_id = in_user_id;
	SELECT 'User Locked' h, 'You have successfully locked the user' m, 'success' s;
END $$
DELIMITER $$