DROP PROCEDURE IF EXISTS sp_users_type_add;
DELIMITER $$
CREATE PROCEDURE sp_users_type_add(
	IN in_user_type_name VARCHAR(100)
) validate : BEGIN
	
    IF EXISTS(SELECT * FROM atb_user_type WHERE user_type_name = in_user_type_name LIMIT 1) THEN
		SELECT 'Add User Type Failed' h, 'User type already exists' m, 'warning' s;
        LEAVE validate;
	END IF;
    
    INSERT INTO atb_user_type(user_type_name) 
		SELECT in_user_type_name;
	SELECT 'Good Job!' h, 'You have successfully added new user type!' m, 'success' s;
        
END $$
DELIMITER $$

