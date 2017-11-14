$("document").ready(function(){

	$("#send").click(function(){

		var data = $("#needs-validation").serialize();

		$.ajax({
			url: 'insert.php',
			type: 'POST',
			data: data,
			success: function(response) {
				alert(response);
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