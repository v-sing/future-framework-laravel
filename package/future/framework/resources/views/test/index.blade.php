<?php
Form::action(function ($form){
    $form->button()->submit()->reset()->addButton('button')->render();
    $form->button()->submit()->render();
})->render();

?>