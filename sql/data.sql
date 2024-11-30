CREATE TABLE nurse (
    nurse_id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(255),
    last_name VARCHAR(255),
    email VARCHAR(255),
    gender VARCHAR(255),
    home_address VARCHAR(255),
    date_of_birth DATE,
    nationality VARCHAR(255),
    salary VARCHAR(255),
    user_id INT,
    added_by VARCHAR(50),
    last_updated_by VARCHAR(50),
    last_update TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    searched_by VARCHAR(50),
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE user_db (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50),
    first_name VARCHAR(50),
    last_name VARCHAR(50),
    password VARCHAR(50),
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE audit_log (
    audit_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50),
    action VARCHAR(50),
    table_name VARCHAR(50),
    update_id INT,
    action_details VARCHAR(50),
    action_timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);