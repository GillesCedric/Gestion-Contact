<?php
class VCF
{

	static function Export($datas, $filename)
	{
		header('Content-type: text/vcf;');
		header('Content-Disposition: attachment; filename="' . $filename . '.vcf"');
		foreach ($datas as $d) {
			echo "BEGIN:VCARD" . "\n" . "VERSION:2.1" . "\n" . "N:;" . $d['nom'] . ";;;" . "\n" . "FN:" . $d['nom'] . "\n" . "TEL;CELL:" . $d['numero'] . "\n" . "END:VCARD" . "\n";
		}
	}
}
