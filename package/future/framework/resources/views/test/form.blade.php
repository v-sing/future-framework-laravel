<?php
use Future\Admin\Form;
return Admin::form(\Future\Admin\Auth\Database\Config::class, function (Form $form) {
    $form->text('name');
    $form->text('title');

});
?>