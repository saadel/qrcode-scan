<?php

class Session {

	private  $_logged_in = false;
	private  $_user_id;
	private $_message;
	

	public function __construct()
	{
	      session_start();

		  $this->is_there_any_msg();
		  $this->is_there_cookie();
		  $this->check_login();		 
	}


	public function is_loggedin()
	{
		return  $this->_logged_in;
	}

	public function get_user_id()
	{
		return $this->_user_id;
	}


	public function set_user_id($id)
	{
		if (is_int($id))
		{
			$this->_user_id = $id;
		}
		else
		{
			die("var id is not an int");
		}
	}

	public function login($id, $utilisateur)
	{
		$_SESSION["user_id"] = $id;
		$_SESSION["utilisateur"] = $utilisateur;

		$this->_logged_in = true;
		$this->_user_id = $id;
		$this->_utilisateur = $utilisateur;
	}

	public function logout()
	{
		if ($this->_logged_in)
		{
			$this->_logged_in = false;
			$this->_utilisateur = false;

			unset($_SESSION["user_id"]);
			unset($_SESSION["utilisateur"]);
			unset($this->_user_id);

			setcookie("auth", "", time(), "/", "localhost", false, true);
		}
	}


	public function check_login()
	{
		if(isset($_SESSION["user_id"]))
		{
		    $this->_user_id = $_SESSION["user_id"];
			$this->_utilisateur = $_SESSION["utilisateur"];
			$this->_logged_in = true;	
		}
		else
		{
			$this->_logged_in = false;
			$this->_utilisateur = false;
			unset($this->_user_id);
		}
	}


	public function is_there_any_msg()
	{
		if(isset($_SESSION["message"]))
		{
			$this->_message = $_SESSION["message"];
			unset($_SESSION["message"]);
		}
		else
		{
			$this->_message="";
		}
	}


	public function message($msg = "")
	{
		if(!empty($msg))
		{
			$_SESSION["message"] = $msg;
		}
		else
		{	
			return $this->_message;
		}
	}


	public function remember_me()
	{
		setcookie("auth", $this->_user_id."-".$this->_utilisateur, time()+3600*24*7, "/", "localhost", false, true);
	}

	public function is_there_cookie()
	{
		if(!isset($_SESSION["user_id"]) && isset($_COOKIE["auth"]))
		{
			$data_array = explode("-", $_COOKIE["auth"]);
			$_SESSION["user_id"] = $data_array[0]; 
			$_SESSION["utilisateur"] = $data_array[1];
		}
	}
	
}
?>