

CREATE VIEW view_item_issue AS SELECT 
iss.i_id, 
sum(coalesce(ist.ist_qty,0)) AS `total_item_issue`,
sum(coalesce(coalesce(ist.ist_qty,0)*ist.ist_price,0)) AS `total_item_issue_price`
FROM item_issue AS iss 
RIGHT JOIN item_issue_trac AS ist ON iss.is_id = ist.is_id
GROUP BY iss.i_id
/////////////////old//////////////////
CREATE VIEW view_item_issue AS
SELECT item_issue.i_id AS i_id,
       SUM(COALESCE(item_issue.is_qty, 0)) AS total_item_issue,
       SUM(COALESCE(item_issue.is_qty * item_issue.is_avg_price, 0)) AS total_item_issue_price
FROM item_issue
WHERE item_issue.is_active = 1
GROUP BY item_issue.i_id;

//update view
CREATE VIEW view_item_purchase AS
SELECT
    ip.i_id,
    SUM(COALESCE(r.p_recive_qty, 0)) AS total_item_purchase,
    SUM(COALESCE(r.p_recive_qty * iP.p_unit_price, 0)) AS total_item_purchase_price
FROM tem_purchase_recive r
    INNER JOIN (SELECT p_id, i_id, p_unit_price FROM item_purchase) ip ON ip.p_id = r.p_id
GROUP BY ip.i_id;

CREATE VIEW view_item_purchase AS
SELECT item_purchase.i_id AS i_id,
       SUM(COALESCE(item_purchase.p_qty, 0)) AS total_item_purchase,
       SUM(COALESCE(item_purchase.p_qty * item_purchase.p_unit_price, 0)) AS total_item_purchase_price
FROM item_purchase
WHERE item_purchase.p_recive = 1
GROUP BY item_purchase.i_id;
----This is old Balance Statement-----------
CREATE VIEW balance AS
SELECT i.c_id AS c_id,
       C.c_name AS c_name,
       i.i_id AS i_id,
       i.i_name AS i_name,
       COALESCE(ip.total_item_purchase, 0) AS total_item_purchase,
       COALESCE(iss.total_item_issue, 0) AS total_item_issue,
       COALESCE(ip.total_item_purchase_price, 0) AS total_item_purchase_price,
       COALESCE(iss.total_item_issue_price, 0) AS total_item_issue_price,
       (COALESCE(ip.total_item_purchase, 0) - COALESCE(iss.total_item_issue, 0)) AS qty_balance,
       (COALESCE((COALESCE(ip.total_item_purchase_price, 0) - COALESCE(iss.total_item_issue_price, 0)) /
           NULLIF((COALESCE(ip.total_item_purchase, 0) - COALESCE(iss.total_item_issue, 0)), 0), 0)) AS item_issue_avg_price
FROM item i
LEFT JOIN view_item_purchase ip ON i.i_id = ip.i_id
LEFT JOIN view_item_issue iss ON i.i_id = iss.i_id
INNER JOIN category_ITEM c ON i.c_id = c.c_id;

----This is New Balance Statement-----------
CREATE VIEW balance AS
SELECT i.c_id AS c_id,
       c.c_name AS c_name,
       i.i_id AS i_id,
       i.i_name AS i_name,
       COALESCE(ip.total_item_purchase, 0) AS total_item_purchase,
       COALESCE(isss.total_item_issue, 0) AS total_item_issue,
       COALESCE(ip.total_item_purchase_price, 0) AS total_item_purchase_price,
       COALESCE(isss.total_item_issue_price, 0) AS total_item_issue_price,
       COALESCE(ip.qty_balance, 0)  AS qty_balance,
       (COALESCE((COALESCE(ip.total_item_purchase_price, 0) - COALESCE(isss.total_item_issue_price, 0)) /
                 NULLIF((COALESCE(ip.total_item_purchase, 0) - COALESCE(isss.total_item_issue, 0)), 0), 0)) AS item_issue_avg_price
FROM item i
         INNER JOIN category_item c ON i.c_id = c.c_id
         LEFT JOIN (SELECT ip.i_id,
                           SUM(r.p_recive_qty) AS total_item_purchase,
                           SUM(r.p_recive_qty * ip.p_unit_price) AS total_item_purchase_price,
                           SUM(r.p_stock) as qty_balance
                    FROM tem_purchase_recive r
                             INNER JOIN item_purchase ip ON ip.p_id = r.p_id
                    GROUP BY ip.i_id) ip ON i.i_id = ip.i_id
         LEFT JOIN (SELECT iss.i_id,
                           SUM(ist.ist_qty) AS total_item_issue,
                           SUM(ist.ist_qty * ist.ist_price) AS total_item_issue_price
                    FROM item_issue_trac ist
                             INNER JOIN item_issue iss ON ist.is_id = iss.is_id
                    GROUP BY iss.i_id) isss ON i.i_id = isss.i_id;







