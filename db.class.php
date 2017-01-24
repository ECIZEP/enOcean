<?php

	require_once("db_config.php");   //include configuration
	/**
	* DataBase Manager Class
	*/
	class DBManager {

		private static $host = DB_HOST;            //the host
  		private static $username = DB_USER;        //username for db
	  	private static $password = DB_PASSWORD;    //password for db
	  	private static $dbname = DB_NAME;          //the name of database
	  	private static $connect;            	   //temporary variable for connecting
		
		private function __construct($host=DB_HOST ,$username=DB_USER,$password=DB_PASSWORD,$dbname=DB_NAME) {
			$this->host = $host;
			$this->username = $username;
			$this->password = $password;
			$this->dbname = $dbname;
		}


		//connect the database
		//after using ,this connection must be disconnected 
		public static function connect_mysql() {
			self::$connect = mysql_connect(self::$host,self::$username,self::$password);
			if(!self::$connect) {
				die("mysql error:".mysql_error());
			}
			//set the character-set for writing and reading database
			//otherwise chinese character will be in mess
			mysql_query("set names utf8");
			mysql_select_db(self::$dbname);
		}

		//close the connection of the database
		public static function close_mysql(){
			if(self::$connect){
				mysql_close(self::$connect);
			}
		}	

		//query mysql by sql statemeny,but return the result in Array
		public static function query_mysql($sql_str){
			self::connect_mysql();
			$result = mysql_query($sql_str);
			$result_array = array();
			$i = 0;
			while ( $row = mysql_fetch_array($result)) {
				if($row){
					$result_array[$i] = $row;
					$i++;
				}
			}
			self::close_mysql();
			return $result_array;
		}

		//update statement,return true or false
		public static function update_mysql($sql){
			self::connect_mysql();
        	$isUpdated = mysql_query($sql);
        	self::close_mysql();
        	return $isUpdated;
		}

		//for profile page,get all account's information by username
		//return type:array
		public static function query_account_by_username($username){
			$sql = "select * from account where username ='{$username}'";
			return self::query_mysql($sql)["0"];
		}

		//register
		public static function register_account($sql,$username){
        	self::connect_mysql();
        	if(!mysql_query($sql)) {
            	return false;        	
            }
        	self::close_mysql();
        	//create directory for every account to store some files,such as Avatar
        	if(!is_dir("./upload/{$username}")){
        		mkdir("./upload/{$username}");
        	}
        	return true;
		}

		
	}


?>