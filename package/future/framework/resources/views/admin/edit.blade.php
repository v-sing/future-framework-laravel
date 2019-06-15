{!!

     Form::action(function ($form)use ($groupdata,$row,$groupids){
         $form->selects()->field('group[]',$groupids)->label(lang('Group'))->data($groupdata)->render();
         $form->text()->field('username',$row['username'])->label(lang('Username'))->rule(['require','username'])->render();
         $form->email()->field('email',$row['email'])->label(lang('Email'))->rule(['require','email'])->render();
         $form->text()->field('nickname',$row['nickname'])->label(lang('Nickname'))->rule(['require'])->render();
         $form->password()->field('password')->label(lang('Password'))->rule(['require'])->render();
         $form->radio()->field('status',$row['status'])->label(lang('Status'))->data( ['normal'=>lang('Normal'), 'hidden'=>lang('Hidden')])->render();
         $form->button()->submit(lang('Submit'))->reset(lang('Reset'))->render();
     })->render();

 !!}