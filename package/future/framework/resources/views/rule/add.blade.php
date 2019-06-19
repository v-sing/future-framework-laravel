{!!


 Form::action(function ($form)use ($ruledata){

        $form->radio()->field('ismenu',1)->label(lang('Ismenu'))->data(['1'=>lang('Yes'), '0'=>lang('No')])->render();
        $form->select()->field('pid')->label(lang('Parent'))->rule(['require'])->data($ruledata)->render();
        $form->text()->field()->label()->rule(['require'])->render();

 })->render();




 !!}