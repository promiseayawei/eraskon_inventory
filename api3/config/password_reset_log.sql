CREATE TABLE password_reset_log (
    id INT AUTO_INCREMENT PRIMARY KEY,
    description VARCHAR(225) NULL,
    email VARCHAR(100) NOT NULL,
    token VARCHAR(255) NOT NULL,
    expires_at DATETIME NOT NULL,
    password_reset INT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    date_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    FOREIGN KEY (password_reset) REFERENCES password_reset(id),
);
