DROP PROCEDURE IF EXISTS sp_users_type_access_edit;
DELIMITER $$
CREATE PROCEDURE sp_users_type_access_edit(
	IN in_user_type INT,
    IN in_user_access LONGTEXT
) BEGIN
	UPDATE atb_user_type 
		SET user_access = in_user_access
        WHERE user_type = in_user_type;
        
	SELECT 'User Type Access' h, 'You have successfully modified the user type access!' m, 'success' s;
	
END  $$
DELIMITER $$

