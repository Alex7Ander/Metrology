CREATE DATABASE Metrology;
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
					verificatorId INT UNSIGNED,
                    managerId INT UNSIGNED,
                    deviceId INT UNSIGNED,
                    work_index INT UNSIGNED,                      
                    device_etalon_type CHAR(64),
                    temperature DOUBLE, 
                    humidity DOUBLE, 
                    preasure DOUBLE,
                    protocolLink CHAR(255),
                    documentLink CHAR(255),
                    FOREIGN KEY (deviceId) REFERENCES devices (id) ON DELETE CASCADE,
					FOREIGN KEY (verificatorId) REFERENCES staff (id) ON DELETE SET NULL,
                    FOREIGN KEY (managerId) REFERENCES staff (id) ON DELETE SET NULL);
