<?php
/**
 * @author M�rcio Ramos e-mail: marciomrs4@hotmail.com
 * @name File Upload
 * @example Essa classe � utilizada para enviar arquivos para o sistema
 * @package script
 * @version 1.0 Data 12/11/2015
 * 
 */
class FileCopy
{	

	const PATH = DirectoryCreate::PATH;

	const PROJETOS = DirectoryCreate::PROJETOS;
	const CHAMADOS = DirectoryCreate::CHAMADOS;
	const MELHORIA = DirectoryCreate::MELHORIA;
	const RNC = DirectoryCreate::RNC;
	const DS = DirectoryCreate::DS;

	private $chamado;
	private $rnc;



	public function setChamado($chamado)
	{
		$this->chamado = $chamado;
		return $this;
	}

	public function setRnc($rnc)
	{
		$this->rnc = $rnc;
		return $this;
	}

	public function copyChamadoToRnc()
	{

		$dir = new DirectoryIterator(self::PATH.self::CHAMADOS.$this->chamado);

		foreach($dir AS $file){

			if($file->isDot()){ continue; }

			$oldfile = self::PATH.self::CHAMADOS.$this->chamado.self::DS.$file->getFilename();

			$newfile = self::PATH.self::RNC.$this->rnc.self::DS.$file->getFilename();

			if(copy($oldfile,$newfile)){
				$file->getFilename();
			}else{
				$file->getFilename();
			}
		}


	}


}

?>