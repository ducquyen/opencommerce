<?php
use Librecommerce\Components\Controller as Controller;
use Librecommerce\Components\Event as Event;
use Librecommerce\Components\Model as Model;

class ModelLocalisationReturnReason extends Model {
	public function getReturnReasons($data = []) {
		if ($data) {
			$sql = "SELECT * FROM oc_return_reason WHERE language_id = :language_id";
            $args[':language_id'] = $this->config->get('config_language_id');

			$sql .= " ORDER BY name";

			if (isset($data['return']) && ($data['return'] == 'DESC')) {
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

			$query = $this->db->query($sql);

			return $query->rows;
		} else {
			$return_reason_data = $this->cache->get('return_reason.' . (int)$this->config->get('config_language_id'));

			if (!$return_reason_data) {
				$query = $this->db->query("SELECT return_reason_id, name FROM oc_return_reason WHERE language_id = :language_id ORDER BY name",
                    [
                        ':language_id' => $this->config->get('config_language_id')
                    ]);

				$return_reason_data = $query->rows;

				$this->cache->set('return_reason.' . (int)$this->config->get('config_language_id'), $return_reason_data);
			}

			return $return_reason_data;
		}
	}
}
