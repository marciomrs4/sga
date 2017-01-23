<?php
/**
 * @author M�rcio Ramos e-mail: marciomrs4@hotmail.com
 * @name File Upload
 * @example Essa classe � utilizada para enviar arquivos para o sistema
 * @package script
 * @version 1.0 Data 12/11/2015
 * 
 */
class FileUpload
{	

	const PATH = DirectoryCreate::PATH;

	const PROJETOS = DirectoryCreate::PROJETOS;
	const CHAMADOS = DirectoryCreate::CHAMADOS;
	const MELHORIA = DirectoryCreate::MELHORIA;
	const RNC = DirectoryCreate::RNC;

	private $file;
	private $erro;
	private $diretoryDestiny;

	/**
	 * @param $file
	 * Seta o arquivo fala upload
	 */
	public function setFile($file)
	{
		$this->file = $file;
		return $this;
	}

	/**
	 * @param $diretoryDestiny
	 * seta o destino
	 */
	public function setDestination($diretoryDestiny)
	{
		$this->diretoryDestiny = $diretoryDestiny;
		return $this;
	}

	/**
	 * Move o arquivo para o destination
	 */
	public function moveUploaded()
	{
		$this->erro = move_uploaded_file($this->file, $this->diretoryDestiny);
		return $this;
	}

	public function getErro()
	{
		if($this->erro){
			return 'Upload com sucesso';
		}else{
			return 'Houve algum problema ao enviar o arquivo';
		}
	}

	public function validateSizeFile($file, $size = 5000000)
	{

		if($file >= $size)
		{
			throw new \Exception('Arquivo Excede o limite de tamanho de 5MB');
		}
	}

}

?>