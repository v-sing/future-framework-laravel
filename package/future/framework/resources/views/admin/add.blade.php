{!!

     Form::action(function ($form)use ($groupdata){
         $form->selects()->field('group')->label(lang('Group'))->data($groupdata)->render();
         $form->text()->field('username')->label(lang('Username'))->rule(['require','username'])->render();
         $form->email()->field('email')->label(lang('Email'))->rule(['require','email'])->render();
         $form->button()->submit(lang('Submit'))->reset(lang('Reset'))->render();

     })->render();

 !!}