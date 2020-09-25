DROP PROCEDURE IF EXISTS sp_users_list_edit;
DELIMITER $$
CREATE PROCEDURE sp_users_list_edit(
	IN in_user_id INT,
    IN in_user_type INT
) validate : BEGIN
	
    
    UPDATE atb_user SET user_type = in_user_type, user_access = (SELECT user_access FROM atb_user_type WHERE user_type = in_user_type) WHERE user_id = in_user_id;
	SELECT 'Edit User Success' h, 'You have successfully modified the User' m, 'success' s;
    
END $$
DELIMITER $$