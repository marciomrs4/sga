<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/sga/componentes/config.php');

include_once 'componentes/TopoPainelTarefas.php';

?>
	
	<div class="container-fluid">

		<div class="row">

           <div class="col-sm-3">

               <div class="panel panel-primary">
                   <div class="panel-heading">
                       <h3 class="panel-title">Tarefas</h3>
                   </div>
                   <div class="panel-body">
                       <ul class="list-group">
                           <?php
                           $ExecutarTarefa = new TbExecutarTarefas();

                           $dados['dep_codigo'] = $_SESSION['dep_codigo'];
                           foreach($ExecutarTarefa->listarExecutarTarefas($dados)->fetchAll(\PDO::FETCH_OBJ) as $tarefa):
                            ?>
                           <li class="list-group-item"><?php echo($tarefa->tae_descricao); ?></li>
                           <?php
                           endforeach;
                           ?>
                       </ul>
                       <label>Tarefa:</label>
                       <input type="text">
                       <button class="btn btn-primary btn-sm addtarefa">Inserir</button>
                   </div>
                   <div class="panel-footer"></div>
               </div>

               <div class="panel panel-primary">
                   <div class="panel-heading">
                       <h3 class="panel-title">Chamados</h3>
                   </div>
                   <div class="panel-body">
                        <div id="listarchamado"></div>
                   </div>
                   <div class="panel-footer"></div>
               </div>

               <div class="panel panel-primary">
                   <div class="panel-heading">
                       <h3 class="panel-title">Atividades</h3>
                   </div>
                   <div class="panel-body">
                        <div id="listaratividade"></div>
                   </div>
                   <div class="panel-footer"></div>
               </div>

           </div>

            <div class="col-sm-9">

                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">Lista de Tarefas</h3>
                    </div>
                    <div class="panel-body">
                        <div id="listartarefa"></div>
                    </div>
                    <div class="panel-footer"></div>
                </div>

            </div>

        </div>
					
	</div>
	<!-- Fim Div Principal -->
	
<?php 
	include_once 'componentes/footerPainelTarefas.php';
?>
