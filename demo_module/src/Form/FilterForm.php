<?php

namespace Drupal\demo_module\Form;
 
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;
use Drupal\Core\Url;
use Drupal\Core\Routing;
 
/**
* Provides the form for filter Students.
*/
class FilterForm extends FormBase {

    /**
    * {@inheritdoc}
    */
    public function getFormId() {
        return 'demo_filter_form';
    }
 
    /**
    * {@inheritdoc}
    */
    public function buildForm(array $form, FormStateInterface $form_state) {
      
   
        $form['filters'] = [
            '#type'  => 'fieldset',
            '#title' => $this->t('Filter'),
            '#open'  => true,
        ];
   
        $form['filters']['first_name'] = [
            '#title'         => 'First Name',
            '#type'          => 'search'	
        ];
        $form['filters']['last_name'] = [
            '#title'         => 'Last Name',
            '#type'          => 'search'
        ];
        $form['filters']['user_mail'] = [
            '#title'         => 'Email',
            '#type'          => 'search'
        ];
        $form['filters']['actions'] = [
            '#type'       => 'actions'
        ];
   
        $form['filters']['actions']['submit'] = [
            '#type'  => 'submit',
            '#value' => $this->t('Filter')	
        ];
        
        return $form;

    }
 
    /**
    * {@inheritdoc}
    */
/*    public function validateForm(array &$form, FormStateInterface $form_state) {
     
        if ( $form_state->getValue('first_name') == "") {
        	$form_state->setErrorByName('first_name', $this->t('You must enter a valid firstname.'));
        }
        elseif( $form_state->getValue('last_name') == ""){
        	$form_state->setErrorByName('last_name', $this->t('You must enter a valid to lastname.'));
        }
        elseif( $form_state->getValue('user_mail') == ""){
            $form_state->setErrorByName('user_mail', $this->t('You must enter a valid email address.'));
        }
	 
    }*/

    /**
    * {@inheritdoc}
    */
    public function submitForm(array & $form, FormStateInterface $form_state) {	  
        $field = $form_state->getValues();
        $firstname = $field["first_name"];
        $lastname = $field["last_name"];
        $email = $field["user_mail"];
        $url = \Drupal\Core\Url::fromRoute('demo_module.list')
        ->setRouteParameters(array('first_name'=>$firstname,'last_name'=>$lastname,'user_mail'=>$email));
        $form_state->setRedirectUrl($url); 
    }
 
}