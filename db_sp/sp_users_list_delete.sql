DROP PROCEDURE IF EXISTS sp_users_list_delete;
DELIMITER $$
CREATE PROCEDURE sp_users_list_delete(
	IN in_user_id INT
) validate : BEGIN

	IF EXISTS (SELECT user_id from atb_user WHERE user_id = in_user_id AND user_locked = 0) THEN
		SELECT 'Remove User' h, "Please lock the users before removing it" m, 'warning' s;
		LEAVE validate;
    END IF;

	UPDATE atb_user SET user_deleted = 1 WHERE user_id = in_user_id;
	SELECT 'Remove User' h, "You have successfully removed the user" m, 'success' s;

END $$
DELIMITER $$