<?php

	include ("../db.php");

	if ($_POST['new_mail']){
		//echo ($_POST['new_mail']);

		$mail_verify=trim(htmlspecialchars($_POST['new_mail']));

		$uncorrect="Некорректно введен e-mail";

		$button_block="
		<style>
			#new_submit_block {
				display: block;
			}
			#new_submit_unblock {
				display: none;
			}
			#submit_block {
				display: block;
			}
			#submit_unblock {
				display: none;
			}
		</style>";
		/*эту переменную выводим при неверно введенном e-mail,
		  скрывая действительную кнопку, выводя вместо нее
		  похожую, но со свойством disabled*/

		$uncorrect_sign="";

		/*Изначально эта переменная пуста
		  Если после нескольких этапов проверки
		  так и останется пустой, то все правильно.
		  На любом из этапов проверки при несоответствии 
		  условиям присваиваем ей определенной значение.*/

		$pos = strpos($mail_verify, "@");
		if (empty($pos)){
			$uncorrect_sign="on";
		}
		 

		//если отсутствует знак @, значит некорректно

		$diff=strlen($mail_verify)-$pos;
		/*разница между позицией знака @ и общим количеством символов
		  Не может знак @ быть в самом конце, также не может после 
		  этого знака быть один-два знака. Хотя бы три.*/ 
		if ($diff<=3){
			 $uncorrect_sign="on";
		}
		 



		if(!(preg_match ("/[a-zA-Z0-9-_@.]/", $mail_verify))||
     	 ((preg_match ("/[а-яА-Я ]/", $mail_verify)))){
     	 	$uncorrect_sign="on";
     	 }
     	 /*проверяем, чтобы e-mail содержал латиницу, цифры, знаки "-", "_", "@", точку,
     	 и не содержал кирилицу и знак пробела*/



		/*пройдя несколько этапов проверки, проверяем 
		  переменную $uncorrect_sign. Если не пустой,
		  то блокируем кнопку нажатия и выводим нажпись*/

		if (!empty($uncorrect_sign)){
			echo ($uncorrect);
			echo ($button_block);
		}
		 

		$query="SELECT * FROM ".table_name." WHERE mail='".$mail_verify."'";
		$res_mail_verify=mysqli_query ($conn, $query);
		$row_mail_verify=mysqli_fetch_assoc ($res_mail_verify);
		if (!empty($row_mail_verify)){
			if (!($_POST['id']==$row_mail_verify['id']))
				{echo ("такой e-mail уже есть");
				echo ($button_block);}
			/*if (!($_POST['id']==$row_mail_verify['id'])) - для чего это?
			  Вдруг пользователь изменить e-mail, но передумает, и  не нажмет кнопку.
			  (только для редактирования, не для занесеня нового)
			  Тогда проверка найдет существующие e-mail (самого себя),
			  и будет тоже говорить, что такой уже есть. 
			  Этого быть не должно.
			  Сверяем id пользователя, которого мы в данный момент редактируем*/
		}


	}


?>