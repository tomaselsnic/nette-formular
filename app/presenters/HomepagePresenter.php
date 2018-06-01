<?php

namespace App\Presenters;
use Nette\Application\UI;
use Nette;


class HomepagePresenter extends BasePresenter
{
	private $database;

    public function __construct(Nette\Database\Context $database)
    {
        $this->database = $database;
    }
    public function renderDefault()
	{
		$this->template->data = $this->database->table('data');
        
   
	}	
	 protected function createComponentCustomer()
	 {
	 $form = new UI\Form;
	 $form->addText('zakaznik', 'Přidat zákazníka: ');
	 $form->addSubmit('send', 'Odeslat');
	 $form->onSuccess[] = [$this, 'registrationFormSucceeded'];
	return $form;
	 }
	public function registrationFormSucceeded(UI\Form $form, $values)
    {
		
        $this->database->table('zakaznici')->insert($values);
		$this->redirect('this');

       	
	}
	
	
}
