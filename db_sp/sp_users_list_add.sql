DROP PROCEDURE IF EXISTS sp_users_list_add;
DELIMITER $$
CREATE PROCEDURE sp_users_list_add(
	IN in_user_email VARCHAR(100),
    IN in_password_count INT,
    IN in_user_password VARCHAR(255),
    IN in_user_type INT
) validate : BEGIN
	
	DECLARE min_password INT;
	DECLARE max_password INT;
    DECLARE id INT;
    
    SELECT 	setup_min_password,	setup_max_password
	INTO 	min_password,		max_password
    FROM atb_setup LIMIT 1;
    
	IF NOT EXISTS(SELECT * FROM atb_user_type WHERE user_type = in_user_type LIMIT 1) THEN
		SELECT 'Add User Failed' h, 'User type does not eixst!' m, 'warning' s;
		LEAVE validate;
    END IF;
    
    IF in_password_count < min_password OR in_password_count > max_password THEN
		SELECT 'Add User Failed' h, CONCAT('Password requires minimum of ',min_password,' and maximum of ',max_password,' characters') m, 'warning' s;
        LEAVE validate;
    END IF;
    
    IF EXISTS(SELECT * FROM atb_user WHERE user_email = in_user_email  LIMIT 1) THEN
		SELECT 'Add User Failed' h, 'User already exists' m, 'warning' s;
        LEAVE validate;
    END IF;
    
    INSERT INTO atb_user (user_name,user_email,user_password,user_type)
		SELECT in_user_email,in_user_email,in_user_password,in_user_type;
	
    SELECT user_id INTO id FROM atb_user WHERE user_email = in_user_email;
    
	INSERT INTO atb_user_access
		SELECT id,access_dashboard,access_master_list,access_users,access_settings FROM atb_user_type WHERE user_type = in_user_type;
        
	SELECT 'Add User Success' h, 'You have successfully added new user!' m, 'success' s;
        
        
     
END $$
DELIMITER $$