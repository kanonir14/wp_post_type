$(document).ready(function() {

	wp.init();

});

var wp = {

	init: function() {
		this.ajax_func();
	},

	validateEmail: function(email) {
		var re = /\S+@\S+\.\S+/;

    	return re.test(email);
	},

	ajax_func: function() {
		var self = this;
		var $btn = $("button[name=send]"),
			$loader = $(".loader");

		$(".add-form").submit(function(event) {
			event.preventDefault();

			var $title = $(this).find('input[name=title]').val(),
				$email = $(this).find('input[name=email]').val(),
				$files = $(this).find("input[name=profile_picture]")[0].files[0];

			if ( self.validateEmail($email) ) {

				console.log('VAlidate');

				var formData = new FormData();
					formData.append("profile_picture", $files);
					formData.append("title", $title);
					formData.append("email", $email);
					formData.append("action",'my_action_callback');

				$.ajax({
					url: myajax.url,
					type: 'POST',
					data: formData,
					processData: false, 
					contentType: false,
					beforeSend: function() {
						$loader.addClass('loader--visible');
						$btn.text("Загрузка");
					}
				})
				.done(function(response) {
					if (response === 'false') {
						$.fancybox.open('<div class="message"><h2>УПС! Что-то пошло не так</h2></div>');
					} else {
						$(".add-form")[0].reset();	
						$.fancybox.open('<div class="message"><h2>Объявление добавлено!</h2><p>Ваше объявление добавлено на сайт. Спасибо!</p></div>');
					}
					
				})
				.fail(function(response) {
					console.log("error");
				})
				.always(function() {
					$loader.removeClass('loader--visible');
					$btn.text("Добавить объявление");
				})

			}

		});
	}

}