<?php
	require_once("database.php");
	
	class Infos {
		
		private static $_table="infos";
		
		private $infos;
		
		public function __construct()
		{
			$this->infos=array(
			"i_id"=>null,
			"i_jour"=>null,
			"heure_debut"=>null,
			"heure_fin"=>null,
			"durée"=>null,
			"o_id"=>null
			);
		}
		
		
		public function get_infos()
		{
			return $this->infos;
		}
		
		public function set_infos($key,$value)
		{
			$this->infos[$key]=$value;
		}
		public function find_by_id($id)
		{
			global $db;
			$sql="select * from ".self::$_table;
			$sql.=" where i_id=:id"; 
			$sql.=" limit 1;";
			$re=$db->query($sql,array("id"=>$id));
			$resultat=$re->fetch(PDO::FETCH_ASSOC);
			if(empty($resultat))
			{
				$this->infos=array();
			}else
			{
				$this->infos=$resultat;
			}	
		}
		public function count_all()
		{
			global $db;
			$sql="select count(*) from ".self::$_table.";";
			$re=$db->query($sql);
			$resultat=$re->fetch(PDO::FETCH_ASSOC);
			
			return array_shift($resultat);
		}
		public function create()
		{
			global $db;
			$sql="insert into ".self::$_table;
			$sql.=" (".implode(",",array_keys($this->infos)).")";
			$sql.=" values(:".implode(", :",array_keys($this->infos)).");";
			
			$re=$db->query($sql,$this->infos);
			if($db->affected_rows($re)>0)
			{
				$this->find_by_id($db->last_insert_id());
				return true;
			}else
			{
				
				return false;
			}
		
		}
		public function update()
		{
			global $db;
			$shifted=$this->infos;
			array_shift($shifted);
			$array_key_key=array();
			foreach($shifted as $key => $val)
			{
				$array_key_key[]=$key."=:".$key;
			}
			
			$sql="update ".self::$_table;
			$sql.=" set ".implode(",",$array_key_key);
			$sql.=" where i_id=:i_id;";
			
			$re=$db->query($sql,$this->infos);
			if($db->affected_rows($re)>0)
			{
				
				return true;
			}else
			{
				return false;
			}
		
		}
		public function delete()
		{
			global $db;
			$sql1 ="SET FOREIGN_KEY_CHECKS=0;";
			$db->query($sql1);
			
			$sql="delete from  ".self::$_table;
			$sql.=" where i_id=:i_id;";
			
			$re=$db->query($sql,array("i_id"=>$this->infos["i_id"]));
			if($db->affected_rows($re)>0)
			{
				
				return true;
			}else
			{
				return false;
			}
		}
		public function envoie($o_id)
		{
			global $db;
			$sql="insert 
				into envoie
				values(:o_id,:i_id) ";
				$re=$db->query($sql,array("o_id"=>$o_id,"i_id"=>$this->infos["i_id"]));
				if($db->affected_rows($re)>0)
				{
					return true;
				}else
				{
					
					return false;
				}	
		}

		public static function tous_les_infos()
		{
		
	        global $db;
			$sql="select 
				  i_id,
				  heure_debut,
				  heure_fin,
				  durée,
				  o_id
				  
				  from infos;";	
		   
		    $list=array();
			$re=$db->query($sql);
			$list=$re->fetchAll(PDO::FETCH_ASSOC);
			return $list;
		
		}
		
		public static function tous_infos_ouvrier($o_id,$offset=0,$limit=10)
		{
		
	        global $db;
			$sql="select 

				  i_id,
				  i_jour,
				  heure_debut,
				  heure_fin,
				  durée				  

				  from infos
				  where o_id=:o_id
				  limit  ".$offset.",".$limit.";";	
		   
		    $list=array();
			$re=$db->query($sql,array("o_id"=>$o_id));
			$list=$re->fetchAll(PDO::FETCH_ASSOC);
			return $list;
		
		}
		
		
	}


?>