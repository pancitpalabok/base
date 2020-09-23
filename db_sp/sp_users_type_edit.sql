DROP PROCEDURE IF EXISTS sp_users_type_edit;
DELIMITER $$
CREATE PROCEDURE sp_users_type_edit(
	IN in_user_type INT,
    IN in_user_type_name VARCHAR(100)
) validate : BEGIN
	
    IF EXISTS (SELECT user_type FROM  atb_user_type WHERE user_type != in_user_type AND user_type_name = in_user_type_name LIMIT 1) THEN
		SELECT 'Modify User Type Failed' h, 'User type already exist or currently in use and cannot be modified' m, 'warning' s;
		LEAVE validate;
    END IF;
    
    UPDATE atb_user_type SET user_type_name = in_user_type_name WHERE user_type = in_user_type;
	SELECT 'Edit User Type Success' h, 'You have successfully modified the User Type' m, 'success' s;
    
END $$
DELIMITER $$