<?php

include_once '../php/model/user.php';
include_once '../php/database.php';
include_once '../html/Liceu-Trigonometrie.php';

function showLiceuAnaliza(){

    $database = new Database();
    $db = $database->connect();
    
    $query = "SELECT * FROM trigonometrie_liceu";
    $result = $db->prepare($query);
    $result->execute();

    $result_per_page = 5;
    $number_of_result = $result->rowCount();

    $number_of_pages = ceil($number_of_result/$result_per_page);

    if(!isset($_GET['page'])){
        $page = 1;
    }
    else {
        $page = $_GET['page'];
    }

   $this_page_first_result = ($page-1)*$result_per_page;


    $sql = "SELECT ID, title, text_problem, score FROM trigonometrie_liceu LIMIT " . $this_page_first_result .',' . $result_per_page;
    $result = $db->prepare($sql);
    $result->execute();

    if($result-> rowCount() > 0){
    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        echo
        "<tr>
                <td class='id'>". $row["ID"] ."</td>
                <td class='title'>" . $row["title"] ."</td>
                <td>" . $row["text_problem"] . "</td>
                <td class='score'>" . $row["score"] ."</td>
                <td class='tess'>
                <div>
                    <input id='" . $row["ID"] . "' type='text' class='input-raspuns' name='tt' placeholder='Raspuns...'>
                    <input type='hidden' id='custId-". $row['ID'] ."' name='custId' value='" . $row['ID'] ."'>
                    <input name='caca' type='submit' onclick='z(" . $row['ID'] . ")'></i>
                    <i class='fa fa-check-circle' id='check-". $row['ID'] ."' style='font-size:48px;color:red;display:none;'></i>
                </div>
                </td>
            </tr>";
        }
    }
    for($page = 1; $page <= $number_of_pages; $page++){
        echo '<a href="../html/Liceu-Trigonometrie.php?page=' .$page . '" class="pages">' .$page . '</a> ';
    }    
} 