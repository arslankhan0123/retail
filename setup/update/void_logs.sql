CREATE TABLE IF NOT EXISTS db_voidlogs (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT, store_id INT NULL, warehouse_id INT NULL,
  user_id INT NOT NULL, salesman_id INT NOT NULL, invoice_date DATE NOT NULL,
  invoice_time TIME NOT NULL, invoice_no VARCHAR(100) NOT NULL,
  invoice_type ENUM('POS','Sale') NOT NULL DEFAULT 'POS',
  delete_type ENUM('Single','Bulk') NOT NULL, created_at DATETIME NOT NULL,
  PRIMARY KEY (id), KEY idx_void_invoice (invoice_no), KEY idx_void_salesman (salesman_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS db_voidlogitems (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT, void_log_id BIGINT UNSIGNED NOT NULL,
  item_id INT NULL, barcode VARCHAR(100) NULL, item_code VARCHAR(100) NULL,
  item_name VARCHAR(255) NOT NULL, qty DECIMAL(20,4) NOT NULL DEFAULT 0,
  price DECIMAL(20,4) NOT NULL DEFAULT 0, disc DECIMAL(20,4) NOT NULL DEFAULT 0,
  tax DECIMAL(20,4) NOT NULL DEFAULT 0, subtotal DECIMAL(20,4) NOT NULL DEFAULT 0,
  PRIMARY KEY (id), KEY idx_voidlog_parent (void_log_id),
  CONSTRAINT fk_voidlogitems_parent FOREIGN KEY (void_log_id) REFERENCES db_voidlogs (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
