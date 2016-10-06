<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);


function pages($id)
{
    if (isset($_GET["page"])) {
        $page = $_GET["page"];
    } else {
        $page = 1;
    }
    ;
    
    $conn = mysqli_connect("localhost", "root", "root", "company");
    
    $start_from = ($page - 1) * 10;
    $sql        = "SELECT * FROM login WHERE id != ".$id."  LIMIT $start_from, 10";
    $result     = mysqli_query($conn, $sql);
    $pages      = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {
            
            
            array_push($pages, $row);
            
            
            
        }
        
        
        
        $sql = "SELECT COUNT(username) FROM login";
        
        $rs_result     = mysqli_query($conn, $sql);
        $row           = mysqli_fetch_row($rs_result);
        $total_records = $row[0];
        $total_pages   = ceil($total_records / 10);
        
        for ($i = 1; $i <= $total_pages; $i++) {
            echo "<a href='public.php?page=" . $i . "'>" . $i . "</a> ";
        }
        
    }
    return $pages;
}
?>


