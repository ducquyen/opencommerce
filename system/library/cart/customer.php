<?php
namespace Cart;
class Customer {
	private $customer_id = 0;
	private $firstname = '';
	private $lastname = '';
	private $customer_group_id = 0;
	private $email = '';
	private $telephone = '';
	private $newsletter = '';
	private $address_id = '';

	public function __construct($registry) {
		$this->config  = $registry->get('config');
		$this->db      = $registry->get('db');
		$this->request = $registry->get('request');
		$this->session = $registry->get('session');

		if (isset($this->session->data['customer_id'])) {
			$customer_query = $this->db->query("SELECT * FROM oc_customer WHERE customer_id = :customer_id AND status = :status",
                [
                    ':customer_id' => $this->session->data['customer_id'],
                    ':status' => 1
                ]);

			if ($customer_query->num_rows) {
				$this->customer_id = $customer_query->row['customer_id'];
				$this->firstname = $customer_query->row['firstname'];
				$this->lastname = $customer_query->row['lastname'];
				$this->customer_group_id = $customer_query->row['customer_group_id'];
				$this->email = $customer_query->row['email'];
				$this->telephone = $customer_query->row['telephone'];
				$this->newsletter = $customer_query->row['newsletter'];
				$this->address_id = $customer_query->row['address_id'];

				$this->db->query("UPDATE oc_customer SET language_id = :language_id, ip = :ip WHERE customer_id = :customer_id",
                    [
                        ':language_id' => $this->config->get('config_language_id'),
                        ':ip' => $this->request->server['REMOTE_ADDR'],
                        ':customer_id' => $this->customer_id
                    ]);
			} else {
				$this->logout();
			}
		}
	}

    public function login($email, $password, $override = false) {
        $customer_query = $this->db->query("SELECT * FROM oc_customer WHERE LOWER(email) = :email AND status = :status",
            [
                ':email' => utf8_strtolower($email),
                ':status' => 1
            ]);
        if ($customer_query->num_rows) {
            if (password_verify($password, $customer_query->row['password'])) {
                $this->session->data['customer_id'] = $customer_query->row['customer_id'];

                $this->customer_id = $customer_query->row['customer_id'];
                $this->firstname = $customer_query->row['firstname'];
                $this->lastname = $customer_query->row['lastname'];
                $this->customer_group_id = $customer_query->row['customer_group_id'];
                $this->email = $customer_query->row['email'];
                $this->telephone = $customer_query->row['telephone'];
                $this->newsletter = $customer_query->row['newsletter'];
                $this->address_id = $customer_query->row['address_id'];

                // Check password strength, rehash if necessary
                if (password_needs_rehash($customer_query->row['password'], PASSWORD_DEFAULT)) {
                    $this->db->query("UPDATE oc_customer SET password = :password WHERE customer_id = :customer_id",
                        [
                            ':password' => password_hash($password, PASSWORD_DEFAULT),
                            ':customer_id' => $this->customer_id
                        ]);
                }

                return true;
            } else {
                return false;
            }
        }
    }

	public function logout() {
        unset($this->session->data['customer_id']);

		$this->customer_id = '';
		$this->firstname = '';
		$this->lastname = '';
		$this->customer_group_id = '';
		$this->email = '';
		$this->telephone = '';
		$this->newsletter = '';
		$this->address_id = '';
	}

	public function isLogged() {
		return $this->customer_id;
	}

	public function getId() {
		return $this->customer_id;
	}

	public function getFirstName() {
		return $this->firstname;
	}

	public function getLastName() {
		return $this->lastname;
	}

	public function getGroupId() {
		return $this->customer_group_id;
	}

	public function getEmail() {
		return $this->email;
	}

	public function getTelephone() {
		return $this->telephone;
	}

	public function getNewsletter() {
		return $this->newsletter;
	}

	public function getAddressId() {
		return $this->address_id;
	}

	public function getBalance() {
		$query = $this->db->query("SELECT SUM(amount) AS total FROM `oc_customer_transaction` WHERE `customer_id` = :customer_id",
            [
                ':customer_id' => $this->customer_id
            ]);

		return $query->row['total'];
	}

}
