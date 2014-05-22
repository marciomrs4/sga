<?php

class Table
{

	/**
	 * Descrição ...
	 * @var string
	 * @example Inserir o nome da classe CSS para linha
	 * csslinha1 = 'cssnome'
	 */
	public $css = 'table table-striped table-bordered table-condensed table-hover';


	/**
	 * 
	 * @var id
	 */
	public $id = 'table-bootstrap';
	
	/**
	 * Descrição ...
	 * @var bolean
	 * @example Inserir valor boleano para poder aparecer o link
	 * com javascript
	 * islinkJavasript = true
	 */
	public $colunaoculta = 0;

	/**
	 * Descrição ...
	 * @var bolean
	 * @example Inserir valor boleano para poder aparecer o link
	 * islink = true
	 */
	
	/**
	 * Descrição ...
	 * @var array
	 * @example dados que devem ser mostrados na tabela
	 * dados = tabeladedados
	 */
	public $dados;

	/**
	 * Descrição ...
	 * @var array
	 * @example Nomes para o titulo de cada coluna
	 * cabecalho = titulodascolunas
	 */
			
	public $cabecalho;

	
	public $function;
	
	public $columnNumber;

	/**
	 *
	 * Enter description here ...
	 * @param array $cabecalho
	 * @param array $dados
	 * @author
	 */
	public function __construct($cabecalho = NULL,$dados = NULL)
	{
		$this->setDados($dados);
		$this->setCabecalho($cabecalho);
	}

	public function setDados($dados)
	{
		$this->dados = $dados;
	}
	
	public function setCabecalho($cabecalho)
	{
		$this->cabecalho = $cabecalho;
	}
	
	/**
	 *
	 * Enter description here ...
	 * @example Metodo que cria o cabeçalho baseado no array informado no
	 * construtor
	 */
	
	private function criaCabecalho()
	{

		echo("<table class='{$this->css}' id='{$this->id}'>
				<thead>
					<tr class='info'>");				
				foreach ($this->cabecalho as $cabecalho):
					echo("<th><a href='#'>{$cabecalho}</a></th>");
				endforeach;
				
				echo("</tr>");
		 echo("</thead>");
	}


	public function setFunctionColumn($function, $columnNumber)
	{
		$this->function = $function;
		$this->columnNumber = $columnNumber;
	}
	
	public function getFunctionColumn($column,$count)
	{
		$function = $this->function;
		
		if(function_exists($function)){
				
			if($this->columnNumber == $count){
				
				return $function($column);
			}else{
				return $column;
			}
		}else{
				
			return $column;
		}
	}
	
	/**
	 *
	 * Enter description here ...
	 * @example Metodo que cria a tabela com os dados iformados no contrutor
	 */
	private function criaTabela()
	{
		$linha = 0;
		
		foreach ($this->dados as $campo)
		{
			
			$this->coluna = count($campo) / 2;
			echo("<tr>");			
					
			for($x = $this->colunaoculta; $x < $this->coluna ; $x++)
			{
				
				echo("<td>{$this->getFunctionColumn($campo[$x],$x)}</td>");
			}
			$linha++;
			echo('</tr>');
		}
		echo('</table>');
	}

	/**
	 *
	 * Enter description here ...
	 * @param int $campo
	 * @example Criar as colunas de link com o ID que deve ser a primeira posicao
	 * do array informado no array dados no construtor
	 */
	
	/**
	 * @example Metodo que mostra a tabela na tela, chamando todos
	 * os metodos anteriores
	 */
	public function mostrarDatagrid()
	{
			self::criaCabecalho();
			self::criaTabela();
	}
}
?>