DROP PROCEDURE IF EXISTS sp_users_type_delete;
DELIMITER $$
CREATE PROCEDURE sp_users_type_delete(
	IN in_user_type INT
) validate : BEGIN
	
    IF EXISTS (SELECT * FROM atb_user WHERE user_type = in_user_type AND user_deleted = 0 LIMIT 1) THEN
		SELECT 'Delete User Type Failed' h, 'User type is currently in use and cannot be removed' m, 'warning' s;
        LEAVE validate;
    END IF;
    
    DELETE FROM atb_user WHERE user_type = in_user_type;
    DELETE FROM atb_user_type WHERE user_type = in_user_type;
	SELECT 'Delete User Type Success' h, 'You have successfully removed User Type' m, 'success' s;
    
END $$
DELIMITER $$
