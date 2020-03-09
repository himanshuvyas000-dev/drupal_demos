<?php

namespace Drupal\demo_module\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\ConfirmFormBase;
use Drupal\Core\Url;
use Drupal\Core\Render\Element;


/**
* Class DeleteForm.
*
* @package Drupal\mydata\Form
*/
class DeleteForm extends ConfirmFormBase {

    /**
    * {@inheritdoc}
    */
    public function getFormId() {
        return 'delete_form';
    }

    public $cid;

    public function getQuestion() { 
        return t('Do you want to delete %cid?', array('%cid' => $this->cid));
    }

    public function getCancelUrl() {
        return new Url('demo_module.list');
    }

    public function getDescription() {
        return t('Only do this if you are sure!');
    }

    /**
    * {@inheritdoc}
    */
    public function getConfirmText() {
        return t('Delete it!');
    }

    /**
    * {@inheritdoc}
    */
    public function getCancelText() {
         return t('Cancel');
    }

    /**
    * {@inheritdoc}
    */
    public function buildForm( array $form, FormStateInterface $form_state, $cid = NULL ) {

        $this->id = $cid;
        return parent::buildForm($form, $form_state);
    }

    /**
    * {@inheritdoc}
    */
    public function submitForm( array &$form, FormStateInterface $form_state ) {

        db_delete('contact_form')->condition('id',$this->id)->execute();
        drupal_set_message("succesfully deleted");
        $form_state->setRedirect('demo_module.list');

    }
    
}
