CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(255),
    last_name VARCHAR(255),
    email VARCHAR(255) UNIQUE,
    password VARCHAR(255),
    role VARCHAR(50),  -- e.g., admin, customer, employee
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);


CREATE TABLE customers (
    customer_id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50),
    last_name VARCHAR(50),
    email VARCHAR(50),
    phone VARCHAR(15),
    license_number VARCHAR(50),
    added_by INT,  -- User who added the record
    last_updated_by INT,  -- User who last updated the record
    last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP  -- Timestamp of last update
);


CREATE TABLE cars (
    car_id INT AUTO_INCREMENT PRIMARY KEY,
    model VARCHAR(50),
    plate_number VARCHAR(20),
    color VARCHAR(20),
    status ENUM('available', 'rented', 'maintenance'),
    price_per_day DECIMAL(10, 2),
    added_by INT,  -- User who added the record
    last_updated_by INT,  -- User who last updated the record
    last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP  -- Timestamp of last update
);


CREATE TABLE rentals (
    rental_id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT,
    car_id INT,
    status VARCHAR(20),
    start_date DATE,
    end_date DATE,
    added_by INT,  -- User who added the record
    last_updated_by INT,  -- User who last updated the record
    last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,  -- Timestamp of last update
    FOREIGN KEY (customer_id) REFERENCES customers(customer_id) ON DELETE CASCADE,
    FOREIGN KEY (car_id) REFERENCES cars(car_id) ON DELETE CASCADE
);


CREATE TABLE payments (
    payment_id INT AUTO_INCREMENT PRIMARY KEY,
    rental_id INT,
    payment_date DATE,
    amount DECIMAL(10, 2),
    payment_method VARCHAR(20),
    added_by INT,  -- User who added the record
    last_updated_by INT,  -- User who last updated the record
    last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,  -- Timestamp of last update
    FOREIGN KEY (rental_id) REFERENCES rentals(rental_id) ON DELETE CASCADE
);
