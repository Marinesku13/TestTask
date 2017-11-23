<?php
	include ("db.php");
	if ($_POST['new_submit']){
		$new_name=trim(htmlspecialchars($_POST['new_name']));
		$new_second_name=trim(htmlspecialchars($_POST['new_second_name']));
		$new_mail=trim(htmlspecialchars($_POST['new_mail']));
		$query="INSERT INTO people (name, second_name, mail) VALUES ('".$new_name."', '".$new_second_name."', '".$new_mail."')";
		mysqli_query ($conn, $query);
		$_SESSION['new_item']="Новая запись была сделана";
		header ("Location: index.php");
    	exit;
	}
	if ($_POST['submit']){
		$edit_name=trim(htmlspecialchars($_POST['name']));
		$edit_second_name=trim(htmlspecialchars($_POST['second_name']));
		$edit_mail=trim(htmlspecialchars($_POST['mail']));
		$hidden_id=$_POST['hidden_id'];
		$query="UPDATE people SET name='".$edit_name."', second_name='".$edit_second_name."', mail='".$edit_mail."' WHERE id='".$hidden_id."'";
		mysqli_query ($conn, $query);
		$_SESSION['edit']="Запись отредактирована";
		header ("Location: index.php");
    	exit;
	}
	if ($_POST['delete']){
		 
		$hidden_id=$_POST['hidden_id'];
		$query="DELETE FROM people WHERE id='".$hidden_id."'";
		mysqli_query ($conn, $query);
		$_SESSION['del']="Запись удалена";
		header ("Location: index.php");
    	exit;
	}
 
?>

<!DOCTYPE html>
<html lang="ru">
	<head>
		<meta charset="utf-8" />
		<meta name="author" content="Script Tutorials" />
		<meta name="description" content="People table (test task)">
		<meta http-equiv="X-UA-Compatible" content="IE=Edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<meta charset="UTF-8">
		<title>Тестовое задание - Зубко Артем (Mates Academy)</title>
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/style.css" rel="stylesheet">
		<link href="css/media_style.css" rel="stylesheet">
		 <script src="http://code.jquery.com/jquery-latest.js"></script>
	</head>
	<body>
		<script src="js/bootstrap.min.js"></script>

		<div class="new_item_label">
			<?php
				if (!empty($_SESSION['new_item'])){
					echo ($_SESSION['new_item']);
					unset($_SESSION['new_item']);
				}
				if (!empty($_SESSION['edit'])){
					echo ($_SESSION['edit']);
					unset($_SESSION['edit']);
				}
				if (!empty($_SESSION['del'])){
					echo ($_SESSION['del']);
					unset($_SESSION['del']);
				}
				/*это надписи, появляющиеся сразу после добавления, 
				  редактировани и удаления записи после перезагрузки 
				  страницы. именно потому и сессионные. И сразу же удаляются,
				  так сказать "одноразовые"*/
			?>
		</div>


		<div class="new_item-content">
			<a href="#myModal" class="btn btn-primary" data-toggle="modal">Новая запись</a>
		</div>
	

		<div id="myModal" class="modal fade">
			<div class="modal-dialog">
    			<div class="modal-content">
    				<!-- Заголовок модального окна -->
     				<div class="modal-header">
        				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        				<h4 class="modal-title">Новая запись</h4>
    				</div>
    				<!-- Основное содержимое модального окна -->
    				<div class="modal-body">
        				<form method="POST"   class="edit_form new_item_container">
							<table>
								<tr>
									<td align="left">Имя</td>
									<td><input type="text" name="new_name" id="new_name" placeholder="Имя" class="input" autocomplete="off" required /></td>
								</tr>
								<tr>
									<td align="left">Фамилия</td>
									<td><input type="text" name="new_second_name" id="new_second_name" placeholder="Фамилия" class="input" autocomplete="off" required /></td>
								</tr>
								<tr>
									<td align="left">e-mail</td>
									<td><input type="text" name="new_mail" id="new_mail" placeholder="e-mail" class="input" onchange="mail_varify()" autocomplete="off" required /></td>
								</tr>
								<tr><td></td><td align="left"><div id="msg_mail"></div></td></tr>
								 
							</table>
    					</div>
    					<!-- Футер модального окна -->
      					<div class="modal-footer">
      						<input type="submit" name="new_submit" id="new_submit_unblock" value="Внести" class="btn btn-primary" />
      						<input type="submit" id="new_submit_block" value="Внести" class="btn btn-primary" disabled="disabled" />
        					<button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
      					</div>
      				</form>
    			</div>
  			</div>
		</div>
          
		<script>
		function mail_varify(){
		    var new_mail = $('#new_mail').val();
		    $.ajax({
		        type: "POST",
		        url: "ajax/verify.php",
		        data: {new_mail:new_mail}
		    }).done(function( result )
		        {
		            $("#msg_mail").html(result );
		        });
		}
		</script>
		<!-- функция ajax, проверяющая e-mail на корректность и уникальность -->



		<div class="container">
			<div class="col-sm-6">
				<?php
					$query="SELECT * FROM ".table_name;
					$people_array=array();
					$res_people=mysqli_query ($conn, $query);
						if (!empty($res_people)){

    						WHILE ($row_people=mysqli_fetch_assoc ($res_people))
    						{//array_push($people_array, $row_people);
    							$people_array[$row_people['id']]=$row_people;
    						}
    						 
    					}

    				/*собираем массив из всех записей в таблице - $people_array,
    				ключом в котором является $id*/
					 if (empty($people_array)){
					 	echo ("Списко пуст");
					 }
					 else {
					 	foreach ($people_array as $id=>$single_man){
					 		//echo ($id);
					 		echo ("<div class=\"single_man\" onclick=\"show_edit_form_".$id."()\">");
					 		/*$id увеличиваем на 1 для того, чтобы при первом (нулевом)
					 		значении переменная, передаваемая через ajax, не была пустой,
					 		нулевой*/
					 		echo ($single_man['name']." ");
					 		echo ($single_man['second_name']." | ");
					 		echo ($single_man['mail']);
					 		echo ("<div class=\"edit_button\">редактировать</div></div>");
					 	}
					 }
					 /*циклом вывели список всех людей (с функцией на onclick,
					   чтоб при нажатии выводилась форма редактирования (через ajax))*/
				?>
			</div>
			<div class="col-sm-6">
				<?php
					/*циклом выводим список функций ajax на каждый элемент списка
					(для каждого $id)*/

					for ($i=1; $i<=count($people_array); $i++){
						echo ("<script>
							function show_edit_form_".$i."(){
							    var people_id = ".$i.";
     
							    $.ajax({
							        type: \"POST\",
							        url: \"ajax/edit_item.php\",
							        data: {people_id:people_id}
							    }).done(function( result )
							        {
							            $(\"#msg_edit\").html(result );
							        });
							}
							</script>");
					}
				?>
				<div id="msg_edit"></div>

			</div>
		</div>

	</body>
</html>