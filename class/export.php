<?php
require 'csv.php';
require 'vcf.php';

class Export
{
	static string $filename = 'Liste des contacts';

	static function downloadVCF($connection, $id)
	{
		$datas = array();
		$update = $connection->prepare('SELECT * FROM numero WHERE id >= ?');
		$update->execute(array(
			$id,
		));
		while ($result = $update->fetch(PDO::FETCH_OBJ)) {
			$datas[] = array(
				'nom' => $result->nom . "" . $result->id,
				'numero' => $result->numero,
			);
		}
		VCF::Export($datas, self::$filename);
	}

	static function downloadCSV($connection, $id)
	{
		$datas = array();
		$update = $connection->prepare('SELECT * FROM numero WHERE id >= ?');
		$update->execute(array(
			$id,
		));
		while ($result = $update->fetch(PDO::FETCH_OBJ)) {
			$datas[] = array(
				'Name' => $result->nom . "" . $result->id,
				'Phone 1 - Type' => 'Mobile',
				'Phone 1 - Value' => $result->numero,
			);
		}
		CSV::Export($datas, self::$filename);
	}
	static function exportContacts(string $format, int $id, PDO $connection): void
	{
		if ($format == "csv") {
			self::downloadCSV($connection, $id);
		} else {
			self::downloadVCF($connection, $id);
		}
	}
}
