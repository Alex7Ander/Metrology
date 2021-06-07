DROP TABLE IF EXISTS works;
DROP TABLE IF EXISTS devices;
DROP TABLE IF EXISTS staff;

CREATE TABLE staff (id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                    name CHAR(255),
                    surname CHAR(255),
                    patronimyc CHAR(255),
                    verificator_status BOOLEAN, 
                    manager_status BOOLEAN);
                    
CREATE TABLE device_types (id INT UNSIGNED PRIMARY KEY,
							state_number VARCHAR(16),
							designation VARCHAR(256),
							name VARCHAR(256));                    

CREATE TABLE devices (id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                    device_type_id  INT UNSIGNED,                    
                    serial_number CHAR(64),
                    FOREIGN KEY (device_type_id) REFERENCES device_types (id));
                                        
CREATE TABLE works (id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
					device_id INT UNSIGNED,
					verificator_id INT UNSIGNED,
					manager_id INT UNSIGNED,
                    verification_date DATE,
					request_number VARCHAR(16),
					account_number VARCHAR(16),
					work_index VARCHAR(32),
					standart_type VARCHAR(64),
					temperature DECIMAL(3,1),
					humidity TINYINT UNSIGNED,
					preasure SMALLINT UNSIGNED,
					protocol_link VARCHAR(256),
					document_link VARCHAR(256),
					taken BOOL,
					measured BOOL,
					processed BOOL,
					metrology_closed BOOL,
					document_printed BOOL,
					given_away BOOL,
					document_number VARCHAR(256),
					FOREIGN KEY (device_id)  REFERENCES devices (id),
					FOREIGN KEY (verificator_id)  REFERENCES staff (id),
					FOREIGN KEY (manager_id)  REFERENCES staff (id));
