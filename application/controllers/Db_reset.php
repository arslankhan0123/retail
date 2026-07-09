<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Db_reset extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Load database library
        $this->load->database();
    }

    public function index() {
        // Security key check to prevent accidental hits
        $secure_key = "clean_db";
        $input_key = $this->input->get('key');
        
        if ($input_key !== $secure_key) {
            header('Content-Type: text/html; charset=UTF-8');
            echo "<div style='font-family: Arial, sans-serif; max-width: 600px; margin: 50px auto; padding: 20px; border: 1px solid #ccc; border-radius: 5px; background-color: #f9f9f9;'>";
            echo "<h3 style='color: #d9534f;'>Access Denied</h3>";
            echo "<p>Please provide the correct security key in the URL query parameters to reset the database. Example:</p>";
            echo "<code style='display: block; background: #eee; padding: 10px; border-radius: 3px; font-weight: bold;'>" . site_url('db_reset?key=clean_db') . "</code>";
            echo "</div>";
            exit;
        }

        // List of tables to protect (system and config tables that shouldn't be cleared)
        $protected_tables = array(
            'ci_sessions',
            'db_users',
            'db_sitesettings',
            'db_roles',
            'db_permissions',
            'db_languages',
            'db_currency',
            'db_country',
            'db_states',
            'db_company',
            'db_timezone',
            'db_smsapi',
            'db_smstemplates',
            'db_stripe',
            'db_paypal',
            'db_twilio',
            'db_emailtemplates',
            'db_paymenttypes',
            'db_store',
            'db_bankdetails',
            'db_fivemojo',
            'db_instamojo',
            'db_package'
        );

        // Get all tables in the database
        $all_tables = $this->db->list_tables();
        
        header('Content-Type: text/html; charset=UTF-8');
        echo "<div style='font-family: Arial, sans-serif; max-width: 800px; margin: 30px auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px; box-shadow: 0 0 10px rgba(0,0,0,0.1);'>";
        echo "<h2 style='color: #337ab7;'>Database Reset Process Started</h2>";
        echo "<hr>";
        echo "<ul style='list-style-type: none; padding-left: 0; line-height: 1.6;'>";

        // Disable foreign key checks to prevent constraints violation during truncation
        $this->db->query("SET FOREIGN_KEY_CHECKS = 0;");

        $cleared_count = 0;
        foreach ($all_tables as $table) {
            if (in_array($table, $protected_tables)) {
                echo "<li><span style='color: #5cb85c; font-weight: bold;'>[PROTECTED]</span> Table: <strong>$table</strong> (Data Preserved)</li>";
            } else {
                // Truncate table
                if ($this->db->truncate($table)) {
                    echo "<li><span style='color: #0275d8; font-weight: bold;'>[CLEARED]</span> Table: <strong>$table</strong> (Truncated)</li>";
                    $cleared_count++;
                } else {
                    // Fallback to DELETE if truncate fails
                    $this->db->query("DELETE FROM " . $this->db->escape_identifiers($table));
                    echo "<li><span style='color: #f0ad4e; font-weight: bold;'>[CLEARED - DELETE]</span> Table: <strong>$table</strong> (Deleted records)</li>";
                    $cleared_count++;
                }
            }
        }

        // Re-enable foreign key checks
        $this->db->query("SET FOREIGN_KEY_CHECKS = 1;");

        // Re-seed the System warehouse for every store (required for Sales, POS, Stock etc.)
        $stores = $this->db->select('id')->get('db_store')->result();
        $created_date = date("Y-m-d");
        $warehouse_seeded = 0;
        foreach ($stores as $store) {
            $existing = $this->db->where('store_id', $store->id)->where('warehouse_type', 'System')->get('db_warehouse')->num_rows();
            if ($existing == 0) {
                $this->db->query("INSERT INTO db_warehouse(store_id, warehouse_type, warehouse_name, mobile, email, status, created_date)
                                  VALUES({$store->id}, 'System', 'System Warehouse', '', '', 1, '$created_date')");
                $warehouse_seeded++;
            }
        }

        echo "</ul>";
        echo "<hr>";
        echo "<h3 style='color: #5cb85c;'>Database Reset Completed! Successfully cleared $cleared_count tables.</h3>";
        if ($warehouse_seeded > 0) {
            echo "<p style='color: #337ab7;'><strong>&#10003; System Warehouse re-created</strong> for $warehouse_seeded store(s) to restore normal operation.</p>";
        }
        echo "<p><a href='" . base_url() . "' style='display: inline-block; padding: 10px 15px; color: #fff; background-color: #337ab7; text-decoration: none; border-radius: 4px;'>Go to Dashboard</a></p>";
        echo "</div>";
    }
}
