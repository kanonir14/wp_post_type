<?php
/*
Template Name: Добавление объявления
*/
?>

<?php get_header(); ?>

<section class="create-post">

	<form class="add-form" method="post" action="" enctype="multipart/form-data">
		<h1>Добавить объявление:</h1>

		<div class="form-control">
			<label for="title">Заголовок</label>
			<input id="title" name="title" type="text" placeholder="Введите заголовок" required />
		</div>

		<div class="form-control">
			<label for="title">Ваш Email</label>
			<input id="email" name="email" type="email" placeholder="example: johndoe@gmail.com"  required />
		</div>

		<div class="form-control">
			<label for="title">Выберите картинку</label>
			<input id="input-picture" name="profile_picture" accept=".jpg, .jpeg, .png" type="file">
		</div>


		<div class="form-control form-btn">
			<span class="loader"></span>
			<button id="send" name="send" class="btn btn-lg btn-primary">Добавить объявление</button>
		</div>
	</form>
	
</section>

<?php get_footer(); ?>