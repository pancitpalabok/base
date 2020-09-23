DROP PROCEDURE IF EXISTS sp_users_list_data;
DELIMITER $$
CREATE PROCEDURE sp_users_list_data(
	 IN in_user_type INT,
     IN in_user_logged_id INT
) BEGIN	
	SELECT
		a.user_id,
		a.user_name,
		a.user_email,
		a.user_locked,
		a.user_date_registered,
		a.user_change_password,
		a.user_img,
        CASE  
			WHEN in_user_logged_id = a.user_id or a.user_id = 1 THEN 1
            ELSE '0' END user_logged,
		b.*,
		c.*
	FROM atb_user a
	INNER JOIN atb_user_type b ON a.user_type = b.user_type
	INNER JOIN atb_user_access c ON a.user_id = c.user_id
	WHERE
		a.user_deleted = 0 AND
		CASE in_user_type
			WHEN 0 THEN 1=1
			ELSE b.user_type = in_user_type
		END;
END $$
DELIMITER $$

CALL sp_users_list_data(0,2)