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
	<link rel="stylesheet" href="./css/main.css" /><!-- endbuild -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800&amp;subset=cyrillic-ext" rel="stylesheet">
	<!--[if lt IE 9]><script src="http://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.2/html5shiv.min.js"></script><![endif]-->
</head>
<?php 
	$link = mysqli_connect('localhost', 'root', 'root', 'WD04-filmoteka-Kozhan');
	if( mysqli_connect_error() ) {
		die( "Ошибка подключения к базе данных" );
	}
?>
<!-- Добавить новый фильм -->
<?php
// print_r($_POST);
if ( array_key_exists( 'newFilm', $_POST ) ) {
	if ( $_POST['title'] == '' ) {
		echo "Необходимо ввести название фильма";
	} else {
		$query = "INSERT INTO `films` (`name`, `type`, `year`) VALUES ('" 
			.mysqli_real_escape_string($link, $_POST['title']) . "','"
			.mysqli_real_escape_string($link, $_POST['genre']) . "','"
			.mysqli_real_escape_string($link, $_POST['year']) . "'
			) ";
			if( mysqli_query($link, $query) ) {
				echo "<p>Пользователь добавлен в БД</p>";
			} else {
				echo "<p>Пользователь не добавлен. Проверьте введенные данные</p>";
			}
	}
}
?>



<!-- Вывод фильмов -->

<body class="index-page">
	<div class="container user-content section-page">
		<div class="title-1">Фильмотека</div>
			<?php
				$query = "SELECT * FROM `films`";
				if( $result = mysqli_query($link, $query) ) {
					while ( $row = mysqli_fetch_array( $result ) ) {
						$film[] = $row;
					}
				}
				foreach ($film as $key => $value) {
				?>			
					<div class="card mb-20 flex-card">
						<h4 class="title-4"><?php echo $film[$key]['name'] ?></h4>
						<div class="badge"><?php echo $film[$key]['type'] ?></div>
						<div class="badge"><?php echo $film[$key]['year'] ?></div>
					</div>
				
				<?php  
				}
			?>
		<div class="panel-holder mt-80 mb-40">
			<div class="title-3 mt-0">Добавить фильм</div>
			<form action="index.php" method="POST">
				<!-- <div id="error" class="notify notify--error mb-20">Название фильма не может быть пустым.</div> -->
				<div class="form-group"><label class="label">Название фильма<input class="input" name="title" type="text" placeholder="Такси 2" /></label></div>
				<div class="row">
					<div class="col">
						<div class="form-group"><label class="label">Жанр<input class="input" name="genre" type="text" placeholder="комедия" /></label></div>
					</div>
					<div class="col">
						<div class="form-group"><label class="label">Год<input class="input" name="year" type="text" placeholder="2000" /></label></div>
					</div>
				</div><input class="button" type="submit" name="newFilm" value="Добавить" />
			</form>
		</div>
	</div><!-- build:jsLibs js/libs.js -->
	<script src="libs/jquery/jquery.js"></script><!-- endbuild -->
	<!-- build:jsVendor js/vendor.js -->
	<script src="libs/jquery-custom-scrollbar/jquery.custom-scrollbar.js"></script>


</body>

</html>
