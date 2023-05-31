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

// Get Book Data
$borrowLists = $db->getConnection()->prepare("SELECT borrowers.id, books.name, borrowers.book_id, borrowers.borrow_date, borrowers.return_date, borrowers.actual_date FROM borrowers CROSS JOIN books ON borrowers.book_id = books.id WHERE borrowers.id = ?");
$borrowLists->bind_param('s', $id);
$borrowLists->execute();
$borrowListsResult = $borrowLists->get_result();
$borrowerData      = $borrowListsResult->fetch_assoc();

// Update book status
$db->update('books', ['availability' => 'available'], "id = {$borrowerData['book_id']}");

// Update borrower status,
$db->update('borrowers', ['actual_date' => date('Y-m-d H:i:s')], "id = '{$id}'");

// Add new penalty data if late
if(strtotime(date('Y-m-d')) > strtotime($borrowerData['return_date'])) {
  $return = new DateTime($borrowerData['return_date']);
  $today = new DateTime(date('Y-m-d'));
  $lateDiff = date_diff($today, $return);

  $fee = $lateDiff->d * 1500;

  $dataPenalty = [
    'borrower_id' => $user['id'],
    'book_id' => $borrowerData['book_id'],
    'penalty_fee' => $fee,
    'return_date' => date('Y-m-d H:i:s'),
    'paid_status' => 0,
    'paid_date' => null,
  ];

  $db->insert('penalties', $dataPenalty);
}

return header("Location: ../");