<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>Chamado</title>
<link rel="stylesheet" type="text/css" href="./forms/login/view.css" media="all">
<script type="text/javascript" src="./forms/login/view.js"></script>
<link rel='shortcut icon' href='css/images/LogoICO.ico'>

</head>
<body id="main_body" >
	
	<img id="top" src="top.png" alt="">
	<div id="form_container">
	
		<h1><a>Chamado</a></h1>
		<form id="form_650304" class="appnitro"  method="post" action="./action/login.php">
					<div class="form_description">
					<p id="logo"></p>
			<h2>SGA - CEADIS</h2>
			<p></p>
		</div>						
			<ul >
				<li><?php 
				
				Texto::mostrarMensagem($_SESSION['erro']); unset($_SESSION['erro']);?></li>
					<li id="li_1" >
		<label class="description" for="element_1"><?php echo($_SESSION['config']['usuario']); ?>: </label>
		<div>
			<input id="element_1" name="ace_usuario" class="element text medium" type="text" maxlength="255" value=""/> 
		</div> 
		</li>		<li id="li_2" >
		<label class="description" for="element_2"><?php echo($_SESSION['config']['senha']); ?>: </label>
		<div>
			<input id="element_2" name="ace_senha" class="element text medium" type="password" maxlength="255" value=""/> 
		</div> 
		</li>
			
					<li class="buttons">
			    <input type="hidden" name="form_id" value="650304" />
			    
				<input id="saveForm" class="button_text" type="submit" name="submit" value="Acessar" />
		</li>
			</ul>
		</form>	
	</div>
	<img id="bottom" src="bottom.png" alt="">
	</body>
</html>