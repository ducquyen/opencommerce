<?php

use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class Opencart30 extends AbstractMigration
{
    public function change()
    {
        $this->execute("ALTER DATABASE CHARACTER SET 'utf8';");
        $this->execute("ALTER DATABASE COLLATE='utf8_general_ci';");
        $table = $this->table("oc_address", ['id' => false, 'primary_key' => ["address_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('address_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'identity' => 'enable']);
        $table->addColumn('customer_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'address_id']);
        $table->addColumn('firstname', 'string', ['null' => false, 'limit' => 32, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'customer_id']);
        $table->addColumn('lastname', 'string', ['null' => false, 'limit' => 32, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'firstname']);
        $table->addColumn('company', 'string', ['null' => false, 'limit' => 60, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'lastname']);
        $table->addColumn('address_1', 'string', ['null' => false, 'limit' => 128, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'company']);
        $table->addColumn('address_2', 'string', ['null' => false, 'limit' => 128, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'address_1']);
        $table->addColumn('city', 'string', ['null' => false, 'limit' => 128, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'address_2']);
        $table->addColumn('postcode', 'string', ['null' => false, 'limit' => 10, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'city']);
        $table->addColumn('country_id', 'integer', ['null' => false, 'default' => '0', 'limit' => 9, 'precision' => 10, 'after' => 'postcode']);
        $table->addColumn('zone_id', 'integer', ['null' => false, 'default' => '0', 'limit' => 9, 'precision' => 10, 'after' => 'country_id']);
        $table->addColumn('custom_field', 'text', ['null' => false, 'limit' => 65535, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'zone_id']);
        $table->save();
        if($this->table('oc_address')->hasIndex('customer_id')) {
            $this->table("oc_address")->removeIndexByName('customer_id');
        }
        $this->table("oc_address")->addIndex(['customer_id'], ['name' => "customer_id", 'unique' => false])->save();
        $table = $this->table("oc_api", ['id' => false, 'primary_key' => ["api_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('api_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'identity' => 'enable']);
        $table->addColumn('username', 'string', ['null' => false, 'limit' => 64, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'api_id']);
        $table->addColumn('key', 'text', ['null' => false, 'limit' => 65535, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'username']);
        $table->addColumn('status', 'boolean', ['null' => false, 'limit' => 1, 'precision' => 3, 'after' => 'key']);
        $table->addColumn('date_added', 'datetime', ['null' => false, 'after' => 'status']);
        $table->addColumn('date_modified', 'datetime', ['null' => false, 'after' => 'date_added']);
        $table->save();

        $table = $this->table("oc_api_ip", ['id' => false, 'primary_key' => ["api_ip_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('api_ip_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'identity' => 'enable']);
        $table->addColumn('api_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'api_ip_id']);
        $table->addColumn('ip', 'string', ['null' => false, 'limit' => 40, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'api_id']);
        $table->save();

        $table = $this->table("oc_api_session", ['id' => false, 'primary_key' => ["api_session_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('api_session_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'identity' => 'enable']);
        $table->addColumn('api_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'api_session_id']);
        $table->addColumn('session_id', 'string', ['null' => false, 'limit' => 32, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'api_id']);
        $table->addColumn('ip', 'string', ['null' => false, 'limit' => 40, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'session_id']);
        $table->addColumn('date_added', 'datetime', ['null' => false, 'after' => 'ip']);
        $table->addColumn('date_modified', 'datetime', ['null' => false, 'after' => 'date_added']);
        $table->save();

        $table = $this->table("oc_attribute", ['id' => false, 'primary_key' => ["attribute_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('attribute_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'identity' => 'enable']);
        $table->addColumn('attribute_group_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'attribute_id']);
        $table->addColumn('sort_order', 'integer', ['null' => false, 'default' => 0, 'limit' => 9, 'precision' => 10, 'after' => 'attribute_group_id']);
        $table->save();

        $table = $this->table("oc_attribute_description", ['id' => false, 'primary_key' => ["attribute_id", "language_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('attribute_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10]);
        $table->addColumn('language_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'attribute_id']);
        $table->addColumn('name', 'string', ['null' => false, 'limit' => 64, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'language_id']);
        $table->save();

        $table = $this->table("oc_attribute_group", ['id' => false, 'primary_key' => ["attribute_group_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('attribute_group_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'identity' => 'enable']);
        $table->addColumn('sort_order', 'integer', ['null' => false, 'default' => 0, 'limit' => 9, 'precision' => 10, 'after' => 'attribute_group_id']);
        $table->save();

        $table = $this->table("oc_attribute_group_description", ['id' => false, 'primary_key' => ["attribute_group_id", "language_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('attribute_group_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10]);
        $table->addColumn('language_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'attribute_group_id']);
        $table->addColumn('name', 'string', ['null' => false, 'limit' => 64, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'language_id']);
        $table->save();

        $table = $this->table("oc_banner", ['id' => false, 'primary_key' => ["banner_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('banner_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'identity' => 'enable']);
        $table->addColumn('name', 'string', ['null' => false, 'limit' => 64, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'banner_id']);
        $table->addColumn('status', 'boolean', ['null' => false, 'limit' => 1, 'precision' => 3, 'after' => 'name']);
        $table->save();

        $table = $this->table("oc_banner_image", ['id' => false, 'primary_key' => ["banner_image_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('banner_image_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'identity' => 'enable']);
        $table->addColumn('banner_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'banner_image_id']);
        $table->addColumn('language_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'banner_id']);
        $table->addColumn('title', 'string', ['null' => false, 'limit' => 64, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'language_id']);
        $table->addColumn('link', 'string', ['null' => false, 'limit' => 255, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'title']);
        $table->addColumn('image', 'string', ['null' => false, 'limit' => 255, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'link']);
        $table->addColumn('sort_order', 'integer', ['null' => false, 'default' => '0', 'limit' => 9, 'precision' => 10, 'after' => 'image']);
        $table->save();

        $table = $this->table("oc_cart", ['id' => false, 'primary_key' => ["cart_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('cart_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'signed' => false, 'identity' => 'enable']);
        $table->addColumn('api_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'cart_id']);
        $table->addColumn('customer_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'api_id']);
        $table->addColumn('session_id', 'string', ['null' => false, 'limit' => 32, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'customer_id']);
        $table->addColumn('product_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'session_id']);
        $table->addColumn('recurring_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'product_id']);
        $table->addColumn('option', 'text', ['null' => false, 'limit' => 65535, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'recurring_id']);
        $table->addColumn('quantity', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'option']);
        $table->addColumn('date_added', 'datetime', ['null' => false, 'after' => 'quantity']);
        $table->save();
        if($this->table('oc_cart')->hasIndex('cart_id')) {
            $this->table("oc_cart")->removeIndexByName('cart_id');
        }

        $this->table("oc_cart")->addIndex(['api_id','customer_id','session_id','product_id','recurring_id'], ['name' => "cart_id", 'unique' => false])->save();
        $table = $this->table("oc_category", ['id' => false, 'primary_key' => ["category_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('category_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'identity' => 'enable']);
        $table->addColumn('image', 'string', ['null' => true, 'limit' => 255, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'category_id']);
        $table->addColumn('parent_id', 'integer', ['null' => false, 'default' => '0', 'limit' => 9, 'precision' => 10, 'after' => 'image']);
        $table->addColumn('top', 'boolean', ['null' => false, 'limit' => 1, 'precision' => 3, 'after' => 'parent_id']);
        $table->addColumn('column', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'top']);
        $table->addColumn('sort_order', 'integer', ['null' => false, 'default' => '0', 'limit' => 9, 'precision' => 10, 'after' => 'column']);
        $table->addColumn('status', 'boolean', ['null' => false, 'limit' => 1, 'precision' => 3, 'after' => 'sort_order']);
        $table->addColumn('date_added', 'datetime', ['null' => false, 'after' => 'status']);
        $table->addColumn('date_modified', 'datetime', ['null' => false, 'after' => 'date_added']);
        $table->save();
        if($this->table('oc_category')->hasIndex('parent_id')) {
            $this->table("oc_category")->removeIndexByName('parent_id');
        }

        $this->table("oc_category")->addIndex(['parent_id'], ['name' => "parent_id", 'unique' => false])->save();
        $table = $this->table("oc_category_description", ['id' => false, 'primary_key' => ["category_id", "language_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('category_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10]);
        $table->addColumn('language_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'category_id']);
        $table->addColumn('name', 'string', ['null' => false, 'limit' => 255, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'language_id']);
        $table->addColumn('description', 'text', ['null' => false, 'limit' => 65535, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'name']);
        $table->addColumn('meta_title', 'string', ['null' => false, 'limit' => 255, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'description']);
        $table->addColumn('meta_description', 'string', ['null' => false, 'limit' => 255, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'meta_title']);
        $table->addColumn('meta_keyword', 'string', ['null' => false, 'limit' => 255, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'meta_description']);
        $table->save();
        if($this->table('oc_category_description')->hasIndex('name')) {
            $this->table("oc_category_description")->removeIndexByName('name');
        }
        $this->table("oc_category_description")->addIndex(['name'], ['name' => "name", 'unique' => false])->save();
        $table = $this->table("oc_category_filter", ['id' => false, 'primary_key' => ["category_id", "filter_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('category_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10]);
        $table->addColumn('filter_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'category_id']);
        $table->save();

        $table = $this->table("oc_category_path", ['id' => false, 'primary_key' => ["category_id", "path_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('category_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10]);
        $table->addColumn('path_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'category_id']);
        $table->addColumn('level', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'path_id']);
        $table->save();

        $table = $this->table("oc_category_to_layout", ['id' => false, 'primary_key' => ["category_id", "store_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('category_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10]);
        $table->addColumn('store_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'category_id']);
        $table->addColumn('layout_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'store_id']);
        $table->save();

        $table = $this->table("oc_category_to_store", ['id' => false, 'primary_key' => ["category_id", "store_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('category_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10]);
        $table->addColumn('store_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'category_id']);
        $table->save();

        $table = $this->table("oc_country", ['id' => false, 'primary_key' => ["country_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('country_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'identity' => 'enable']);
        $table->addColumn('name', 'string', ['null' => false, 'limit' => 128, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'country_id']);
        $table->addColumn('iso_code_2', 'string', ['null' => false, 'limit' => 2, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'name']);
        $table->addColumn('iso_code_3', 'string', ['null' => false, 'limit' => 3, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'iso_code_2']);
        $table->addColumn('address_format', 'text', ['null' => false, 'limit' => 65535, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'iso_code_3']);
        $table->addColumn('postcode_required', 'boolean', ['null' => false, 'limit' => 1, 'precision' => 3, 'after' => 'address_format']);
        $table->addColumn('status', 'boolean', ['null' => false, 'default' => '1', 'limit' => 1, 'precision' => 3, 'after' => 'postcode_required']);
        $table->save();

        $table = $this->table("oc_coupon", ['id' => false, 'primary_key' => ["coupon_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('coupon_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'identity' => 'enable']);
        $table->addColumn('name', 'string', ['null' => false, 'limit' => 128, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'coupon_id']);
        $table->addColumn('code', 'string', ['null' => false, 'limit' => 20, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'name']);
        $table->addColumn('type', 'char', ['null' => false, 'limit' => 1, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'code']);
        $table->addColumn('discount', 'decimal', ['null' => false, 'precision' => 15, 'scale' => 4, 'after' => 'type']);
        $table->addColumn('logged', 'boolean', ['null' => false, 'limit' => 1, 'precision' => 3, 'after' => 'discount']);
        $table->addColumn('shipping', 'boolean', ['null' => false, 'limit' => 1, 'precision' => 3, 'after' => 'logged']);
        $table->addColumn('total', 'decimal', ['null' => false, 'precision' => 15, 'scale' => 4, 'after' => 'shipping']);
        $table->addColumn('date_start', 'date', ['null' => false, 'default' => '2001-01-01', 'after' => 'total']);
        $table->addColumn('date_end', 'date', ['null' => false, 'default' => '2001-01-01', 'after' => 'date_start']);
        $table->addColumn('uses_total', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'date_end']);
        $table->addColumn('uses_customer', 'string', ['null' => false, 'limit' => 11, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'uses_total']);
        $table->addColumn('status', 'boolean', ['null' => false, 'limit' => 1, 'precision' => 3, 'after' => 'uses_customer']);
        $table->addColumn('date_added', 'datetime', ['null' => false, 'after' => 'status']);
        $table->save();

        $table = $this->table("oc_coupon_category", ['id' => false, 'primary_key' => ["coupon_id", "category_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('coupon_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10]);
        $table->addColumn('category_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'coupon_id']);
        $table->save();

        $table = $this->table("oc_coupon_history", ['id' => false, 'primary_key' => ["coupon_history_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('coupon_history_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'identity' => 'enable']);
        $table->addColumn('coupon_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'coupon_history_id']);
        $table->addColumn('order_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'coupon_id']);
        $table->addColumn('customer_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'order_id']);
        $table->addColumn('amount', 'decimal', ['null' => false, 'precision' => 15, 'scale' => 4, 'after' => 'customer_id']);
        $table->addColumn('date_added', 'datetime', ['null' => false, 'after' => 'amount']);
        $table->save();

        $table = $this->table("oc_coupon_product", ['id' => false, 'primary_key' => ["coupon_product_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('coupon_product_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'identity' => 'enable']);
        $table->addColumn('coupon_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'coupon_product_id']);
        $table->addColumn('product_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'coupon_id']);
        $table->save();

        $table = $this->table("oc_cron", ['id' => false, 'primary_key' => ["cron_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('cron_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'identity' => 'enable']);
        $table->addColumn('code', 'string', ['null' => false, 'limit' => 64, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'cron_id']);
        $table->addColumn('cycle', 'string', ['null' => false, 'limit' => 12, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'code']);
        $table->addColumn('action', 'text', ['null' => false, 'limit' => 65535, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'cycle']);
        $table->addColumn('status', 'boolean', ['null' => false, 'limit' => 1, 'precision' => 3, 'after' => 'action']);
        $table->addColumn('date_added', 'datetime', ['null' => false, 'after' => 'status']);
        $table->addColumn('date_modified', 'datetime', ['null' => false, 'after' => 'date_added']);
        $table->save();

        $table = $this->table("oc_currency", ['id' => false, 'primary_key' => ["currency_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('currency_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'identity' => 'enable']);
        $table->addColumn('title', 'string', ['null' => false, 'limit' => 32, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'currency_id']);
        $table->addColumn('code', 'string', ['null' => false, 'limit' => 3, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'title']);
        $table->addColumn('symbol_left', 'string', ['null' => false, 'limit' => 12, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'code']);
        $table->addColumn('symbol_right', 'string', ['null' => false, 'limit' => 12, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'symbol_left']);
        $table->addColumn('decimal_place', 'char', ['null' => false, 'limit' => 1, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'symbol_right']);
        $table->addColumn('value', 'decimal', ['null' => false, 'precision' => 15, 'scale' => 8, 'after' => 'decimal_place']);
        $table->addColumn('status', 'boolean', ['null' => false, 'limit' => 1, 'precision' => 3, 'after' => 'value']);
        $table->addColumn('date_modified', 'datetime', ['null' => false, 'after' => 'status']);
        $table->save();

        $table = $this->table("oc_custom_field", ['id' => false, 'primary_key' => ["custom_field_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('custom_field_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'identity' => 'enable']);
        $table->addColumn('type', 'string', ['null' => false, 'limit' => 32, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'custom_field_id']);
        $table->addColumn('value', 'text', ['null' => false, 'limit' => 65535, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'type']);
        $table->addColumn('validation', 'string', ['null' => false, 'limit' => 255, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'value']);
        $table->addColumn('location', 'string', ['null' => false, 'limit' => 10, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'validation']);
        $table->addColumn('status', 'boolean', ['null' => false, 'limit' => 1, 'precision' => 3, 'after' => 'location']);
        $table->addColumn('sort_order', 'integer', ['null' => false, 'default' => '0', 'limit' => 9, 'precision' => 10, 'after' => 'status']);
        $table->save();

        $table = $this->table("oc_custom_field_customer_group", ['id' => false, 'primary_key' => ["custom_field_id", "customer_group_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('custom_field_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10]);
        $table->addColumn('customer_group_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'custom_field_id']);
        $table->addColumn('required', 'boolean', ['null' => false, 'limit' => 1, 'precision' => 3, 'after' => 'customer_group_id']);
        $table->save();

        $table = $this->table("oc_custom_field_description", ['id' => false, 'primary_key' => ["custom_field_id", "language_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('custom_field_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10]);
        $table->addColumn('language_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'custom_field_id']);
        $table->addColumn('name', 'string', ['null' => false, 'limit' => 128, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'language_id']);
        $table->save();

        $table = $this->table("oc_custom_field_value", ['id' => false, 'primary_key' => ["custom_field_value_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('custom_field_value_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'identity' => 'enable']);
        $table->addColumn('custom_field_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'custom_field_value_id']);
        $table->addColumn('sort_order', 'integer', ['null' => false, 'default' => '0', 'limit' => 9, 'precision' => 10, 'after' => 'custom_field_id']);
        $table->save();

        $table = $this->table("oc_custom_field_value_description", ['id' => false, 'primary_key' => ["custom_field_value_id", "language_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('custom_field_value_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10]);
        $table->addColumn('language_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'custom_field_value_id']);
        $table->addColumn('custom_field_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'language_id']);
        $table->addColumn('name', 'string', ['null' => false, 'limit' => 128, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'custom_field_id']);
        $table->save();

        $table = $this->table("oc_customer", ['id' => false, 'primary_key' => ["customer_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('customer_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'identity' => 'enable']);
        $table->addColumn('customer_group_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'customer_id']);
        $table->addColumn('store_id', 'integer', ['null' => false, 'default' => '0', 'limit' => 9, 'precision' => 10, 'after' => 'customer_group_id']);
        $table->addColumn('language_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'store_id']);
        $table->addColumn('firstname', 'string', ['null' => false, 'limit' => 32, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'language_id']);
        $table->addColumn('lastname', 'string', ['null' => false, 'limit' => 32, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'firstname']);
        $table->addColumn('email', 'string', ['null' => false, 'limit' => 96, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'lastname']);
        $table->addColumn('telephone', 'string', ['null' => false, 'limit' => 32, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'email']);
        $table->addColumn('fax', 'string', ['null' => false, 'limit' => 32, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'telephone']);
        $table->addColumn('password', 'string', ['null' => false, 'limit' => 255, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'fax']);
        $table->addColumn('salt', 'string', ['null' => false, 'limit' => 9, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'password']);
        $table->addColumn('cart', 'text', ['null' => true, 'limit' => 65535, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'salt']);
        $table->addColumn('wishlist', 'text', ['null' => true, 'limit' => 65535, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'cart']);
        $table->addColumn('newsletter', 'boolean', ['null' => false, 'default' => '0', 'limit' => 1, 'precision' => 3, 'after' => 'wishlist']);
        $table->addColumn('address_id', 'integer', ['null' => false, 'default' => '0', 'limit' => 9, 'precision' => 10, 'after' => 'newsletter']);
        $table->addColumn('custom_field', 'text', ['null' => false, 'limit' => 65535, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'address_id']);
        $table->addColumn('ip', 'string', ['null' => false, 'limit' => 40, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'custom_field']);
        $table->addColumn('status', 'boolean', ['null' => false, 'limit' => 1, 'precision' => 3, 'after' => 'ip']);
        $table->addColumn('safe', 'boolean', ['null' => false, 'limit' => 1, 'precision' => 3, 'after' => 'status']);
        $table->addColumn('token', 'text', ['null' => false, 'limit' => 65535, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'safe']);
        $table->addColumn('code', 'string', ['null' => false, 'limit' => 40, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'token']);
        $table->addColumn('date_added', 'datetime', ['null' => false, 'after' => 'code']);
        $table->save();

        $table = $this->table("oc_customer_activity", ['id' => false, 'primary_key' => ["customer_activity_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('customer_activity_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'identity' => 'enable']);
        $table->addColumn('customer_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'customer_activity_id']);
        $table->addColumn('key', 'string', ['null' => false, 'limit' => 64, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'customer_id']);
        $table->addColumn('data', 'text', ['null' => false, 'limit' => 65535, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'key']);
        $table->addColumn('ip', 'string', ['null' => false, 'limit' => 40, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'data']);
        $table->addColumn('date_added', 'datetime', ['null' => false, 'after' => 'ip']);
        $table->save();

        $table = $this->table("oc_customer_affiliate", ['id' => false, 'primary_key' => ["customer_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('customer_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10]);
        $table->addColumn('company', 'string', ['null' => false, 'limit' => 40, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'customer_id']);
        $table->addColumn('website', 'string', ['null' => false, 'limit' => 255, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'company']);
        $table->addColumn('tracking', 'string', ['null' => false, 'limit' => 64, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'website']);
        $table->addColumn('commission', 'decimal', ['null' => false, 'default' => '0.00', 'precision' => 4, 'scale' => 2, 'after' => 'tracking']);
        $table->addColumn('tax', 'string', ['null' => false, 'limit' => 64, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'commission']);
        $table->addColumn('payment', 'string', ['null' => false, 'limit' => 6, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'tax']);
        $table->addColumn('cheque', 'string', ['null' => false, 'limit' => 100, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'payment']);
        $table->addColumn('paypal', 'string', ['null' => false, 'limit' => 64, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'cheque']);
        $table->addColumn('bank_name', 'string', ['null' => false, 'limit' => 64, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'paypal']);
        $table->addColumn('bank_branch_number', 'string', ['null' => false, 'limit' => 64, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'bank_name']);
        $table->addColumn('bank_swift_code', 'string', ['null' => false, 'limit' => 64, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'bank_branch_number']);
        $table->addColumn('bank_account_name', 'string', ['null' => false, 'limit' => 64, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'bank_swift_code']);
        $table->addColumn('bank_account_number', 'string', ['null' => false, 'limit' => 64, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'bank_account_name']);
        $table->addColumn('custom_field', 'text', ['null' => false, 'limit' => 65535, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'bank_account_number']);
        $table->addColumn('status', 'boolean', ['null' => false, 'limit' => 1, 'precision' => 3, 'after' => 'custom_field']);
        $table->addColumn('date_added', 'datetime', ['null' => false, 'after' => 'status']);
        $table->save();

        $table = $this->table("oc_customer_affiliate_report", ['id' => false, 'primary_key' => ["customer_affiliate_report_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('customer_affiliate_report_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'identity' => 'enable']);
        $table->addColumn('customer_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'customer_affiliate_report_id']);
        $table->addColumn('store_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'customer_id']);
        $table->addColumn('ip', 'string', ['null' => false, 'limit' => 40, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'store_id']);
        $table->addColumn('country', 'string', ['null' => false, 'limit' => 2, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'ip']);
        $table->addColumn('date_added', 'datetime', ['null' => false, 'after' => 'country']);
        $table->save();

        $table = $this->table("oc_customer_approval", ['id' => false, 'primary_key' => ["customer_approval_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('customer_approval_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'identity' => 'enable']);
        $table->addColumn('customer_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'customer_approval_id']);
        $table->addColumn('type', 'string', ['null' => false, 'limit' => 9, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'customer_id']);
        $table->addColumn('date_added', 'datetime', ['null' => false, 'after' => 'type']);
        $table->save();

        $table = $this->table("oc_customer_group", ['id' => false, 'primary_key' => ["customer_group_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('customer_group_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'identity' => 'enable']);
        $table->addColumn('approval', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'customer_group_id']);
        $table->addColumn('sort_order', 'integer', ['null' => false, 'default' => '0', 'limit' => 9, 'precision' => 10, 'after' => 'approval']);
        $table->save();

        $table = $this->table("oc_customer_group_description", ['id' => false, 'primary_key' => ["customer_group_id", "language_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('customer_group_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10]);
        $table->addColumn('language_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'customer_group_id']);
        $table->addColumn('name', 'string', ['null' => false, 'limit' => 32, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'language_id']);
        $table->addColumn('description', 'text', ['null' => false, 'limit' => 65535, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'name']);
        $table->save();

        $table = $this->table("oc_customer_history", ['id' => false, 'primary_key' => ["customer_history_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('customer_history_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'identity' => 'enable']);
        $table->addColumn('customer_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'customer_history_id']);
        $table->addColumn('comment', 'text', ['null' => false, 'limit' => 65535, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'customer_id']);
        $table->addColumn('date_added', 'datetime', ['null' => false, 'after' => 'comment']);
        $table->save();

        $table = $this->table("oc_customer_ip", ['id' => false, 'primary_key' => ["customer_ip_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('customer_ip_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'identity' => 'enable']);
        $table->addColumn('customer_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'customer_ip_id']);
        $table->addColumn('store_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'customer_id']);
        $table->addColumn('ip', 'string', ['null' => false, 'limit' => 40, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'store_id']);
        $table->addColumn('country', 'string', ['null' => false, 'limit' => 2, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'ip']);
        $table->addColumn('date_added', 'datetime', ['null' => false, 'after' => 'country']);
        $table->save();
        if($this->table('oc_customer_ip')->hasIndex('ip')) {
            $this->table("oc_customer_ip")->removeIndexByName('ip');
        }
        $this->table("oc_customer_ip")->addIndex(['ip'], ['name' => "ip", 'unique' => false])->save();

        $table = $this->table("oc_customer_login", ['id' => false, 'primary_key' => ["customer_login_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('customer_login_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'identity' => 'enable']);
        $table->addColumn('email', 'string', ['null' => false, 'limit' => 96, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'customer_login_id']);
        $table->addColumn('ip', 'string', ['null' => false, 'limit' => 40, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'email']);
        $table->addColumn('total', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'ip']);
        $table->addColumn('date_added', 'datetime', ['null' => false, 'after' => 'total']);
        $table->addColumn('date_modified', 'datetime', ['null' => false, 'after' => 'date_added']);
        $table->save();
        if($this->table('oc_customer_login')->hasIndex('email')) {
            $this->table("oc_customer_login")->removeIndexByName('email');
        }
        $this->table("oc_customer_login")->addIndex(['email'], ['name' => "email", 'unique' => false])->save();
        if($this->table('oc_customer_login')->hasIndex('ip')) {
            $this->table("oc_customer_login")->removeIndexByName('ip');
        }
        $this->table("oc_customer_login")->addIndex(['ip'], ['name' => "ip", 'unique' => false])->save();

        $table = $this->table("oc_customer_online", ['id' => false, 'primary_key' => ["ip"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('ip', 'string', ['null' => false, 'limit' => 40, 'collation' => "utf8_general_ci", 'encoding' => "utf8"]);
        $table->addColumn('customer_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'ip']);
        $table->addColumn('url', 'text', ['null' => false, 'limit' => 65535, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'customer_id']);
        $table->addColumn('referer', 'text', ['null' => false, 'limit' => 65535, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'url']);
        $table->addColumn('date_added', 'datetime', ['null' => false, 'after' => 'referer']);
        $table->save();

        $table = $this->table("oc_customer_reward", ['id' => false, 'primary_key' => ["customer_reward_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('customer_reward_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'identity' => 'enable']);
        $table->addColumn('customer_id', 'integer', ['null' => false, 'default' => '0', 'limit' => 9, 'precision' => 10, 'after' => 'customer_reward_id']);
        $table->addColumn('order_id', 'integer', ['null' => false, 'default' => '0', 'limit' => 9, 'precision' => 10, 'after' => 'customer_id']);
        $table->addColumn('description', 'text', ['null' => false, 'limit' => 65535, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'order_id']);
        $table->addColumn('points', 'integer', ['null' => false, 'default' => '0', 'limit' => 9, 'precision' => 10, 'after' => 'description']);
        $table->addColumn('date_added', 'datetime', ['null' => false, 'after' => 'points']);
        $table->save();

        $table = $this->table("oc_customer_search", ['id' => false, 'primary_key' => ["customer_search_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('customer_search_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'identity' => 'enable']);
        $table->addColumn('store_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'customer_search_id']);
        $table->addColumn('language_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'store_id']);
        $table->addColumn('customer_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'language_id']);
        $table->addColumn('keyword', 'string', ['null' => false, 'limit' => 255, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'customer_id']);
        $table->addColumn('category_id', 'integer', ['null' => true, 'limit' => 9, 'precision' => 10, 'after' => 'keyword']);
        $table->addColumn('sub_category', 'boolean', ['null' => false, 'limit' => 1, 'precision' => 3, 'after' => 'category_id']);
        $table->addColumn('description', 'boolean', ['null' => false, 'limit' => 1, 'precision' => 3, 'after' => 'sub_category']);
        $table->addColumn('products', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'description']);
        $table->addColumn('ip', 'string', ['null' => false, 'limit' => 40, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'products']);
        $table->addColumn('date_added', 'datetime', ['null' => false, 'after' => 'ip']);
        $table->save();

        $table = $this->table("oc_customer_transaction", ['id' => false, 'primary_key' => ["customer_transaction_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('customer_transaction_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'identity' => 'enable']);
        $table->addColumn('customer_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'customer_transaction_id']);
        $table->addColumn('order_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'customer_id']);
        $table->addColumn('description', 'text', ['null' => false, 'limit' => 65535, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'order_id']);
        $table->addColumn('amount', 'decimal', ['null' => false, 'precision' => 15, 'scale' => 4, 'after' => 'description']);
        $table->addColumn('date_added', 'datetime', ['null' => false, 'after' => 'amount']);
        $table->save();

        $table = $this->table("oc_customer_wishlist", ['id' => false, 'primary_key' => ["customer_id", "product_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('customer_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10]);
        $table->addColumn('product_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'customer_id']);
        $table->addColumn('date_added', 'datetime', ['null' => false, 'after' => 'product_id']);
        $table->save();

        $table = $this->table("oc_download", ['id' => false, 'primary_key' => ["download_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('download_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'identity' => 'enable']);
        $table->addColumn('filename', 'string', ['null' => false, 'limit' => 160, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'download_id']);
        $table->addColumn('mask', 'string', ['null' => false, 'limit' => 128, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'filename']);
        $table->addColumn('date_added', 'datetime', ['null' => false, 'after' => 'mask']);
        $table->save();

        $table = $this->table("oc_download_description", ['id' => false, 'primary_key' => ["download_id", "language_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('download_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10]);
        $table->addColumn('language_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'download_id']);
        $table->addColumn('name', 'string', ['null' => false, 'limit' => 64, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'language_id']);
        $table->save();

        $table = $this->table("oc_download_report", ['id' => false, 'primary_key' => ["download_report_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('download_report_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'identity' => 'enable']);
        $table->addColumn('download_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'download_report_id']);
        $table->addColumn('store_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'download_id']);
        $table->addColumn('ip', 'string', ['null' => false, 'limit' => 40, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'store_id']);
        $table->addColumn('country', 'string', ['null' => false, 'limit' => 2, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'ip']);
        $table->addColumn('date_added', 'datetime', ['null' => false, 'after' => 'country']);
        $table->save();

        $table = $this->table("oc_event", ['id' => false, 'primary_key' => ["event_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('event_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'identity' => 'enable']);
        $table->addColumn('code', 'string', ['null' => false, 'limit' => 64, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'event_id']);
        $table->addColumn('trigger', 'text', ['null' => false, 'limit' => 65535, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'code']);
        $table->addColumn('action', 'text', ['null' => false, 'limit' => 65535, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'trigger']);
        $table->addColumn('status', 'boolean', ['null' => false, 'limit' => 1, 'precision' => 3, 'after' => 'action']);
        $table->addColumn('sort_order', 'integer', ['null' => false, 'default' => '0', 'limit' => 9, 'precision' => 10, 'after' => 'status']);
        $table->save();

        $table = $this->table("oc_extension", ['id' => false, 'primary_key' => ["extension_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('extension_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'identity' => 'enable']);
        $table->addColumn('type', 'string', ['null' => false, 'limit' => 32, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'extension_id']);
        $table->addColumn('code', 'string', ['null' => false, 'limit' => 32, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'type']);
        $table->save();

        $table = $this->table("oc_extension_install", ['id' => false, 'primary_key' => ["extension_install_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('extension_install_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'identity' => 'enable']);
        $table->addColumn('extension_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'extension_install_id']);
        $table->addColumn('extension_download_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'extension_id']);
        $table->addColumn('filename', 'string', ['null' => false, 'limit' => 255, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'extension_download_id']);
        $table->addColumn('date_added', 'datetime', ['null' => false, 'after' => 'filename']);
        $table->save();

        $table = $this->table("oc_extension_path", ['id' => false, 'primary_key' => ["extension_path_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('extension_path_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'identity' => 'enable']);
        $table->addColumn('extension_install_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'extension_path_id']);
        $table->addColumn('path', 'string', ['null' => false, 'limit' => 255, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'extension_install_id']);
        $table->addColumn('date_added', 'datetime', ['null' => false, 'after' => 'path']);
        $table->save();

        $table = $this->table("oc_filter", ['id' => false, 'primary_key' => ["filter_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('filter_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'identity' => 'enable']);
        $table->addColumn('filter_group_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'filter_id']);
        $table->addColumn('sort_order', 'integer', ['null' => false, 'default' => '0', 'limit' => 9, 'precision' => 10, 'after' => 'filter_group_id']);
        $table->save();

        $table = $this->table("oc_filter_description", ['id' => false, 'primary_key' => ["filter_id", "language_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('filter_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10]);
        $table->addColumn('language_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'filter_id']);
        $table->addColumn('filter_group_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'language_id']);
        $table->addColumn('name', 'string', ['null' => false, 'limit' => 64, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'filter_group_id']);
        $table->save();

        $table = $this->table("oc_filter_group", ['id' => false, 'primary_key' => ["filter_group_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('filter_group_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'identity' => 'enable']);
        $table->addColumn('sort_order', 'integer', ['null' => false, 'default' => '0', 'limit' => 9, 'precision' => 10, 'after' => 'filter_group_id']);
        $table->save();

        $table = $this->table("oc_filter_group_description", ['id' => false, 'primary_key' => ["filter_group_id", "language_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('filter_group_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10]);
        $table->addColumn('language_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'filter_group_id']);
        $table->addColumn('name', 'string', ['null' => false, 'limit' => 64, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'language_id']);
        $table->save();

        $table = $this->table("oc_geo_zone", ['id' => false, 'primary_key' => ["geo_zone_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('geo_zone_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'identity' => 'enable']);
        $table->addColumn('name', 'string', ['null' => false, 'limit' => 32, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'geo_zone_id']);
        $table->addColumn('description', 'string', ['null' => false, 'limit' => 255, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'name']);
        $table->addColumn('date_added', 'datetime', ['null' => false, 'after' => 'description']);
        $table->addColumn('date_modified', 'datetime', ['null' => false, 'after' => 'date_added']);
        $table->save();

        $table = $this->table("oc_information", ['id' => false, 'primary_key' => ["information_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('information_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'identity' => 'enable']);
        $table->addColumn('bottom', 'integer', ['null' => false, 'default' => '0', 'limit' => 9, 'precision' => 10, 'after' => 'information_id']);
        $table->addColumn('sort_order', 'integer', ['null' => false, 'default' => '0', 'limit' => 9, 'precision' => 10, 'after' => 'bottom']);
        $table->addColumn('status', 'boolean', ['null' => false, 'default' => '1', 'limit' => 1, 'precision' => 3, 'after' => 'sort_order']);
        $table->save();

        $table = $this->table("oc_information_description", ['id' => false, 'primary_key' => ["information_id", "language_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('information_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10]);
        $table->addColumn('language_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'information_id']);
        $table->addColumn('title', 'string', ['null' => false, 'limit' => 64, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'language_id']);
        $table->addColumn('description', 'text', ['null' => false, 'limit' => MysqlAdapter::TEXT_MEDIUM, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'title']);
        $table->addColumn('meta_title', 'string', ['null' => false, 'limit' => 255, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'description']);
        $table->addColumn('meta_description', 'string', ['null' => false, 'limit' => 255, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'meta_title']);
        $table->addColumn('meta_keyword', 'string', ['null' => false, 'limit' => 255, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'meta_description']);
        $table->save();

        $table = $this->table("oc_information_to_layout", ['id' => false, 'primary_key' => ["information_id", "store_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('information_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10]);
        $table->addColumn('store_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'information_id']);
        $table->addColumn('layout_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'store_id']);
        $table->save();

        $table = $this->table("oc_information_to_store", ['id' => false, 'primary_key' => ["information_id", "store_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('information_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10]);
        $table->addColumn('store_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'information_id']);
        $table->save();

        $table = $this->table("oc_language", ['id' => false, 'primary_key' => ["language_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('language_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'identity' => 'enable']);
        $table->addColumn('name', 'string', ['null' => false, 'limit' => 32, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'language_id']);
        $table->addColumn('code', 'string', ['null' => false, 'limit' => 5, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'name']);
        $table->addColumn('locale', 'string', ['null' => false, 'limit' => 255, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'code']);
        $table->addColumn('image', 'string', ['null' => false, 'limit' => 64, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'locale']);
        $table->addColumn('directory', 'string', ['null' => false, 'limit' => 32, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'image']);
        $table->addColumn('sort_order', 'integer', ['null' => false, 'default' => '0', 'default' => '0', 'limit' => 9, 'precision' => 10, 'after' => 'directory']);
        $table->addColumn('status', 'boolean', ['null' => false, 'limit' => 1, 'precision' => 3, 'after' => 'sort_order']);
        $table->save();
        if($this->table('oc_language')->hasIndex('name')) {
            $this->table("oc_language")->removeIndexByName('name');
        }
        $this->table("oc_language")->addIndex(['name'], ['name' => "name", 'unique' => false])->save();

        $table = $this->table("oc_layout", ['id' => false, 'primary_key' => ["layout_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('layout_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'identity' => 'enable']);
        $table->addColumn('name', 'string', ['null' => false, 'limit' => 64, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'layout_id']);
        $table->save();

        $table = $this->table("oc_layout_module", ['id' => false, 'primary_key' => ["layout_module_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('layout_module_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'identity' => 'enable']);
        $table->addColumn('layout_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'layout_module_id']);
        $table->addColumn('code', 'string', ['null' => false, 'limit' => 64, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'layout_id']);
        $table->addColumn('position', 'string', ['null' => false, 'limit' => 14, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'code']);
        $table->addColumn('sort_order', 'integer', ['null' => false, 'default' => '0', 'limit' => 9, 'precision' => 10, 'after' => 'position']);
        $table->save();

        $table = $this->table("oc_layout_route", ['id' => false, 'primary_key' => ["layout_route_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('layout_route_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'identity' => 'enable']);
        $table->addColumn('layout_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'layout_route_id']);
        $table->addColumn('store_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'layout_id']);
        $table->addColumn('route', 'string', ['null' => false, 'limit' => 64, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'store_id']);
        $table->save();

        $table = $this->table("oc_length_class", ['id' => false, 'primary_key' => ["length_class_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('length_class_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'identity' => 'enable']);
        $table->addColumn('value', 'decimal', ['null' => false, 'precision' => 15, 'scale' => 8, 'after' => 'length_class_id']);
        $table->save();

        $table = $this->table("oc_length_class_description", ['id' => false, 'primary_key' => ["length_class_id", "language_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('length_class_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10]);
        $table->addColumn('language_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'length_class_id']);
        $table->addColumn('title', 'string', ['null' => false, 'limit' => 32, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'language_id']);
        $table->addColumn('unit', 'string', ['null' => false, 'limit' => 4, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'title']);
        $table->save();

        $table = $this->table("oc_location", ['id' => false, 'primary_key' => ["location_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('location_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'identity' => 'enable']);
        $table->addColumn('name', 'string', ['null' => false, 'limit' => 32, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'location_id']);
        $table->addColumn('address', 'text', ['null' => false, 'limit' => 65535, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'name']);
        $table->addColumn('telephone', 'string', ['null' => false, 'limit' => 32, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'address']);
        $table->addColumn('fax', 'string', ['null' => false, 'limit' => 32, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'telephone']);
        $table->addColumn('geocode', 'string', ['null' => false, 'limit' => 32, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'fax']);
        $table->addColumn('image', 'string', ['null' => true, 'limit' => 255, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'geocode']);
        $table->addColumn('open', 'text', ['null' => false, 'limit' => 65535, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'image']);
        $table->addColumn('comment', 'text', ['null' => false, 'limit' => 65535, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'open']);
        $table->save();
        if($this->table('oc_location')->hasIndex('name')) {
            $this->table("oc_location")->removeIndexByName('name');
        }
        $this->table("oc_location")->addIndex(['name'], ['name' => "name", 'unique' => false])->save();

        $table = $this->table("oc_manufacturer", ['id' => false, 'primary_key' => ["manufacturer_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('manufacturer_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'identity' => 'enable']);
        $table->addColumn('name', 'string', ['null' => false, 'limit' => 64, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'manufacturer_id']);
        $table->addColumn('image', 'string', ['null' => true, 'limit' => 255, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'name']);
        $table->addColumn('sort_order', 'integer', ['null' => false, 'default' => '0', 'limit' => 9, 'precision' => 10, 'after' => 'image']);
        $table->save();

        $table = $this->table("oc_manufacturer_to_store", ['id' => false, 'primary_key' => ["manufacturer_id", "store_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('manufacturer_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10]);
        $table->addColumn('store_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'manufacturer_id']);
        $table->save();

        $table = $this->table("oc_marketing", ['id' => false, 'primary_key' => ["marketing_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('marketing_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'identity' => 'enable']);
        $table->addColumn('name', 'string', ['null' => false, 'limit' => 32, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'marketing_id']);
        $table->addColumn('description', 'text', ['null' => false, 'limit' => 65535, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'name']);
        $table->addColumn('code', 'string', ['null' => false, 'limit' => 64, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'description']);
        $table->addColumn('clicks', 'integer', ['null' => false, 'default' => '0', 'limit' => 9, 'precision' => 10, 'after' => 'code']);
        $table->addColumn('date_added', 'datetime', ['null' => false, 'after' => 'clicks']);
        $table->save();

        $table = $this->table("oc_marketing_report", ['id' => false, 'primary_key' => ["marketing_report_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('marketing_report_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'identity' => 'enable']);
        $table->addColumn('marketing_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'marketing_report_id']);
        $table->addColumn('store_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'marketing_id']);
        $table->addColumn('ip', 'string', ['null' => false, 'limit' => 40, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'store_id']);
        $table->addColumn('country', 'string', ['null' => false, 'limit' => 2, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'ip']);
        $table->addColumn('date_added', 'datetime', ['null' => false, 'after' => 'country']);
        $table->save();

        $table = $this->table("oc_modification", ['id' => false, 'primary_key' => ["modification_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('modification_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'identity' => 'enable']);
        $table->addColumn('extension_install_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'modification_id']);
        $table->addColumn('extension_download_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'extension_install_id']);
        $table->addColumn('name', 'string', ['null' => false, 'limit' => 64, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'extension_download_id']);
        $table->addColumn('code', 'string', ['null' => false, 'limit' => 64, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'name']);
        $table->addColumn('author', 'string', ['null' => false, 'limit' => 64, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'code']);
        $table->addColumn('version', 'string', ['null' => false, 'limit' => 32, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'author']);
        $table->addColumn('link', 'string', ['null' => false, 'limit' => 255, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'version']);
        $table->addColumn('xml', 'text', ['null' => false, 'limit' => MysqlAdapter::TEXT_MEDIUM, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'link']);
        $table->addColumn('status', 'boolean', ['null' => false, 'limit' => 1, 'precision' => 3, 'after' => 'xml']);
        $table->addColumn('date_added', 'datetime', ['null' => false, 'after' => 'status']);
        $table->save();

        $table = $this->table("oc_module", ['id' => false, 'primary_key' => ["module_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('module_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'identity' => 'enable']);
        $table->addColumn('name', 'string', ['null' => false, 'limit' => 64, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'module_id']);
        $table->addColumn('code', 'string', ['null' => false, 'limit' => 32, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'name']);
        $table->addColumn('setting', 'text', ['null' => false, 'limit' => 65535, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'code']);
        $table->save();

        $table = $this->table("oc_option", ['id' => false, 'primary_key' => ["option_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('option_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'identity' => 'enable']);
        $table->addColumn('type', 'string', ['null' => false, 'limit' => 32, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'option_id']);
        $table->addColumn('sort_order', 'integer', ['null' => false, 'default' => '0', 'limit' => 9, 'precision' => 10, 'after' => 'type']);
        $table->save();

        $table = $this->table("oc_option_description", ['id' => false, 'primary_key' => ["option_id", "language_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('option_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10]);
        $table->addColumn('language_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'option_id']);
        $table->addColumn('name', 'string', ['null' => false, 'limit' => 128, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'language_id']);
        $table->save();

        $table = $this->table("oc_option_value", ['id' => false, 'primary_key' => ["option_value_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('option_value_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'identity' => 'enable']);
        $table->addColumn('option_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'option_value_id']);
        $table->addColumn('image', 'string', ['null' => false, 'limit' => 255, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'option_id']);
        $table->addColumn('sort_order', 'integer', ['null' => false, 'default' => '0', 'limit' => 9, 'precision' => 10, 'after' => 'image']);
        $table->save();

        $table = $this->table("oc_option_value_description", ['id' => false, 'primary_key' => ["option_value_id", "language_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('option_value_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10]);
        $table->addColumn('language_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'option_value_id']);
        $table->addColumn('option_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'language_id']);
        $table->addColumn('name', 'string', ['null' => false, 'limit' => 128, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'option_id']);
        $table->save();

        $table = $this->table("oc_order", ['id' => false, 'primary_key' => ["order_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('order_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'identity' => 'enable']);
        $table->addColumn('invoice_no', 'integer', ['null' => false, 'default' => '0', 'limit' => 9, 'precision' => 10, 'after' => 'order_id']);
        $table->addColumn('invoice_prefix', 'string', ['null' => false, 'limit' => 26, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'invoice_no']);
        $table->addColumn('store_id', 'integer', ['null' => false, 'default' => '0', 'limit' => 9, 'precision' => 10, 'after' => 'invoice_prefix']);
        $table->addColumn('store_name', 'string', ['null' => false, 'limit' => 64, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'store_id']);
        $table->addColumn('store_url', 'string', ['null' => false, 'limit' => 255, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'store_name']);
        $table->addColumn('customer_id', 'integer', ['null' => false, 'default' => '0', 'limit' => 9, 'precision' => 10, 'after' => 'store_url']);
        $table->addColumn('customer_group_id', 'integer', ['null' => false, 'default' => '0', 'limit' => 9, 'precision' => 10, 'after' => 'customer_id']);
        $table->addColumn('firstname', 'string', ['null' => false, 'limit' => 32, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'customer_group_id']);
        $table->addColumn('lastname', 'string', ['null' => false, 'limit' => 32, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'firstname']);
        $table->addColumn('email', 'string', ['null' => false, 'limit' => 96, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'lastname']);
        $table->addColumn('telephone', 'string', ['null' => false, 'limit' => 32, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'email']);
        $table->addColumn('fax', 'string', ['null' => false, 'limit' => 32, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'telephone']);
        $table->addColumn('custom_field', 'text', ['null' => false, 'limit' => 65535, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'fax']);
        $table->addColumn('payment_firstname', 'string', ['null' => false, 'limit' => 32, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'custom_field']);
        $table->addColumn('payment_lastname', 'string', ['null' => false, 'limit' => 32, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'payment_firstname']);
        $table->addColumn('payment_company', 'string', ['null' => false, 'limit' => 60, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'payment_lastname']);
        $table->addColumn('payment_address_1', 'string', ['null' => false, 'limit' => 128, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'payment_company']);
        $table->addColumn('payment_address_2', 'string', ['null' => false, 'limit' => 128, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'payment_address_1']);
        $table->addColumn('payment_city', 'string', ['null' => false, 'limit' => 128, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'payment_address_2']);
        $table->addColumn('payment_postcode', 'string', ['null' => false, 'limit' => 10, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'payment_city']);
        $table->addColumn('payment_country', 'string', ['null' => false, 'limit' => 128, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'payment_postcode']);
        $table->addColumn('payment_country_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'payment_country']);
        $table->addColumn('payment_zone', 'string', ['null' => false, 'limit' => 128, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'payment_country_id']);
        $table->addColumn('payment_zone_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'payment_zone']);
        $table->addColumn('payment_address_format', 'text', ['null' => false, 'limit' => 65535, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'payment_zone_id']);
        $table->addColumn('payment_custom_field', 'text', ['null' => false, 'limit' => 65535, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'payment_address_format']);
        $table->addColumn('payment_method', 'string', ['null' => false, 'limit' => 128, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'payment_custom_field']);
        $table->addColumn('payment_code', 'string', ['null' => false, 'limit' => 128, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'payment_method']);
        $table->addColumn('shipping_firstname', 'string', ['null' => false, 'limit' => 32, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'payment_code']);
        $table->addColumn('shipping_lastname', 'string', ['null' => false, 'limit' => 32, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'shipping_firstname']);
        $table->addColumn('shipping_company', 'string', ['null' => false, 'limit' => 60, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'shipping_lastname']);
        $table->addColumn('shipping_address_1', 'string', ['null' => false, 'limit' => 128, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'shipping_company']);
        $table->addColumn('shipping_address_2', 'string', ['null' => false, 'limit' => 128, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'shipping_address_1']);
        $table->addColumn('shipping_city', 'string', ['null' => false, 'limit' => 128, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'shipping_address_2']);
        $table->addColumn('shipping_postcode', 'string', ['null' => false, 'limit' => 10, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'shipping_city']);
        $table->addColumn('shipping_country', 'string', ['null' => false, 'limit' => 128, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'shipping_postcode']);
        $table->addColumn('shipping_country_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'shipping_country']);
        $table->addColumn('shipping_zone', 'string', ['null' => false, 'limit' => 128, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'shipping_country_id']);
        $table->addColumn('shipping_zone_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'shipping_zone']);
        $table->addColumn('shipping_address_format', 'text', ['null' => false, 'limit' => 65535, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'shipping_zone_id']);
        $table->addColumn('shipping_custom_field', 'text', ['null' => false, 'limit' => 65535, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'shipping_address_format']);
        $table->addColumn('shipping_method', 'string', ['null' => false, 'limit' => 128, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'shipping_custom_field']);
        $table->addColumn('shipping_code', 'string', ['null' => false, 'limit' => 128, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'shipping_method']);
        $table->addColumn('comment', 'text', ['null' => false, 'limit' => 65535, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'shipping_code']);
        $table->addColumn('total', 'decimal', ['null' => false, 'default' => '0.0000', 'precision' => 15, 'scale' => 4, 'after' => 'comment']);
        $table->addColumn('order_status_id', 'integer', ['null' => false, 'default' => '0', 'limit' => 9, 'precision' => 10, 'after' => 'total']);
        $table->addColumn('affiliate_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'order_status_id']);
        $table->addColumn('commission', 'decimal', ['null' => false, 'precision' => 15, 'scale' => 4, 'after' => 'affiliate_id']);
        $table->addColumn('marketing_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'commission']);
        $table->addColumn('tracking', 'string', ['null' => false, 'limit' => 64, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'marketing_id']);
        $table->addColumn('language_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'tracking']);
        $table->addColumn('currency_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'language_id']);
        $table->addColumn('currency_code', 'string', ['null' => false, 'limit' => 3, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'currency_id']);
        $table->addColumn('currency_value', 'decimal', ['null' => false, 'default' => '1.00000000', 'precision' => 15, 'scale' => 8, 'after' => 'currency_code']);
        $table->addColumn('ip', 'string', ['null' => false, 'limit' => 40, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'currency_value']);
        $table->addColumn('forwarded_ip', 'string', ['null' => false, 'limit' => 40, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'ip']);
        $table->addColumn('user_agent', 'string', ['null' => false, 'limit' => 255, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'forwarded_ip']);
        $table->addColumn('accept_language', 'string', ['null' => false, 'limit' => 255, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'user_agent']);
        $table->addColumn('date_added', 'datetime', ['null' => false, 'after' => 'accept_language']);
        $table->addColumn('date_modified', 'datetime', ['null' => false, 'after' => 'date_added']);
        $table->save();

        $table = $this->table("oc_order_history", ['id' => false, 'primary_key' => ["order_history_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('order_history_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'identity' => 'enable']);
        $table->addColumn('order_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'order_history_id']);
        $table->addColumn('order_status_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'order_id']);
        $table->addColumn('notify', 'boolean', ['null' => false, 'default' => '0', 'limit' => 1, 'precision' => 3, 'after' => 'order_status_id']);
        $table->addColumn('comment', 'text', ['null' => false, 'limit' => 65535, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'notify']);
        $table->addColumn('date_added', 'datetime', ['null' => false, 'after' => 'comment']);
        $table->save();

        $table = $this->table("oc_order_option", ['id' => false, 'primary_key' => ["order_option_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('order_option_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'identity' => 'enable']);
        $table->addColumn('order_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'order_option_id']);
        $table->addColumn('order_product_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'order_id']);
        $table->addColumn('product_option_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'order_product_id']);
        $table->addColumn('product_option_value_id', 'integer', ['null' => false, 'default' => '0', 'limit' => 9, 'precision' => 10, 'after' => 'product_option_id']);
        $table->addColumn('name', 'string', ['null' => false, 'limit' => 255, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'product_option_value_id']);
        $table->addColumn('value', 'text', ['null' => false, 'limit' => 65535, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'name']);
        $table->addColumn('type', 'string', ['null' => false, 'limit' => 32, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'value']);
        $table->save();

        $table = $this->table("oc_order_product", ['id' => false, 'primary_key' => ["order_product_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('order_product_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'identity' => 'enable']);
        $table->addColumn('order_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'order_product_id']);
        $table->addColumn('product_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'order_id']);
        $table->addColumn('name', 'string', ['null' => false, 'limit' => 255, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'product_id']);
        $table->addColumn('model', 'string', ['null' => false, 'limit' => 64, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'name']);
        $table->addColumn('quantity', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'model']);
        $table->addColumn('price', 'decimal', ['null' => false, 'default' => '0.0000', 'precision' => 15, 'scale' => 4, 'after' => 'quantity']);
        $table->addColumn('total', 'decimal', ['null' => false, 'default' => '0.0000', 'precision' => 15, 'scale' => 4, 'after' => 'price']);
        $table->addColumn('tax', 'decimal', ['null' => false, 'default' => '0.0000', 'precision' => 15, 'scale' => 4, 'after' => 'total']);
        $table->addColumn('reward', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'tax']);
        $table->save();
        if($this->table('oc_order_product')->hasIndex('order_id')) {
            $this->table("oc_order_product")->removeIndexByName('order_id');
        }
        $this->table("oc_order_product")->addIndex(['order_id'], ['name' => "order_id", 'unique' => false])->save();

        $table = $this->table("oc_order_recurring", ['id' => false, 'primary_key' => ["order_recurring_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('order_recurring_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'identity' => 'enable']);
        $table->addColumn('order_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'order_recurring_id']);
        $table->addColumn('reference', 'string', ['null' => false, 'limit' => 255, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'order_id']);
        $table->addColumn('product_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'reference']);
        $table->addColumn('product_name', 'string', ['null' => false, 'limit' => 255, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'product_id']);
        $table->addColumn('product_quantity', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'product_name']);
        $table->addColumn('recurring_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'product_quantity']);
        $table->addColumn('recurring_name', 'string', ['null' => false, 'limit' => 255, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'recurring_id']);
        $table->addColumn('recurring_description', 'string', ['null' => false, 'limit' => 255, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'recurring_name']);
        $table->addColumn('recurring_frequency', 'string', ['null' => false, 'limit' => 25, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'recurring_description']);
        $table->addColumn('recurring_cycle', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_SMALL, 'precision' => 5, 'after' => 'recurring_frequency']);
        $table->addColumn('recurring_duration', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_SMALL, 'precision' => 5, 'after' => 'recurring_cycle']);
        $table->addColumn('recurring_price', 'decimal', ['null' => false, 'precision' => 10, 'scale' => 4, 'after' => 'recurring_duration']);
        $table->addColumn('trial', 'boolean', ['null' => false, 'limit' => 1, 'precision' => 3, 'after' => 'recurring_price']);
        $table->addColumn('trial_frequency', 'string', ['null' => false, 'limit' => 25, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'trial']);
        $table->addColumn('trial_cycle', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_SMALL, 'precision' => 5, 'after' => 'trial_frequency']);
        $table->addColumn('trial_duration', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_SMALL, 'precision' => 5, 'after' => 'trial_cycle']);
        $table->addColumn('trial_price', 'decimal', ['null' => false, 'precision' => 10, 'scale' => 4, 'after' => 'trial_duration']);
        $table->addColumn('status', 'integer', ['null' => false, 'limit' => 1, 'precision' => 3, 'after' => 'trial_price']);
        $table->addColumn('date_added', 'datetime', ['null' => false, 'after' => 'status']);
        $table->save();

        $table = $this->table("oc_order_recurring_transaction", ['id' => false, 'primary_key' => ["order_recurring_transaction_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('order_recurring_transaction_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'identity' => 'enable']);
        $table->addColumn('order_recurring_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'order_recurring_transaction_id']);
        $table->addColumn('reference', 'string', ['null' => false, 'limit' => 255, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'order_recurring_id']);
        $table->addColumn('type', 'string', ['null' => false, 'limit' => 255, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'reference']);
        $table->addColumn('amount', 'decimal', ['null' => false, 'precision' => 10, 'scale' => 4, 'after' => 'type']);
        $table->addColumn('date_added', 'datetime', ['null' => false, 'after' => 'amount']);
        $table->save();

        $table = $this->table("oc_order_shipment", ['id' => false, 'primary_key' => ["order_shipment_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('order_shipment_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'identity' => 'enable']);
        $table->addColumn('order_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'order_shipment_id']);
        $table->addColumn('date_added', 'datetime', ['null' => false, 'after' => 'order_id']);
        $table->addColumn('shipping_courier_id', 'string', ['null' => false, 'default' => '', 'limit' => 255, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'date_added']);
        $table->addColumn('tracking_number', 'string', ['null' => false, 'default' => '', 'limit' => 255, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'shipping_courier_id']);
        $table->save();

        $table = $this->table("oc_order_status", ['id' => false, 'primary_key' => ["order_status_id", "language_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('order_status_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'identity' => 'enable']);
        $table->addColumn('language_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'order_status_id']);
        $table->addColumn('name', 'string', ['null' => false, 'limit' => 32, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'language_id']);
        $table->save();

        $table = $this->table("oc_order_total", ['id' => false, 'primary_key' => ["order_total_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('order_total_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'identity' => 'enable']);
        $table->addColumn('order_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'order_total_id']);
        $table->addColumn('code', 'string', ['null' => false, 'limit' => 32, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'order_id']);
        $table->addColumn('title', 'string', ['null' => false, 'limit' => 255, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'code']);
        $table->addColumn('value', 'decimal', ['null' => false, 'default' => '0.0000', 'precision' => 15, 'scale' => 4, 'after' => 'title']);
        $table->addColumn('sort_order', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'value']);
        $table->save();
        if($this->table('oc_order_total')->hasIndex('order_id')) {
            $this->table("oc_order_total")->removeIndexByName('order_id');
        }
        $this->table("oc_order_total")->addIndex(['order_id'], ['name' => "order_id", 'unique' => false])->save();

        $table = $this->table("oc_order_voucher", ['id' => false, 'primary_key' => ["order_voucher_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('order_voucher_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'identity' => 'enable']);
        $table->addColumn('order_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'order_voucher_id']);
        $table->addColumn('voucher_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'order_id']);
        $table->addColumn('description', 'string', ['null' => false, 'limit' => 255, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'voucher_id']);
        $table->addColumn('code', 'string', ['null' => false, 'limit' => 10, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'description']);
        $table->addColumn('from_name', 'string', ['null' => false, 'limit' => 64, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'code']);
        $table->addColumn('from_email', 'string', ['null' => false, 'limit' => 96, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'from_name']);
        $table->addColumn('to_name', 'string', ['null' => false, 'limit' => 64, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'from_email']);
        $table->addColumn('to_email', 'string', ['null' => false, 'limit' => 96, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'to_name']);
        $table->addColumn('voucher_theme_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'to_email']);
        $table->addColumn('message', 'text', ['null' => false, 'limit' => 65535, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'voucher_theme_id']);
        $table->addColumn('amount', 'decimal', ['null' => false, 'precision' => 15, 'scale' => 4, 'after' => 'message']);
        $table->save();

        $table = $this->table("oc_product", ['id' => false, 'primary_key' => ["product_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('product_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'identity' => 'enable']);
        $table->addColumn('model', 'string', ['null' => false, 'limit' => 64, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'product_id']);
        $table->addColumn('sku', 'string', ['null' => false, 'limit' => 64, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'model']);
        $table->addColumn('upc', 'string', ['null' => false, 'limit' => 12, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'sku']);
        $table->addColumn('ean', 'string', ['null' => false, 'limit' => 14, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'upc']);
        $table->addColumn('jan', 'string', ['null' => false, 'limit' => 13, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'ean']);
        $table->addColumn('isbn', 'string', ['null' => false, 'limit' => 17, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'jan']);
        $table->addColumn('mpn', 'string', ['null' => false, 'limit' => 64, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'isbn']);
        $table->addColumn('location', 'string', ['null' => false, 'limit' => 128, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'mpn']);
        $table->addColumn('quantity', 'integer', ['null' => false, 'default' => '0', 'limit' => 9, 'precision' => 10, 'after' => 'location']);
        $table->addColumn('stock_status_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'quantity']);
        $table->addColumn('image', 'string', ['null' => true, 'limit' => 255, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'stock_status_id']);
        $table->addColumn('manufacturer_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'image']);
        $table->addColumn('shipping', 'boolean', ['null' => false, 'default' => '1', 'limit' => 1, 'precision' => 3, 'after' => 'manufacturer_id']);
        $table->addColumn('price', 'decimal', ['null' => false, 'default' => '0.0000', 'precision' => 15, 'scale' => 4, 'after' => 'shipping']);
        $table->addColumn('points', 'integer', ['null' => false, 'default' => '0', 'limit' => 9, 'precision' => 10, 'after' => 'price']);
        $table->addColumn('tax_class_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'points']);
        $table->addColumn('date_available', 'date', ['null' => false, 'default' => '2001-01-01', 'after' => 'tax_class_id']);
        $table->addColumn('weight', 'decimal', ['null' => false, 'default' => '0.00000000', 'precision' => 15, 'scale' => 8, 'after' => 'date_available']);
        $table->addColumn('weight_class_id', 'integer', ['null' => false, 'default' => '0', 'limit' => 9, 'precision' => 10, 'after' => 'weight']);
        $table->addColumn('length', 'decimal', ['null' => false, 'default' => '0.00000000', 'precision' => 15, 'scale' => 8, 'after' => 'weight_class_id']);
        $table->addColumn('width', 'decimal', ['null' => false, 'default' => '0.00000000', 'precision' => 15, 'scale' => 8, 'after' => 'length']);
        $table->addColumn('height', 'decimal', ['null' => false, 'default' => '0.00000000', 'precision' => 15, 'scale' => 8, 'after' => 'width']);
        $table->addColumn('length_class_id', 'integer', ['null' => false, 'default' => '0', 'limit' => 9, 'precision' => 10, 'after' => 'height']);
        $table->addColumn('subtract', 'boolean', ['null' => false, 'default' => '1', 'limit' => 1, 'precision' => 3, 'after' => 'length_class_id']);
        $table->addColumn('minimum', 'integer', ['null' => false, 'default' => '1', 'limit' => 9, 'precision' => 10, 'after' => 'subtract']);
        $table->addColumn('sort_order', 'integer', ['null' => false, 'default' => '0', 'limit' => 9, 'precision' => 10, 'after' => 'minimum']);
        $table->addColumn('status', 'boolean', ['null' => false, 'default' => '0', 'limit' => 1, 'precision' => 3, 'after' => 'sort_order']);
        $table->addColumn('viewed', 'integer', ['null' => false, 'default' => '0', 'limit' => 9, 'precision' => 10, 'after' => 'status']);
        $table->addColumn('date_added', 'datetime', ['null' => false, 'after' => 'viewed']);
        $table->addColumn('date_modified', 'datetime', ['null' => false, 'after' => 'date_added']);
        $table->save();

        $table = $this->table("oc_product_attribute", ['id' => false, 'primary_key' => ["product_id", "attribute_id", "language_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('product_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10]);
        $table->addColumn('attribute_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'product_id']);
        $table->addColumn('language_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'attribute_id']);
        $table->addColumn('text', 'text', ['null' => false, 'limit' => 65535, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'language_id']);
        $table->save();

        $table = $this->table("oc_product_description", ['id' => false, 'primary_key' => ["product_id", "language_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('product_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10]);
        $table->addColumn('language_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'product_id']);
        $table->addColumn('name', 'string', ['null' => false, 'limit' => 255, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'language_id']);
        $table->addColumn('description', 'text', ['null' => false, 'limit' => 65535, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'name']);
        $table->addColumn('tag', 'text', ['null' => false, 'limit' => 65535, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'description']);
        $table->addColumn('meta_title', 'string', ['null' => false, 'limit' => 255, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'tag']);
        $table->addColumn('meta_description', 'string', ['null' => false, 'limit' => 255, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'meta_title']);
        $table->addColumn('meta_keyword', 'string', ['null' => false, 'limit' => 255, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'meta_description']);
        $table->save();
        if($this->table('oc_product_description')->hasIndex('name')) {
            $this->table("oc_product_description")->removeIndexByName('name');
        }
        $this->table("oc_product_description")->addIndex(['name'], ['name' => "name", 'unique' => false])->save();

        $table = $this->table("oc_product_discount", ['id' => false, 'primary_key' => ["product_discount_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('product_discount_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'identity' => 'enable']);
        $table->addColumn('product_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'product_discount_id']);
        $table->addColumn('customer_group_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'product_id']);
        $table->addColumn('quantity', 'integer', ['null' => false, 'default' => '0', 'limit' => 9, 'precision' => 10, 'after' => 'customer_group_id']);
        $table->addColumn('priority', 'integer', ['null' => false, 'default' => '1', 'limit' => 9, 'precision' => 10, 'after' => 'quantity']);
        $table->addColumn('price', 'decimal', ['null' => false, 'default' => '0.0000', 'precision' => 15, 'scale' => 4, 'after' => 'priority']);
        $table->addColumn('date_start', 'date', ['null' => false, 'default' => '2001-01-01', 'after' => 'price']);
        $table->addColumn('date_end', 'date', ['null' => false, 'default' => '2001-01-01', 'after' => 'date_start']);
        $table->save();

        if($this->table('oc_product_discount')->hasIndex('product_id')) {
            $this->table("oc_product_discount")->removeIndexByName('product_id');
        }
        $this->table("oc_product_discount")->addIndex(['product_id'], ['name' => "product_id", 'unique' => false])->save();

        $table = $this->table("oc_product_filter", ['id' => false, 'primary_key' => ["product_id", "filter_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('product_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10]);
        $table->addColumn('filter_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'product_id']);
        $table->save();

        $table = $this->table("oc_product_image", ['id' => false, 'primary_key' => ["product_image_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('product_image_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'identity' => 'enable']);
        $table->addColumn('product_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'product_image_id']);
        $table->addColumn('image', 'string', ['null' => true, 'limit' => 255, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'product_id']);
        $table->addColumn('sort_order', 'integer', ['null' => false, 'default' => '0', 'limit' => 9, 'precision' => 10, 'after' => 'image']);
        $table->save();

        if($this->table('oc_product_image')->hasIndex('product_id')) {
            $this->table("oc_product_image")->removeIndexByName('product_id');
        }
        $this->table("oc_product_image")->addIndex(['product_id'], ['name' => "product_id", 'unique' => false])->save();

        $table = $this->table("oc_product_option", ['id' => false, 'primary_key' => ["product_option_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('product_option_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'identity' => 'enable']);
        $table->addColumn('product_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'product_option_id']);
        $table->addColumn('option_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'product_id']);
        $table->addColumn('value', 'text', ['null' => false, 'limit' => 65535, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'option_id']);
        $table->addColumn('required', 'boolean', ['null' => false, 'limit' => 1, 'precision' => 3, 'after' => 'value']);
        $table->save();

        $table = $this->table("oc_product_option_value", ['id' => false, 'primary_key' => ["product_option_value_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('product_option_value_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'identity' => 'enable']);
        $table->addColumn('product_option_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'product_option_value_id']);
        $table->addColumn('product_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'product_option_id']);
        $table->addColumn('option_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'product_id']);
        $table->addColumn('option_value_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'option_id']);
        $table->addColumn('quantity', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'option_value_id']);
        $table->addColumn('subtract', 'boolean', ['null' => false, 'limit' => 1, 'precision' => 3, 'after' => 'quantity']);
        $table->addColumn('price', 'decimal', ['null' => false, 'precision' => 15, 'scale' => 4, 'after' => 'subtract']);
        $table->addColumn('price_prefix', 'string', ['null' => false, 'limit' => 1, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'price']);
        $table->addColumn('points', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'price_prefix']);
        $table->addColumn('points_prefix', 'string', ['null' => false, 'limit' => 1, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'points']);
        $table->addColumn('weight', 'decimal', ['null' => false, 'precision' => 15, 'scale' => 8, 'after' => 'points_prefix']);
        $table->addColumn('weight_prefix', 'string', ['null' => false, 'limit' => 1, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'weight']);
        $table->save();

        $table = $this->table("oc_product_recurring", ['id' => false, 'primary_key' => ["product_id", "recurring_id", "customer_group_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('product_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10]);
        $table->addColumn('recurring_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'product_id']);
        $table->addColumn('customer_group_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'recurring_id']);
        $table->save();

        $table = $this->table("oc_product_related", ['id' => false, 'primary_key' => ["product_id", "related_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('product_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10]);
        $table->addColumn('related_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'product_id']);
        $table->save();

        $table = $this->table("oc_product_reward", ['id' => false, 'primary_key' => ["product_reward_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('product_reward_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'identity' => 'enable']);
        $table->addColumn('product_id', 'integer', ['null' => false, 'default' => '0', 'limit' => 9, 'precision' => 10, 'after' => 'product_reward_id']);
        $table->addColumn('customer_group_id', 'integer', ['null' => false, 'default' => '0', 'limit' => 9, 'precision' => 10, 'after' => 'product_id']);
        $table->addColumn('points', 'integer', ['null' => false, 'default' => '0', 'limit' => 9, 'precision' => 10, 'after' => 'customer_group_id']);
        $table->save();

        $table = $this->table("oc_product_special", ['id' => false, 'primary_key' => ["product_special_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('product_special_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'identity' => 'enable']);
        $table->addColumn('product_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'product_special_id']);
        $table->addColumn('customer_group_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'product_id']);
        $table->addColumn('priority', 'integer', ['null' => false, 'default' => '1', 'limit' => 9, 'precision' => 10, 'after' => 'customer_group_id']);
        $table->addColumn('price', 'decimal', ['null' => false, 'default' => '0.0000', 'precision' => 15, 'scale' => 4, 'after' => 'priority']);
        $table->addColumn('date_start', 'date', ['null' => false, 'default' => '2001-01-01', 'after' => 'price']);
        $table->addColumn('date_end', 'date', ['null' => false, 'default' => '2001-01-01', 'after' => 'date_start']);
        $table->save();

        if($this->table('oc_product_special')->hasIndex('product_id')) {
            $this->table("oc_product_special")->removeIndexByName('product_id');
        }
        $this->table("oc_product_special")->addIndex(['product_id'], ['name' => "product_id", 'unique' => false])->save();

        $table = $this->table("oc_product_to_category", ['id' => false, 'primary_key' => ["product_id", "category_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('product_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10]);
        $table->addColumn('category_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'product_id']);
        $table->save();

        if($this->table('oc_product_to_category')->hasIndex('category_id')) {
            $this->table("oc_product_to_category")->removeIndexByName('category_id');
        }
        $this->table("oc_product_to_category")->addIndex(['category_id'], ['name' => "category_id", 'unique' => false])->save();
        $table = $this->table("oc_product_to_download", ['id' => false, 'primary_key' => ["product_id", "download_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('product_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10]);
        $table->addColumn('download_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'product_id']);
        $table->save();

        $table = $this->table("oc_product_to_layout", ['id' => false, 'primary_key' => ["product_id", "store_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('product_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10]);
        $table->addColumn('store_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'product_id']);
        $table->addColumn('layout_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'store_id']);
        $table->save();

        $table = $this->table("oc_product_to_store", ['id' => false, 'primary_key' => ["product_id", "store_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('product_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10]);
        $table->addColumn('store_id', 'integer', ['null' => false, 'default' => '0', 'limit' => 9, 'precision' => 10, 'after' => 'product_id']);
        $table->save();

        $table = $this->table("oc_recurring", ['id' => false, 'primary_key' => ["recurring_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('recurring_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'identity' => 'enable']);
        $table->addColumn('price', 'decimal', ['null' => false, 'precision' => 10, 'scale' => 4, 'after' => 'recurring_id']);
        $table->addColumn('frequency', 'enum', ['null' => false, 'limit' => 10, 'values' => ['day','week','semi_month','month','year'], 'after' => 'price']);
        $table->addColumn('duration', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'signed' => false, 'after' => 'frequency']);
        $table->addColumn('cycle', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'signed' => false, 'after' => 'duration']);
        $table->addColumn('trial_status', 'integer', ['null' => false, 'limit' => 1, 'precision' => 3, 'after' => 'cycle']);
        $table->addColumn('trial_price', 'decimal', ['null' => false, 'precision' => 10, 'scale' => 4, 'after' => 'trial_status']);
        $table->addColumn('trial_frequency', 'enum', ['null' => false, 'limit' => 10, 'values' => ['day','week','semi_month','month','year'], 'after' => 'trial_price']);
        $table->addColumn('trial_duration', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'signed' => false, 'after' => 'trial_frequency']);
        $table->addColumn('trial_cycle', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'signed' => false, 'after' => 'trial_duration']);
        $table->addColumn('status', 'integer', ['null' => false, 'limit' => 1, 'precision' => 3, 'after' => 'trial_cycle']);
        $table->addColumn('sort_order', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'status']);
        $table->save();

        $table = $this->table("oc_recurring_description", ['id' => false, 'primary_key' => ["recurring_id", "language_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('recurring_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10]);
        $table->addColumn('language_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'recurring_id']);
        $table->addColumn('name', 'string', ['null' => false, 'limit' => 255, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'language_id']);
        $table->save();

        $table = $this->table("oc_return", ['id' => false, 'primary_key' => ["return_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('return_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'identity' => 'enable']);
        $table->addColumn('order_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'return_id']);
        $table->addColumn('product_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'order_id']);
        $table->addColumn('customer_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'product_id']);
        $table->addColumn('firstname', 'string', ['null' => false, 'limit' => 32, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'customer_id']);
        $table->addColumn('lastname', 'string', ['null' => false, 'limit' => 32, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'firstname']);
        $table->addColumn('email', 'string', ['null' => false, 'limit' => 96, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'lastname']);
        $table->addColumn('telephone', 'string', ['null' => false, 'limit' => 32, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'email']);
        $table->addColumn('product', 'string', ['null' => false, 'limit' => 255, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'telephone']);
        $table->addColumn('model', 'string', ['null' => false, 'limit' => 64, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'product']);
        $table->addColumn('quantity', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'model']);
        $table->addColumn('opened', 'boolean', ['null' => false, 'limit' => 1, 'precision' => 3, 'after' => 'quantity']);
        $table->addColumn('return_reason_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'opened']);
        $table->addColumn('return_action_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'return_reason_id']);
        $table->addColumn('return_status_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'return_action_id']);
        $table->addColumn('comment', 'text', ['null' => true, 'limit' => 65535, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'return_status_id']);
        $table->addColumn('date_ordered', 'date', ['null' => false, 'default' => '2001-01-01', 'after' => 'comment']);
        $table->addColumn('date_added', 'datetime', ['null' => false, 'after' => 'date_ordered']);
        $table->addColumn('date_modified', 'datetime', ['null' => false, 'after' => 'date_added']);
        $table->save();

        $table = $this->table("oc_return_action", ['id' => false, 'primary_key' => ["return_action_id", "language_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('return_action_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'identity' => 'enable']);
        $table->addColumn('language_id', 'integer', ['null' => false, 'default' => '0', 'limit' => 9, 'precision' => 10, 'after' => 'return_action_id']);
        $table->addColumn('name', 'string', ['null' => false, 'limit' => 64, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'language_id']);
        $table->save();

        $table = $this->table("oc_return_history", ['id' => false, 'primary_key' => ["return_history_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('return_history_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'identity' => 'enable']);
        $table->addColumn('return_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'return_history_id']);
        $table->addColumn('return_status_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'return_id']);
        $table->addColumn('notify', 'boolean', ['null' => false, 'limit' => 1, 'precision' => 3, 'after' => 'return_status_id']);
        $table->addColumn('comment', 'text', ['null' => false, 'limit' => 65535, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'notify']);
        $table->addColumn('date_added', 'datetime', ['null' => false, 'after' => 'comment']);
        $table->save();

        $table = $this->table("oc_return_reason", ['id' => false, 'primary_key' => ["return_reason_id", "language_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('return_reason_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'identity' => 'enable']);
        $table->addColumn('language_id', 'integer', ['null' => false, 'default' => '0', 'limit' => 9, 'precision' => 10, 'after' => 'return_reason_id']);
        $table->addColumn('name', 'string', ['null' => false, 'limit' => 128, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'language_id']);
        $table->save();

        $table = $this->table("oc_return_status", ['id' => false, 'primary_key' => ["return_status_id", "language_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('return_status_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'identity' => 'enable']);
        $table->addColumn('language_id', 'integer', ['null' => false, 'default' => '0', 'limit' => 9, 'precision' => 10, 'after' => 'return_status_id']);
        $table->addColumn('name', 'string', ['null' => false, 'limit' => 32, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'language_id']);
        $table->save();

        $table = $this->table("oc_review", ['id' => false, 'primary_key' => ["review_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('review_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'identity' => 'enable']);
        $table->addColumn('product_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'review_id']);
        $table->addColumn('customer_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'product_id']);
        $table->addColumn('author', 'string', ['null' => false, 'limit' => 64, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'customer_id']);
        $table->addColumn('text', 'text', ['null' => false, 'limit' => 65535, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'author']);
        $table->addColumn('rating', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'text']);
        $table->addColumn('status', 'boolean', ['null' => false, 'default' => '0', 'limit' => 1, 'precision' => 3, 'after' => 'rating']);
        $table->addColumn('date_added', 'datetime', ['null' => false, 'after' => 'status']);
        $table->addColumn('date_modified', 'datetime', ['null' => false, 'after' => 'date_added']);
        $table->save();

        if($this->table('oc_review')->hasIndex('product_id')) {
            $this->table("oc_review")->removeIndexByName('product_id');
        }
        $this->table("oc_review")->addIndex(['product_id'], ['name' => "product_id", 'unique' => false])->save();

        $table = $this->table("oc_seo_url", ['id' => false, 'primary_key' => ["seo_url_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('seo_url_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'identity' => 'enable']);
        $table->addColumn('store_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'seo_url_id']);
        $table->addColumn('language_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'store_id']);
        $table->addColumn('query', 'string', ['null' => false, 'limit' => 255, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'language_id']);
        $table->addColumn('keyword', 'string', ['null' => false, 'limit' => 255, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'query']);
        $table->save();

        if($this->table('oc_seo_url')->hasIndex('query')) {
            $this->table("oc_seo_url")->removeIndexByName('query');
        }
        $this->table("oc_seo_url")->addIndex(['query'], ['name' => "query", 'unique' => false])->save();

        if($this->table('oc_seo_url')->hasIndex('keyword')) {
            $this->table("oc_seo_url")->removeIndexByName('keyword');
        }
        $this->table("oc_seo_url")->addIndex(['keyword'], ['name' => "keyword", 'unique' => false])->save();

        $table = $this->table("oc_session", ['id' => false, 'primary_key' => ["session_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('session_id', 'string', ['null' => false, 'limit' => 32, 'collation' => "utf8_general_ci", 'encoding' => "utf8"]);
        $table->addColumn('data', 'text', ['null' => false, 'limit' => 65535, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'session_id']);
        $table->addColumn('expire', 'datetime', ['null' => false, 'after' => 'data']);
        $table->save();

        $table = $this->table("oc_setting", ['id' => false, 'primary_key' => ["setting_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('setting_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'identity' => 'enable']);
        $table->addColumn('store_id', 'integer', ['null' => false, 'default' => '0', 'limit' => 9, 'precision' => 10, 'after' => 'setting_id']);
        $table->addColumn('code', 'string', ['null' => false, 'limit' => 128, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'store_id']);
        $table->addColumn('key', 'string', ['null' => false, 'limit' => 128, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'code']);
        $table->addColumn('value', 'text', ['null' => false, 'limit' => 65535, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'key']);
        $table->addColumn('serialized', 'boolean', ['null' => false, 'limit' => 1, 'precision' => 3, 'after' => 'value']);
        $table->save();

        $table = $this->table("oc_shipping_courier", ['id' => false, 'primary_key' => ["shipping_courier_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('shipping_courier_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10]);
        $table->addColumn('shipping_courier_code', 'string', ['null' => false, 'default' => '', 'limit' => 255, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'shipping_courier_id']);
        $table->addColumn('shipping_courier_name', 'string', ['null' => false, 'default' => '', 'limit' => 255, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'shipping_courier_code']);
        $table->save();

        $table = $this->table("oc_statistics", ['id' => false, 'primary_key' => ["statistics_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('statistics_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'identity' => 'enable']);
        $table->addColumn('code', 'string', ['null' => false, 'limit' => 64, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'statistics_id']);
        $table->addColumn('value', 'decimal', ['null' => false, 'precision' => 15, 'scale' => 4, 'after' => 'code']);
        $table->save();

        $table = $this->table("oc_stock_status", ['id' => false, 'primary_key' => ["stock_status_id", "language_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('stock_status_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'identity' => 'enable']);
        $table->addColumn('language_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'stock_status_id']);
        $table->addColumn('name', 'string', ['null' => false, 'limit' => 32, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'language_id']);
        $table->save();

        $table = $this->table("oc_store", ['id' => false, 'primary_key' => ["store_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('store_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'identity' => 'enable']);
        $table->addColumn('name', 'string', ['null' => false, 'limit' => 64, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'store_id']);
        $table->addColumn('url', 'string', ['null' => false, 'limit' => 255, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'name']);
        $table->addColumn('ssl', 'string', ['null' => false, 'limit' => 255, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'url']);
        $table->save();

        $table = $this->table("oc_tax_class", ['id' => false, 'primary_key' => ["tax_class_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('tax_class_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'identity' => 'enable']);
        $table->addColumn('title', 'string', ['null' => false, 'limit' => 32, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'tax_class_id']);
        $table->addColumn('description', 'string', ['null' => false, 'limit' => 255, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'title']);
        $table->addColumn('date_added', 'datetime', ['null' => false, 'after' => 'description']);
        $table->addColumn('date_modified', 'datetime', ['null' => false, 'after' => 'date_added']);
        $table->save();

        $table = $this->table("oc_tax_rate", ['id' => false, 'primary_key' => ["tax_rate_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('tax_rate_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'identity' => 'enable']);
        $table->addColumn('geo_zone_id', 'integer', ['null' => false, 'default' => '0', 'limit' => 9, 'precision' => 10, 'after' => 'tax_rate_id']);
        $table->addColumn('name', 'string', ['null' => false, 'limit' => 32, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'geo_zone_id']);
        $table->addColumn('rate', 'decimal', ['null' => false, 'default' => '0.0000', 'precision' => 15, 'scale' => 4, 'after' => 'name']);
        $table->addColumn('type', 'char', ['null' => false, 'limit' => 1, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'rate']);
        $table->addColumn('date_added', 'datetime', ['null' => false, 'after' => 'type']);
        $table->addColumn('date_modified', 'datetime', ['null' => false, 'after' => 'date_added']);
        $table->save();

        $table = $this->table("oc_tax_rate_to_customer_group", ['id' => false, 'primary_key' => ["tax_rate_id", "customer_group_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('tax_rate_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10]);
        $table->addColumn('customer_group_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'tax_rate_id']);
        $table->save();

        $table = $this->table("oc_tax_rule", ['id' => false, 'primary_key' => ["tax_rule_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('tax_rule_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'identity' => 'enable']);
        $table->addColumn('tax_class_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'tax_rule_id']);
        $table->addColumn('tax_rate_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'tax_class_id']);
        $table->addColumn('based', 'string', ['null' => false, 'limit' => 10, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'tax_rate_id']);
        $table->addColumn('priority', 'integer', ['null' => false, 'default' => '1', 'limit' => 9, 'precision' => 10, 'after' => 'based']);
        $table->save();

        $table = $this->table("oc_theme", ['id' => false, 'primary_key' => ["theme_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('theme_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'identity' => 'enable']);
        $table->addColumn('store_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'theme_id']);
        $table->addColumn('theme', 'string', ['null' => false, 'limit' => 64, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'store_id']);
        $table->addColumn('route', 'string', ['null' => false, 'limit' => 64, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'theme']);
        $table->addColumn('code', 'text', ['null' => false, 'limit' => MysqlAdapter::TEXT_MEDIUM, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'route']);
        $table->addColumn('date_added', 'datetime', ['null' => false, 'after' => 'code']);
        $table->save();

        $table = $this->table("oc_translation", ['id' => false, 'primary_key' => ["translation_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('translation_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'identity' => 'enable']);
        $table->addColumn('store_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'translation_id']);
        $table->addColumn('language_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'store_id']);
        $table->addColumn('route', 'string', ['null' => false, 'limit' => 64, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'language_id']);
        $table->addColumn('key', 'string', ['null' => false, 'limit' => 64, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'route']);
        $table->addColumn('value', 'text', ['null' => false, 'limit' => 65535, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'key']);
        $table->addColumn('date_added', 'datetime', ['null' => false, 'after' => 'value']);
        $table->save();

        $table = $this->table("oc_upload", ['id' => false, 'primary_key' => ["upload_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('upload_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'identity' => 'enable']);
        $table->addColumn('name', 'string', ['null' => false, 'limit' => 255, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'upload_id']);
        $table->addColumn('filename', 'string', ['null' => false, 'limit' => 255, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'name']);
        $table->addColumn('code', 'string', ['null' => false, 'limit' => 255, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'filename']);
        $table->addColumn('date_added', 'datetime', ['null' => false, 'after' => 'code']);
        $table->save();

        $table = $this->table("oc_user", ['id' => false, 'primary_key' => ["user_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('user_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'identity' => 'enable']);
        $table->addColumn('user_group_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'user_id']);
        $table->addColumn('username', 'string', ['null' => false, 'limit' => 20, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'user_group_id']);
        $table->addColumn('password', 'string', ['null' => false, 'limit' => 255, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'username']);
        $table->addColumn('salt', 'string', ['null' => false, 'limit' => 9, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'password']);
        $table->addColumn('firstname', 'string', ['null' => false, 'limit' => 32, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'salt']);
        $table->addColumn('lastname', 'string', ['null' => false, 'limit' => 32, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'firstname']);
        $table->addColumn('email', 'string', ['null' => false, 'limit' => 96, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'lastname']);
        $table->addColumn('image', 'string', ['null' => false, 'limit' => 255, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'email']);
        $table->addColumn('code', 'string', ['null' => false, 'limit' => 40, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'image']);
        $table->addColumn('ip', 'string', ['null' => false, 'limit' => 40, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'code']);
        $table->addColumn('status', 'boolean', ['null' => false, 'limit' => 1, 'precision' => 3, 'after' => 'ip']);
        $table->addColumn('date_added', 'datetime', ['null' => false, 'after' => 'status']);
        $table->save();

        $table = $this->table("oc_user_group", ['id' => false, 'primary_key' => ["user_group_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('user_group_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'identity' => 'enable']);
        $table->addColumn('name', 'string', ['null' => false, 'limit' => 64, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'user_group_id']);
        $table->addColumn('permission', 'text', ['null' => false, 'limit' => 65535, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'name']);
        $table->save();

        $table = $this->table("oc_voucher", ['id' => false, 'primary_key' => ["voucher_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('voucher_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'identity' => 'enable']);
        $table->addColumn('order_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'voucher_id']);
        $table->addColumn('code', 'string', ['null' => false, 'limit' => 10, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'order_id']);
        $table->addColumn('from_name', 'string', ['null' => false, 'limit' => 64, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'code']);
        $table->addColumn('from_email', 'string', ['null' => false, 'limit' => 96, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'from_name']);
        $table->addColumn('to_name', 'string', ['null' => false, 'limit' => 64, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'from_email']);
        $table->addColumn('to_email', 'string', ['null' => false, 'limit' => 96, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'to_name']);
        $table->addColumn('voucher_theme_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'to_email']);
        $table->addColumn('message', 'text', ['null' => false, 'limit' => 65535, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'voucher_theme_id']);
        $table->addColumn('amount', 'decimal', ['null' => false, 'precision' => 15, 'scale' => 4, 'after' => 'message']);
        $table->addColumn('status', 'boolean', ['null' => false, 'limit' => 1, 'precision' => 3, 'after' => 'amount']);
        $table->addColumn('date_added', 'datetime', ['null' => false, 'after' => 'status']);
        $table->save();

        $table = $this->table("oc_voucher_history", ['id' => false, 'primary_key' => ["voucher_history_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('voucher_history_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'identity' => 'enable']);
        $table->addColumn('voucher_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'voucher_history_id']);
        $table->addColumn('order_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'voucher_id']);
        $table->addColumn('amount', 'decimal', ['null' => false, 'precision' => 15, 'scale' => 4, 'after' => 'order_id']);
        $table->addColumn('date_added', 'datetime', ['null' => false, 'after' => 'amount']);
        $table->save();

        $table = $this->table("oc_voucher_theme", ['id' => false, 'primary_key' => ["voucher_theme_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('voucher_theme_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'identity' => 'enable']);
        $table->addColumn('image', 'string', ['null' => false, 'limit' => 255, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'voucher_theme_id']);
        $table->save();

        $table = $this->table("oc_voucher_theme_description", ['id' => false, 'primary_key' => ["voucher_theme_id", "language_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('voucher_theme_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10]);
        $table->addColumn('language_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'voucher_theme_id']);
        $table->addColumn('name', 'string', ['null' => false, 'limit' => 32, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'language_id']);
        $table->save();

        $table = $this->table("oc_weight_class", ['id' => false, 'primary_key' => ["weight_class_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('weight_class_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'identity' => 'enable']);
        $table->addColumn('value', 'decimal', ['null' => false, 'default' => '0.00000000', 'precision' => 15, 'scale' => 8, 'after' => 'weight_class_id']);
        $table->save();

        $table = $this->table("oc_weight_class_description", ['id' => false, 'primary_key' => ["weight_class_id", "language_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('weight_class_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10]);
        $table->addColumn('language_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'weight_class_id']);
        $table->addColumn('title', 'string', ['null' => false, 'limit' => 32, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'language_id']);
        $table->addColumn('unit', 'string', ['null' => false, 'limit' => 4, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'title']);
        $table->save();

        $table = $this->table("oc_zone", ['id' => false, 'primary_key' => ["zone_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('zone_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'identity' => 'enable']);
        $table->addColumn('country_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'zone_id']);
        $table->addColumn('name', 'string', ['null' => false, 'limit' => 128, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'country_id']);
        $table->addColumn('code', 'string', ['null' => false, 'limit' => 32, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'name']);
        $table->addColumn('status', 'boolean', ['null' => false, 'default' => '1', 'limit' => 1, 'precision' => 3, 'after' => 'code']);
        $table->save();

        $table = $this->table("oc_zone_to_geo_zone", ['id' => false, 'primary_key' => ["zone_to_geo_zone_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_general_ci", 'comment' => ""]);
        $table->addColumn('zone_to_geo_zone_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'identity' => 'enable']);
        $table->addColumn('country_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'zone_to_geo_zone_id']);
        $table->addColumn('zone_id', 'integer', ['null' => false, 'default' => '0', 'limit' => 9, 'precision' => 10, 'after' => 'country_id']);
        $table->addColumn('geo_zone_id', 'integer', ['null' => false, 'limit' => 9, 'precision' => 10, 'after' => 'zone_id']);
        $table->addColumn('date_added', 'datetime', ['null' => false, 'after' => 'geo_zone_id']);
        $table->addColumn('date_modified', 'datetime', ['null' => false, 'after' => 'date_added']);
        $table->save();
    }
}
