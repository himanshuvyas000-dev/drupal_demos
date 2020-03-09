<?php

/**
 * @file
 * Contains \Drupal\resume\Form\WorkForm.
 */	
namespace Drupal\demo_module\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Render\Markup;

class CustomForm extends FormBase {

	/**
	* {@inheritdoc}
	*/
	public function getFormId() {
	    return 'demo_form';
	}

	/**
	* {@inheritdoc}
	*/
	public function buildForm(array $form, FormStateInterface $form_state) {

	    $form['first_name'] = array(
	      '#type' => 'textfield',
	      '#title' => t('FirstName:'),
	      '#required' => TRUE,
	    );

	    $form['last_name'] = array(
	      '#type' => 'textfield',
	      '#title' => t('LastName:'),
	      '#required' => TRUE,
	    );

	    $form['user_mail'] = array(
	      '#type' => 'email',
	      '#title' => t('Email ID:'),
	      '#required' => TRUE,
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
	public function submitForm(array &$form, FormStateInterface $form_state) {


		$userCurrent = \Drupal::currentUser();
		$user = \Drupal\user\Entity\User::load($userCurrent->id());
		$uid = $user->get('uid')->value;

		// Here u can insert Your custom form values into your custom table.
		db_insert('contact_form')->fields(
			array(	
			'firstname' => $form_state->getValue('first_name'),
			'lastname' => $form_state->getValue('last_name'),
			'email' => $form_state->getValue('user_mail'),
			))->execute();
		drupal_set_message("Successfully submitted your contact details");

		$mailManager = \Drupal::service('plugin.manager.mail');
		$module = 'demo_module';
		$key = 'demo_module_form';
		$to = "himanshu.vyas@neosofttech.com";
		$body = '<html>
					<head>
					<style>
						table, th, td {
						  border: 1px double black;
						  border-collapse: collapse;
						  text-align:left;
						}
					</style>
					</head>
				<body>
				<h4>Contact form details:</h4>
				<table style="width:50%">
				  <tr>
				    <th>Firstname</th>
				    <th>Lastname</th> 
				    <th>Email</th>
				  </tr>
				  <tr>
				    <td>'.$form_state->getValue('first_name').'</td>
				    <td>'.$form_state->getValue('last_name').'</td>
				    <td>'.$form_state->getValue('user_mail').'</td>
				  </tr>
				</table>
				</body>
				</html>';
		$params['message'] = Markup::create($body);
		$langcode = \Drupal::currentUser()->getPreferredLangcode();
		$send = true;
		$result = $mailManager->mail($module, $key, $to, $langcode, $params, NULL, $send);
		if ($result['result'] !== true) {
		   drupal_set_message(t('There was a problem sending your message and it was not sent.'), 'error');
		}
		else {}

	}
}

?>