<?php

class UserViewer extends UserModel
{
	public function getFullName()
	{
		return $this->firstname." ".$this->lastname;
	}

	public function getTypeName()
	{
		$returnValue = "";

		switch ($this->type) {
			case 0:
				$returnValue = "Membre";
				break;
			case 1:
				$returnValue = "Créateur";
				break;
			case 2:
				$returnValue = "Administrateur";
				break;
		}

		return $returnValue;
	}

	public function getTypeIndex()
	{
		return $this->type;
	}
}