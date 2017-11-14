$("document").ready(function(){

	$("#send").click(function(){

		var data = $("#needs-validation").serialize();

		$.ajax({
			url: 'ajax.php',
			type: 'POST',
			data: data,
			success: function(response) {
				$('.comments__blocks').append(response);
				console.log(response);
			}
		})
		.done(function() {
			console.log("success");
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});
		return false;
	})
})