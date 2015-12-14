<?php
/**
 * @author M�rcio Ramos e-mail: marciomrs4@hotmail.com
 * @name File Upload
 * @example Essa classe � utilizada para enviar arquivos para o sistema
 * @package script
 * @version 1.0 Data 12/11/2015
 * 
 */
class DirectoryCreate
{	

	const PATH = '/var/www/sga/files/';

	const PROJETOS = 'projetos/';
	const CHAMADOS = 'chamados/';
	const MELHORIA = 'melhoria/';
	const RNC = 'rnc/';
	const DS = DIRECTORY_SEPARATOR;

	private function createDir($path)
	{
		mkdir($path);
	}

	public function getFile()
	{
		return self::PATH.self::CHAMADOS;
	}

	public function createDirChamados($codigo)
	{
		$this->createDir(self::PATH.self::CHAMADOS.$codigo);
	}

	public function createDirProjetos($codigo)
	{
		$this->createDir(self::PATH.self::PROJETOS.$codigo);
	}

	public function createDirMelhoria($codigo)
	{
		$this->createDir(self::PATH.self::MELHORIA.$codigo);
	}

	public function createDirRnc($codigo)
	{
		$this->createDir(self::PATH.self::RNC.$codigo);
	}


}

?>