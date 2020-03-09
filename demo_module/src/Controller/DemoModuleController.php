<?php 
	
namespace Drupal\demo_module\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\Core\Render\Element;
use Drupal\Core\Routing;

/**
* Defines HelloController class.
*/ 
class DemoModuleController extends ControllerBase  {

    /**
    * Display the markup.
    *
    * @return array
    *   Return markup array.
    */
    public function list() {

        $firstname = \Drupal::request()->query->get('first_name');
        $lastname = \Drupal::request()->query->get('last_name');
        $email = \Drupal::request()->query->get('user_mail');

        $build = \Drupal::formBuilder()->getForm('\Drupal\demo_module\Form\FilterForm');

        $header = array(
            array('data' => t('ID'), 'field' => 'id'),
            array('data' => t('First Name'), 'field' => 'firstname'),
            array('data' => t('Last Name'), 'field' => 'lastname'),
            array('data' => t('Email'), 'field' => 'email'),
            array('data' => t('Actions')),
        );
        $query = db_select('contact_form', 'cf')->fields('cf', array('id', 'firstname', 'lastname', 'email'))
        ->extend('Drupal\Core\Database\Query\TableSortExtender')
        ->extend('Drupal\Core\Database\Query\PagerSelectExtender')
        ->orderByHeader($header);
        $data = $query->execute();
        $rows = array();
        foreach ($data as $row) {

            $delete = Url::fromUserInput( '/admin/config/demo_module/form/delete/'.$row->id );
            $edit   = Url::fromUserInput('/admin/config/demo_module/edit/?id='.$row->id );
            $mainLink = t('@linkApprove  @linkReject', array('@linkApprove' => \Drupal::l('Edit', $edit), '@linkReject' => \Drupal::l('Delete', $delete)));  
            //echo "<pre>"; print_r($row); echo "</pre>";  exit();
            $rows[] = array('id'=> $row->id, 'firstname' => $row->firstname, 'lastname' => $row->lastname, 'email' => $row->email, 'edit' =>   $mainLink );

        }
        if($firstname == "" && $lastname =="" && $email ==""){

            $build['table_pager'][] = array(
              '#type' => 'table',
              '#header' => $header,
              '#rows' => get_search_details("All",$firstname="",$lastname="",$email="", $header),
              '#empty' => t('No data found'),
            );

        }else{

            $build['table_pager'][] = array(
              '#type' => 'table',
              '#header' => $header,
              '#rows' => get_search_details( "",$firstname, $lastname, $email, $header ),
              '#empty' => t('No data found'),
            );

        }
        $build['table_pager'][] = array(
            '#type' => 'pager',
        );
      return $build;
    }

}

?>