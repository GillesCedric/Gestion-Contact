<?php

class Import
{
	private array $file;
	private string $chemin;
	private PDO $connection;
	private array $extensions = array('pdf', 'txt', 'doc', 'docx');

	public function __construct(array $file, PDO $connection)
	{
		$this->file = $file;
		$this->chemin = "files/" . $this->file['name'];
		$this->connection = $connection;
	}

	public function validExtension(): bool
	{
		$extensionsupload = strtolower(substr(strrchr($this->file['name'], '.'), 1));
		if (in_array($extensionsupload, $this->extensions)) {
			return true;
		}
		return false;
	}
	public function saveFileInDatabase(): void
	{
		$update = $this->connection->prepare('INSERT INTO fichier (nom,url) VALUES (?,?)');
		$update->execute(array(
			$this->file['name'],
			$this->chemin
		));
	}
	public function saveContactInDatabase(string $contact)
	{
		$values = explode(',', $contact);
		foreach ($values as $key => $value) {
			$val = str_replace(' ', '', str_replace('-', '', $value));
			$update = $this->connection->prepare('INSERT INTO numero (nom,numero) VALUES (?,?)');
			$update->execute(array(
				'client',
				$val
			));
		}
	}
	public function readFile(): string
	{
		$fichier = fopen($this->chemin, 'r');
		while ($line = fgets($fichier)) {
			$this->saveContactInDatabase($line);
		}
		fclose($fichier);
		return "Enregistrement des contacts terminé";
	}
	public function moveFile(): string
	{
		if ($this->validExtension()) {
			if (move_uploaded_file($this->file['tmp_name'], $this->chemin)) {
				$this->saveFileInDatabase();
				return "L'importation a réussi";
			}
		}
		return "L'extension du fichier n'est pas compatible";
	}
}
