<?php

namespace Drupal\demo_module\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\ConfirmFormBase;
use Drupal\Core\Url;
use Drupal\Core\Render\Element;

/**
* Class EditForm.
*
* @package Drupal\mydata\Form
*/
class EditForm extends FormBase {

    /**
    * {@inheritdoc}
    */
    public function getFormId() {
        return 'edit_form';
    }

    public $cid;

    /**
    * {@inheritdoc}
    */
    public function buildForm( array $form, FormStateInterface $form_state, $cid = NULL ) {
      
        $data = array();
        if (isset($_GET['id'])) { 
            $query = db_select('contact_form', 'cf')->fields('cf')->condition( 'id', $_GET['id'] )
            ->extend('Drupal\Core\Database\Query\TableSortExtender')
            ->extend('Drupal\Core\Database\Query\PagerSelectExtender');
            $data = $query->execute()->fetchAssoc();
        } 

        $this->id = $cid;
        $form['first_name'] = array(
            '#type' => 'textfield',
            '#title' => t('FirstName:'),
            '#required' => TRUE,
            '#default_value' => (isset($data['firstname']) && $_GET['id']) ? $data['firstname']:'',
        );

        $form['last_name'] = array(
            '#type' => 'textfield',
            '#title' => t('LastName:'),
            '#required' => TRUE,
            '#default_value' => (isset($data['lastname']) && $_GET['id']) ? $data['lastname']:'',
        );

        $form['user_mail'] = array(
            '#type' => 'email',
            '#title' => t('Email ID:'),
            '#required' => TRUE,
            '#default_value' => (isset($data['email']) && $_GET['id']) ? $data['email']:'',
        );

        $form['actions']['#type'] = 'actions';
        $form['actions']['submit'] = array(
            '#type' => 'submit',
            '#value' => $this->t('Submit'),
            '#button_type' => 'primary',
        );
      return $form;

    }
  

    /**
    * {@inheritdoc}
    */
    public function submitForm( array &$form, FormStateInterface $form_state ) {

        if (isset($_GET['id'])) {

        db_update('contact_form')->fields(
        array(  
            'firstname' => $form_state->getValue('first_name'),
            'lastname' => $form_state->getValue('last_name'),
            'email' => $form_state->getValue('user_mail'),
        )
        )->condition('id', $_GET['id'])->execute();
            drupal_set_message("succesfully updated");
            $form_state->setRedirect('demo_module.list');
        } 

    }

}
