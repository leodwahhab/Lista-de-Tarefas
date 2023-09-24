<?php
	require 'app/Tarefa.php';

	$obTarefa = new Tarefa();
	$registros = $obTarefa::recuperarTarefas();

	if(isset($_GET['id'], $_GET['acao']) && is_numeric($_GET['id'])){
		if($_GET['acao'] == 'r'){
			$obTarefa::removerTarefa($_GET['id']);
			header('location: todas_tarefas.php?status=3');
		}
		else if($_GET['acao'] == 'c'){
			$obTarefa::alterarStatusTarefa($_GET['stts'], $_GET['id']);
			header('location: todas_tarefas.php?status=4');
		}
	}
	if(isset($_POST, $_POST['tarefa'], $_POST['id'])){
		$valores[] = $_POST['tarefa'];
		$valores[] = $_POST['id'];
		header('location: todas_tarefas.php?status=2');
        $obTarefa::editarTarefa('tarefa',$valores);
    }
?>

<html>
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>App Lista Tarefas</title>

		<link rel="stylesheet" href="css/estilo.css">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
<head>

	<body>
		<nav class="navbar navbar-light bg-light">
			<div class="container">
				<a class="navbar-brand" href="#">
					<img src="img/logo.png" width="30" height="30" class="d-inline-block align-top" alt="">
					App Lista Tarefas
				</a>
			</div>
		</nav>

		<?php   if(isset($_GET['status']) && is_numeric($_GET['status'])){
					if($_GET['status'] == 2){ ?>
						<div class="bg-success pt-2 text-white d-flex justify-content-center">
							<h5>Tarefa atualizada com sucesso!</h5>
						</div>
			<?php	} else if($_GET['status'] == 3){ ?>
						<div class="bg-success pt-2 text-white d-flex justify-content-center">
							<h5>Tarefa removida com sucesso!</h5>
						</div>
			<?php 	} else if($_GET['status'] == 4) { ?>
						<div class="bg-success pt-2 text-white d-flex justify-content-center">
							<h5>Status alterado com sucesso!</h5>
						</div>
		<?php   }   }?>

		<div class="container app">
			<div class="row">
				<div class="col-sm-3 menu">
					<ul class="list-group">
						<li class="list-group-item"><a href="index.php">Tarefas pendentes</a></li>
						<li class="list-group-item"><a href="nova_tarefa.php">Nova tarefa</a></li>
						<li class="list-group-item active"><a href="#">Todas tarefas</a></li>
					</ul>
				</div>

				<div class="col-sm-9">
					<div class="container pagina">
						<div class="row">
							<div class="col">
								<h4>Todas tarefas</h4>
								<hr />
						<?php for($i = 0; $i < count($registros); $i++){ ?>
								<div class="row mb-3 d-flex align-items-center tarefa">
									<div id="tarefa_<?= $registros[$i]['id'] ?>" class="col-sm-9"><?= $registros[$i]['tarefa'] .' ('. $registros[$i]['status'] .')' ?> </div>
									<div class="col-sm-3 mt-2 d-flex justify-content-between">
										<a href="todas_tarefas.php?acao=r&id=<?=$registros[$i]['id']?>"><i class="fas fa-trash-alt fa-lg text-danger"></i></a>
									<?php if($registros[$i]['status'] == 'pendente'){ ?>
										<i class="fas fa-edit fa-lg text-info" onclick="ativarModoEditar(<?= $registros[$i]['id'] ?>, '<?= $registros[$i]['tarefa'] ?>')"></i>
										<a href="todas_tarefas.php?acao=c&id=<?= $registros[$i]['id'] ?>&stts=<?= $registros[$i]['status'] ?>"><i class="fas fa-check-square fa-lg text-success"></i></a>
									<?php } ?>
									</div>
								</div>
						<?php } ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<script>
			function ativarModoEditar(id, descTarefa){
				let form = document.createElement('form')
				form.action = '#'
				form.method = 'post'
				form.className = 'row'
				
				let input = document.createElement('input')
				input.type = 'text'
				input.name = 'tarefa'
				input.id = 'name'
				input.className = 'form-control col-9'
				input.value = descTarefa
				
				let inputHidden = document.createElement('input')
				inputHidden.type = 'hidden'
				inputHidden.name = 'id'
				inputHidden.id = 'id'
				inputHidden.value = id

				let button = document.createElement('button')
				button.type = 'submit'
				button.className = 'col-3 btn btn-info'
				button.innerHTML = 'Atualizar'

				form.appendChild(input)
				form.appendChild(inputHidden)
				form.appendChild(button)

				let tarefa = document.getElementById('tarefa_'+id)
				tarefa.innerHTML = ''
				tarefa.insertBefore(form, tarefa[0])

			}

		</script>
	</body>
</html>