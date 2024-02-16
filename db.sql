CREATE DATABASE renault_website;

use renault_website;

-- Create users table
CREATE TABLE users (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL,
    fname VARCHAR(50) NOT NULL,
    lname VARCHAR(50) NOT NULL,
    registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create cars table
CREATE TABLE cars (
    car_id INT PRIMARY KEY AUTO_INCREMENT,
    model VARCHAR(100) NOT NULL,
    year INT,
    description TEXT,
    image_url TEXT,
    engine_type VARCHAR(50),
    horsepower INT,
    torque INT,
    transmission VARCHAR(50),
    acceleration_time DECIMAL(5,2),
    top_speed INT,
    fuel_efficiency_city DECIMAL(5,2),
    fuel_efficiency_highway DECIMAL(5,2),
    weight INT,
    quantity INT DEFAULT 0  -- Added quantity column with a default value of 0
);

-- Create orders table
CREATE TABLE orders (
    order_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    car_id INT,
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    quantity INT,
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (car_id) REFERENCES cars(car_id)
);

-- Insert data for Renault cars
INSERT INTO cars (model, year, description, image_url, engine_type, horsepower, torque, transmission, acceleration_time, top_speed, fuel_efficiency_city, fuel_efficiency_highway, weight, quantity)
VALUES 
    ('Renault Kadjar', 2023, 'Spacious and comfortable SUV', 'https://images7.alphacoders.com/923/923240.jpg', 'Petrol', 150, 200, 'Automatic', 9.5, 200, 12.5, 18.5, 1600, 5),
    ('Renault Capture', 2022, 'Compact crossover with modern features', 'https://images5.alphacoders.com/104/1046017.jpg', 'Diesel', 120, 180, 'Manual', 10.2, 185, 14.0, 20.0, 1300, 5),
    ('Renault Clio', 2021, 'Economical and stylish hatchback', 'https://citymagazine.si/en/renault-clio-this-is-the-new-clio/renault-clio-2019-7/', 'Petrol', 100, 150, 'Automatic', 11.0, 175, 15.5, 22.0, 1200, 5),
    ('Renault Megane', 2022, 'Elegant and dynamic compact car', 'https://i.redd.it/qi60zeqbhsd01.jpg', 'Petrol', 140, 190, 'Automatic', 9.8, 195, 13.5, 19.5, 1500, 2),
    ('Renault Zoe', 2023, 'Electric hatchback with advanced technology', 'https://gracepacerace.com/wp-content/uploads/2022/08/Renault_Zoe_2022.jpg', 'Electric', 135, 150, 'Automatic', 7.2, 160, 20.5, 25.0, 1300, 1),
    ('Renault Twingo', 2020, 'Compact city car for urban adventures', 'https://s1.1zoom.me/b4654/462/Renault_2016_Twingo_GT_Orange_Metallic_526358_1920x1080.jpg', 'Petrol', 90, 110, 'Manual', 12.0, 155, 15.0, 22.5, 900, 3),
    ('Renault Talisman', 2021, 'Sophisticated midsize sedan with a focus on comfort', 'https://www.renderhub.com/alphagroup/renault-talisman-2020/renault-talisman-2020-03.jpg', 'Diesel', 160, 200, 'Automatic', 10.5, 190, 11.5, 17.8, 1600, 3),
    ('Renault Arkana', 2022, 'Sleek and versatile crossover', 'https://images.drive.com.au/driveau/image/upload/c_fill,f_auto,g_auto,h_1080,q_auto:eco,w_1920/v1/cms/uploads/ipilsq4sdufkjhfdo2x6', 'Petrol', 140, 190, 'Automatic', 9.8, 195, 13.5, 19.5, 1500, 4),
    ('Renault Koleos', 2022, 'Premium SUV with a blend of style and performance', 'https://images.drive.com.au/driveau/image/upload/c_fill,f_auto,g_auto,h_1080,q_auto:eco,w_1920/v1/cms/uploads/sfadewzgubibjwarqeaa', 'Diesel', 170, 210, 'Automatic', 9.0, 205, 12.8, 18.0, 1800, 10);


-- Insert data for users
INSERT INTO users (username, password, email, fname, lname)
VALUES 
    ('ivak', 'ivak123', 'ivak@ivak.com', 'Ivaylo', 'Ivanov');
    
INSERT INTO orders (user_id, car_id, quantity)
VALUES 
    (1, 1, 2);    
