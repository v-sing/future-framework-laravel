{!!
 Form::action(function ($form){
    $form->number()->field('weigh','2')->label('weigh')->render();
    $form->button()->submit(lang('Submit'))->reset(lang('Reset'))->addButton('button')->label('name')->render();
})->render()

 !!}