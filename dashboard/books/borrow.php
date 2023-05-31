<?php

use Inc\XssProtection;

require_once "../../inc/include.php";

// User Middleware
if(!$auth->getUser()) {
  $_SESSION['errors'] = ['Sorry! You are not allowed to access that page before you authenticated!'];
  return header("Location: ../../login.php");
}

// User get Data
$user = $auth->getUser();

// Insertion process
$id = XssProtection::validateInput($_GET['id']);

// Check the book listing to avoid bug references
$bookLists = $db->getConnection()->prepare("SELECT * FROM books WHERE id = ? AND availability = 'available'");
$bookLists->bind_param('s', $id);
$bookLists->execute();
$bookListsResult = $bookLists->get_result();
if($bookListsResult->num_rows) {
  $data = [
    'borrower_id' => $user['id'],
    'book_id' => $id,
    'borrow_date' => date('Y-m-d H:i:s'),
    'return_date' => date('Y-m-d H:i:s', time() + (86400 * 7)), // Add 7 day borrow
    'actual_date' => null,
  ];
  $db->insert('borrowers', $data);
  $db->update('books', ['availability' => 'borrowed'], "id = {$id}");

  return header("Location: ../my-borrows");
} else {
  return header("Location: ./");
}