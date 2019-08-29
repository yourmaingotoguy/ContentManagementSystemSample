<?php

function find_all_subjects(){
    global $db;
    
    $query = "SELECT * FROM SUBJECTS ";
    $query .= "ORDER BY position ASC";
    $rs = mysqli_query($db,$query);
    confirm_result_set($rs);
    return $rs;
}

function find_all_pages(){
    global $db;
    $query = "SELECT * FROM PAGES ";
    $query .= "ORDER BY position ASC";
    $rs = mysqli_query($db,$query);
    confirm_result_set($rs);
    return $rs;
}

function find_subject_by_id($id){
    global $db;
    $query = "SELECT * FROM SUBJECTS ";
    $query .= "WHERE ID = '" . $id . "'";
    $rs = mysqli_query($db,$query);
    confirm_result_set($rs);
    $subject = mysqli_fetch_assoc($rs);
    mysqli_free_result($rs);
    return $subject;
}

function find_page_by_id($id){
    global $db;
    $query = "SELECT * FROM PAGES ";
    $query .= "WHERE ID = '" . $id . "'";
    $rs = mysqli_query($db,$query);
    confirm_result_set($rs);
    $page = mysqli_fetch_assoc($rs);
    mysqli_free_result($rs);
    return $page;
}

function validate_subject($subject){
    $errors = [];

    //menu_item
    if(is_blank($subject['menu_name'])){
        $errors[] = "Name cannot be blank.";
    }elseif(!has_length($subject['menu_name'], ['min' => 2, 'max' => 255])){
        $errors[] = "Name must be between 2 and 255 characters.";
    }
    
    //position
    $position_int = (int) $subject['position'];
    if($position_int <= 0){
        $errors[] = "Position must be greater than 0.";
    }
    if($position_int > 999){
        $errors[] = "Position must be less than 999.";
    }
    //visible
    if(!has_inclusion_of($subject['visible'], ["0","1"])){
        $errors[] = "Visible must be true or false.";
    }
    return $errors;
}


function insert_subject($subject){
    global $db;
    
    $errors = validate_subject($subject);
    if(!empty($errors)){
        return $errors;
    }
    $query = "INSERT INTO SUBJECTS ";
    $query .= "(menu_name,position,visible) ";
    $query .= "VALUES ('" . $subject['menu_name'] . "','" . $subject['position'] . "','" . $subject['visible'] . "')";
    return mysqli_query($db,$query);
}

function update_subject($subject){
    global $db;
    
    $errors = validate_subject($subject);
    if(!empty($errors)){
        return $errors;
    }
    $query = "UPDATE SUBJECTS SET ";
    $query .= "menu_name='" . $subject['menu_name'] . "', ";
    $query .= "position='" . $subject['position'] . "', ";
    $query .= "visible='" . $subject['visible'] . "' ";
    $query .= "WHERE id='" . $subject['id'] . "' ";
    $query .= "LIMIT 1";
    return mysqli_query($db,$query);
}

function insert_page($page){
    global $db;

    $sql = "INSERT INTO pages ";
    $sql .= "(subject_id, menu_name, position, visible, content) ";
    $sql .= "VALUES (";
    $sql .= "'" . $page['subject_id'] . "',";
    $sql .= "'" . $page['menu_name'] . "',";
    $sql .= "'" . $page['position'] . "',";
    $sql .= "'" . $page['visible'] . "',";
    $sql .= "'" . $page['content'] . "'";
    $sql .= ")";
    return mysqli_query($db,$sql);
}

function update_page($page){
    global $db;
    $query = "UPDATE PAGES SET ";
    $query .= "subject_id='" . $page['subject_id'] . "', ";
    $query .= "menu_name='" . $page['menu_name'] . "', ";
    $query .= "position='" . $page['position'] . "', ";
    $query .= "visible='" . $page['visible'] . "', ";
    $query .= "content='" . $page['content'] . "' ";
    $query .= "WHERE id='" . $page['id'] . "' ";
    $query .= "LIMIT 1";
    return mysqli_query($db,$query);
}
 
function get_subject_count(){
    global $db;
    $query = "SELECT COUNT(*) as total ";
    $query .= "FROM SUBJECTS";
    $rs = mysqli_query($db,$query);
    confirm_result_set($rs);
    $result = mysqli_fetch_assoc($rs);
    mysqli_free_result($rs);
    return $result['total'];
}

function get_page_count(){
    global $db;
    $query = "SELECT COUNT(*) as total ";
    $query .= "FROM PAGES";
    $rs = mysqli_query($db,$query);
    confirm_result_set($rs);
    $result = mysqli_fetch_assoc($rs);
    mysqli_free_result($rs);
    return $result['total'];
}

function delete_subject($id){
    global $db;
    $query = "DELETE FROM SUBJECTS ";
    $query .= "WHERE ID = '" . $id . "' ";
    $query .= "LIMIT 1";
    return mysqli_query($db,$query); 
}

function delete_page($id){
    global $db;
    $query = "DELETE FROM PAGES ";
    $query .= "WHERE ID = '" . $id . "' ";
    $query .= "LIMIT 1";
    return mysqli_query($db,$query); 
}

?>