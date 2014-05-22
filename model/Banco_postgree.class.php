<?php
/**
 *
 *@author Márcio Ramos
 *@version Fevereiro 2011
 *@name Banco
 *@example Classe abstrata para conectar ao banco
 */
abstract class Banco_postgree
{

	private $user = 'ceadis';
	private $password = 'ceadis2011';
	private $tipobanco = 'pgsql';
	private $database = 'ceadis';
	private $server =  '172.22.0.33';


/*	private $user = 'teste';
	private $password = 'teste';
	private $tipobanco = 'pgsql';
	private $database = 'ceadis_teste';
	private $server =  '192.168.31.225';
*/
	/**
	 *@name PDO
	 *@uses conexao
	 *@example para fazer conexao
	 */
	protected $conexao;

	public function __construct()
	{
		try{
			//$this->conexao = new PDO($this->tipobanco.':host='.$this->server.';dbname='.$this->database,$this->user,$this->password,array(PDO::ATTR_PERSISTENT => true));
				
			$this->conexao = new PDO("$this->tipobanco:host=$this->server;dbname=$this->database;user=$this->user;password=$this->password");
				
			$this->conexao->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		}
		catch (PDOException $e)
		{
			echo 'ERRO: '.$e->getMessage().' COD: '.$e->getCode().' Arquivo '.$e->getFile();
		}
	}
}

// $pdoConnection = new PDO("pgsql:host=hostname;dbname=databasename;user=username;password=thepassword");
?>
