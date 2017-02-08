<?php

	require_once("database.php");
	require_once(__DIR__."/../lib/password.php");

	class Utilisateur
	{

	  	private static $_table = "utilisateur";
		private $utilisateur;

		public function __construct()
		{
			$this->utilisateur = array(
				"u_id"=>null,
				"u_nom"=>null,
				"u_prenom"=>null,
				"username"=>null,
				"u_password"=>null,
				"u_validation"=>null,
			);
		}

		public function authenticate($username, $password)
		{
			global $db;

			$sql = "SELECT u_password FROM " . self::$_table;
			$sql .= " WHERE username=:username";
			$sql .= " LIMIT 1;";

			$re = $db->query($sql, array("username"=>$username));
			$resultat = $re->fetch();
			$resultat = $resultat['u_password'];

			if(password_verify($password,$resultat))
			{
				$this->find_by_username($username);
				return true;
			}else
			{
				return false;
			}
		}


		public function get_utilisateur()
		{
			return $this->utilisateur;
		}


		public function set_utilisateur($key, $value)
		{
			$this->utilisateur[$key] = $value;
		}


		public function find_by_id($id)
		{
			global $db;

			$sql = "SELECT * FROM " . self::$_table;
			$sql .= " WHERE u_id=:id";
			$sql .= " LIMIT 1;";

			$re = $db->query($sql, array("id"=>$id));
			$resultat = $re->fetch(PDO::FETCH_ASSOC);

			if(empty($resultat))
			{
				$this->utilisateur = array();
			}
			else
			{
				$this->utilisateur = $resultat;
			}
		}

		public function find_by_username($username)
		{
			global $db;
			$sql="select * from ".self::$_table;
			$sql.=" where username=:username";
			$sql.=" limit 1;";
			$re=$db->query($sql,array("username"=>$username));
			$resultat=$re->fetch(PDO::FETCH_ASSOC);
			if(empty($resultat)) {
				$this->utilisateur=array();
			} else {
				$this->utilisateur=$resultat;
			}
		}

		public function count_all()
		{
			global $db;

			$sql = "SELECT COUNT(*) FROM " . self::$_table . ";";

			$re = $db->query($sql);
			$resultat = $re->fetch(PDO::FETCH_ASSOC);

			return array_shift($resultat);
		}


		public function create()
		{
			global $db;

			$sql = "INSERT INTO " . self::$_table;
			$sql .= " (" . implode(",",array_keys($this->utilisateur)) . ")";
			$sql .= " values(:".implode(", :",array_keys($this->utilisateur)) . ");";

			$re = $db->query($sql, $this->utilisateur);

			if($db->affected_rows($re) > 0)
			{
				$this->find_by_id($db->last_insert_id());
				return true;
			}
			else
			{
				return false;
			}

		}


		public function update()
		{
			global $db;

			$shifted = $this->utilisateur;
			array_shift($shifted);
			$array_key_key = array();

			foreach($shifted as $key => $val)
			{
				$array_key_key[] = $key . "=:" . $key;
			}

			$sql = "UPDATE " . self::$_table;
			$sql .= " SET ". implode(",", $array_key_key);
			$sql .= " WHERE u_id=:u_id;";

			$re = $db->query($sql, $this->utilisateur);

			if($db->affected_rows($re) > 0)
			{
				return true;
			}
			else
			{
				return false;
			}
		}

		public static function utilisateurs()
		{
			global $db;

			$sql = "SELECT *
				    FROM ".self::$_table.";";

		    $list = array();
			$re = $db->query($sql);
			$list = $re->fetchAll(PDO::FETCH_ASSOC);

			return $list;
		}

	}


?>
