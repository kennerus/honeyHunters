<?php
/**
 * Created by PhpStorm.
 * User: apuc0
 * Date: 14.11.2017
 * Time: 9:48
 * @var $data array
 */
?>
<div class="col-lg-4 col-md-4 col-sm-6 col-12 comments__block">
    <div class="container">
        <div class="row">
            <div class="col-md-12 block__title">
                <h3><?= $data['name'] ?></h3>
            </div>
            <div class="col-md-12 block__text">
                <a href="mailto:<?= $data['email'] ?>"><?= $data['email'] ?></a>
                <p class="line-clamp"><?= $data['comment'] ?></p>
            </div>
        </div>
    </div>
</div>
