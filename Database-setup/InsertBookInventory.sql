USE bookstore;

INSERT INTO `bookstore`.`book_inventory` 
(`Name`, `Available_Copies`, `Price`, `Created_Datetime`, `Modified_Datetime`, `Author`, `Image_URL`) 
VALUES 
('The Journey', '100', '50.00', now(), now(), 'Mary Jane', 'journey.jpg'),
('Harry Potter', '100', '40.00', now(), now(), 'J.K Rowling', 'Harry.jpg'),
('Invincible', '100', '32.00', now(), now(), 'Darwin Jr.', 'invincible.webp'),
('Shallows', '120', '53.00', now(), now(), 'Margret San', 'shallows.jpg'),
('Broken', '90', '45.00', now(), now(), 'Chetan Bhagat', 'broken.jpg'),
('The MockingBird', '130', '80.00', now(), now(), 'Susan Shawn', 'mocking.jpg'),
('Prada Women', '100', '67.00', now(), now(), 'Gigi Hydes', 'prada.jpg'),
('Hello', '120', '20.00', now(), now(), 'Mark Twain', 'hello.jpg');
