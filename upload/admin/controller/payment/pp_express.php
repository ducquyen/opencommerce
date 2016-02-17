<?php
class ControllerPaymentPPExpress extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('payment/pp_express');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('pp_express', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], true));
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_signup'] = $this->language->get('text_signup');
		$data['text_sandbox'] = $this->language->get('text_sandbox');		
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_all_zones'] = $this->language->get('text_all_zones');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');
		$data['text_authorization'] = $this->language->get('text_authorization');
		$data['text_sale'] = $this->language->get('text_sale');
		
		$data['entry_username'] = $this->language->get('entry_username');
		$data['entry_password'] = $this->language->get('entry_password');
		$data['entry_signature'] = $this->language->get('entry_signature');
		$data['entry_sandbox_username'] = $this->language->get('entry_sandbox_username');
		$data['entry_sandbox_password'] = $this->language->get('entry_sandbox_password');
		$data['entry_sandbox_signature'] = $this->language->get('entry_sandbox_signature');
		$data['entry_ipn'] = $this->language->get('entry_ipn');
		$data['entry_test'] = $this->language->get('entry_test');
		$data['entry_debug'] = $this->language->get('entry_debug');
		$data['entry_currency'] = $this->language->get('entry_currency');
		$data['entry_recurring_cancel'] = $this->language->get('entry_recurring_cancel');		
		$data['entry_transaction'] = $this->language->get('entry_transaction');
		$data['entry_total'] = $this->language->get('entry_total');
		$data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$data['entry_canceled_reversal_status'] = $this->language->get('entry_canceled_reversal_status');
		$data['entry_completed_status'] = $this->language->get('entry_completed_status');
		$data['entry_denied_status'] = $this->language->get('entry_denied_status');
		$data['entry_expired_status'] = $this->language->get('entry_expired_status');
		$data['entry_failed_status'] = $this->language->get('entry_failed_status');
		$data['entry_pending_status'] = $this->language->get('entry_pending_status');
		$data['entry_processed_status'] = $this->language->get('entry_processed_status');
		$data['entry_refunded_status'] = $this->language->get('entry_refunded_status');
		$data['entry_reversed_status'] = $this->language->get('entry_reversed_status');
		$data['entry_voided_status'] = $this->language->get('entry_voided_status');
		$data['entry_allow_notes'] = $this->language->get('entry_allow_notes');
		$data['entry_logo'] = $this->language->get('entry_logo');
		$data['entry_colour'] = $this->language->get('entry_colour');

		$data['help_total'] = $this->language->get('help_total');
		$data['help_ipn'] = $this->language->get('help_ipn');
		$data['help_currency'] = $this->language->get('help_currency');
		$data['help_logo'] = $this->language->get('help_logo');
		$data['help_colour'] = $this->language->get('help_colour');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_search'] = $this->language->get('button_search');

		$data['tab_api'] = $this->language->get('tab_api');
		$data['tab_general'] = $this->language->get('tab_general');
		$data['tab_order_status'] = $this->language->get('tab_order_status');
		$data['tab_checkout'] = $this->language->get('tab_checkout');
		
		$data['token'] = $this->session->data['token'];

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['username'])) {
			$data['error_username'] = $this->error['username'];
		} else {
			$data['error_username'] = '';
		}

		if (isset($this->error['password'])) {
			$data['error_password'] = $this->error['password'];
		} else {
			$data['error_password'] = '';
		}

		if (isset($this->error['signature'])) {
			$data['error_signature'] = $this->error['signature'];
		} else {
			$data['error_signature'] = '';
		}

		if (isset($this->error['sandbox_username'])) {
			$data['error_sandbox_username'] = $this->error['sandbox_username'];
		} else {
			$data['error_sandbox_username'] = '';
		}

		if (isset($this->error['sandbox_password'])) {
			$data['error_sandbox_password'] = $this->error['sandbox_password'];
		} else {
			$data['error_sandbox_password'] = '';
		}

		if (isset($this->error['sandbox_signature'])) {
			$data['error_sandbox_signature'] = $this->error['sandbox_signature'];
		} else {
			$data['error_sandbox_signature'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true),
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_payment'),
			'href' => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], true),
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('payment/pp_express', 'token=' . $this->session->data['token'], true),
		);

		$data['action'] = $this->url->link('payment/pp_express', 'token=' . $this->session->data['token'], true);
		$data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], true);
		$data['search'] = $this->url->link('payment/pp_express/search', 'token=' . $this->session->data['token'], true);

		$this->load->model('localisation/country');

		$country_info = $this->model_localisation_country->getCountry($this->config->get('config_country_id'));

		$data['signup'] = 'https://www.paypal.com/webapps/merchantboarding/webflow/externalpartnerflow?countryCode=' . $country_info['iso_code_2'] . '&integrationType=F&merchantId=David111&displayMode=minibrowser&partnerId=9PDNYE4RZBVFJ&productIntentID=addipmt&receiveCredentials=TRUE&returnToPartnerUrl=' . base64_encode(html_entity_decode($this->url->link('payment/pp_express/live', 'token=' . $this->session->data['token'], true))) . '&subIntegrationType=S';
		$data['sandbox'] = 'https://www.sandbox.paypal.com/webapps/merchantboarding/webflow/externalpartnerflow?countryCode=' . $country_info['iso_code_2'] . '&integrationType=F&merchantId=David111&displayMode=minibrowser&partnerId=T4E8WSXT43QPJ&productIntentID=addipmt&receiveCredentials=TRUE&returnToPartnerUrl=' . base64_encode(html_entity_decode($this->url->link('payment/pp_express/sandbox', 'token=' . $this->session->data['token'], true))) . '&subIntegrationType=S';

		if (isset($this->request->post['pp_express_username'])) {
			$data['pp_express_username'] = $this->request->post['pp_express_username'];
		} else {
			$data['pp_express_username'] = $this->config->get('pp_express_username');
		}

		if (isset($this->request->post['pp_express_password'])) {
			$data['pp_express_password'] = $this->request->post['pp_express_password'];
		} else {
			$data['pp_express_password'] = $this->config->get('pp_express_password');
		}

		if (isset($this->request->post['pp_express_signature'])) {
			$data['pp_express_signature'] = $this->request->post['pp_express_signature'];
		} else {
			$data['pp_express_signature'] = $this->config->get('pp_express_signature');
		}

		if (isset($this->request->post['pp_express_sandbox_username'])) {
			$data['pp_express_sandbox_username'] = $this->request->post['pp_express_sandbox_username'];
		} else {
			$data['pp_express_sandbox_username'] = $this->config->get('pp_express_sandbox_username');
		}

		if (isset($this->request->post['pp_express_sandbox_password'])) {
			$data['pp_express_sandbox_password'] = $this->request->post['pp_express_sandbox_password'];
		} else {
			$data['pp_express_sandbox_password'] = $this->config->get('pp_express_sandbox_password');
		}

		if (isset($this->request->post['pp_express_sandbox_signature'])) {
			$data['pp_express_sandbox_signature'] = $this->request->post['pp_express_sandbox_signature'];
		} else {
			$data['pp_express_sandbox_signature'] = $this->config->get('pp_express_sandbox_signature');
		}

		$data['ipn_url'] = HTTPS_CATALOG . 'index.php?route=payment/pp_express/ipn';

		if (isset($this->request->post['pp_express_test'])) {
			$data['pp_express_test'] = $this->request->post['pp_express_test'];
		} else {
			$data['pp_express_test'] = $this->config->get('pp_express_test');
		}

		if (isset($this->request->post['pp_express_debug'])) {
			$data['pp_express_debug'] = $this->request->post['pp_express_debug'];
		} else {
			$data['pp_express_debug'] = $this->config->get('pp_express_debug');
		}
		
		if (isset($this->request->post['pp_express_currency'])) {
			$data['pp_express_currency'] = $this->request->post['pp_express_currency'];
		} else {
			$data['pp_express_currency'] = $this->config->get('pp_express_currency');
		}

		$this->load->model('payment/pp_express');

		$data['currencies'] = $this->model_payment_pp_express->getCurrencies();
		
		if (isset($this->request->post['pp_express_recurring_cancel'])) {
			$data['pp_express_recurring_cancel'] = $this->request->post['pp_express_recurring_cancel'];
		} else {
			$data['pp_express_recurring_cancel'] = $this->config->get('pp_express_recurring_cancel');
		}			
				
		if (isset($this->request->post['pp_express_transaction'])) {
			$data['pp_express_transaction'] = $this->request->post['pp_express_transaction'];
		} else {
			$data['pp_express_transaction'] = $this->config->get('pp_express_transaction');
		}

		if (isset($this->request->post['pp_express_total'])) {
			$data['pp_express_total'] = $this->request->post['pp_express_total'];
		} else {
			$data['pp_express_total'] = $this->config->get('pp_express_total');
		}

		if (isset($this->request->post['pp_express_geo_zone_id'])) {
			$data['pp_express_geo_zone_id'] = $this->request->post['pp_express_geo_zone_id'];
		} else {
			$data['pp_express_geo_zone_id'] = $this->config->get('pp_express_geo_zone_id');
		}

		$this->load->model('localisation/geo_zone');

		$data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		if (isset($this->request->post['pp_express_status'])) {
			$data['pp_express_status'] = $this->request->post['pp_express_status'];
		} else {
			$data['pp_express_status'] = $this->config->get('pp_express_status');
		}

		if (isset($this->request->post['pp_express_sort_order'])) {
			$data['pp_express_sort_order'] = $this->request->post['pp_express_sort_order'];
		} else {
			$data['pp_express_sort_order'] = $this->config->get('pp_express_sort_order');
		}

		if (isset($this->request->post['pp_express_canceled_reversal_status_id'])) {
			$data['pp_express_canceled_reversal_status_id'] = $this->request->post['pp_express_canceled_reversal_status_id'];
		} else {
			$data['pp_express_canceled_reversal_status_id'] = $this->config->get('pp_express_canceled_reversal_status_id');
		}

		if (isset($this->request->post['pp_express_completed_status_id'])) {
			$data['pp_express_completed_status_id'] = $this->request->post['pp_express_completed_status_id'];
		} else {
			$data['pp_express_completed_status_id'] = $this->config->get('pp_express_completed_status_id');
		}

		if (isset($this->request->post['pp_express_denied_status_id'])) {
			$data['pp_express_denied_status_id'] = $this->request->post['pp_express_denied_status_id'];
		} else {
			$data['pp_express_denied_status_id'] = $this->config->get('pp_express_denied_status_id');
		}

		if (isset($this->request->post['pp_express_expired_status_id'])) {
			$data['pp_express_expired_status_id'] = $this->request->post['pp_express_expired_status_id'];
		} else {
			$data['pp_express_expired_status_id'] = $this->config->get('pp_express_expired_status_id');
		}

		if (isset($this->request->post['pp_express_failed_status_id'])) {
			$data['pp_express_failed_status_id'] = $this->request->post['pp_express_failed_status_id'];
		} else {
			$data['pp_express_failed_status_id'] = $this->config->get('pp_express_failed_status_id');
		}

		if (isset($this->request->post['pp_express_pending_status_id'])) {
			$data['pp_express_pending_status_id'] = $this->request->post['pp_express_pending_status_id'];
		} else {
			$data['pp_express_pending_status_id'] = $this->config->get('pp_express_pending_status_id');
		}

		if (isset($this->request->post['pp_express_processed_status_id'])) {
			$data['pp_express_processed_status_id'] = $this->request->post['pp_express_processed_status_id'];
		} else {
			$data['pp_express_processed_status_id'] = $this->config->get('pp_express_processed_status_id');
		}

		if (isset($this->request->post['pp_express_refunded_status_id'])) {
			$data['pp_express_refunded_status_id'] = $this->request->post['pp_express_refunded_status_id'];
		} else {
			$data['pp_express_refunded_status_id'] = $this->config->get('pp_express_refunded_status_id');
		}

		if (isset($this->request->post['pp_express_reversed_status_id'])) {
			$data['pp_express_reversed_status_id'] = $this->request->post['pp_express_reversed_status_id'];
		} else {
			$data['pp_express_reversed_status_id'] = $this->config->get('pp_express_reversed_status_id');
		}

		if (isset($this->request->post['pp_express_voided_status_id'])) {
			$data['pp_express_voided_status_id'] = $this->request->post['pp_express_voided_status_id'];
		} else {
			$data['pp_express_voided_status_id'] = $this->config->get('pp_express_voided_status_id');
		}

		$this->load->model('localisation/order_status');
		
		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		if (isset($this->request->post['pp_express_allow_note'])) {
			$data['pp_express_allow_note'] = $this->request->post['pp_express_allow_note'];
		} else {
			$data['pp_express_allow_note'] = $this->config->get('pp_express_allow_note');
		}

		if (isset($this->request->post['pp_express_colour'])) {
			$data['pp_express_colour'] = str_replace('#', '', $this->request->post['pp_express_colour']);
		} else {
			$data['pp_express_colour'] = $this->config->get('pp_express_colour');
		}
		
		if (isset($this->request->post['pp_express_logo'])) {
			$data['pp_express_logo'] = $this->request->post['pp_express_logo'];
		} else {
			$data['pp_express_logo'] = $this->config->get('pp_express_logo');
		}

		$this->load->model('tool/image');

		if (isset($this->request->post['pp_express_logo']) && is_file(DIR_IMAGE . $this->request->post['pp_express_logo'])) {
			$data['thumb'] = $this->model_tool_image->resize($this->request->post['pp_express_logo'], 750, 90);
		} elseif (is_file(DIR_IMAGE . $this->config->get('pp_express_logo'))) {
			$data['thumb'] = $this->model_tool_image->resize($this->config->get('pp_express_logo'), 750, 90);
		} else {
			$data['thumb'] = $this->model_tool_image->resize('no_image.png', 750, 90);
		}

		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 750, 90);

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('payment/pp_express', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'payment/pp_express')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ($this->request->post['pp_express_test']) {
			if (!$this->request->post['pp_express_sandbox_username']) {
				$this->error['sandbox_username'] = $this->language->get('error_sandbox_username');
			}

			if (!$this->request->post['pp_express_sandbox_password']) {
				$this->error['sandbox_password'] = $this->language->get('error_sandbox_password');
			}

			if (!$this->request->post['pp_express_sandbox_signature']) {
				$this->error['sandbox_signature'] = $this->language->get('error_sandbox_signature');
			}
		} else {
			if (!$this->request->post['pp_express_username']) {
				$this->error['username'] = $this->language->get('error_username');
			}

			if (!$this->request->post['pp_express_password']) {
				$this->error['password'] = $this->language->get('error_password');
			}

			if (!$this->request->post['pp_express_signature']) {
				$this->error['signature'] = $this->language->get('error_signature');
			}
		}

		return !$this->error;
	}

	public function install() {
		$this->load->model('payment/pp_express');
		
		$this->model_payment_pp_express->install();
	}

	public function uninstall() {
		$this->load->model('payment/pp_express');
		
		$this->model_payment_pp_express->uninstall();
	}

	public function order() {
		if ($this->config->get('pp_express_status')) {
			$this->load->language('payment/pp_express_order');
		
			if (isset($this->request->get['order_id'])) {
				$order_id = $this->request->get['order_id'];
			} else {
				$order_id = 0;
			}	
					
			$this->load->model('payment/pp_express');
			
			$paypal_info = $this->model_payment_pp_express->getOrder($order_id);

			if ($paypal_info) {
				$data['text_payment'] = $this->language->get('text_payment');				
				$data['text_capture'] = $this->language->get('text_capture');
				$data['text_transaction'] = $this->language->get('text_transaction');
				$data['text_capture_status'] = $this->language->get('text_capture_status');
				$data['text_amount_authorised'] = $this->language->get('text_amount_authorised');
				$data['text_amount_captured'] = $this->language->get('text_amount_captured');
				$data['text_amount_refunded'] = $this->language->get('text_amount_refunded');
				$data['text_confirm_void'] = $this->language->get('text_confirm_void');
				$data['text_loading'] = $this->language->get('text_loading');
								
				$data['entry_capture_amount'] = $this->language->get('entry_capture_amount');
				$data['entry_capture_complete'] = $this->language->get('entry_capture_complete');								
								
				$data['button_void'] = $this->language->get('button_void');
				$data['button_capture'] = $this->language->get('button_capture');
	
				$data['token'] = $this->session->data['token'];
				
				$data['order_id'] = $this->request->get['order_id'];
				
				$data['capture_status'] = $paypal_info['capture_status'];
				
				$data['total'] = $paypal_info['total'];

				$captured = number_format($this->model_payment_pp_express->getTotalCaptured($paypal_info['paypal_order_id']), 2);
				$refunded = number_format($this->model_payment_pp_express->getTotalRefunded($paypal_info['paypal_order_id']), 2);

				$data['captured'] = $captured;
				$data['refunded'] = $refunded;
				$data['remaining'] = number_format($paypal_info['total'] - $captured, 2);
				
				return $this->load->view('payment/pp_express_order', $data);
			}
		}
	}
	
	public function transaction() {
		$this->load->language('payment/pp_express_order');
		
		if (isset($this->request->get['order_id'])) {
			$order_id = $this->request->get['order_id'];
		} else {
			$order_id = 0;
		}	

		$this->load->model('payment/pp_express');
		
		$paypal_info = $this->model_payment_pp_express->getOrder($order_id);
		
		$data['text_no_results'] = $this->language->get('text_no_results');
		
		$data['column_transaction'] = $this->language->get('column_transaction');
		$data['column_amount'] = $this->language->get('column_amount');
		$data['column_type'] = $this->language->get('column_type');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_pending_reason'] = $this->language->get('column_pending_reason');
		$data['column_date_added'] = $this->language->get('column_date_added');
		$data['column_action'] = $this->language->get('column_action');

		$data['button_view'] = $this->language->get('button_view');
		$data['button_refund'] = $this->language->get('button_refund');
		$data['button_resend'] = $this->language->get('button_resend');

		$data['transactions'] = array();
				
		if ($paypal_info) {	
			$results = $this->model_payment_pp_express->getTransactions($paypal_info['paypal_order_id']);
	
			foreach ($results as $result) {
				$data['transactions'][] = array(
					'transaction_id' => $result['transaction_id'],
					'amount'         => $result['amount'],
					'payment_type'   => $result['payment_type'],
					'payment_status' => $result['payment_status'],
					'pending_reason' => $result['pending_reason'],
					'date_added'     => date($this->language->get('datetime_format'), strtotime($result['date_added'])),
					'view'           => $this->url->link('payment/pp_express/info', 'token=' . $this->session->data['token'] . '&transaction_id=' . $result['transaction_id'], true),
					'refund'         => $this->url->link('payment/pp_express/refund', 'token=' . $this->session->data['token'] . '&paypal_order_transaction_id=' . $result['paypal_order_transaction_id'], true),
					'resend'         => $this->url->link('payment/pp_express/resend', 'token=' . $this->session->data['token'] . '&paypal_order_transaction_id=' . $result['paypal_order_transaction_id'], true)
				);
			}
		}
		
		$this->response->setOutput($this->load->view('payment/pp_express_transaction', $data));	
	}
	
	public function capture() {
		$json = array();
		
		$this->load->language('payment/pp_express');
		
		if (!isset($this->request->post['amount']) && $this->request->post['amount'] > 0) {
			$json['error'] = $this->language->get('error_capture');
		}
		
		if (!$json) {
			$this->load->model('payment/pp_express');
		
			if (isset($this->request->get['order_id'])) {
				$order_id = $this->request->get['order_id'];
			} else {
				$order_id = 0;
			}
		
			$paypal_info = $this->model_payment_pp_express->getOrder($order_id);
		
			if ($paypal_info) {
				// Curl
				if (!$this->config->get('pp_express_test')) {
					$api_url = 'https://api-3t.paypal.com/nvp';
					$api_username = $this->config->get('pp_express_username');
					$api_password = $this->config->get('pp_express_password');
					$api_signature = $this->config->get('pp_express_signature');
				} else {				
					$api_url = 'https://api-3t.sandbox.paypal.com/nvp';
					$api_username = $this->config->get('pp_express_sandbox_username');
					$api_password = $this->config->get('pp_express_sandbox_password');
					$api_signature = $this->config->get('pp_express_sandbox_signature');
				}
		
				// If this is the final amount to capture or not
				if ($this->request->post['complete']) {
					$complete = 'Complete';
				} else {
					$complete = 'NotComplete';
				}
		
				$request = array(
					'USER'            => $api_username,
					'PWD'             => $api_password,
					'SIGNATURE'       => $api_signature,
					'VERSION'         => '84',
					'BUTTONSOURCE'    => 'OpenCart_Cart_EC',	
					'METHOD'          => 'DoCapture',
					'AUTHORIZATIONID' => $paypal_info['authorization_id'],
					'AMT'             => number_format($this->request->post['amount'], 2),
					'CURRENCYCODE'    => $paypal_info['currency_code'],
					'COMPLETETYPE'    => $complete,
					'MSGSUBID'        => uniqid(mt_rand(), true)
				);
		
				$curl = curl_init($api_url);
				
				curl_setopt($curl, CURLOPT_POST, true);
				curl_setopt($curl, CURLOPT_POSTFIELDS, $request);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($curl, CURLOPT_HEADER, false);
				curl_setopt($curl, CURLOPT_TIMEOUT, 30);
				curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		
				$response = curl_exec($curl);
				
				if (!$response) {
					$json['error'] = sprintf($this->language->get('error_curl'), curl_errno($curl), curl_error($curl));
				}
		
				curl_close($curl);
		
				$response_info = array();
				
				parse_str($response, $response_info);
		
				if (isset($response_info['ACK']) && ($response_info['ACK'] != 'Failure') && ($response_info['ACK'] != 'FailureWithWarning')) {
					$transaction_data = array(
						'paypal_order_id'       => $paypal_info['paypal_order_id'],
						'transaction_id'        => $response_info['TRANSACTIONID'],
						'parent_transaction_id' => $paypal_info['authorization_id'],
						'note'                  => '',
						'msgsubid'              => $response_info['MSGSUBID'],
						'receipt_id'            => '',
						'payment_type'          => $response_info['PAYMENTTYPE'],
						'payment_status'        => $response_info['PAYMENTSTATUS'],
						'pending_reason'        => (isset($response_info['PENDINGREASON']) ? $response_info['PENDINGREASON'] : ''),
						'transaction_entity'    => 'payment',
						'amount'                => $response_info['AMT'],
						'debug_data'            => json_encode($response)
					);					
		
					$this->model_payment_pp_express->addTransaction($transaction_data);
		
					$captured = number_format($this->model_payment_pp_express->getTotalCaptured($paypal_info['paypal_order_id']), 2);
					$refunded = number_format($this->model_payment_pp_express->getTotalRefunded($paypal_info['paypal_order_id']), 2);
		
					$json['captured'] = $captured;
					$json['refunded'] = $refunded;
					$json['remaining'] = number_format($response_info['total'] - $captured, 2);
		
					if ($this->request->post['complete'] || $json['remaining'] = 0.00) {
						$json['capture_status'] = $this->language->get('text_complete');
						
						$this->model_payment_pp_express->editPayPalOrder($this->request->post['order_id'], 'Complete');
					}
		
					$json['success'] = $this->language->get('text_success');
				} else {
					$json['error'] = (isset($response_info['L_SHORTMESSAGE0']) ? $response_info['L_SHORTMESSAGE0'] : '');
				}
			} else {
				$json['error'] = $this->language->get('error_not_found');
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
/*
	public function resend() {
		$json = array();
		
		$this->load->language('payment/pp_express');

		if (isset($this->request->get['paypal_order_transaction_id'])) {
			$paypal_order_transaction_id = $this->request->get['paypal_order_transaction_id'];
		} else {
			$paypal_order_transaction_id = 0;
		}

		$this->load->model('payment/pp_express');
		
		$transaction = $this->model_payment_pp_express->getFailedTransaction($paypal_order_transaction_id);

		if ($transaction) {
			
			
			
			
			
			
			$call_data = json_decode($transaction['call_data'], true);

			$result = $this->model_payment_pp_express->call($call_data);

			if ($response_info) {

				$parent_transaction = $this->model_payment_pp_express->getLocalTransaction($transaction['parent_transaction_id']);

				if ($parent_transaction['amount'] == abs($transaction['amount'])) {
					$this->db->query("UPDATE `" . DB_PREFIX . "paypal_order_transaction` SET `payment_status` = 'Refunded' WHERE `transaction_id` = '" . $this->db->escape($transaction['parent_transaction_id']) . "' LIMIT 1");
				} else {
					$this->db->query("UPDATE `" . DB_PREFIX . "paypal_order_transaction` SET `payment_status` = 'Partially-Refunded' WHERE `transaction_id` = '" . $this->db->escape($transaction['parent_transaction_id']) . "' LIMIT 1");
				}

				if (isset($result['REFUNDTRANSACTIONID'])) {
					$transaction['transaction_id'] = $result['REFUNDTRANSACTIONID'];
				} else {
					$transaction['transaction_id'] = $result['TRANSACTIONID'];
				}

				if (isset($result['PAYMENTTYPE'])) {
					$transaction['payment_type'] = $result['PAYMENTTYPE'];
				} else {
					$transaction['payment_type'] = $result['REFUNDSTATUS'];
				}

				if (isset($result['PAYMENTSTATUS'])) {
					$transaction['payment_status'] = $result['PAYMENTSTATUS'];
				} else {
					$transaction['payment_status'] = 'Refunded';
				}

				if (isset($result['AMT'])) {
					$transaction['amount'] = $result['AMT'];
				} else {
					$transaction['amount'] = $transaction['amount'];
				}

				$transaction['pending_reason'] = (isset($result['PENDINGREASON']) ? $result['PENDINGREASON'] : '');

				$this->model_payment_pp_express->updateTransaction($transaction);

				$json['success'] = $this->language->get('success_transaction_resent');
			} else {
				$json['error'] = $this->language->get('error_timeout');
			}
		} else {
			$json['error'] = $this->language->get('error_transaction_missing');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
*/

	public function void() {
		/**
		 * used to void an authorised payment
		 */
		if (isset($this->request->post['order_id']) && $this->request->post['order_id'] != '') {
			$this->load->model('payment/pp_express');

			$paypal_order = $this->model_payment_pp_express->getOrder($this->request->post['order_id']);

			$call_data = array();
			
			
			$call_data['METHOD'] = 'DoVoid';
			$call_data['AUTHORIZATIONID'] = $paypal_order['authorization_id'];

			$result = $this->model_payment_pp_express->call($call_data);

			if ($result['ACK'] != 'Failure' && $result['ACK'] != 'FailureWithWarning') {
				$transaction = array(
					'paypal_order_id' => $paypal_order['paypal_order_id'],
					'transaction_id' => '',
					'parent_transaction_id' => $paypal_order['authorization_id'],
					'note' => '',
					'msgsubid' => '',
					'receipt_id'         => '',
					'payment_type'       => 'void',
					'payment_status'     => 'Void',
					'pending_reason'     => '',
					'transaction_entity' => 'auth',
					'amount'             => '',
					'debug_data'         => json_encode($result)
				);

				$this->model_payment_pp_express->addTransaction($transaction);
				
				$this->model_payment_pp_express->updateOrder('Complete', $this->request->post['order_id']);

				unset($transaction['debug_data']);
				
				$transaction['date_added'] = date("Y-m-d H:i:s");

				$json['data'] = $transaction;
				$json['error'] = false;
				$json['msg'] = 'Transaction void';
			} else {
				$json['error'] = true;
				$json['msg'] = (isset($result['L_SHORTMESSAGE0']) ? $result['L_SHORTMESSAGE0'] : 'There was an error');
			}
		} else {
			$json['error'] = true;
			$json['msg'] = 'Missing data';
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function doRefund() {
		/**
		 * used to issue a refund for a captured payment
		 *
		 * refund can be full or partial
		 */
		if (isset($this->request->post['transaction_id']) && isset($this->request->post['refund_full'])) {

			$this->load->model('payment/pp_express');
			$this->load->language('payment/pp_express_refund');

			if ($this->request->post['refund_full'] == 0 && $this->request->post['amount'] == 0) {
				$this->session->data['error'] = $this->language->get('error_partial_amt');
			} else {
				$order_id = $this->model_payment_pp_express->getOrderId($this->request->post['transaction_id']);
				$paypal_order = $this->model_payment_pp_express->getOrder($order_id);

				if ($paypal_order) {
					$call_data = array();
					$call_data['METHOD'] = 'RefundTransaction';
					$call_data['TRANSACTIONID'] = $this->request->post['transaction_id'];
					$call_data['NOTE'] = urlencode($this->request->post['refund_message']);
					$call_data['MSGSUBID'] = uniqid(mt_rand(), true);

					$current_transaction = $this->model_payment_pp_express->getLocalTransaction($this->request->post['transaction_id']);

					if ($this->request->post['refund_full'] == 1) {
						$call_data['REFUNDTYPE'] = 'Full';
					} else {
						$call_data['REFUNDTYPE'] = 'Partial';
						$call_data['AMT'] = number_format($this->request->post['amount'], 2);
						$call_data['CURRENCYCODE'] = $this->request->post['currency_code'];
					}

					$result = $this->model_payment_pp_express->call($call_data);

					$transaction = array(
						'paypal_order_id' => $paypal_order['paypal_order_id'],
						'transaction_id' => '',
						'parent_transaction_id' => $this->request->post['transaction_id'],
						'note' => $this->request->post['refund_message'],
						'msgsubid' => $call_data['MSGSUBID'],
						'receipt_id' => '',
						'payment_type' => '',
						'payment_status' => 'Refunded',
						'transaction_entity' => 'payment',
						'pending_reason' => '',
						'amount' => '-' . (isset($call_data['AMT']) ? $call_data['AMT'] : $current_transaction['amount']),
						'debug_data' => json_encode($result)
					);

					if ($result == false) {
						$transaction['payment_status'] = 'Failed';
						$this->model_payment_pp_express->addTransaction($transaction, $call_data);
						$this->response->redirect($this->url->link('sale/order/info', 'token=' . $this->session->data['token'] . '&order_id=' . $paypal_order['order_id'], true));
					} else if ($result['ACK'] != 'Failure' && $result['ACK'] != 'FailureWithWarning') {

						$transaction['transaction_id'] = $result['REFUNDTRANSACTIONID'];
						$transaction['payment_type'] = $result['REFUNDSTATUS'];
						$transaction['pending_reason'] = $result['PENDINGREASON'];
						$transaction['amount'] = '-' . $result['GROSSREFUNDAMT'];

						$this->model_payment_pp_express->addTransaction($transaction);

						//edit transaction to refunded status
						if ($result['TOTALREFUNDEDAMOUNT'] == $this->request->post['amount_original']) {
							$this->db->query("UPDATE `" . DB_PREFIX . "paypal_order_transaction` SET `payment_status` = 'Refunded' WHERE `transaction_id` = '" . $this->db->escape($this->request->post['transaction_id']) . "' LIMIT 1");
						} else {
							$this->db->query("UPDATE `" . DB_PREFIX . "paypal_order_transaction` SET `payment_status` = 'Partially-Refunded' WHERE `transaction_id` = '" . $this->db->escape($this->request->post['transaction_id']) . "' LIMIT 1");
						}

						//redirect back to the order
						$this->response->redirect($this->url->link('sale/order/info', 'token=' . $this->session->data['token'] . '&order_id=' . $paypal_order['order_id'], true));
					} else {
						$this->model_payment_pp_express->log(json_encode($result));
						$this->session->data['error'] = (isset($result['L_SHORTMESSAGE0']) ? $result['L_SHORTMESSAGE0'] : 'There was an error') . (isset($result['L_LONGMESSAGE0']) ? '<br />' . $result['L_LONGMESSAGE0'] : '');
						$this->response->redirect($this->url->link('payment/pp_express/refund', 'token=' . $this->session->data['token'] . '&transaction_id=' . $this->request->post['transaction_id'], true));
					}
				} else {
					$this->session->data['error'] = $this->language->get('error_data_missing');
					$this->response->redirect($this->url->link('payment/pp_express/refund', 'token=' . $this->session->data['token'] . '&transaction_id=' . $this->request->post['transaction_id'], true));
				}
			}
		} else {
			$this->session->data['error'] = $this->language->get('error_data');
			$this->response->redirect($this->url->link('payment/pp_express/refund', 'token=' . $this->session->data['token'] . '&transaction_id=' . $this->request->post['transaction_id'], true));
		}
	}
	
	public function search() {
		$this->load->language('payment/pp_express_search');
		
		$this->document->setTitle($this->language->get('heading_title'));

		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_buyer_info'] = $this->language->get('text_buyer_info');
		$data['text_name'] = $this->language->get('text_name');
		$data['text_searching'] = $this->language->get('text_searching');
		$data['text_view'] = $this->language->get('text_view');
		$data['text_format'] = $this->language->get('text_format');
		$data['text_date_search'] = $this->language->get('text_date_search');
		$data['text_no_results'] = $this->language->get('text_no_results');
		
		$data['entry_date'] = $this->language->get('entry_date');
		$data['entry_date_start'] = $this->language->get('entry_date_start');
		$data['entry_date_end'] = $this->language->get('entry_date_end');
		$data['entry_date_to'] = $this->language->get('entry_date_to');
		$data['entry_transaction'] = $this->language->get('entry_transaction');
		$data['entry_transaction_type'] = $this->language->get('entry_transaction_type');
		$data['entry_transaction_status'] = $this->language->get('entry_transaction_status');
		$data['entry_email'] = $this->language->get('entry_email');
		$data['entry_email_buyer'] = $this->language->get('entry_email_buyer');
		$data['entry_email_merchant'] = $this->language->get('entry_email_merchant');
		$data['entry_receipt'] = $this->language->get('entry_receipt');
		$data['entry_transaction_id'] = $this->language->get('entry_transaction_id');
		$data['entry_invoice_no'] = $this->language->get('entry_invoice_no');
		$data['entry_auction'] = $this->language->get('entry_auction');
		$data['entry_amount'] = $this->language->get('entry_amount');
		$data['entry_recurring_id'] = $this->language->get('entry_recurring_id');

		$data['entry_firstname'] = $this->language->get('entry_firstname');
		$data['entry_middlename'] = $this->language->get('entry_middlename');
		$data['entry_lastname'] = $this->language->get('entry_lastname');
		$data['entry_suffix'] = $this->language->get('entry_suffix');
		
		$data['entry_salutation'] = $this->language->get('entry_salutation');

		$data['entry_status_all'] = $this->language->get('entry_status_all');
		$data['entry_status_pending'] = $this->language->get('entry_status_pending');
		$data['entry_status_processing'] = $this->language->get('entry_status_processing');
		$data['entry_status_success'] = $this->language->get('entry_status_success');
		$data['entry_status_denied'] = $this->language->get('entry_status_denied');
		$data['entry_status_reversed'] = $this->language->get('entry_status_reversed');

		$data['entry_trans_all'] = $this->language->get('entry_trans_all');
		$data['entry_trans_sent'] = $this->language->get('entry_trans_sent');
		$data['entry_trans_received'] = $this->language->get('entry_trans_received');
		$data['entry_trans_masspay'] = $this->language->get('entry_trans_masspay');
		$data['entry_trans_money_req'] = $this->language->get('entry_trans_money_req');
		$data['entry_trans_funds_add'] = $this->language->get('entry_trans_funds_add');
		$data['entry_trans_funds_with'] = $this->language->get('entry_trans_funds_with');
		$data['entry_trans_referral'] = $this->language->get('entry_trans_referral');
		$data['entry_trans_fee'] = $this->language->get('entry_trans_fee');
		$data['entry_trans_subscription'] = $this->language->get('entry_trans_subscription');
		$data['entry_trans_dividend'] = $this->language->get('entry_trans_dividend');
		$data['entry_trans_billpay'] = $this->language->get('entry_trans_billpay');
		$data['entry_trans_refund'] = $this->language->get('entry_trans_refund');
		$data['entry_trans_conv'] = $this->language->get('entry_trans_conv');
		$data['entry_trans_bal_trans'] = $this->language->get('entry_trans_bal_trans');
		$data['entry_trans_reversal'] = $this->language->get('entry_trans_reversal');
		$data['entry_trans_shipping'] = $this->language->get('entry_trans_shipping');
		$data['entry_trans_bal_affect'] = $this->language->get('entry_trans_bal_affect');
		$data['entry_trans_echeque'] = $this->language->get('entry_trans_echeque');

		$data['column_date'] = $this->language->get('column_date');
		$data['column_type'] = $this->language->get('column_type');
		$data['column_email'] = $this->language->get('column_email');
		$data['column_name'] = $this->language->get('column_name');
		$data['column_transid'] = $this->language->get('column_transid');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_currency'] = $this->language->get('column_currency');
		$data['column_amount'] = $this->language->get('column_amount');
		$data['column_fee'] = $this->language->get('column_fee');
		$data['column_netamt'] = $this->language->get('column_netamt');
		$data['column_action'] = $this->language->get('column_action');

		$data['button_search'] = $this->language->get('button_search');
		$data['button_edit'] = $this->language->get('button_edit');

		$data['token'] = $this->session->data['token'];

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true),
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_pp_express'),
			'href' => $this->url->link('payment/pp_express', 'token=' . $this->session->data['token'], true),
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('payment/pp_express/search', 'token=' . $this->session->data['token'], true),
		);
		
		$this->load->model('payment/pp_express');

		$data['currency_codes'] = $this->model_payment_pp_express->getCurrencies();
		
		$data['default_currency'] = $this->config->get('pp_express_currency');

		$data['date_start'] = date("Y-m-d", strtotime('-30 days'));
		$data['date_end'] = date("Y-m-d");
		$data['view_link'] = $this->url->link('payment/pp_express/info', 'token=' . $this->session->data['token'], true);

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('payment/pp_express_search', $data));
	}
	
	public function refund() {
		$this->load->language('payment/pp_express_refund');

		$this->document->setTitle($this->language->get('heading_title'));

		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_refund'] = $this->language->get('text_refund');
	
		$data['entry_transaction_id'] = $this->language->get('entry_transaction_id');
		$data['entry_full_refund'] = $this->language->get('entry_full_refund');
		$data['entry_amount'] = $this->language->get('entry_amount');
		$data['entry_message'] = $this->language->get('entry_message');
		
		$data['button_refund'] = $this->language->get('button_refund');
		$data['button_cancel'] = $this->language->get('button_cancel');

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true),
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_pp_express'),
			'href' => $this->url->link('payment/pp_express', 'token=' . $this->session->data['token'], true),
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('payment/pp_express/refund', 'token=' . $this->session->data['token'], true),
		);

		//button actions
		$data['action'] = $this->url->link('payment/pp_express/doRefund', 'token=' . $this->session->data['token'], true);
		$data['cancel'] = $this->url->link('payment/pp_express', 'token=' . $this->session->data['token'], true);

		$data['transaction_id'] = $this->request->get['transaction_id'];

		$this->load->model('payment/pp_express');
		
		$pp_transaction = $this->model_payment_pp_express->getTransaction($this->request->get['transaction_id']);

		$data['amount_original'] = $pp_transaction['AMT'];
		$data['currency_code'] = $pp_transaction['CURRENCYCODE'];

		$refunded = number_format($this->model_payment_pp_express->getTotalRefundedTransaction($this->request->get['transaction_id']), 2);

		if ($refunded != 0.00) {
			$data['refund_available'] = number_format($data['amount_original'] + $refunded, 2);
			$data['attention'] = $this->language->get('text_current_refunds') . ': ' . $data['refund_available'];
		} else {
			$data['refund_available'] = '';
			$data['attention'] = '';
		}

		$data['token'] = $this->session->data['token'];

		if (isset($this->session->data['error'])) {
			$data['error'] = $this->session->data['error'];
			unset($this->session->data['error']);
		} else {
			$data['error'] = '';
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('payment/pp_express_refund', $data));
	}
	
	public function info() {
		$this->load->language('payment/pp_express_view');

		$this->document->setTitle($this->language->get('heading_title'));

		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_product_lines'] = $this->language->get('text_product_lines');
		$data['text_ebay_txn_id'] = $this->language->get('text_ebay_txn_id');
		$data['text_name'] = $this->language->get('text_name');
		$data['text_qty'] = $this->language->get('text_qty');
		$data['text_price'] = $this->language->get('text_price');
		$data['text_number'] = $this->language->get('text_number');
		$data['text_coupon_id'] = $this->language->get('text_coupon_id');
		$data['text_coupon_amount'] = $this->language->get('text_coupon_amount');
		$data['text_coupon_currency'] = $this->language->get('text_coupon_currency');
		$data['text_loyalty_currency'] = $this->language->get('text_loyalty_currency');
		$data['text_loyalty_disc_amt'] = $this->language->get('text_loyalty_disc_amt');
		$data['text_options_name'] = $this->language->get('text_options_name');
		$data['text_tax_amt'] = $this->language->get('text_tax_amt');
		$data['text_currency_code'] = $this->language->get('text_currency_code');
		$data['text_amount'] = $this->language->get('text_amount');
		$data['text_gift_msg'] = $this->language->get('text_gift_msg');
		$data['text_gift_receipt'] = $this->language->get('text_gift_receipt');
		$data['text_gift_wrap_name'] = $this->language->get('text_gift_wrap_name');
		$data['text_gift_wrap_amt'] = $this->language->get('text_gift_wrap_amt');
		$data['text_buyer_email_market'] = $this->language->get('text_buyer_email_market');
		$data['text_survey_question'] = $this->language->get('text_survey_question');
		$data['text_survey_chosen'] = $this->language->get('text_survey_chosen');
		$data['text_receiver_business'] = $this->language->get('text_receiver_business');
		$data['text_receiver_email'] = $this->language->get('text_receiver_email');
		$data['text_receiver_id'] = $this->language->get('text_receiver_id');
		$data['text_buyer_email'] = $this->language->get('text_buyer_email');
		$data['text_payer_id'] = $this->language->get('text_payer_id');
		$data['text_payer_status'] = $this->language->get('text_payer_status');
		$data['text_country_code'] = $this->language->get('text_country_code');
		$data['text_payer_business'] = $this->language->get('text_payer_business');
		$data['text_payer_salute'] = $this->language->get('text_payer_salute');
		$data['text_payer_firstname'] = $this->language->get('text_payer_firstname');
		$data['text_payer_middlename'] = $this->language->get('text_payer_middlename');
		$data['text_payer_lastname'] = $this->language->get('text_payer_lastname');
		$data['text_payer_suffix'] = $this->language->get('text_payer_suffix');
		$data['text_address_owner'] = $this->language->get('text_address_owner');
		$data['text_address_status'] = $this->language->get('text_address_status');
		$data['text_ship_sec_name'] = $this->language->get('text_ship_sec_name');
		$data['text_ship_name'] = $this->language->get('text_ship_name');
		$data['text_ship_street1'] = $this->language->get('text_ship_street1');
		$data['text_ship_street2'] = $this->language->get('text_ship_street2');
		$data['text_ship_city'] = $this->language->get('text_ship_city');
		$data['text_ship_state'] = $this->language->get('text_ship_state');
		$data['text_ship_zip'] = $this->language->get('text_ship_zip');
		$data['text_ship_country'] = $this->language->get('text_ship_country');
		$data['text_ship_phone'] = $this->language->get('text_ship_phone');
		$data['text_ship_sec_add1'] = $this->language->get('text_ship_sec_add1');
		$data['text_ship_sec_add2'] = $this->language->get('text_ship_sec_add2');
		$data['text_ship_sec_city'] = $this->language->get('text_ship_sec_city');
		$data['text_ship_sec_state'] = $this->language->get('text_ship_sec_state');
		$data['text_ship_sec_zip'] = $this->language->get('text_ship_sec_zip');
		$data['text_ship_sec_country'] = $this->language->get('text_ship_sec_country');
		$data['text_ship_sec_phone'] = $this->language->get('text_ship_sec_phone');
		$data['text_trans_id'] = $this->language->get('text_trans_id');
		$data['text_receipt_id'] = $this->language->get('text_receipt_id');
		$data['text_parent_trans_id'] = $this->language->get('text_parent_trans_id');
		$data['text_trans_type'] = $this->language->get('text_trans_type');
		$data['text_payment_type'] = $this->language->get('text_payment_type');
		$data['text_order_time'] = $this->language->get('text_order_time');
		$data['text_fee_amount'] = $this->language->get('text_fee_amount');
		$data['text_settle_amount'] = $this->language->get('text_settle_amount');
		$data['text_tax_amount'] = $this->language->get('text_tax_amount');
		$data['text_exchange'] = $this->language->get('text_exchange');
		$data['text_payment_status'] = $this->language->get('text_payment_status');
		$data['text_pending_reason'] = $this->language->get('text_pending_reason');
		$data['text_reason_code'] = $this->language->get('text_reason_code');
		$data['text_protect_elig'] = $this->language->get('text_protect_elig');
		$data['text_protect_elig_type'] = $this->language->get('text_protect_elig_type');
		$data['text_store_id'] = $this->language->get('text_store_id');
		$data['text_terminal_id'] = $this->language->get('text_terminal_id');
		$data['text_invoice_number'] = $this->language->get('text_invoice_number');
		$data['text_custom'] = $this->language->get('text_custom');
		$data['text_note'] = $this->language->get('text_note');
		$data['text_sales_tax'] = $this->language->get('text_sales_tax');
		$data['text_buyer_id'] = $this->language->get('text_buyer_id');
		$data['text_close_date'] = $this->language->get('text_close_date');
		$data['text_multi_item'] = $this->language->get('text_multi_item');
		$data['text_sub_amt'] = $this->language->get('text_sub_amt');
		$data['text_sub_period'] = $this->language->get('text_sub_period');
		
		$data['button_cancel'] = $this->language->get('button_cancel');

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true),
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_pp_express'),
			'href' => $this->url->link('payment/pp_express', 'token=' . $this->session->data['token'], true),
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('payment/pp_express/info', 'token=' . $this->session->data['token'] . '&transaction_id=' . $this->request->get['transaction_id'], true),
		);

		$this->load->model('payment/pp_express');
		
		$data['transaction'] = $this->model_payment_pp_express->getTransaction($this->request->get['transaction_id']);
		$data['lines'] = $this->formatRows($data['transaction']);
		$data['view_link'] = $this->url->link('payment/pp_express/info', 'token=' . $this->session->data['token'], true);
		$data['cancel'] = $this->url->link('payment/pp_express/search', 'token=' . $this->session->data['token'], true);
		$data['token'] = $this->session->data['token'];

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('payment/pp_express_view', $data));
	}
			

	public function doSearch() {
		/**
		 * used to search for transactions from a user account
		 */
		if (isset($this->request->post['date_start'])) {

			$this->load->model('payment/pp_express');

			$call_data = array();
			$call_data['METHOD'] = 'TransactionSearch';
			$call_data['STARTDATE'] = gmdate($this->request->post['date_start'] . "\TH:i:s\Z");

			if (!empty($this->request->post['date_end'])) {
				$call_data['ENDDATE'] = gmdate($this->request->post['date_end'] . "\TH:i:s\Z");
			}

			if (!empty($this->request->post['transaction_class'])) {
				$call_data['TRANSACTIONCLASS'] = $this->request->post['transaction_class'];
			}

			if (!empty($this->request->post['status'])) {
				$call_data['STATUS'] = $this->request->post['status'];
			}

			if (!empty($this->request->post['buyer_email'])) {
				$call_data['EMAIL'] = $this->request->post['buyer_email'];
			}

			if (!empty($this->request->post['merchant_email'])) {
				$call_data['RECEIVER'] = $this->request->post['merchant_email'];
			}

			if (!empty($this->request->post['receipt_id'])) {
				$call_data['RECEIPTID'] = $this->request->post['receipt_id'];
			}

			if (!empty($this->request->post['transaction_id'])) {
				$call_data['TRANSACTIONID'] = $this->request->post['transaction_id'];
			}

			if (!empty($this->request->post['invoice_number'])) {
				$call_data['INVNUM'] = $this->request->post['invoice_number'];
			}

			if (!empty($this->request->post['auction_item_number'])) {
				$call_data['AUCTIONITEMNUMBER'] = $this->request->post['auction_item_number'];
			}

			if (!empty($this->request->post['amount'])) {
				$call_data['AMT'] = number_format($this->request->post['amount'], 2);
				$call_data['CURRENCYCODE'] = $this->request->post['currency_code'];
			}

			if (!empty($this->request->post['recurring_id'])) {
				$call_data['PROFILEID'] = $this->request->post['recurring_id'];
			}

			if (!empty($this->request->post['name_salutation'])) {
				$call_data['SALUTATION'] = $this->request->post['name_salutation'];
			}

			if (!empty($this->request->post['name_first'])) {
				$call_data['FIRSTNAME'] = $this->request->post['name_first'];
			}

			if (!empty($this->request->post['name_middle'])) {
				$call_data['MIDDLENAME'] = $this->request->post['name_middle'];
			}

			if (!empty($this->request->post['name_last'])) {
				$call_data['LASTNAME'] = $this->request->post['name_last'];
			}

			if (!empty($this->request->post['name_suffix'])) {
				$call_data['SUFFIX'] = $this->request->post['name_suffix'];
			}

			$result = $this->model_payment_pp_express->call($call_data);

			if ($result['ACK'] != 'Failure' && $result['ACK'] != 'FailureWithWarning' && $result['ACK'] != 'Warning') {
				$response['error'] = false;
				$response['result'] = $this->formatRows($result);
			} else {
				$response['error'] = true;
				$response['error_msg'] = $result['L_LONGMESSAGE0'];
			}

			$this->response->addHeader('Content-Type: application/json');
			$this->response->setOutput(json_encode($response));
		} else {
			$response['error'] = true;
			$response['error_msg'] = 'Enter a start date';
			$this->response->addHeader('Content-Type: application/json');
			$this->response->setOutput(json_encode($response));
		}
	}

	public function live() {
		if (isset($this->request->get['merchantId'])) {
			$this->load->language('payment/pp_express');

			$this->load->model('payment/pp_express');
			$this->load->model('setting/setting');

			$token = $this->model_payment_pp_express->getTokens('live');

			if (isset($token->access_token)) {
				$user_info = $this->model_payment_pp_express->getUserInfo($this->request->get['merchantId'], 'live', $token->access_token);
			} else {
				$this->session->data['error_api'] = $this->language->get('error_api');
			}

			if (isset($user_info->api_user_name)) {
				$this->model_setting_setting->editSettingValue('pp_express', 'pp_express_username', $user_info->api_user_name);
				$this->model_setting_setting->editSettingValue('pp_express', 'pp_express_password', $user_info->api_password);
				$this->model_setting_setting->editSettingValue('pp_express', 'pp_express_signature', $user_info->signature);
			} else {
				$this->session->data['error_api'] = $this->language->get('error_api');
			}
		}
		
		$this->response->redirect($this->url->link('payment/pp_express', 'token=' . $this->session->data['token'], true));
	}
		
	public function sandbox() {
		if (isset($this->request->get['merchantId'])) {
			$this->load->language('payment/pp_express');

			$this->load->model('payment/pp_express');
			$this->load->model('setting/setting');

			$token = $this->model_payment_pp_express->getTokens('sandbox');

			if (isset($token->access_token)) {
				$user_info = $this->model_payment_pp_express->getUserInfo($this->request->get['merchantId'], 'sandbox', $token->access_token);
			} else {
				$this->session->data['error_api'] = $this->language->get('error_api_sandbox');
			}

			if (isset($user_info->api_user_name)) {
				$this->model_setting_setting->editSettingValue('pp_express', 'pp_express_sandbox_username', $user_info->api_user_name);
				$this->model_setting_setting->editSettingValue('pp_express', 'pp_express_sandbox_password', $user_info->api_password);
				$this->model_setting_setting->editSettingValue('pp_express', 'pp_express_sandbox_signature', $user_info->signature);
			} else {
				$this->session->data['error_api'] = $this->language->get('error_api_sandbox');
			}
		}
		$this->response->redirect($this->url->link('payment/pp_express', 'token=' . $this->session->data['token'], true));
	}

	private function formatRows($data) {
		$return = array();

		foreach ($data as $k => $v) {
			$elements = preg_split("/(\d+)/", $k, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
			if (isset($elements[1]) && isset($elements[0])) {
				if ($elements[0] == 'L_TIMESTAMP') {
					$v = str_replace('T', ' ', $v);
					$v = str_replace('Z', '', $v);
				}
				$return[$elements[1]][$elements[0]] = $v;
			}
		}

		return $return;
	}
	
	// Cancel an active recurring
	public function recurringCancel() {
		$this->load->language('sale/recurring');

		$this->load->model('sale/recurring');
		
		$recurring = $this->model_sale_recurring->getRecurring($this->request->get['order_recurring_id']);

		if ($recurring && !empty($recurring['reference'])) {
			$this->load->model('payment/pp_express');
			
			$result = $this->model_payment_pp_express->recurringCancel($recurring['reference']);

			if (isset($result['PROFILEID'])) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "order_recurring_transaction` SET `order_recurring_id` = '" . (int)$recurring['order_recurring_id'] . "', `date_added` = NOW(), `type` = '5'");
				$this->db->query("UPDATE `" . DB_PREFIX . "order_recurring` SET `status` = 4 WHERE `order_recurring_id` = '" . (int)$recurring['order_recurring_id'] . "' LIMIT 1");

				$this->session->data['success'] = $this->language->get('text_cancelled');
			} else {
				$this->session->data['error'] = sprintf($this->language->get('error_not_cancelled'), $result['L_LONGMESSAGE0']);
			}
		} else {
			$this->session->data['error'] = $this->language->get('error_not_found');
		}

		$this->response->redirect($this->url->link('sale/recurring/info', 'order_recurring_id=' . $this->request->get['order_recurring_id'] . '&token=' . $this->request->get['token'], true));
	}

	public function recurringButtons() {
		$this->load->model('sale/recurring');

		$recurring = $this->model_sale_recurring->getRecurring($this->request->get['order_recurring_id']);

		$data['buttons'] = array();

		if ($recurring['status'] == 2 || $recurring['status'] == 3) {
			$data['buttons'][] = array(
				'text' => $this->language->get('button_cancel_recurring'),
				'link' => $this->url->link('payment/pp_express/recurringCancel', 'order_recurring_id=' . $this->request->get['order_recurring_id'] . '&token=' . $this->request->get['token'], true)
			);
		}

		return $this->load->view('sale/recurring_button', $data);
	}
}
