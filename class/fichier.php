<?php

class Fichier
{

	static function getFichiersInDatabase(PDO $connexion): array
	{
		$datas = array();
		$update = $connexion->query("SELECT * FROM fichier");
		while ($result = $update->fetch(PDO::FETCH_OBJ)) {
			$datas[] = array(
				'nom' => $result->nom,
				'url' => $result->url,
			);
		}
		return $datas;
	}
}
