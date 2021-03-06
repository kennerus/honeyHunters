$("document").ready(function () {

    function ell() {
        $(".line-clamp").dotdotdot({
            ellipsis: "\u2026 ",
            height: 150
        });
    }

    ell();

    $("#send").click(function () {

        var data = $("#needs-validation").serialize();

        $.ajax({
            url: 'ajax.php',
            type: 'POST',
            data: data,
            success: function (response) {
                console.log(response);
                $('.comments__blocks').append(response).each(function () {
                    $(".line-clamp").dotdotdot({
                        ellipsis: "\u2026 ",
                        height: 150
                    })
                    console.log($('line-clamp'));
                });
                alert('Ваш комментарий добавлен!');
            }
        })
            .done(function () {
                console.log('done')
            })
            .fail(function () {
                console.log("error");
            })
            .always(function () {
                console.log('complete')
            });
    })

    var itemBox = $('.comments__block')

    $("._delete").click(function (event) {
        event.preventDefault();
        var $this = $(this);
        var $thisItem = $this.closest(itemBox);
        var thisIndex = $this.attr('data-id');

        $.ajax({
            url: 'delete.php',
            type: 'POST',
            data: {'itemId': thisIndex},
            success: function (r) {
                $thisItem.slideUp(300, function () {
                    $thisItem.remove();
                });
            }
        });

    });
})