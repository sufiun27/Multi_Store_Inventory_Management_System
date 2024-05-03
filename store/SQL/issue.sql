DELIMITER //

CREATE PROCEDURE process_item_issue()
BEGIN
    DECLARE total_amount INT;
    DECLARE amount_left INT;
    DECLARE price DECIMAL(10, 2);
    DECLARE selling_price DECIMAL(10, 2);

    -- Temp table to store purchased items and their prices
    CREATE TEMPORARY TABLE temp_purchase (
        item_name VARCHAR(50),
        amount INT,
        price DECIMAL(10, 2)
    );

    -- Insert purchased items into the temp table
INSERT INTO temp_purchase (item_name, amount, price)
SELECT item_name, amount, price
FROM item_purchase;

-- Iterate through issued items and calculate selling price
FOR issue_record IN (SELECT item_name, amount, issue_date FROM item_issue ORDER BY issue_date)
    DO
        SET total_amount = issue_record.amount;
        SET amount_left = total_amount;

        -- Calculate selling price based on purchase price
        WHILE amount_left > 0
        DO
SELECT price INTO price
FROM temp_purchase
WHERE item_name = issue_record.item_name
ORDER BY price
    LIMIT 1;

IF amount_left <= (SELECT SUM(amount) FROM temp_purchase WHERE item_name = issue_record.item_name) THEN
                SET selling_price = price;
ELSE
                SET selling_price = (SELECT price FROM temp_purchase WHERE item_name = issue_record.item_name ORDER BY price DESC LIMIT 1);
END IF;

            -- Update the temp_purchase table to remove items that have been sold at this price
UPDATE temp_purchase
SET amount = amount - LEAST(amount, amount_left)
WHERE item_name = issue_record.item_name AND price = selling_price;

-- Update the amount_left for the next iteration
SET amount_left = amount_left - LEAST(amount_left, amount);

            -- Here you can do whatever you want with the selling_price (e.g., issue a receipt, record the transaction in another table, etc.)
            -- For simplicity, let's just print the details.
SELECT CONCAT('Issued ', LEAST(amount_left, amount), ' units of ', issue_record.item_name, ' at price ', selling_price) AS message;

-- If there are no more items left in the temp_purchase table for this item_name, delete the row
DELETE FROM temp_purchase WHERE amount = 0;
END WHILE;
END FOR;

    -- Clean up the temp table
    DROP TEMPORARY TABLE IF EXISTS temp_purchase;
END;
//

DELIMITER ;
