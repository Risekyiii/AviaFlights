<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="buyform.css">
</head>
<body>
	<div class="container">
		<main class="main">
			<div class="main-heading">
				<img src="main-icon.png" alt="" class="passenger">
				<h1 class="h1">пассажиры</h1>
			</div>
			<form class="form" action="processform.php" method="post">
				<h2 class="form-h2">Взрослый</h2>
				<p class="star"><span>*</span>Поле обязательно для заполнения</p>
				<!-- Вставляем скрытое поле для передачи flightId -->
				<?php
                    $flightId = isset($_GET['flightId']) ? $_GET['flightId'] : null;
                    if ($flightId) {
                        echo '<input type="hidden" name="flightId" value="' . $flightId . '">';
                    }
                ?>
				<div class="person-info">
					<div class="person-data">
						<div class="person-radio">
							<h3>Пол<span>*</span></h3>
							<input id="radio-man" type="radio" name="gender" value="М" checked>
							<label for="radio-man">М</label>
						</div>
						<div class="person-radio">
							<input id="radio-female" type="radio" name="gender" value="Ж">
							<label for="radio-female">Ж</label>
						</div>
					</div>
					<div class="person-data">
						<h3>Фамилия<span>*</span></h3>
						<input type="text" name="last_name" required>
					</div>
					<div class="person-data">
						<h3>Имя<span>*</span></h3>
						<input type="text" name="first_name" required>
					</div>
					<div class="person-data">
						<h3>Отчество (если есть)<span>*</span></h3>
						<input type="text" name="middle_name">
					</div>
				</div>
				<hr>
				<h2 class="document-h2">Информация о документе
					<img src="info-icon.png" alt="Информация">
				</h2>
				<div class="document-info">
					<div class="person-data">
						<h3>Дата рождения<span>*</span></h3>
						<input type="date" name="birth_date" required>
					</div>
					<div class="person-data">
						<h3>Гражданство</h3>
						<input type="text" name="citizenship">
					</div>
					<div class="person-data">
						<h3>Серия и номер<span>*</span></h3>
						<input type="text" name="document_series_number" required>
					</div>
					<div class="person-data">
						<h3>Страна выдачи<span>*</span></h3>
						<input type="text" name="country_of_issue" required>
					</div>
				</div>
				<div class="button-container">
            		<button class="button-next" type="submit">Подтвердить</button>
        		</div>
			</form>
		</main>
	</div>
	<div class="container">
		<div class="confirming form">
			<div class="main-heading">
				<img src="main-icon.png" alt="" class="passenger">
				<h1 class="h1">правила и ограничения</h1>
			</div>
			<p class="confirmig-text">Для создания бронирования следует подтвердить, что вы ознакомились с информацией размещенной на сайте, а также о том, что вы ознакомились и согласны с правилами применения тарифов и другими условиями, и нажать кнопку "Подтвердить".</p>

			<div class="checkbox-cont">
				<div class="main-checkbox">
					<input class="main-input" type="checkbox" name="conf" onclick="document.querySelectorAll('.item').forEach(checkbox => checkbox.checked = this.checked)">
					<label class="main-label" for="conf">Я ознакомился и согласился со всеми правилами и условиями:</label>

					<div class="checboxes">
						<div class="checkbox">
							<input type="checkbox" name="conf" class="item">
							<label for="conf">
								Условия договора<span>*</span>
								<br>
								Правила воздущных перевозок пассажиров и багажа<span>*</span>
							</label>
						</div>
						<div class="checkbox">
							<input type="checkbox" name="conf" class="item">
							<label for="conf">
								Правила тарифа и политики отмены/возврата<span>*</span>
								<br>
								Правила бронирования и оплаты<span>*</span>
							</label>
						</div>
						<div class="checkbox">
							<input type="checkbox" name="conf" class="item">
							<label for="conf">
								Я согласен(на) на обработку моих персональных данных
							</label>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>