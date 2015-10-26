<?php
	/**
	 * To Authenticate the user
	 * Id: Login-2.php
	 *
	 * Developed By: Chandrashekar Venkatesh
	 */
	
	require_once( "./include/Vars.php" );
	require_once( "./include/Utils-Misc.php" );
	require_once( "./include/adodb/adodb.inc.php" );
	
	$userName = $_POST['userName'];
	$password = $_POST['password'];
	
	$con = &AdoNewConnection( $system_db_dbtype );
	$con->Connect( $system_db_server, $system_db_username, $system_db_password, $system_db_dbname );
	
	/*$con->debug = 1;*/
	
	session_start( );
	session_unset( );
	session_destroy( );
	session_start( );
	
	$userId = "";
	$groupId = "";
	
	$sqlLoginCheck = "SELECT
							id,
							userName,
							password,
							groupId
						FROM
							master
						WHERE
							userName = " . $con->qstr( $userName, get_magic_quotes_gpc( ) ) . "
						AND
							password = " . $con->qstr( $password, get_magic_quotes_gpc( ) ) . "
						AND
							isLoginActive = 'y'
						AND
							recordStatus = 'a'";
	
	
	$rstLoginCheck = $con->Execute( $sqlLoginCheck );
	
	if( $rstLoginCheck && !$rstLoginCheck->EOF )
	{
		$_SESSION['userName'] = $rstLoginCheck->fields['userName'];
		$_SESSION['userId'] = $rstLoginCheck->fields['id'];
		$_SESSION['groupId'] = $rstLoginCheck->fields['groupId'];
		$_SESSION['password'] = $rstLoginCheck->fields['password'];
		echo $rstLoginCheck->fields['password'];
		$userId = $rstLoginCheck->fields['id'];
		$groupId = $rstLoginCheck->fields['groupId'];
		
		$rstLoginCheck->Close( );
	}
	else
	{
		echo "<script> location.href = '".$http_site_root."Login.php?msg=notAuth'; </script>";
	}
	
	echo $_SESSION['userName'];
	if( $groupId == 1 )
	{
		//echo "<script> location.href = '".$http_site_root."Admin/Home.php'; </script>";
	}
	else if( $groupId == 2 )
	{
		/*echo "<script> location.href = 'Student/Home.php'; </script>";*/
		//Temporary Redirection
		echo "<script> location.href = '".$http_site_root."index1.php'; </script>";
	}
	else
	{
		echo "<script> location.href = '".$http_site_root."Login.php?msg=notAuth'; </script>";
	}
	
?>
