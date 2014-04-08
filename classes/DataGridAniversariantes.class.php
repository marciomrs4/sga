<?php

class DataGridAniversariantes
{

	/**
	 * Descrição ...
	 * @var string
	 * @example Inserir o nome da classe CSS para linha
	 * csslinha1 = 'cssnome'
	 */
	public $csslinha1 = 'linha1';

	/**
	 * Descrição ...
	 * @var string
	 * @example Inserir o nome da classe CSS para linha
	 * csslinha2 = 'cssnome'
	 */
	public $csslinha2 = 'linha2';

	/**
	 * Descrição ...
	 * @var string
	 * @example Inserir o nome da classe CSS para cabeçalho
	 * csscabecalho = 'cssnome'
	 */
	public $csscabecalho = 'linha3';

	/**
	 * Descrição ...
	 * @var int
	 * @example Inserir o valor para borda
	 * borda = 1
	 */
	public $borda = 0;

	/**
	 * Descrição ...
	 * @var string
	 * @example Inserir o nome da classe CSS para tabela
	 * csstabela = 'cssnome'
	 */
	public $csstabela = 'tabela';

	/**
	 * Descrição ...
	 * @var string
	 * @example Inserir o nome da variavél que vai no link
	 * getnome = 'pes_codigo'
	 */
	public $acao;
	
	public $acao2;

	/**
	 * Descrição ...
	 * @var string
	 * @example Inserir o nome do link que aparecerá para clicar
	 * nomelink = 'Clique Aqui'
	 */
		
	public $nomelink = "<img src='/SGA/css/images/editar.gif' />";
	public $nomelink2 = '<img src="/SGA/css/images/adcionar.png" />';
	
	
	public $excel = false; 
	public $botaoexcel = '<a href="./GerarExcel.php"><img src="./css/images/excel.png" title="Exportar Excel"></a>';
	
	/**
	 * Descrição ...
	 * @var string
	 * @example Inserir o nome do link que sejá chamado ao clicar
	 * link = 'link.php'
	 */
	public $link = '/SGA/action/formcontroler.php';
	
	public $link2 = '/SGA/action/formcontroler.php';

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
	public $islink = true;
	
	public $islink2 = false;
	
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
	
	public $titulofield;
		
	public $cabecalho;

	/**
	 * Descrição ...
	 * @var int
	 * @example quantidade de colunas que haverá na tabela, obtido automaticamente
	 * coluna = quantidadecoluna
	 */
	private $coluna;

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
		echo("<div style='float: left;'>
				<table class='$this->csstabela' border='{$this->borda}'>
			<thead>
			<tr align='center' style='color: #F00' >");
		foreach ($this->cabecalho as $cabecalho):
		echo("<th nowrap='nowrap' class='tabela-niver-cabecalho'>{$cabecalho}</th>");
		endforeach;
		echo("</tr>
			</thead>");
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
			$estilo = ValidarCampos::campoTernario($linha,$this->csslinha1,$this->csslinha2);
			$this->coluna = count($campo) / 2;
			echo("<tr class ='{$estilo}'>");
			for($x = $this->colunaoculta; $x < $this->coluna ; $x++)
			{
				echo("<td>{$campo[$x]}</td>");
			}
			$linha++;
			self::colunaLink(base64_encode($campo[0]));
			self::colunaLink2(base64_encode($campo[0]));			
		}
		echo('</tr>');
	}

	/**
	 *
	 * Enter description here ...
	 * @param int $campo
	 * @example Criar as colunas de link com o ID que deve ser a primeira posicao
	 * do array informado no array dados no construtor
	 */
	private function colunaLink($campo)
	{
		if($this->islink)
		{
			echo("<td class='{$this->csstabela}'><a href='{$this->link}?{$this->getAcao()}={$campo}' 
					  class='{$this->csstabela}'>{$this->nomelink}</a></td>");
		}
	}
	
	private function getAcao()
	{
		return(base64_encode($this->acao));
	}
	
	
	private function colunaLink2($campo)
	{
		if($this->islink2)
		{
			echo("<td class='{$this->csstabela}'><a href='{$this->link2}?{$this->getAcao2()}={$campo}' 
					  class='{$this->csstabela}'>{$this->nomelink2}</a></td>");
		}
	}
	
	private function getAcao2()
	{
		return(base64_encode($this->acao2));
	}
	
	private function botaoExcel()
	{
		if($this->excel == true)
		{
			return($this->botaoexcel);
		}
	}
	
	
	
	
	#Para funcionar a exportação do Excel isso deve ser chamado dentro do
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
	
/**
	 *
	 * Enter description here ...
	 * @example Metodo que cria o rodapé com a quantidade de linhas retornadas
	 * da busca
	 */
	private function criaRodape()
	{
		$this->coluna = $this->coluna - $this->colunaoculta;
		echo("<tfoot>
			
			</tfoot>
		</table>
			</div>");
	}

	
	/**
	 * @example Metodo que mostra a tabela na tela, chamando todos
	 * os metodos anteriores
	 */
	public function mostrarDatagrid($mostrar = 0)
	{
		if($mostrar == 0)
		{
			if($_SESSION['acao'])
			{
				
			
			}else 
			{	
				self::criaCabecalho();
				self::criaTabela();
				self::criaRodape();
			}
		}else
		{
			self::criaCabecalho();
			self::criaTabela();
			//self::criaRodape();
		}
	}
}
?>