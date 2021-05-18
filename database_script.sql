DROP TABLE IF EXISTS works;
DROP TABLE IF EXISTS devices;
DROP TABLE IF EXISTS staff;

CREATE TABLE staff (id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                    name CHAR(255),
                    surname CHAR(255),
                    patronimyc CHAR(255),
                    verificator_status BOOLEAN, 
                    manager_status BOOLEAN);

CREATE TABLE devices (id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                    device_group  CHAR(255),
                    device_type CHAR(255),                    
                    serial_number CHAR(64),
                    state_register_number CHAR(64));

CREATE TABLE works (id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
					verificator_id INT UNSIGNED,
                    manager_id INT UNSIGNED,
                    device_id INT UNSIGNED,
                    request_number CHAR(64),
                    account_number CHAR(64),
                    work_index INT UNSIGNED,                      
                    device_etalon_type CHAR(64),
                    temperature DOUBLE, 
                    humidity DOUBLE, 
                    preasure DOUBLE,
                    protocolLink CHAR(255),
                    documentLink CHAR(255),
                    FOREIGN KEY (device_id) REFERENCES devices (id) ON DELETE CASCADE,
					FOREIGN KEY (verificator_id) REFERENCES staff (id) ON DELETE SET NULL,
                    FOREIGN KEY (manager_id) REFERENCES staff (id) ON DELETE SET NULL);
