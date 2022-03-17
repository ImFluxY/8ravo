<?php

class UserModel
{
	protected $id;
	public function getId()
	{
		return $this->id;
	}

	protected $firstname;
	public function getFirstname()
	{
		return $this->firstname;
	}

	protected $lastname;
	public function getLastname()
	{
		return $this->lastname;
	}

	protected $email;
	public function getEmail()
	{
		return $this->email;
	}

	protected $birthdate;
	public function getBirthdate()
	{
		return $this->birthdate;
	}

	protected $type;
	public function gettype()
	{
		return $this->type;
	}
	
	protected $avatar;
	public function getAvatar()
	{
		return $this->avatar;
	}

	protected $banned;
	public function getBanned()
	{
		return $this->banned;
	}

	public function __construct($p1, $p2, $p3, $p4, $p5, $p6, $p7, $p8)
	{
		$this->id = $p1;
		$this->firstname = $p2;
		$this->lastname = $p3;
		$this->email = $p4;
		$this->birthdate = $p5;
		$this->type = $p6;
		$this->avatar = $p7;
		$this->banned = $p8;
	}

	public static function auth($p1, $p2)
	{
		try {
			$cnx = new Base(BASE, USERNAME, PASSWORD);
			$lignes = $cnx->query(
				'select * from users where email=? and password=?',
				array($p1, sha1($p2))
			);
			if (count($lignes) == 0)
				return null;
			else
				return new UserViewer(
					$lignes[0]['id'],
					$lignes[0]['firstname'],
					$lignes[0]['lastname'],
					$lignes[0]['email'],
					$lignes[0]['birthDate'],
					$lignes[0]['type'],
					$lignes[0]['avatar'],
					$lignes[0]['banned']
					
				);
		} catch (PDOException $e) {
			echo $e->getMessage();
			die;
		}
		return null;
	}

	public static function authToken($p1, $p2)
	{
		try {
			$cnx = new Base(BASE, USERNAME, PASSWORD);
			$lignes = $cnx->query(
				'select * from users where email=? and token=?',
				array($p1, $p2)
			);
			if (count($lignes) == 0)
				return null;
			else
				return new UserViewer(
					$lignes[0]['id'],
					$lignes[0]['firstname'],
					$lignes[0]['lastname'],
					$lignes[0]['email'],
					$lignes[0]['birthDate'],
					$lignes[0]['type'],
					$lignes[0]['avatar'],
					$lignes[0]['banned']
				);
		} catch (PDOException $e) {
			echo $e->getMessage();
			die;
		}
		return null;
	}

	public function update($p1, $p2, $p3, $p4, $p5, $p6, $p7, $p8)
	{
		try {
			$cnx = new Base(BASE, USERNAME, PASSWORD);
			$cnx->update(
				"update users set firstname=?, " .
					"lastname=?, email=?, birthDate=?, type=?, banned=?, avatar=? where id=?",
				array($p2, $p3, $p4, $p5, $p6, $p7,$p8, $p1)
			);
			$this->id = $p1;
			$this->firstname = $p2;
			$this->lastname = $p3;
			$this->email = $p4;
			$this->birthdate = $p5;
			$this->type = $p6;
			$this->banned = $p7;
			$this->avatar = $p8;
			return true;
		} catch (PDOException $e) {
			echo $e->getMessage();
			die;
			return false;
		}
		return false;
	}
}
