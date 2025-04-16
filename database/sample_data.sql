-- Clear existing data
DELETE FROM inventory_logs;
DELETE FROM items;

-- Insert sample data
INSERT INTO items (id, name, category, quantity, price) VALUES
-- Electronics Category
('E001', 'iPhone 13 Pro', 'electronics', 15, 999.99),
('E002', 'Samsung 4K TV', 'electronics', 8, 799.99),
('E003', 'MacBook Air', 'electronics', 12, 1299.99),
('E004', 'AirPods Pro', 'electronics', 25, 249.99),
('E005', 'Dell XPS Laptop', 'electronics', 7, 1499.99),
('E006', 'iPad Mini', 'electronics', 18, 499.99),
('E007', 'Sony PlayStation 5', 'electronics', 5, 499.99),
('E008', 'Nintendo Switch', 'electronics', 20, 299.99),
('E009', 'Canon EOS Camera', 'electronics', 9, 699.99),
('E010', 'Bose Headphones', 'electronics', 15, 349.99),
('E011', 'Apple Watch', 'electronics', 22, 399.99),
('E012', 'Google Pixel 6', 'electronics', 13, 699.99),
('E013', 'Samsung Galaxy Tab', 'electronics', 11, 449.99),
('E014', 'LG OLED TV', 'electronics', 6, 1299.99),
('E015', 'Microsoft Surface', 'electronics', 9, 899.99),
('E016', 'Roku Streaming Stick', 'electronics', 30, 49.99),
('E017', 'Ring Doorbell', 'electronics', 17, 199.99),
('E018', 'Echo Dot', 'electronics', 40, 49.99),
('E019', 'GoPro Camera', 'electronics', 14, 399.99),
('E020', 'Wireless Mouse', 'electronics', 50, 29.99),

-- Furniture Category
('F001', 'Leather Sofa', 'furniture', 4, 899.99),
('F002', 'Dining Table Set', 'furniture', 6, 599.99),
('F003', 'Queen Bed Frame', 'furniture', 8, 499.99),
('F004', 'Office Chair', 'furniture', 15, 199.99),
('F005', 'Bookshelf', 'furniture', 12, 149.99),
('F006', 'Coffee Table', 'furniture', 10, 249.99),
('F007', 'Wardrobe Cabinet', 'furniture', 7, 399.99),
('F008', 'TV Stand', 'furniture', 9, 179.99),
('F009', 'Desk Lamp', 'furniture', 25, 39.99),
('F010', 'Bean Bag Chair', 'furniture', 20, 89.99),
('F011', 'Kitchen Island', 'furniture', 5, 349.99),
('F012', 'Bar Stools Set', 'furniture', 16, 199.99),
('F013', 'Side Table', 'furniture', 18, 79.99),
('F014', 'Mirror Cabinet', 'furniture', 11, 159.99),
('F015', 'Shoe Rack', 'furniture', 22, 49.99),
('F016', 'Filing Cabinet', 'furniture', 13, 129.99),
('F017', 'Bedside Table', 'furniture', 24, 89.99),
('F018', 'Room Divider', 'furniture', 8, 159.99),
('F019', 'Ottoman', 'furniture', 14, 119.99),
('F020', 'Console Table', 'furniture', 9, 169.99),

-- Clothing Category
('C001', 'Men\'s Jeans', 'clothing', 45, 59.99),
('C002', 'Women\'s Dress', 'clothing', 35, 79.99),
('C003', 'Winter Jacket', 'clothing', 25, 129.99),
('C004', 'Running Shoes', 'clothing', 30, 89.99),
('C005', 'T-Shirt Pack', 'clothing', 60, 29.99),
('C006', 'Yoga Pants', 'clothing', 40, 49.99),
('C007', 'Sweater', 'clothing', 28, 69.99),
('C008', 'Business Suit', 'clothing', 15, 299.99),
('C009', 'Summer Shorts', 'clothing', 50, 34.99),
('C010', 'Rain Boots', 'clothing', 20, 44.99),
('C011', 'Leather Belt', 'clothing', 35, 29.99),
('C012', 'Wool Socks', 'clothing', 75, 14.99),
('C013', 'Baseball Cap', 'clothing', 45, 24.99),
('C014', 'Sunglasses', 'clothing', 30, 79.99),
('C015', 'Dress Shirt', 'clothing', 40, 59.99),
('C016', 'Workout Shorts', 'clothing', 55, 29.99),
('C017', 'Winter Gloves', 'clothing', 40, 19.99),
('C018', 'Scarf Set', 'clothing', 30, 34.99),
('C019', 'Hiking Boots', 'clothing', 18, 129.99),
('C020', 'Swimwear', 'clothing', 40, 39.99),

-- Other Category
('O001', 'Yoga Mat', 'other', 25, 29.99),
('O002', 'Water Bottle', 'other', 50, 19.99),
('O003', 'Backpack', 'other', 30, 49.99),
('O004', 'Wall Clock', 'other', 20, 24.99),
('O005', 'Plant Pot', 'other', 40, 15.99),
('O006', 'Throw Pillows', 'other', 35, 24.99),
('O007', 'Board Game', 'other', 15, 39.99),
('O008', 'Art Print', 'other', 25, 34.99),
('O009', 'Lunch Box', 'other', 30, 19.99),
('O010', 'Umbrella', 'other', 40, 22.99),
('O011', 'Candle Set', 'other', 45, 29.99),
('O012', 'Picture Frame', 'other', 35, 17.99),
('O013', 'Desk Organizer', 'other', 28, 24.99),
('O014', 'Sleeping Bag', 'other', 12, 79.99),
('O015', 'Tool Kit', 'other', 15, 89.99),
('O016', 'First Aid Kit', 'other', 25, 34.99),
('O017', 'Camping Tent', 'other', 8, 199.99),
('O018', 'Guitar Strings', 'other', 50, 14.99),
('O019', 'Cooking Set', 'other', 10, 129.99),
('O020', 'Chess Set', 'other', 18, 44.99),

-- Additional Electronics
('E021', 'Wireless Charger', 'electronics', 45, 29.99),
('E022', 'Bluetooth Speaker', 'electronics', 28, 79.99),
('E023', 'Smartwatch', 'electronics', 15, 199.99),
('E024', 'Gaming Mouse', 'electronics', 32, 59.99),
('E025', 'USB-C Hub', 'electronics', 40, 39.99),

-- Additional Furniture
('F021', 'Floor Lamp', 'furniture', 12, 89.99),
('F022', 'Storage Bench', 'furniture', 8, 159.99),
('F023', 'Wall Shelf Set', 'furniture', 16, 69.99),
('F024', 'Coat Rack', 'furniture', 20, 49.99),
('F025', 'Kids Table', 'furniture', 10, 79.99),

-- Additional Clothing
('C021', 'Denim Jacket', 'clothing', 25, 89.99),
('C022', 'Polo Shirt', 'clothing', 35, 44.99),
('C023', 'Leather Wallet', 'clothing', 40, 49.99),
('C024', 'Running Socks', 'clothing', 60, 12.99),
('C025', 'Beach Hat', 'clothing', 30, 24.99),

-- Additional Other Items
('O021', 'Fitness Band', 'other', 22, 29.99),
('O022', 'Travel Pillow', 'other', 28, 19.99),
('O023', 'Garden Tools', 'other', 15, 49.99),
('O024', 'Desk Fan', 'other', 18, 34.99),
('O025', 'Pet Bed', 'other', 12, 44.99);

-- Add inventory logs for each item
INSERT INTO inventory_logs (item_id, action, quantity_change)
SELECT id, 'create', quantity FROM items;