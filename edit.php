<!-- Разные миксины по одному, которые понадобятся. Для логотипа, бейджа, и т.д.-->
<!DOCTYPE html>
<html lang="ru">

<head>
	<meta charset="UTF-8" />
	<title>Михаил Кожан - Фильмотека</title>
	<!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge"/><![endif]-->
	<meta name="keywords" content="" />
	<meta name="description" content="" /><!-- build:cssVendor css/vendor.css -->
	<link rel="stylesheet" href="libs/normalize-css/normalize.css" />
	<link rel="stylesheet" href="libs/bootstrap-4-grid/grid.min.css" />
	<link rel="stylesheet" href="libs/jquery-custom-scrollbar/jquery.custom-scrollbar.css" /><!-- endbuild -->
	<!-- build:cssCustom css/main.css -->
	<link rel="stylesheet" href="css/main.css"><!-- endbuild -->
	<link rel="stylesheet" href="css/main.css">
	<!-- <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800&amp;subset=cyrillic-ext" rel="stylesheet"> -->
	<!--[if lt IE 9]><script src="http://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.2/html5shiv.min.js"></script><![endif]-->
</head>

<!-- Подключение к БД -->
	<?php 
		$link = mysqli_connect('localhost', 'root', 'root', 'WD04-filmoteka-Kozhan');
		if( mysqli_connect_error() ) {
			die( "Ошибка подключения к базе данных" );
		}
	?>
<!-- //Подключение к БД -->

<!-- Скрипт обновления фильма -->
	<?php
		if ( array_key_exists( 'update-film', $_POST ) ) {
		if ( $_POST['title'] == '' ) {
			echo "Необходимо ввести название фильма";
		} else { 
			$query = "UPDATE films SET
			name = '" . mysqli_real_escape_string($link, $_POST['title']) . "',
			type = '" . mysqli_real_escape_string($link, $_POST['genre']) . "',
			year = '" . mysqli_real_escape_string($link, $_POST['year']) . "' 
			WHERE id = '" .mysqli_real_escape_string($link, $_GET['id']) . "'";
			$query1 = "UPDATE `films` SET 
			`name` = '" 
				.mysqli_real_escape_string($link, $_POST['title']) . "',
			`type` = '" 
				.mysqli_real_escape_string($link, $_POST['genre']) . "'
			`year` = '" 
				.mysqli_real_escape_string($link, $_POST['year']) . "'
			WHERE `id` = " .mysqli_real_escape_string($link, $_GET['id']) . "";
				if( mysqli_query($link, $query) ) {
					echo "<p>Фильм обновлен</p>";
				} else {
					echo "<p>Фильм не обновлен</p>";
				}
			}
		}
	?>
<!-- //Скрипт добавления нового фильма -->

<!-- Удалить фильм -->
	<?php 
		if ( @$_GET['action'] == 'delete' ) {
			$query = "DELETE FROM `films` WHERE `id` = '" . mysqli_real_escape_string($link, $_GET['id']) . "'LIMIT 1";
			mysqli_query($link, $query);
			if( mysqli_affected_rows($link) > 0 ) //возвращает кол-во рядов, которые были затронуты при выполнении последнего запроса 
			{
				$resultInfo = "<p>Фильм был удален!</p>";
			} else {
				$resultError = "<p>Что-то пошло не так</p>";
			}
		}
	?>
<!-- //Удалить фильм -->

<body class="index-page">
	<div class="container user-content section-page">
		<div class="title-1">Фильмотека</div>
			<!-- Выбор фильма -->
			<?php
				$query = "SELECT * FROM `films` WHERE `id` = '" . mysqli_real_escape_string($link, $_GET['id']) . "'";
				if( $result = mysqli_query($link, $query) ) {
					while ( $row = mysqli_fetch_array( $result ) ) {
						$film[] = $row;
					}
				}
			?>
			<!-- //Выбор фильма -->

			<!-- Обход массива, поиск фильма -->
				<div class="row">
					<?php
					foreach ($film as $key => $value) {
					?>			
					<div class="card mb-20 col-md-3">
						<h4 class="title-4"><?php echo $film[$key]['name'] ?></h4>
						<div class="badge"><?php echo $film[$key]['type'] ?></div>
						<div class="badge"><?php echo $film[$key]['year'] ?></div>
						
						<a class="button-update" href="edit.php?id=<?=$film['id']?>">&#9998</a>
						<a class="button-delete" href="?action=delete&id=<?=$film[$key]['id']?>">X</a>
					</div>
				
					<?php  
					}
					?>
				</div>
			<!-- //Обход массива, поиск фильма -->

			<!-- Форма изменения фильма -->
			<div class="panel-holder mt-80 mb-40">
				<div class="title-3 mt-0">Изменить фильм <?php echo $film[$key]['name'] ?></div>
				<form action="edit.php?id=<?=$film[$key]['id'] ?>" method="POST">
					<!-- Валидация -->
						<div id="error" class="notify notify--error mb-20">Название фильма не может быть пустым.</div>
						<div id="error" class="notify notify--error err-type mb-20">Жанр не может быть пустым.</div>
						<div id="error" class="notify notify--error err-year mb-20">Год не может быть пустым.</div>
					<!-- //Валидация -->
					<div class="form-group"><label class="label">Название фильма
						<input class="input film-name film-title" name="title" type="text" placeholder="Например - Мстители" value = "<?php echo $film[$key]['name'] ?>"/></label></div>
					<div class="row">
						<div class="col">
							<div class="form-group"><label class="label">Жанр
								<input class="input film-type" name="genre" type="text" placeholder="Например - Комедия" value = "<?php echo $film[$key]['type'] ?>"/></label></div>
						</div>
						<div class="col">
							<div class="form-group"><label class="label">Год
								<input class="input  film-year" name="year" type="text" placeholder="Например - 2000" value = "<?php echo $film[$key]['year'] ?>"/></label></div>
						</div>
					</div><input class="button" type="submit" name="update-film" value="Обновить" />
					<a href="index.php">Вернуться на главную</a>
				</form>
				</div>
			</div>
	<script src="libs/jquery/jquery.js"></script><!-- endbuild -->
	<!-- build:jsVendor js/vendor.js -->
	<script>
		$('#error').hide();
		$('.err-type').hide();
		$('.err-year').hide();
		var film = (function(){
		    var init = function(){
		        _setUpListeners();
		        console.log("init");
		    }
		    var _setUpListeners = function() {
		        $('.button').on('click', function(event) {
		            validate(event);
		            console.log("_setUpListeners");
		        });
		    }
		    var validate = function(event) {
		        if( ( $('.film-title').val().trim() == '' ) ) {
		        	event.preventDefault();
		        	$('#error').show();
		        } else if ( $('.film-type').val().trim() == '' ) {
		        	event.preventDefault();
		        	$('#error').hide();
		        	$('.err-type').show();
		        }  else if ( $('.film-year').val().trim() == '' ) {
		        		event.preventDefault();
				        $('#error').hide();
				        $('.err-type').hide();
				        $('.err-year').show();
		        	}	else {
							$('#error').hide();
							$('.err-type').hide();
							$('.err-year').hide();
		        	}
		    }
		    return {
		        init
		    }
		}());
		film.init();
	</script>
	<script src="libs/jquery-custom-scrollbar/jquery.custom-scrollbar.js"></script>


</body>

</html>
