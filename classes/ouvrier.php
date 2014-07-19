<?php

	require_once("database.php");

	class Ouvrier
	{

	  	private static $_table = "ouvrier";
		private $ouvrier;
		

		public function __construct()
		{
			$this->ouvrier = array(
				"o_id"=>null,
				"o_nom"=>null,
				"o_prenom"=>null,
				"qrcode"=>null,
				"c_id"=>null
			);
		}
		
	

		public function get_ouvrier()
		{
			return $this->ouvrier;
		}


		public function set_ouvrier($key, $value)
		{
			$this->ouvrier[$key] = $value;
		}


		public function find_by_id($id)
		{
			global $db;

			$sql = "SELECT * FROM " . self::$_table;
			$sql .= " WHERE o_id=:id"; 
			$sql .= " LIMIT 1;";

			$re = $db->query($sql, array("id"=>$id));
			$resultat = $re->fetch(PDO::FETCH_ASSOC);

			if(empty($resultat))
			{
				$this->ouvrier = array();
			}
			else
			{
				$this->ouvrier = $resultat;
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
			$sql .= " (" . implode(",",array_keys($this->ouvrier)) . ")";
			$sql .= " values(:".implode(", :",array_keys($this->ouvrier)) . ");";
			
			$re = $db->query($sql, $this->ouvrier);

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

		public function delete()
		{
			global $db;
			$sql = "DELETE FROM " . self::$_table;
			$sql .= " WHERE o_id=:o_id;";			
			$re = $db->query($sql, array("o_id"=>$this->ouvrier["o_id"]));
			if($db->affected_rows($re) > 0)
			{
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

			$shifted = $this->ouvrier;
			array_shift($shifted);
			$array_key_key = array();

			foreach($shifted as $key => $val)
			{
				$array_key_key[] = $key . "=:" . $key;
			}
			
			$sql = "UPDATE " . self::$_table;
			$sql .= " SET ". implode(",", $array_key_key);
			$sql .= " WHERE o_id=:o_id;";
			
			$re = $db->query($sql, $this->ouvrier);

			if($db->affected_rows($re) > 0)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
	
		public function attache($c_id)
		{
			global $db;
			$sql="insert 
				into ouvrier
				values(:c_id,:o_id) ";
				$re=$db->query($sql,array("c_id"=>$c_id,"o_id"=>$this->ouvrier["o_id"]));
				if($db->affected_rows($re)>0)
				{
					return true;
				}else
				{
					
					return false;
				}	
		}

		public static function ouvriers()
		{
			global $db;

			$sql = "SELECT *
				    FROM ".self::$_table.";";	
		   
		    $list = array();
			$re = $db->query($sql);
			$list = $re->fetchAll(PDO::FETCH_ASSOC);
			
			return $list;
		}

		public static function liste_ouvriers_chef($c_id,$offset=0,$limit=10)
	{
	
        global $db;
		$sql="select 
			  o_id, o_nom, o_prenom
			  from ouvrier
			  where c_id=:c_id
			  limit  ".$offset.",".$limit.";";	
	   
	    $list=array();
		$re=$db->query($sql,array("c_id"=>$c_id));
		$list=$re->fetchAll(PDO::FETCH_ASSOC);
		return $list;
	
	}
		
	}


?>