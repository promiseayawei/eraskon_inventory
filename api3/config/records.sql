CREATE TABLE records (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(255) NOT NULL,
    phone VARCHAR(255) NOT NULL,
    users INT NULL,
    mobilizer INT NULL,
    field_officer INT NULL,
    supervisor INT NULL,
    project_manager INT NULL,
    project_director INT NULL,
    records_activity INT NULL,
    date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    date_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (users) REFERENCES users(id),
    FOREIGN KEY (mobilizer) REFERENCES mobilizer(id),
    FOREIGN KEY (field_officer) REFERENCES field_officer(id), 
    FOREIGN KEY (supervisor) REFERENCES supervisor(id), 
    FOREIGN KEY (project_manager) REFERENCES project_manager(id), 
    FOREIGN KEY (project_director) REFERENCES project_director(id),
    FOREIGN KEY (records_activity) REFERENCES records_activity(id)
);

-- ALTER TABLE records
-- ADD COLUMN users INT NULL,
-- ADD COLUMN records_activity INT NULL;

-- ALTER TABLE records
-- ADD CONSTRAINT fk_users FOREIGN KEY (users) REFERENCES users(id),
-- ADD CONSTRAINT fk_records_activity FOREIGN KEY (records_activity) REFERENCES records_activity(id);
