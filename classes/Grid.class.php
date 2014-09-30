<?php

class Grid
{

	/**
	 * Descrição ...
	 * @var string
	 * @example Inserir o nome da classe CSS para linha
	 * csslinha1 = 'cssnome'
	 */
	public $css = 'table table-striped table-bordered table-condensed table-hover';
				 //table table-striped table-bordered table-condensed table-hover


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
	private $dados;

	/**
	 * Descrição ...
	 * @var array
	 * @example Nomes para o titulo de cada coluna
	 * cabecalho = titulodascolunas
	 */
			
	private $cabecalho;

	private $function = array();
	
	private $columnNumber;

	private $option;
	
	
	/**
	 *
	 * Enter description here ...
	 * @param array $cabecalho
	 * @param array $dados
	 * @author
	 */
	public function __construct($cabecalho = NULL,$dados = NULL)
	{
		$this->setDados($dados)
			 ->setCabecalho($cabecalho);
	}

	public function setDados($dados)
	{
		$this->dados = $dados;
		return $this;
	}
	
	public function setCabecalho($cabecalho)
	{
		$this->cabecalho = $cabecalho;
		return $this;
	}
	
	
	
	/**
	 *
	 * Enter description here ...
	 * @example Metodo que cria o cabeçalho baseado no array informado no
	 * construtor
	 */
	
	private function criarCabecalho()
	{

		echo("<table class='{$this->css}' id='{$this->id}'>
				<thead>
					<tr class='active'>");				
				foreach ($this->cabecalho as $cabecalho):
					echo("<th><a href='#'>{$cabecalho}</a></th>");
				endforeach;
				
				echo("</tr>");
		 echo("</thead>
		 	<tbody>");
		 
		 return $this;
	}


	public function addFunctionColumn($function, $columnNumber)
	{
		$this->function[$columnNumber] = $function;
		$this->columnNumber[$columnNumber] = $columnNumber;
		
		return $this;
	}
	
	private function getFunctionColumn($column, $columnNumber)
	{
		$function = '';
		
		if(array_key_exists($columnNumber, $this->function)){
			$function = $this->function[$columnNumber];
		}
		
		if(is_callable($function)){
			if($this->columnNumber[$columnNumber] == $columnNumber){		
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
	private function criarTabela()
	{
		
		$enableOption = 0;
		
		foreach ($this->dados as $campo){
			
			#Recria o array de forma númerica
			$campo 	 = array_values($campo);
			#Conta quantas colunas eu tenho em cada linha
			$colunas = count($campo);
			
			#Serve para mostrar o Option se for uma instancia de IOption
			if($this->option[0] instanceof IOption){
				$enableOption = 1;				
			}

						
			echo("<tr>");			
			
			for($x = $this->colunaoculta; $x < $colunas ; $x++){
			    
    				if($enableOption == 1){

   				    	echo '<td class="col-md-1">
								<div class="btn-group">
	           						<button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
	               						Opções <span class="caret"></span>
	           						</button>
	             				<ul class="dropdown-menu" role="menu">';    				    	
					             foreach ($this->option as $option){
				    				  	echo $option->createOption($campo[0]);
					             }

    					   echo'</ul>
	          					</div>';
							'</td>';
    					  #Serve para mostrar o Option Apenas uma vez
    					  $enableOption = 0;
			    }

				
				echo("<td>
						{$this->getFunctionColumn($campo[$x],$x)}
					</td>");
			}
			
			echo('</tr>');
		}
		
		echo('</tbody>
			</table>');
	}
	
	public function addOption($option)
	{
	   $this->option[] = $option;
	   return $this;
	}

	
	/**
	 * @example Metodo que mostra a tabela na tela, chamando todos
	 * os metodos anteriores
	 */
	public function show($show=true)
	{
		if($show){
			$this->criarCabecalho()
			->criarTabela();			
		}

	}
}
?>