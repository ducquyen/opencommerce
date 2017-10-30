<?php
class ControllerMailTransaction extends Controller {
	public function index($route, $args, $output) {
		if (isset($args[0])) {
			$customer_id = $args[0];
		} else {
			$customer_id = '';
		}
		
		if (isset($args[1])) {
			$description = $args[1];
		} else {
			$description = '';
		}		
		
		if (isset($args[2])) {
			$amount = $args[2];
		} else {
			$amount = '';
		}
		
		if (isset($args[3])) {
			$order_id = $args[3];
		} else {
			$order_id = '';
		}
			
		$this->load->model('customer/customer_admin');
						
		$customer_info = $this->model_customer_customer_admin->getCustomer($customer_id);

		if ($customer_info) {
			$this->load->language('mail/transaction');

			$this->load->model('setting/store');

			$store_info = $this->model_setting_store->getStore($customer_info['store_id']);

			if ($store_info) {
				$store_name = $store_info['name'];
			} else {
				$store_name = $this->config->get('config_name');
			}

			$data['text_received'] = sprintf($this->language->get('text_received'), $this->currency->format($amount, $this->config->get('config_currency')));
			$data['text_total'] = sprintf($this->language->get('text_total'), $this->currency->format($this->model_customer_customer_admin->getTransactionTotal($customer_id), $this->config->get('config_currency')));

            $mail = $this->registry->get('Mail');
            $email = $customer_info['email'];

			$mail->setSubject(sprintf($this->language->get('text_subject'), html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8')));
			$mail->setText($this->load->view('mail/transaction', $data));
			$mail->send($email);
		}
	}		
}	
