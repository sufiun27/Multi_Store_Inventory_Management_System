<?php

class DateWiseReceive extends DbhReport
{
    public function DateWiseReceiveReport()
    {
        session_start();
$section=$_SESSION['section'];


        
        $sql = "
        SELECT
                c.c_name AS category,
                i.i_name AS item,
                i.i_size AS size,
                i.i_unit AS unit,
                i.i_price AS price,
                COALESCE(vp.total_item_purchase, 0) AS total_purchase,
                COALESCE(vp.total_item_purchase_price, 0) AS total_purchase_price,
                COALESCE(vi.total_item_issue, 0) AS total_issue,
                COALESCE(vi.total_item_issue_price, 0) AS total_issue_price,
                COALESCE(vp.total_item_purchase, 0) - COALESCE(vi.total_item_issue, 0) AS Stock,
                COALESCE(vp.total_item_purchase_price, 0) - COALESCE(vi.total_item_issue_price, 0) AS stock_price
            FROM
                item AS i
            INNER JOIN
                category_item AS c ON c.c_id = i.c_id
            LEFT JOIN
                view_item_purchase AS vp ON vp.i_id = i.i_id
            LEFT JOIN
                view_item_issue AS vi ON vi.i_id = i.i_id   
                WHERE i.section ='$section'         
            ORDER BY
            c.c_name, i.i_name";

        $stmt = $this->connect()->query($sql);
        
        if (!$stmt) {
            return [];
        } else {
            $result = $stmt->fetchAll();
            return $result;
        }
    }

    public function DateWiseNameReceiveReport($itemName)
    {
        session_start();
        $section=$_SESSION['section'];


        
        $sql = "
        SELECT
                c.c_name AS category,
                i.i_name AS item,
                i.i_size AS size,
                i.i_unit AS unit,
                i.i_price AS price,
                COALESCE(vp.total_item_purchase, 0) AS total_purchase,
                COALESCE(vp.total_item_purchase_price, 0) AS total_purchase_price,
                COALESCE(vi.total_item_issue, 0) AS total_issue,
                COALESCE(vi.total_item_issue_price, 0) AS total_issue_price,
                COALESCE(vp.total_item_purchase, 0) - COALESCE(vi.total_item_issue, 0) AS Stock,
                COALESCE(vp.total_item_purchase_price, 0) - COALESCE(vi.total_item_issue_price, 0) AS stock_price
            FROM
                item AS i
            INNER JOIN
                category_item AS c ON c.c_id = i.c_id
            LEFT JOIN
                view_item_purchase AS vp ON vp.i_id = i.i_id
            LEFT JOIN
                view_item_issue AS vi ON vi.i_id = i.i_id            

           WHERE  
           i.section ='$section' AND ( i.i_name LIKE '%$itemName%' OR c.c_name LIKE '%$itemName%' )
            ORDER BY
            c.c_name, i.i_name";

        $stmt = $this->connect()->query($sql);
        
        if (!$stmt) {
            return [];
        } else {
            $result = $stmt->fetchAll();
            return $result;
        }
    }
}
