<?php
use Librecommerce\Components\Controller as Controller;
use Librecommerce\Components\Event as Event;
use Librecommerce\Components\Model as Model;

class ModelExtensionReportCoupon extends Model {
	public function getCoupons($data = []) {
		$sql = "SELECT ch.coupon_id, c.name, c.code, COUNT(DISTINCT ch.order_id) AS `orders`, SUM(ch.amount) AS total FROM `oc_coupon_history` ch LEFT JOIN `oc_coupon` c ON (ch.coupon_id = c.coupon_id)";

		$implode = [];
        $args = [];

		if (!empty($data['filter_date_start'])) {
			$implode[] = "DATE(ch.date_added) >= :date_start";
            $args[':date_start'] = $data['filter_date_start'];
		}

		if (!empty($data['filter_date_end'])) {
			$implode[] = "DATE(ch.date_added) <= :date_end";
            $args[':date_end'] = $data['filter_date_end'];
		}

		if ($implode) {
			$sql .= " WHERE " . implode(" AND ", $implode);
		}

		$sql .= " GROUP BY ch.coupon_id ORDER BY total DESC";

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

	public function getTotalCoupons($data = []) {
		$sql = "SELECT COUNT(DISTINCT coupon_id) AS total FROM `oc_coupon_history`";

		$implode = [];
        $args = [];

        if (!empty($data['filter_date_start'])) {
            $implode[] = "DATE(ch.date_added) >= :date_start";
            $args[':date_start'] = $data['filter_date_start'];
        }

        if (!empty($data['filter_date_end'])) {
            $implode[] = "DATE(ch.date_added) <= :date_end";
            $args[':date_end'] = $data['filter_date_end'];
        }

		if ($implode) {
			$sql .= " WHERE " . implode(" AND ", $implode);
		}

		$query = $this->db->query($sql, $args);

		return $query->row['total'];
	}
}