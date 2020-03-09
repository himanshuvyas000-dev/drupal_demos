<?php

namespace Drupal\demo_module\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Block\BlockPluginInterface;
use Drupal\Core\Form\FormInterface;

/**
 * Provides a 'Demo' Block.
 *
 * @Block(
 *   id = "demo_block",
 *   admin_label = @Translation("Demo Module Block"),
 *   category = @Translation("Hello World"),
 * )
 */
class DemoBlock extends BlockBase {

   /**
   * {@inheritdoc}
   */
  	public function build() {
		
    	$form = \Drupal::formBuilder()->getForm('Drupal\demo_module\Form\CustomForm');	

    	return $form;


   	}

}

?>