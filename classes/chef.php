<?php

	require_once("database.php");

	class Chef
	{

	  	private static $_table = "chef";
		private $chef;

		public function __construct()
		{
			$this->chef = array(
				"c_id"=>null,
				"c_nom"=>null,
				"c_prenom"=>null
			);
		}
		
		public function get_chef()
		{
			return $this->chef;
		}

		public function set_chef($key, $value)
		{
			$this->chef[$key] = $value;
		}

		public function find_by_id($id)
		{
			global $db;

			$sql = "SELECT * FROM " . self::$_table;
			$sql .= " WHERE c_id=:id"; 
			$sql .= " LIMIT 1;";

			$re = $db->query($sql, array("id"=>$id));
			$resultat = $re->fetch(PDO::FETCH_ASSOC);

			if(empty($resultat))
			{
				$this->chef = array();
			}
			else
			{
				$this->chef = $resultat;
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
			$sql .= " (" . implode(",",array_keys($this->chef)) . ")";
			$sql .= " values(:".implode(", :",array_keys($this->chef)) . ");";
			
			$re = $db->query($sql, $this->chef);

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

			$shifted = $this->chef;
			array_shift($shifted);
			$array_key_key = array();

			foreach($shifted as $key => $val)
			{
				$array_key_key[] = $key . "=:" . $key;
			}
			
			$sql = "UPDATE " . self::$_table;
			$sql .= " SET ". implode(",", $array_key_key);
			$sql .= " WHERE c_id=:c_id;";
			
			$re = $db->query($sql, $this->chef);

			if($db->affected_rows($re) > 0)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		
		public static function chefs()
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