<?php
if(isset($_POST['urid'])){
	
	$servername = "localhost";
	$username = "root";
	$password = "Ishop#123";
	$dbname = "ishop";
	
	// Create connection
	$conn = mysql_connect($servername,$username,$password,$dbname);
	// Check connection
	if (!$conn) {
		die("Connection failed: " . mysql_error());
	}

	mysql_select_db($dbname,$conn) or die("Could not select Database");

	$ipAddress = $_SERVER['REMOTE_ADDR'];
	if (array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER)) {			 
		$ipAddress = $_SERVER["HTTP_X_FORWARDED_FOR"];
	}		

	$dbquery = mysql_query("SELECT count(*) allow FROM oc_agent_ipallow where instr( '" . $ipAddress. "' , ipaddr) = 1");
	while ($row = mysql_fetch_array($dbquery, MYSQL_ASSOC)) {
		
		if ($row['allow'] == '1'){
			
			$urid = $_POST['urid'];
			$urlogin = $_POST['urlogin'];
			$urpwd = $_POST['urpwd'];
			$urfname = $_POST['urfname'];
			$urlname = $_POST['urlname'];
			$md5 = md5(uniqid(rand(), true));
			$salt = substr($md5,0,9);
			$pwd = sha1($salt . sha1($salt . sha1($urpwd)));
			
			$result1 = mysql_query("SELECT count(*) cnt FROM oc_user  WHERE agent_id = '" . $urid. "' and status = '1'");
			while ($row1 = mysql_fetch_array($result1, MYSQL_ASSOC)) {
				//echo $row1['cnt'];

			if ($row1['cnt'] == '1'){
				$sql = "UPDATE oc_user SET username = '" . $urlogin . "', salt = '" . $salt . "', password = '" . $pwd . "', firstname = '" . $urfname . "', lastname = '" . $urlname . "' WHERE agent_id = '" . $urid. "' and status = '1'";

				if (mysql_query($sql, $conn)) {
					echo "Update User Success ";
				} else {
					echo "Error!! Update User NOT Success. pls contact Technical ";
				}
			
			} elseif ($row1['cnt'] == '0') {
				
				$sql = "INSERT INTO oc_user SET username = '" . $urlogin . "', user_group_id = '11', salt = '" . $salt . "', password = '" . $pwd . "', firstname = '" . $urfname . "', lastname = '" . $urlname . "', agent_id = '" . $urid . "', status = '1', date_added = NOW()";

				if (mysql_query($sql, $conn)) {
					echo "Insert User Success ";
				} else {
					echo "Error!! Insert User NOT Success. pls contact Technical ";
				}
		
			} else {
				
				echo "ไม่สามารถเพิ่ม User ให้ได้ รบกวนติดต่อ Technical";
				
			}				
				
			}
			mysql_free_result($result1);
			
		} else {
			
			//$vblock = true;
			$sql = "INSERT INTO oc_agent_block SET agentid ='bug add user',  remoteip = '". $ipAddress ."' ";
			if (mysql_query($sql, $conn)) {						
				echo "Insert IP block Success ";
			} else {
				echo "Error!! Insert IP block NOT Success. pls contact Technical ";
			}			
			
		}
	}
	mysql_free_result($dbquery);
	
	mysql_close($conn);
	
} else {
	
	echo "Error!!! Please Login Again ";
}			
?>