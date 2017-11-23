<?php
	include ("../db.php");

	if ($_POST['people_id']){
		$id=$_POST['people_id'];

		$query="SELECT * FROM ".table_name." WHERE id='".$id."'";
		$res_edit_single=mysqli_query ($conn, $query);
		$row_edit_single=mysqli_fetch_assoc ($res_edit_single);
		echo ("<div class=\"edit_label\">Редактирование записи</div>");
		echo ("<form method=\"POST\" class=\"edit_form edit_form1\">
					<table>
						<tr>
							<td>Имя</td>
							<td><input type=\"text\" name=\"name\" id=\"name_".$id."\" placeholder=\"Имя\" class=\"input\" value=\"".$row_edit_single['name']."\" autocomplete=\"off\" required /></td>
						</tr>
						<tr>
							<td>Фамилия</td>
							<td><input type=\"text\" name=\"second_name\" id=\"second_name_".$id."\" placeholder=\"Фамилия\" class=\"input\" value=\"".$row_edit_single['second_name']."\" autocomplete=\"off\" required /></td>
						</tr>
						<tr>
							<td>e-mail</td>
							<td><input type=\"text\" name=\"mail\" id=\"mail_".$id."\" placeholder=\"e-mail\" class=\"input\" value=\"".$row_edit_single['mail']."\" autocomplete=\"off\" onchange=\"mail_verify_edit_".$id."()\" required /></td>
						</tr>
						<tr><td></td><td align=\"left\"><div class=\"edit_msg_box\" id=\"msg_mail_verify_".$id."\"></div></td></tr>
						<tr>
							<td colspan=\"2\" class=\"change_coll\">
								<input type=\"hidden\" name=\"hidden_id\" value=\"".$id."\" >
								<input type=\"submit\" name=\"submit\" id=\"submit_unblock\" value=\"Изменить\" />
								<input type=\"submit\" id=\"submit_block\" disabled=\"disabled\" value=\"Изменить\" />
							</td>
						</tr>
						<tr>
							<td colspan=\"2\" class=\"del_coll\">


								<a href=\"#smallModal\" data-toggle=\"modal\">Удалить</a>
								 
								<!-- модальное окно для удаления элемента -->
								<div id=\"smallModal\" class=\"modal fade\">
									<div class=\"modal-dialog\">
										<div class=\"modal-content delete_modal\">
      									<!-- Заголовок модального окна -->
      										<div class=\"modal-header\">
        										<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\">×</button>
        										<h4 class=\"modal-title\">Вы действительно хотите удалить этот элемент?</h4>
      										</div>
      										<!-- Основное содержимое модального окна -->
      										<div class=\"modal-body\">
         										<input type=\"submit\" name=\"delete\" class=\"btn btn-primary delete_yes\" value=\"Да\">
        										<button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">Нет</button>
      										</div>
      										<!-- Футер модального окна -->
      										<div class=\"modal-footer\">
    										</div>
    									</div>
									</div>
								</div>
							</td>
						</tr>
					</table>
				</form>");



			echo ("<script>
				function mail_verify_edit_".$id."(){
		    					var new_mail = $('#mail_".$id."').val();
		    					var id = ".$id.";
		    					$.ajax({
		        					type: \"POST\",
		        					url: \"ajax/verify.php\",
		        					data: {new_mail:new_mail, id:id}
		    					}).done(function( result )
		        					{
		            					$(\"#msg_mail_verify_".$id."\").html(result );
		        					});
							}
							</script>");

				}

?>