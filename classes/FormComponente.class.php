<?php

class FormComponente
{

	public $objpdo;
	
	/**
	 * 
	 * Enter description here ...
	 * @var String
	 */
	static $name = "Selecione...";
	
	/**
	 * 
	 * Enter description here ...
	 * @param String $campoform
	 * @param String $campo
	 * 
	 * @author Márcio Ramos
	 * @tutorial Este metodo é usado para comparar dois campos
	 * e caso sejam iguais ele retorna o campo selecionado
	 */
	public static function selectedItem($campoform,$campo)
	{
		if($campoform == $campo)
		{
			return('selected="selected"');
		} 
	}

	/**
	 * 
	 * @param String $selectname
	 * @param Object $objpdo
	 * @param bolean $valor
	 * @param String $campo
	 * 
	 * @author Márcio Ramos
	 * @tutorial Este metodo recebe dois parametros obrigatorios
	 * selectname e objpdo, os outros valor e campo não são obrigatorios
	 * ele já cria o campo select completo e ja lista o q estiver no objpdo
	 */
	public static function selectOption($selectname,$objpdo,$valor=true,$campo=null,$valorName=null)
	{
		echo("<select name='" . $selectname . "'>");
          echo(self::optionVazio($valor,$valorName));
			foreach ($objpdo as $linha):
				echo("<option value='");
					echo($linha[0]. "'");
						echo(self::selectedItem($campo[$selectname],$linha[0]));
							echo('>');
					echo($linha[1]);
				echo('</option>');
			endforeach;
		echo('</select>');
	}
	
	private function optionVazio($valor,$valorName)
	{
		if($valor)
		{
			return('<option value='."$valorName".'>'.self::$name.'</option>');

		}
	}

	public static function validarForm($returnbanco,$valor,$returntrue, $returnfalse)
	{
		 echo ($returnbanco == $valor) ? $returntrue : $returnfalse;
	}
	
	public static function actionButton($nameButton,$acao)
	{
		
		return('<a href=/'.$_SESSION['projeto'].'/action/formcontroler.php?'.base64_encode($acao).'>'.$nameButton.'</a>');
	}
	
	public static function validarComponente($valorvalidar,$returntrue,$returnfalse)
	{
		if(!empty($valorvalidar))
		{
			echo($returntrue);
		}else
		{
			echo($returnfalse);
		}
	}
	
	public function montarFormularioCheckList($codigo)
	{
		
		$tbhistorico = new TbHistoricoCheckList();
		$che_codigo = $tbhistorico->confirmCheckList($codigo);

		if(!$che_codigo['che_codigo'])
		{
		
		if($codigo)
		{
		
			$tbcheklsit = new TbChecklist();
			$Check = $tbcheklsit->getForm($codigo);	
			
			
		echo("<fieldset>
					<legend>{$Check['che_titulo']}</legend>
			  
		");
		
		$linkaction = "../{$_SESSION['projeto']}/action/criarchecklist.php";
		echo("<form name='executarchecklist' action='{$linkaction}' method='post'>");
		
		echo("<table border='0'>");
		foreach ($this->objpdo as $campo):
			echo("<tr>
						<td>
						</td>
					</tr>
				<tr>
				  <td>");
						echo self::criaHiperlink($campo[1],$campo[2]);
			echo("</td>
					<td>
					");
					$tb = new TbSimNao();
					self::$name = 'SELECIONE...';

					self::selectOption($campo[1],$tb->selectOkErro(),true);

						$tbanexo = new TbAnexoCheckList();
						$dados = $tbanexo->getForm($campo[0]);
						
				if($dados[0])
				{
				echo("</td>
						<td>
							Procedimento:
						</td>
						<td class='dwl'>");

						$link = "BaixarArquivoAnexoCheckList.php?".base64_encode('id').'='.base64_encode($dados[0]);
						
						$link2 = "<img src='../{$_SESSION['projeto']}/css/images/dwl.png'>";
						
						echo self::criaHiperlink($link2,$link);
				}		
				  echo("</td>
				  </tr>");
		endforeach;
		echo("<tr>
				<td>
					Observação:
				</td>
				<td colspan='4'>
					<textarea name='obs' rows='5' cols='60'></textarea>
					<input type='hidden' name='che_codigo' value='{$codigo}' />
					<input type='hidden' name='che_titulo' value='{$Check['che_titulo']}' />
					<input type='hidden' name='che_email_envio' value='{$Check['che_email_envio']}' />								
				</td>		
			</tr>
			<tr>
				<td colspan='4'>
					<hr/>
				</td>
			</tr>
			<tr>
				<td>
					<input type='submit' class='button-tela' value='Finalizar' />
				</td>
			</tr>
		");
		echo('</table>');
		echo('</form>
		</fieldset>');
		
		}
		
		}else
		{
			$tbhistorico = new TbHistoricoCheckList();
			$che_codigo = $tbhistorico->confirmCheckList($codigo);

			echo("<fieldset>
					<legend>{$che_codigo['che_titulo']}</legend>
			  		<table>
			  			<tr>
			  				<td>
			  				Esta checagem já foi efetuada em: 
							</td>
							<td>
								{$che_codigo['hck_data']}
			  				</td>
			  				<td>
			  					por: 
							</td>
							<td>
								{$che_codigo['usu_email']}
			  				</td>			  				
			  			</tr>
			  		</table>
				
					
				");
		}
		
	}
	
	public static function criaHiperlink($campo,$link)
	{
		if($link != '')
		{
			return("<a href='".$link."' target='blank'>{$campo}</a>");
		}else
		{
			return($campo);
		}
	}

	
}