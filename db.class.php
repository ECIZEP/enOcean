<?php

	require_once("db_config.php");   //引入配置常量文件
	/**
	* 数据库连接类
	*/
	class DBManager {

		private static $host = DB_HOST;            //服务器
  		private static $username = DB_USER;        //数据库用户名
	  	private static $password = DB_PASSWORD;        //数据密码
	  	private static $dbname = DB_NAME;          //数据库名
	  	private static $connect;            //数据库连接变量
		
		private function __construct($host=DB_HOST ,$username=DB_USER,$password=DB_PASSWORD,$dbname=DB_NAME) {
			$this->host = $host;
			$this->username = $username;
			$this->password = $password;
			$this->dbname = $dbname;
		}


		//连接数据库
		public static function connect_mysql() {
			self::$connect = mysql_connect(self::$host,self::$username,self::$password);
			if(!self::$connect) {
				die("mysql error:".mysql_error());
			}
			mysql_query("set names utf8");
			mysql_select_db(self::$dbname);
		}

		//关闭数据库
		public static function close_mysql(){
			if(self::$connect){
				mysql_close(self::$connect);
			}
		}	

		//查询数据库，返回一个数组
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

		//更新数据库
		public static function update_mysql($sql){
			self::connect_mysql();
        	$isUpdated = mysql_query($sql);
        	self::close_mysql();
        	return $isUpdated;
		}

		public static function query_account_by_username($username){
			$sql = "select * from account where username ='{$username}'";
			return self::query_mysql($sql)["0"];
		}

		//注册用户
		public static function register_account($sql,$username){
        	self::connect_mysql();
        	if(!mysql_query($sql)) {
            	return false;        	
            }
        	self::close_mysql();
        	//创建用户信息文件夹
        	if(!is_dir("./upload/{$username}")){
        		mkdir("./upload/{$username}");
        	}
        	return true;
		}

		
	}


?>