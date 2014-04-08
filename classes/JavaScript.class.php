<?php
/**
#Classe para usar Confirm, Alert e Window.Open com Javascript 
#@autor: Márcio Ramos
#@Data: 01/01/2011
#@Versão: 1.0
*/
final class JavaScript
{	

	public static function FazAlertaLink($mensagem)
	{
		echo("
			javascript:
				alert('".$mensagem."');
			
			");
	}
	
	public static function FazAlerta($mensagem)
	{
		echo("
			<script language='javascript'>
				alert('".$mensagem."');
			</script>
			");
	}
	
	public static function AlertaRedirect($mensagem,$url)
	{
		echo("
			<script language='javascript'>
				alert('".$mensagem."');
				location ='".$url."';
			</script>
			");
	}


	public static function ConfirmRedirect($mensagem,$localurl)
	{
		echo("
			<script language='javascript'>
			
			if(confirm('".$mensagem."')){
				location = '".$localurl."';
				}
            </script>

			");
	}

	
	public static function ConfirmDialog($mensagem,$localurl)
	{
		echo("
			javascript:
			if(confirm('".$mensagem."')){
			location='".$localurl."'; }
			");
	}
	
	public static function AbreJanela($url,$titulo,$botaonome,$id=none,$class=none,$largura=400,$altura=300)
	{
		echo("
			<INPUT TYPE=\"button\" VALUE=\"".$botaonome."\" 
			id=\"".$id."\" class=\"".$class."\" 
			ONCLICK=\"open('".$url."', '".$titulo."','menubar=no,width=".$largura.",height=".$altura."')\">
    		");
	}
	
	public static function AbreJanelaLink($mensagem,$url,$titulo,$largura=300,$altura=400)
	{
		echo("
			javascript:if(confirm('".$mensagem."')){
			open(".$url."', '".$titulo."','menubar=no,width=".$largura.",height=".$altura."');	};
	  		");
	}
	
	public static function alertaClose($mensagem)
	{
		echo("
			<script language='javascript'>
				alert('".$mensagem."');
				window.close();
			</script>
			");
	}
	
	public static function confirmClose($mensagem)
	{
		echo("
			javascript:
			if(confirm('".$mensagem."')){
			window.close(); }
			");
	}	
}
?>