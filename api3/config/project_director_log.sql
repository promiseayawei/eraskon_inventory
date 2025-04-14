CREATE TABLE project_director_log (
    id INT AUTO_INCREMENT PRIMARY KEY,
    description VARCHAR(255) NULL,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    state VARCHAR(255) NOT NULL,
    lga VARCHAR(255) NOT NULL,
    town VARCHAR(255) NOT NULL,
    users INT NOT NULL,
    admin INT NOT NULL,
    date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    date_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (users) REFERENCES users(id),
    FOREIGN KEY (admin) REFERENCES admin(id)
    
);

