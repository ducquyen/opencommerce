<?php
use Librecommerce\Components\Controller as Controller;
use Librecommerce\Components\Event as Event;
use Librecommerce\Components\Model as Model;

use Cardinity\Client;
use Cardinity\Method\Payment;
use Cardinity\Method\Refund;

class ModelExtensionPaymentCardinityAdmin extends Model {
	public function getOrder($order_id) {
		$query = $this->db->query("SELECT * FROM `oc_cardinity_order` WHERE `order_id` = '" . (int)$order_id . "' LIMIT 1");

		return $query->row;
	}

	public function createClient($credentials) {
		return Client::create(array(
			'consumerKey'    => $credentials['key'],
			'consumerSecret' => $credentials['secret'],
		));
	}

	public function verifyCredentials($client) {
		$method = new Payment\GetAll(10);

		try {
			$client->call($method);

			return true;
		} catch (Exception $e) {
			$this->log($e->getMessage());

			return false;
		}
	}

	public function getPayment($client, $payment_id) {
		$method = new Payment\Get($payment_id);

		try {
			$payment = $client->call($method);

			return $payment;
		} catch (Exception $e) {
			$this->log($e->getMessage());

			return false;
		}
	}

	public function getRefunds($client, $payment_id) {
		$method = new Refund\GetAll($payment_id);

		try {
			$refunds = $client->call($method);

			return $refunds;
		} catch (Exception $e) {
			$this->log($e->getMessage());

			return false;
		}
	}

	public function refundPayment($client, $payment_id, $amount, $description) {
		$method = new Refund\Create($payment_id, $amount, $description);

		try {
			$refund = $client->call($method);

			return $refund;
		} catch (Exception $e) {
			$this->log($e->getMessage());

			return false;
		}
	}

	public function log($data) {
		if ($this->config->get('payment_cardinity_debug')) {
			$backtrace = debug_backtrace();
			$log = new Log('cardinity.log');
			$log->write('(' . $backtrace[1]['class'] . '::' . $backtrace[1]['function'] . ') - ' . print_r($data, true));
		}
	}

	public function install() {
		$this->db->query("
			CREATE TABLE IF NOT EXISTS `oc_cardinity_order` (
			  `cardinity_order_id` INT(11) NOT NULL AUTO_INCREMENT,
			  `order_id` INT(11) NOT NULL,
			  `payment_id` VARCHAR(255),
			  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
              `date_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
			  PRIMARY KEY (`cardinity_order_id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		");
	}

	public function uninstall() {
		$this->db->query("DROP TABLE IF EXISTS `oc_cardinity_order`;");
	}
}