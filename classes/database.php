<?php
require(__DIR__."/../includes/config.php");

class Database{

	protected $_db;
	
	public function __construct()
	{
		$this->set_db();
	}

	public function set_db()
	{
		$this->_db = new PDO('mysql:host=' . DB_SERVER . ';dbname=' . DB_NAME . ';charset=gbk', DB_USER, DB_PASS);	
	}

	public function close_connection()
	{
		$this->_db = null;
	}

	public function query($sql, $data = array())
	{
		$q = $this->_db->prepare($sql);
		$q->execute($data); 	
	 	return $q;
	}

	public function last_insert_id()
	{
		return $this->_db->lastInsertId();
	}

	public function affected_rows($re)
	{
		return $re->rowCount();	
	}
}

$db = new Database();
/*
	$sql="insert into etudiant (E_nom,E_prenom) values (:E_nom,:E_prenom)";
	$data=array("E_nom"=>"otmane","E_prenom"=>"el guenouni");
	$re=$db->query($sql,$data);
	echo $db->affected_rows($re)."<br>";
	echo $db->last_insert_id()."<br>";

	$db->close_connection();
*/

?>