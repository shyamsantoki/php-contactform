$(function () {
	statusRecaptcha = 0;
	window.verifyRecaptchaCallback = function (response) {
		$('input[data-recaptcha]').val(response).trigger('change');
		statusRecaptcha = 1;
	}
	window.expiredRecaptchaCallback = function () {
		$('input[data-recaptcha]').val("").trigger('change');
		statusRecaptcha = -1;
	}
	$('#contact-form').validator();
	$('#contact-form').on('submit', function (e) {
		console.log('ajax')
		if (!e.isDefaultPrevented()) {
			console.log('ajax if')
			var url = "mailer.php";
			$.ajax({
				type: "POST",
				url: url,
				data: $(this).serialize(),
				success: function () {
					if (statusRecaptcha == 1) {
						var alertBox = '<div class="alert alert-dismissable alert-success fade show">\
											<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Thank you. Your response has been recorded\
										</div>';
					}
					else {
						var alertBox = '<div class="alert alert-dismissable alert-danger fade show">\
											<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Something went wrong. Please try again\
										</div>';
					}
					$('#contact-form').find('.messages').html(alertBox);
					$('#contact-form')[0].reset();
					grecaptcha.reset();
				}
			});
			return false;
		}
	})
});