<?php
Form::action(function ($form){
    $form->button()->submit(lang('Submit'))->reset(lang('Reset'))->addButton('button')->label()->render();
    $form->button()->submit(lang('Submit'))->render();
})->render();

?>