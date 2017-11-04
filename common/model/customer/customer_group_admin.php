<?php
class ModelCustomerCustomerGroupAdmin extends Model {
	public function addCustomerGroup($data) {
		$this->db->query("INSERT INTO oc_customer_group SET approval = :approval, sort_order = :sort_order",
            [
                ':approval' => $data['approval'],
                ':sort_order' => $data['sort_order'] ,
            ]);

		$customer_group_id = $this->db->getLastId();

		foreach ($data['customer_group_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO oc_customer_group_description SET customer_group_id = :customer_group_id, language_id = :language_id, name = :name, description = :description",
                [
                    ':customer_group_id' => $customer_group_id,
                    ':language_id' => $language_id,
                    ':name' => $value['name'],
                    ':description' => $value['description']
                ]);
		}
		
		return $customer_group_id;
	}

	public function editCustomerGroup($customer_group_id, $data) {
		$this->db->query("UPDATE oc_customer_group SET approval = :approval, sort_order = :sort_order WHERE customer_group_id = :customer_group_id",
            [
                ':approval' => $data['approval'],
                ':sort_order' => $data['sort_order'] ,
                ':customer_group_id' => $customer_group_id
            ]);

		$this->db->query("DELETE FROM oc_customer_group_description WHERE customer_group_id = :customer_group_id",
            [
                ':customer_group_id' => $customer_group_id
            ]);

		foreach ($data['customer_group_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO oc_customer_group_description SET customer_group_id = :customer_group_id, language_id = :language_id, name = :name, description = :description",
                [
                    ':customer_group_id' => $customer_group_id,
                    ':language_id' => $language_id,
                    ':name' => $value['name'],
                    ':description' => $value['description']
                ]);
		}
	}

	public function deleteCustomerGroup($customer_group_id) {
		$this->db->query("DELETE FROM oc_customer_group WHERE customer_group_id = :customer_group_id",
            [
                ':customer_group_id' => $customer_group_id
            ]);
		$this->db->query("DELETE FROM oc_customer_group_description WHERE customer_group_id = :customer_group_id",
            [
                ':customer_group_id' => $customer_group_id
            ]);
		$this->db->query("DELETE FROM oc_product_discount WHERE customer_group_id = :customer_group_id",
            [
                ':customer_group_id' => $customer_group_id
            ]);
		$this->db->query("DELETE FROM oc_product_special WHERE customer_group_id = :customer_group_id",
            [
                ':customer_group_id' => $customer_group_id
            ]);
		$this->db->query("DELETE FROM oc_product_reward WHERE customer_group_id = :customer_group_id",
            [
                ':customer_group_id' => $customer_group_id
            ]);
		$this->db->query("DELETE FROM oc_tax_rate_to_customer_group WHERE customer_group_id = :customer_group_id",
            [
                ':customer_group_id' => $customer_group_id
            ]);
	}

	public function getCustomerGroup($customer_group_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM oc_customer_group cg LEFT JOIN oc_customer_group_description cgd ON (cg.customer_group_id = cgd.customer_group_id) WHERE cg.customer_group_id = :customer_group_id AND cgd.language_id = :language_id",
            [
                ':customer_group_id' => $customer_group_id,
                ':language_id' => $this->config->get('config_language_id')
            ]);

		return $query->row;
	}

	public function getCustomerGroups($data = []) {
		$sql = "SELECT * FROM oc_customer_group cg LEFT JOIN oc_customer_group_description cgd ON (cg.customer_group_id = cgd.customer_group_id) WHERE cgd.language_id = :language_id";

        $args[':language_id'] = $this->config->get('config_language_id');
		$sort_data = [
			'cgd.name',
			'cg.sort_order'
        ];

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY cgd.name";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql, $args);

		return $query->rows;
	}

	public function getCustomerGroupDescriptions($customer_group_id) {
		$customer_group_data = [];

		$query = $this->db->query("SELECT * FROM oc_customer_group_description WHERE customer_group_id = :customer_group_id",
        [
            ':customer_group_id' => $customer_group_id
        ]);

		foreach ($query->rows as $result) {
			$customer_group_data[$result['language_id']] = [
				'name'        => $result['name'],
				'description' => $result['description']
            ];
		}

		return $customer_group_data;
	}

	public function getTotalCustomerGroups() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM oc_customer_group");

		return $query->row['total'];
	}
}