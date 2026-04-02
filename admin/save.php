<?php
session_start();
if (!isset($_SESSION['logged'])) {
    header("Location: index.php");
    exit;
}

$path = "../people.json";
$people = json_decode(file_get_contents($path), true);
if (!is_array($people)) $people = [];

$action = $_POST['action'] ?? '';
$i = $_POST['index'] ?? null;

if ($action === "add") {
    $people[] = [
        "name" => trim($_POST['name']),
        "phone" => trim($_POST['phone'])
    ];
}

if ($action === "update" && $i !== null) {
    $people[$i]['name'] = trim($_POST['name']);
    $people[$i]['phone'] = trim($_POST['phone']);
}

if ($action === "delete" && $i !== null) {
    unset($people[$i]);
    $people = array_values($people);
}

if ($action === "move_up" && $i > 0) {
    $temp = $people[$i];
    $people[$i] = $people[$i - 1];
    $people[$i - 1] = $temp;
}

if ($action === "move_down" && $i < count($people) - 1) {
    $temp = $people[$i];
    $people[$i] = $people[$i + 1];
    $people[$i + 1] = $temp;
}

file_put_contents($path, json_encode($people, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

header("Location: dashboard.php");
exit;