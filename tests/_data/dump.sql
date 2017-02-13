TRUNCATE TABLE `products`;

SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE TABLE `categories`;
SET FOREIGN_KEY_CHECKS = 1;

TRUNCATE TABLE `users`;

INSERT INTO `categories` (`name`, `created_at`, `updated_at`) VALUES
('Games', now(), now()),
('Computers', now(), now()),
('TVs and Accessories', now(), now());

INSERT INTO `products` (`name`, `category_id`, `sku`, `price`, `quantity`, `created_at`, `updated_at`)
SELECT 'Pong', id, 'A0001', 69.99, 20, now(), now()
  FROM `categories`
  WHERE name = 'Games'
  LIMIT 1;

INSERT INTO `products` (`name`, `category_id`, `sku`, `price`, `quantity`, `created_at`, `updated_at`)
SELECT 'GameStation 5', id, 'A0002', 269.99, 15, now(), now()
  FROM `categories`
  WHERE name = 'Games'
  LIMIT 1;

INSERT INTO `products` (`name`, `category_id`, `sku`, `price`, `quantity`, `created_at`, `updated_at`)
SELECT 'AP Oman PC - Aluminum', id, 'A0003', 1399.99, 10, now(), now()
  FROM `categories`
  WHERE name = 'Computers'
  LIMIT 1;

INSERT INTO `products` (`name`, `category_id`, `sku`, `price`, `quantity`, `created_at`, `updated_at`)
SELECT 'Fony UHD HDR 55\" 4k TV', id, 'A0004', 69.99, 5, now(), now()
  FROM `categories`
  WHERE name = 'TVs and Accessories'
  LIMIT 1;

INSERT INTO `users` (`name`, `email`, created_at, updated_at) VALUES
('Bobby Fischer', 'bobby@foo.com', now(), now()),
('Betty Rubble', 'betty@foo.com', now(), now());
