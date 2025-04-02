CREATE TABLE cashiers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    serial VARCHAR(50) UNIQUE,
    user_id VARCHAR(50),
    open_cash_amount FLOAT,
    close_cash_amount FLOAT NULL,
    opened_at TIMESTAMP,
    closed_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    created_by VARCHAR(50),
    updated_by VARCHAR(50),
    INDEX idx_status_cashier (user_id, opened_at, closed_at)
);

CREATE TABLE transactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    serial VARCHAR(50) UNIQUE,
    cashier_id INT,
    customer_id VARCHAR(50),
    gross_amount FLOAT,
    total_amount FLOAT,
    discount_amount FLOAT,
    fee_amount FLOAT,
    tax_amount FLOAT,
    status VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    created_by VARCHAR(50),
    updated_by VARCHAR(50),
    FOREIGN KEY (cashier_id) REFERENCES cashiers(id) ON DELETE CASCADE,
    INDEX idx_cashier_transaction (cashier_id, status),
    INDEX idx_customer_transaction (customer_id, status)
);

CREATE TABLE payment_histories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    transaction_id INT,
    pay_amount FLOAT,
    payment_type VARCHAR(50),
    payment_method VARCHAR(50),
    payment_data TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_by VARCHAR(50),
    FOREIGN KEY (transaction_id) REFERENCES transactions(id) ON DELETE CASCADE,
    INDEX idx_transaction (transaction_id),
    INDEX idx_payment_type (payment_type),
    INDEX idx_payment_method (payment_method)
);

CREATE TABLE transaction_fees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    transaction_id INT,
    additional_fee_id VARCHAR(50),
    fee_amount FLOAT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    created_by VARCHAR(50),
    updated_by VARCHAR(50),
    FOREIGN KEY (transaction_id) REFERENCES transactions(id) ON DELETE CASCADE,
    INDEX idx_transaction (transaction_id),
    INDEX idx_additional_fee (additional_fee_id)
);

CREATE TABLE transaction_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    transaction_id INT,
    product_id VARCHAR(50),
    quantity INT,
    product_price FLOAT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    created_by VARCHAR(50),
    updated_by VARCHAR(50),
    FOREIGN KEY (transaction_id) REFERENCES transactions(id) ON DELETE CASCADE,
    INDEX idx_transaction (transaction_id),
    INDEX idx_product (product_id)
);

CREATE TABLE account_receivables (
    id INT AUTO_INCREMENT PRIMARY KEY,
    receivable_id VARCHAR(50) UNIQUE,
    transaction_id INT,
    total_amount FLOAT,
    total_outstanding_amount FLOAT,
    status VARCHAR(50),
    repayment_due_date TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    created_by VARCHAR(50),
    updated_by VARCHAR(50),
    FOREIGN KEY (transaction_id) REFERENCES transactions(id) ON DELETE CASCADE,
    INDEX idx_transaction (transaction_id, status)
);
