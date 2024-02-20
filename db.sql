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
    price DECIMAL(10,2),
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
INSERT INTO cars (model, year, description, image_url, engine_type, horsepower, torque, transmission, acceleration_time, top_speed, fuel_efficiency_city, fuel_efficiency_highway, weight, quantity, price)
VALUES 
    ('Renault Kadjar', 2023, 'Spacious and comfortable SUV', 'https://images7.alphacoders.com/923/923240.jpg', 'Petrol', 150, 200, 'Automatic', 9.5, 200, 12.5, 18.5, 1600, 5, 35000.00),
    ('Renault Capture', 2022, 'Compact crossover with modern features', 'https://images5.alphacoders.com/104/1046017.jpg', 'Diesel', 120, 180, 'Manual', 10.2, 185, 14.0, 20.0, 1300, 5, 25000.00),
    ('Renault Clio', 2021, 'Economical and stylish hatchback', 'https://citymagazine.si/en/renault-clio-this-is-the-new-clio/renault-clio-2019-7/', 'Petrol', 100, 150, 'Automatic', 11.0, 175, 15.5, 22.0, 1200, 15, 20000.00),
    ('Renault Megane', 2022, 'Elegant and dynamic compact car', 'https://i.redd.it/qi60zeqbhsd01.jpg', 'Petrol', 140, 190, 'Automatic', 9.8, 195, 13.5, 19.5, 1500, 2, 28000.00),
    ('Renault Zoe', 2023, 'Electric hatchback with advanced technology', 'https://gracepacerace.com/wp-content/uploads/2022/08/Renault_Zoe_2022.jpg', 'Electric', 135, 150, 'Automatic', 7.2, 160, 20.5, 25.0, 1300, 1, 32000.00),
    ('Renault Twingo', 2020, 'Compact city car for urban adventures', 'https://s1.1zoom.me/b4654/462/Renault_2016_Twingo_GT_Orange_Metallic_526358_1920x1080.jpg', 'Petrol', 90, 110, 'Manual', 12.0, 155, 15.0, 22.5, 900, 3, 18000.00),
    ('Renault Talisman', 2021, 'Sophisticated midsize sedan with a focus on comfort', 'https://www.renderhub.com/alphagroup/renault-talisman-2020/renault-talisman-2020-03.jpg', 'Diesel', 160, 200, 'Automatic', 10.5, 190, 11.5, 17.8, 1600, 3, 30000.00),
    ('Renault Arkana', 2022, 'Sleek and versatile crossover', 'https://images.drive.com.au/driveau/image/upload/c_fill,f_auto,g_auto,h_1080,q_auto:eco,w_1920/v1/cms/uploads/ipilsq4sdufkjhfdo2x6', 'Petrol', 140, 190, 'Automatic', 9.8, 195, 13.5, 19.5, 1500, 4, 26000.00),
    ('Renault Koleos', 2022, 'Premium SUV with a blend of style and performance', 'https://images.drive.com.au/driveau/image/upload/c_fill,f_auto,g_auto,h_1080,q_auto:eco,w_1920/v1/cms/uploads/sfadewzgubibjwarqeaa', 'Diesel', 170, 210, 'Automatic', 9.0, 205, 12.8, 18.0, 1800, 10, 40000.00);


-- Insert data for users
INSERT INTO users (username, password, email, fname, lname)
VALUES 
    ('ivak', 'ivak123', 'ivak@ivak.com', 'Ivaylo', 'Ivanov'),
    ('john_doe', 'john123', 'john@example.com', 'John', 'Doe'),
    ('mary_smith', 'mary456', 'mary@example.com', 'Mary', 'Smith'),
    ('alex_jones', 'alex789', 'alex@example.com', 'Alex', 'Jones'),
    ('lisa_jackson', 'lisa987', 'lisa@example.com', 'Lisa', 'Jackson'),
    ('mike_smith', 'mike123', 'mike@example.com', 'Mike', 'Smith'),
    ('emily_davis', 'emily456', 'emily@example.com', 'Emily', 'Davis'),
    ('chris_miller', 'chris789', 'chris@example.com', 'Chris', 'Miller'),
    ('sarah_wilson', 'sarah234', 'sarah@example.com', 'Sarah', 'Wilson');


    
INSERT INTO orders (user_id, car_id, quantity)
VALUES 
    (1, 1, 2),
    (2, 3, 1),
    (3, 5, 2),
    (4, 2, 3),
    (5, 6, 1),
    (6, 8, 2),
    (7, 4, 1),
    (8, 9, 3),
    (1, 3, 1),
    (2, 7, 2),
    (3, 5, 1),
    (4, 1, 2),
    (5, 3, 1),
    (6, 2, 1),
    (7, 8, 2),
    (8, 3, 1),
    (9, 5, 3),
    (9, 7, 1);


--broqt na poruckite po modeli po dneshna datata
SELECT c.model, COUNT(o.order_id) AS order_count
FROM cars c
JOIN orders o ON c.car_id = o.car_id
WHERE DATE(o.order_date) = CURDATE()
GROUP BY c.model;

+------------------+-------------+
| model            | order_count |
+------------------+-------------+
| Renault Arkana   |           2 |
| Renault Capture  |           2 |
| Renault Clio     |           4 |
| Renault Kadjar   |           2 |
| Renault Koleos   |           1 |
| Renault Megane   |           1 |
| Renault Talisman |           2 |
| Renault Twingo   |           1 |
| Renault Zoe      |           3 |
+------------------+-------------+





--obshtata stojnost na vsicki porucki
SELECT SUM(cars.price * orders.quantity) AS combined_price
FROM orders
JOIN cars ON orders.car_id = cars.car_id;

+----------------+
| combined_price |
+----------------+
|      872000.00 |
+----------------+


--Informaciqta za vsicki porucki po model clio
SELECT
    orders.order_id,
    users.username,
    cars.model,
    orders.quantity,
    cars.price * orders.quantity AS full_price,
    orders.order_date
FROM
    orders
JOIN
    users ON orders.user_id = users.user_id
JOIN
    cars ON orders.car_id = cars.car_id
WHERE cars.model="Renault Clio"    
ORDER BY order_id;    


+----------+--------------+--------------+----------+------------+---------------------+
| order_id | username     | model        | quantity | full_price | order_date          |
+----------+--------------+--------------+----------+------------+---------------------+
|        2 | john_doe     | Renault Clio |        1 |   20000.00 | 2024-02-19 17:07:22 |
|        9 | ivak         | Renault Clio |        1 |   20000.00 | 2024-02-19 17:07:22 |
|       13 | lisa_jackson | Renault Clio |        1 |   20000.00 | 2024-02-19 17:07:22 |
|       16 | chris_miller | Renault Clio |        1 |   20000.00 | 2024-02-19 17:07:22 |
+----------+--------------+--------------+----------+------------+---------------------+

--smeni datata na porucka s id=2
UPDATE orders
SET order_date = '2017-04-20 13:37:00'  
WHERE order_id = 2;

+----------+---------+--------+---------------------+----------+
| order_id | user_id | car_id | order_date          | quantity |
+----------+---------+--------+---------------------+----------+
|        1 |       1 |      1 | 2024-02-19 16:54:06 |        2 |
|        2 |       2 |      3 | 2017-04-20 13:37:00 |        1 |
|        3 |       3 |      5 | 2024-02-19 16:54:06 |        2 |
|        4 |       4 |      2 | 2024-02-19 16:54:06 |        3 |
|        5 |       5 |      6 | 2024-02-19 16:54:06 |        1 |
|        6 |       6 |      8 | 2024-02-19 16:54:06 |        2 |
|        7 |       7 |      4 | 2024-02-19 16:54:06 |        1 |
|        8 |       8 |      9 | 2024-02-19 16:54:06 |        3 |
|        9 |       1 |      3 | 2024-02-19 16:54:06 |        1 |
|       10 |       2 |      7 | 2024-02-19 16:54:06 |        2 |
|       11 |       3 |      5 | 2024-02-19 16:54:06 |        1 |
|       12 |       4 |      1 | 2024-02-19 16:54:06 |        2 |
|       13 |       5 |      3 | 2024-02-19 16:54:06 |        1 |
|       14 |       6 |      2 | 2024-02-19 16:54:06 |        1 |
|       15 |       7 |      8 | 2024-02-19 16:54:06 |        2 |
|       16 |       8 |      3 | 2024-02-19 16:54:06 |        1 |
|       17 |       9 |      5 | 2024-02-19 16:54:06 |        3 |
|       18 |       9 |      7 | 2024-02-19 16:54:06 |        1 |
+----------+---------+--------+---------------------+----------+

--iztrii zapis model sled 2022

DELETE FROM orders
WHERE car_id IN (SELECT car_id FROM cars WHERE year > 2022);

DELETE FROM cars
WHERE year > 2022;


+--------+------------------+------+-----------------------------------------------------+------------------------------------------------------------------------------------------------------------------------------------+-------------+------------+--------+--------------+-------------------+-----------+----------------------+-------------------------+--------+----------+----------+
| car_id | model            | year | description                                         | image_url                                                                                                                          | engine_type | horsepower | torque | transmission | acceleration_time | top_speed | fuel_efficiency_city | fuel_efficiency_highway | weight | price    | quantity |
+--------+------------------+------+-----------------------------------------------------+------------------------------------------------------------------------------------------------------------------------------------+-------------+------------+--------+--------------+-------------------+-----------+----------------------+-------------------------+--------+----------+----------+
|      2 | Renault Capture  | 2022 | Compact crossover with modern features              | https://images5.alphacoders.com/104/1046017.jpg                                                                                    | Diesel      |        120 |    180 | Manual       |             10.20 |       185 |                14.00 |                   20.00 |   1300 | 25000.00 |        5 |
|      3 | Renault Clio     | 2021 | Economical and stylish hatchback                    | https://citymagazine.si/en/renault-clio-this-is-the-new-clio/renault-clio-2019-7/                                                  | Petrol      |        100 |    150 | Automatic    |             11.00 |       175 |                15.50 |                   22.00 |   1200 | 20000.00 |       15 |
|      4 | Renault Megane   | 2022 | Elegant and dynamic compact car                     | https://i.redd.it/qi60zeqbhsd01.jpg                                                                                                | Petrol      |        140 |    190 | Automatic    |              9.80 |       195 |                13.50 |                   19.50 |   1500 | 28000.00 |        2 |
|      6 | Renault Twingo   | 2020 | Compact city car for urban adventures               | https://s1.1zoom.me/b4654/462/Renault_2016_Twingo_GT_Orange_Metallic_526358_1920x1080.jpg                                          | Petrol      |         90 |    110 | Manual       |             12.00 |       155 |                15.00 |                   22.50 |    900 | 18000.00 |        3 |
|      7 | Renault Talisman | 2021 | Sophisticated midsize sedan with a focus on comfort | https://www.renderhub.com/alphagroup/renault-talisman-2020/renault-talisman-2020-03.jpg                                            | Diesel      |        160 |    200 | Automatic    |             10.50 |       190 |                11.50 |                   17.80 |   1600 | 30000.00 |        3 |
|      8 | Renault Arkana   | 2022 | Sleek and versatile crossover                       | https://images.drive.com.au/driveau/image/upload/c_fill,f_auto,g_auto,h_1080,q_auto:eco,w_1920/v1/cms/uploads/ipilsq4sdufkjhfdo2x6 | Petrol      |        140 |    190 | Automatic    |              9.80 |       195 |                13.50 |                   19.50 |   1500 | 26000.00 |        4 |
|      9 | Renault Koleos   | 2022 | Premium SUV with a blend of style and performance   | https://images.drive.com.au/driveau/image/upload/c_fill,f_auto,g_auto,h_1080,q_auto:eco,w_1920/v1/cms/uploads/sfadewzgubibjwarqeaa | Diesel      |        170 |    210 | Automatic    |              9.00 |       205 |                12.80 |                   18.00 |   1800 | 40000.00 |       10 |
+--------+------------------+------+-----------------------------------------------------+------------------------------------------------------------------------------------------------------------------------------------+-------------+------------+--------+--------------+-------------------+-----------+----------------------+-------------------------+--------+----------+----------+