<?php
/**
 * @var $blocks array
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html"/>
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>HoneyHunters</title>
    <link rel="stylesheet" href="css/bootstrap-grid.min.css">
    <link rel="stylesheet" href="css/bootstrap-reboot.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<header class="header">
    <div class="container">
        <div class="row">
            <div class="col-md-3 mr-auto">
                <a href="#"><img src="img/logo.png" alt="HoneyHunters"></a>
            </div>
        </div>
    </div>
</header>
<main class="main">
    <section class="container form">
        <div class="row">
            <div class="col-md-3 col-sm-6 col-6 ml-auto mx-auto form__mail-ico">
                <img src="img/mail-ico.png" alt="">
            </div>
        </div>
        <div class="row">
            <div class="col-11 mx-auto">
                <form id="needs-validation" method="POST" novalidate>
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6 mx-auto">
                                <div class="form-group">
                                    <label class="form__label" for="name">Имя <span class="req">*</span></label>

                                    <input class="form__input form-control" type="text" id="name" name="name" required>
                                </div>

                                <div class="form-group form__email">
                                    <label class="form__label" for="email">E-Mail <span class="req">*</span></label>

                                    <input class="form__input form-control" type="email" id="email" name="email" required>									</div>
                            </div>

                            <div class="col-md-6 mx-auto">
                                <div class="form-group form__textarea">
                                    <label class="form__label" for="textarea">Комментарий <span class="req">*</span></label>

                                    <textarea class="form__text form-control" id="textarea" name="textarea" required></textarea>
                                </div>
                            </div>

                        </div>
                    </div>
                    <button type="button" id="send" class="btn btn-primary ml-auto form__btn">Записать</button>
                </form>
            </div>
        </div>
    </section>
    <section class="container-fluid comments">
        <div class="container">
            <div class="row">
                <div class="col">
                    <h3 class="comments__title">Выводим комментарии</h3>
                </div>
            </div>
            <div class="row comments__blocks">
                <?php foreach ($blocks as $block): ?>
                <div class="col-lg-4 col-md-4 col-sm-12 col-12 comments__block">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 block__title">
                                <h3><?= $block['Name'] ?></h3>
                            </div>
                            <div class="col-md-12 block__text">
                                <a href="mailto:<?= $block['Email'] ?>"><?= $block['Email'] ?></a>
                                <p class="line-clamp"><?= $block['Comment'] ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</main>
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-5 col-6">
                <a href="#"><img src="img/logo.png" alt="HoneyHunters"></a>
            </div>
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-5 col-6 ml-auto social">
                <div class="row justify-content-end">
                    <div class="col-md-4 col-5">
                        <a href="https://vk.com"><img src="img/vk-ico.png" alt="vk.com"></a>
                    </div>
                    <div class="col-md-4 col-5">
                        <a href="https://facebook.com"><img src="img/fb-ico.png" alt="facebook.com"></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/custom.js"></script>
<script src="js/jquery.dotdotdot.js"></script>

<script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function() {
        'use strict';

        window.addEventListener('load', function() {
            var form = document.getElementById('needs-validation');
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        }, false);
    })();
</script>
</body>
</html>