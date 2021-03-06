<?php

    require("common.php");
    
    if(!empty($_POST))
    {
        $query = "
            SELECT
                1
            FROM users
            WHERE
                username = :username
        ";
        
        $query_params = array(
            ':username' => $_POST['username']
        );
        
        try
        {
            $stmt = $db->prepare($query);
            $result = $stmt->execute($query_params);
        }
        catch(PDOException $ex)
        {
            die("Failed to run query: " . $ex->getMessage());
        }
        
        $row = $stmt->fetch();
        
        if($row)
        {
		echo '0';
		return;
		exit;
        }
        
        
        $query = "
            INSERT INTO users (
                username,
                password,
                salt,
		email,
                unit,
		gender,
		bodyweight
            ) VALUES (
                :username,
                :password,
                :salt,
		:email,
		:unit,
		:gender,
		:bodyweight
            )
        ";
        
        $salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647));
        
        $password = hash('sha256', $_POST['password'] . $salt);
        
        for($round = 0; $round < 65536; $round++)
        {
            $password = hash('sha256', $password . $salt);
        }
        

	$email = "0";
	$unit = $_POST['unit'];
	$gender = $_POST['gender'];
	$bodyweight = $_POST['bodyweight'];

        $query_params = array(
            ':username' => $_POST['username'],
            ':password' => $password,
            ':salt' => $salt,
	    ':email' => $email,
	    ':unit' => $unit,
	    ':gender' => $gender,
	    ':bodyweight' => $bodyweight
        );
        
        try
        {
            $stmt = $db->prepare($query);
            $result = $stmt->execute($query_params);
        }
        catch(PDOException $ex)
        {
            die("Failed to run query: " . $ex->getMessage());
        }
    	echo '1';
	return;
	exit; 
    }
    
?>
