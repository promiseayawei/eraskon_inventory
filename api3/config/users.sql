CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    phone VARCHAR(20) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    mobilizer INT NULL,
    field_officer INT NULL,
    supervisor INT NULL,
    project_manager INT NULL,
    project_director INT NULL,
    admin INT NULL,
    date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    date_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (mobilizer) REFERENCES mobilizer(id),
    FOREIGN KEY (field_officer) REFERENCES field_officer(id),
    FOREIGN KEY (supervisor) REFERENCES supervisor(id),
    FOREIGN KEY (project_manager) REFERENCES project_manager(id),
    FOREIGN KEY (project_director) REFERENCES project_director(id),
    FOREIGN KEY (admin) REFERENCES admin(id)
    
);