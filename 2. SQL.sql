-- удаление пустых групп каталога (без товаров)
DELETE FROM categories
WHERE id NOT IN (SELECT DISTINCT category_id FROM products);

-- удаление товаров, которых нет в наличии
DELETE FROM products
WHERE id NOT IN (SELECT DISTINCT product_id FROM availabilities);

-- удаление пустых складов
DELETE FROM stocks
WHERE id NOT IN (SELECT DISTINCT stock_id FROM availabilities);