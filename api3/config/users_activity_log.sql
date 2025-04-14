CREATE TABLE users_activity_log (
    id INT AUTO_INCREMENT PRIMARY KEY,
    role VARCHAR(255) NULL,
    Description VARCHAR(255) NULL,    
    email VARCHAR(255) NULL,
    phone VARCHAR(20) NULL,
    password VARCHAR(255) NULL,
    users INT NULL,
    mobilizer INT NULL,
    field_officer INT NULL,
    supervisor INT NULL,
    project_manager INT NULL,
    project_director INT NULL,
    date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    date_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (users) REFERENCES users(id),
    FOREIGN KEY (mobilizer) REFERENCES mobilizer(id),
    FOREIGN KEY (field_officer) REFERENCES field_officer(id),
    FOREIGN KEY (supervisor) REFERENCES supervisor(id),
    FOREIGN KEY (project_manager) REFERENCES project_manager(id),
    FOREIGN KEY (project_director) REFERENCES project_director(id)
    
);