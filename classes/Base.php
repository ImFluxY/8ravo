<?php


class Base
{
	private $db;

	public function __construct()
	{
		$this->db=new PDO('mysql:host=localhost;dbname='.BASE.';charset=utf8', USERNAME, PASSWORD);
		$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	
	public function delete($sql, $params=null)
	{
		$stmt = $this->db->prepare($sql);
		$stmt->execute($params==null?array():$params);
	}

	public function query($sql, $params=null)
	{
		$stmt = $this->db->prepare($sql);
		$stmt->execute($params==null?array():$params);
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function insert($sql, $params=null)
	{
		$stmt = $this->db->prepare($sql);
		$stmt->execute($params==null?array():$params);
		return $this->db->lastInsertId();
	}

	public function update($sql, $params=null)
	{
		$stmt = $this->db->prepare($sql);
		$stmt->execute($params==null?array():$params);
	}

	public function lastId()
	{
		return $this->db->lastInsertId();
	}

	public function close()
	{
		$this->db=null;
	}
	
	public function __destruct()
	{
		$this->close();
	}
	
}

?>