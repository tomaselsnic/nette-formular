<?php
namespace App\Presenters;
use Nette\Application\UI;
use Nette\Application\UI\Form;
use Nette;
use Czubehead\BootstrapForms\BootstrapForm;
use Czubehead\BootstrapForms\BootstrapRenderer;


class FormPresenter extends BasePresenter
{
	private $database;

    public function __construct(Nette\Database\Context $database)
    {
        $this->database = $database;
    }
	public function renderDefault()
	{
		$this->template->data = $this->database->table('data');
        $this->template->zakaznici = $this->database->table('zakaznici');
   
	}
		protected function createComponentRegistrationForm()
    {
		$data=$this->database->table('zakaznici')->fetchAll();
		$result=[];
		foreach($data as $key=>$value)
		{
			$result[$value->id]=$value->zakaznik;
		}
		
        $form = new UI\Form;
		$form->addSelect('id_zakaznici','Listy: ',$result)
			->setRequired();
        $form->addText('jmeno_kontakt', 'Jméno a kontaktní udaje zákazníka')
			->setRequired()
			->addRule(Form::MIN_LENGTH,'jméno a kontaktní údaje musí mít alespoň %d znaků',5);			
		$form->addDateTimePicker('datum_cas', 'Datum a čas:', 10, 10)
			->setRequired("vyplňte prosím všechna pole");
		$form->addText('helpdesk','#Medoro')
			->setRequired('vyplňte prosím všechna pole');
        $form->addText('jmenoMed', 'Jméno/Medoro:')
			->setRequired()
			->addRule(FORM::PATTERN,'jméno musí mít minimálně 3 znaky a začínat velkým písmenem!','([A-ZŽŠČŘĎŤŇ]){1}.([a-zžščřďťňáéěíýóúů]){1,}');
		$form->addText('kategorie', 'Kategorie spracování:')
			->setRequired('vyplňte prosím všechna pole');
		$form->addTextArea('servisni_zasah', 'Informace o zásahu:')
			->setRequired('vyplňte prosím všechna pole');
		$form->addTextArea('obecny_popis', 'obecný popis technických a organizačně bezpečnostních opatření:')
			->setRequired('vyplňte prosím všechna pole');
			$form->addSelect('predani_treti_zemi','Předání třetí zemi / mezinárodní organizace:',['NE','ANO'])
			->setRequired('vyplňte prosím všechna pole');
		$form->addTextArea('poznamky', 'Poznámka:')
			->setRequired('vyplňte prosím všechna pole');
        $form->addSubmit('send', 'Odeslat');
        $form->onSuccess[] = [$this, 'registrationFormSucceeded'];
		return $form;
		
    }
	public function registrationFormSucceeded(UI\Form $form, $values)
    {
		$this->database->table('data')->insert($values);
		$this->redirect('Homepage:default');
		
        
		
       	
	}
}   