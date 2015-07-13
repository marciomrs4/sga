<?php

class Grid implements IGrid
{

	/**
	 * Descri��o ...
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
	 * Descri��o ...
	 * @var bolean
	 * @example Inserir valor boleano para poder aparecer o link
	 * com javascript
	 * islinkJavasript = true
	 */
	public $colunaoculta = 0;

	/**
	 * Descri��o ...
	 * @var bolean
	 * @example Inserir valor boleano para poder aparecer o link
	 * islink = true
	 */
	
	/**
	 * Descri��o ...
	 * @var array
	 * @example dados que devem ser mostrados na tabela
	 * dados = tabeladedados
	 */
	private $dados;

	/**
	 * Descri��o ...
	 * @var array
	 * @example Nomes para o titulo de cada coluna
	 * cabecalho = titulodascolunas
	 */
			
	private $cabecalho;

	private $function = array();
	
	private $columnNumber;

	private $option;
	
	public $excel = false;
	public $botaoexcel = '<a href="./GerarExcel.php"><img src="./css/images/excel.png" title="Exportar Excel"></a>';
	
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
	 * @example Metodo que cria o cabe�alho baseado no array informado no
	 * construtor
	 */
	
	private function criarCabecalho()
	{

		echo("<div class='table-responsive'>
                <table border='2' class='{$this->css}' id='{$this->id}'>
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
			
			#Recria o array de forma n�merica
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
	               						' . $this->option['0']->getNameButton() . ' <span class="caret"></span>
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
			</table>
           </div>');
	}
	
	public function addOption(IOption $option)
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
	
	#Para funcionar a exporta��o do Excel isso deve ser chamado dentro do
	#Formulario de busca
	public function exportarExcel($NomeExcel,$Metodo,$ColunaOculta = 0)
	{
		$this->excel = ($_SESSION['post']['NomeExcel'] == $NomeExcel) ? true : false;
	
		$this->colunaoculta = $ColunaOculta;
		$Cabecalho = implode(',',$this->cabecalho);
	
		echo("
				<input type='hidden' name='NomeExcel' value='{$NomeExcel}' />
				<input type='hidden' name='Cabecalho' value='{$Cabecalho}' />
				<input type='hidden' name='Metodo' value='{$Metodo}' />
				<input type='hidden' name='ColunaOculta' value='{$ColunaOculta}' />
			");
	}
	
}
?>