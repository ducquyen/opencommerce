<?php  
class ControllerCheckoutPaymentMethod extends Controller {
  	public function index() {
		$this->language->load('checkout/checkout');
		
		if (isset($this->session->data['payment_address'])) {
			// Totals
			$total_data = array();					
			$total = 0;
			$taxes = $this->cart->getTaxes();
			
			$this->load->model('setting/extension');
			
			$sort_order = array(); 
			
			$results = $this->model_setting_extension->getExtensions('total');
			
			foreach ($results as $key => $value) {
				$sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
			}
			
			array_multisort($sort_order, SORT_ASC, $results);
			
			foreach ($results as $result) {
				if ($this->config->get($result['code'] . '_status')) {
					$this->load->model('total/' . $result['code']);
		
					$this->{'model_total_' . $result['code']}->getTotal($total_data, $total, $taxes);
				}
			}
			
			// Payment Methods
			$method_data = array();
			
			$this->load->model('setting/extension');
			
			$results = $this->model_setting_extension->getExtensions('payment');
	
			foreach ($results as $result) {
				if ($this->config->get($result['code'] . '_status')) {
					$this->load->model('payment/' . $result['code']);
					
					$method = $this->{'model_payment_' . $result['code']}->getMethod($this->session->data['payment_address'], $total); 
					
					if ($method) {
						$method_data[$result['code']] = $method;
					}
				}
			}

			$sort_order = array(); 
		  
			foreach ($method_data as $key => $value) {
				$sort_order[$key] = $value['sort_order'];
			}
	
			array_multisort($sort_order, SORT_ASC, $method_data);			
			
			$this->session->data['payment_methods'] = $method_data;	
			
		}			
		
		$data['text_payment_method'] = $this->language->get('text_payment_method');
		$data['text_comments'] = $this->language->get('text_comments');
		$data['text_loading'] = $this->language->get('text_loading');

		$data['button_continue'] = $this->language->get('button_continue');
   
		if (empty($this->session->data['payment_methods'])) {
			$data['error_warning'] = sprintf($this->language->get('error_no_payment'), $this->url->link('information/contact'));
		} else {
			$data['error_warning'] = '';
		}	

		if (isset($this->session->data['payment_methods'])) {
			$data['payment_methods'] = $this->session->data['payment_methods']; 
		} else {
			$data['payment_methods'] = array();
		}
	  
		if (isset($this->session->data['payment_method']['code'])) {
			$data['code'] = $this->session->data['payment_method']['code'];
		} else {
			$data['code'] = '';
		}
		
		if (isset($this->session->data['comment'])) {
			$data['comment'] = $this->session->data['comment'];
		} else {
			$data['comment'] = '';
		}
		
		if ($this->config->get('config_checkout_id')) {
			$this->load->model('catalog/information');
			
			$information_info = $this->model_catalog_information->getInformation($this->config->get('config_checkout_id'));
			
			if ($information_info) {
				$data['text_agree'] = sprintf($this->language->get('text_agree'), $this->url->link('information/information/info', 'information_id=' . $this->config->get('config_checkout_id'), 'SSL'), $information_info['title'], $information_info['title']);
			} else {
				$data['text_agree'] = '';
			}
		} else {
			$data['text_agree'] = '';
		}
		
		if (isset($this->session->data['agree'])) { 
			$data['agree'] = $this->session->data['agree'];
		} else {
			$data['agree'] = '';
		}
			
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/checkout/payment_method.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/checkout/payment_method.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/checkout/payment_method.tpl', $data));
		}
  	}
	
	public function save() {
		$this->language->load('checkout/checkout');
		
		$json = array();
		
		// Validate if payment address has been set.
		if (!isset($this->session->data['payment_address'])) {
			$json['redirect'] = $this->url->link('checkout/checkout', '', 'SSL');
		}		
		
		// Validate cart has products and has stock.			
		if ((!$this->cart->hasProducts() && empty($this->session->data['vouchers'])) || (!$this->cart->hasStock() && !$this->config->get('config_stock_checkout'))) {
			$json['redirect'] = $this->url->link('checkout/cart');				
		}	
		
		// Validate minimum quantity requirments.			
		$products = $this->cart->getProducts();
				
		foreach ($products as $product) {
			$product_total = 0;
				
			foreach ($products as $product_2) {
				if ($product_2['product_id'] == $product['product_id']) {
					$product_total += $product_2['quantity'];
				}
			}		
			
			if ($product['minimum'] > $product_total) {
				$json['redirect'] = $this->url->link('checkout/cart');
				
				break;
			}				
		}
											
		if (!$json) {
			if (!isset($this->request->post['payment_method'])) {
				$json['error']['warning'] = $this->language->get('error_payment');
			} elseif (!isset($this->session->data['payment_methods'][$this->request->post['payment_method']])) {
				$json['error']['warning'] = $this->language->get('error_payment');
			}	
							
			if ($this->config->get('config_checkout_id')) {
				$this->load->model('catalog/information');
				
				$information_info = $this->model_catalog_information->getInformation($this->config->get('config_checkout_id'));
				
				if ($information_info && !isset($this->request->post['agree'])) {
					$json['error']['warning'] = sprintf($this->language->get('error_agree'), $information_info['title']);
				}
			}
			
			if (!$json) {
				$this->session->data['payment_method'] = $this->session->data['payment_methods'][$this->request->post['payment_method']];
			  
				$this->session->data['comment'] = strip_tags($this->request->post['comment']);
			}							
		}
		
		$this->response->setOutput(json_encode($json));
	}
}
?>