<?php
class ControllerMailCustomer extends Controller {
	public function approve(&$route, &$args, &$output) {
		$this->load->model('customer/customer');
		
		$customer_info = $this->model_customer_customer->getCustomer($args[0]);

		if ($customer_info) {
			$this->load->model('setting/store');
	
			$store_info = $this->model_setting_store->getStore($customer_info['store_id']);
	
			if ($store_info) {
				$store_name = html_entity_decode($store_info['name'], ENT_QUOTES, 'UTF-8');
				$store_url = $store_info['url'] . 'index.php?route=account/login';
			} else {
				$store_name = html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8');
				$store_url = HTTP_CATALOG . 'index.php?route=account/login';
			}
			
			$this->load->model('localisation/language');
			
			$language_info = $this->model_localisation_language->getLanguage($customer_info['language_id']);

			if ($language_info) {
				$language_code = $language_info['code'];
			} else {
				$language_code = $this->config->get('config_language');
			}
			
			$language = new Language($language_code);
			$language->load($language_code);
			$language->load('mail/customer_approve');
						
			$subject = sprintf($language->get('text_subject'), $store_name);
								
			$data['text_welcome'] = sprintf($this->language->get('text_welcome'), $store_name);
			$data['text_login'] = $this->language->get('text_login');
			$data['text_service'] = $this->language->get('text_service');
			$data['text_thanks'] = $this->language->get('text_thanks');
				
			$data['login'] = $store_url . 'index.php?route=account/login';	
			$data['store'] = $store_name;
	
			$mail = new Mail();
			$mail->protocol = $this->config->get('config_mail_protocol');
			$mail->parameter = $this->config->get('config_mail_parameter');
			$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
			$mail->smtp_username = $this->config->get('config_mail_smtp_username');
			$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
			$mail->smtp_port = $this->config->get('config_mail_smtp_port');
			$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');
	
			$mail->setTo($customer_info['email']);
			$mail->setFrom($this->config->get('config_email'));
			$mail->setSender($store_name);
			$mail->setSubject($subject);
			$mail->setText($this->load->view('mail/customer_approve', $data));
			$mail->send(); 
		}
	}
	
	public function deny($customer_id) {
		$customer_info = $this->getCustomer($customer_id);

		if ($customer_info) {
			$this->load->model('setting/store');

			$store_info = $this->model_setting_store->getStore($customer_info['store_id']);

			if ($store_info) {
				$store_name = $store_info['name'];
				$store_url = $store_info['url'] . 'index.php?route=account/login';
			} else {
				$store_name = $this->config->get('config_name');
				$store_url = HTTP_CATALOG . 'index.php?route=account/login';
			}

			$this->load->model('localisation/language');
			
			$language_info = $this->model_localisation_language->getLanguage($customer_info['language_id']);

			if ($language_info) {
				$language_code = $language_info['code'];
			} else {
				$language_code = $this->config->get('config_language');
			}

			$language = new Language($language_code);
			$language->load($language_code);
			$language->load('mail/customer');
				
			$subject = sprintf($language->get('text_subject'), html_entity_decode($store_name, ENT_QUOTES, 'UTF-8'));
				
			$data['text_welcome'] = sprintf($this->language->get('text_welcome'), $store_name);
			$data['text_denied'] = $language->get('text_denied');
			$data['text_thanks'] = $this->language->get('text_thanks');
				
			$data['contact'] = $store_url . 'index.php?route=information/contact';	
			$data['store'] = $store_name;

			$mail = new Mail();
			$mail->protocol = $this->config->get('config_mail_protocol');
			$mail->parameter = $this->config->get('config_mail_parameter');
			$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
			$mail->smtp_username = $this->config->get('config_mail_smtp_username');
			$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
			$mail->smtp_port = $this->config->get('config_mail_smtp_port');
			$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

			$mail->setTo($customer_info['email']);
			$mail->setFrom($this->config->get('config_email'));
			$mail->setSender(html_entity_decode($store_name, ENT_QUOTES, 'UTF-8'));
			$mail->setSubject($subject);
			$mail->setText($this->load->view('mail/customer_deny', $data));
			$mail->send();
		}
	}
}	