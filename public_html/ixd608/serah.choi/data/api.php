<?php
include "../lib/php/functions.php";

header("Content-Type: application/json; charset=utf-8");

$type = isset($_GET['type']) ? $_GET['type'] : 'all';
$conn = makeConn();

$rows = [];

switch ($type) {
    case 'search':
        $q = isset($_GET['q']) ? trim($_GET['q']) : '';
        if ($q !== '') {
            $safe = $conn->real_escape_string($q);
            $rows = makeQuery($conn, "SELECT * FROM products WHERE name LIKE '%{$safe}%' OR description LIKE '%{$safe}%' OR category LIKE '%{$safe}%'");
        } else {
            $rows = makeQuery($conn, "SELECT * FROM products ORDER BY id ASC");
        }
        break;

    case 'filter':
        $column = isset($_GET['column']) ? $_GET['column'] : 'category';
        $value = isset($_GET['value']) ? trim($_GET['value']) : '';
        $allowed_columns = ['category'];
        if (!in_array($column, $allowed_columns, true)) {
            $column = 'category';
        }
        if ($value !== '' && strtolower($value) !== 'all') {
            $safe_val = $conn->real_escape_string($value);
            $rows = makeQuery($conn, "SELECT * FROM products WHERE {$column} = '{$safe_val}'");
        } else {
            $rows = makeQuery($conn, "SELECT * FROM products ORDER BY id ASC");
        }
        break;

    case 'sort':
        $sort = isset($_GET['sort']) ? $_GET['sort'] : 'default';
        switch ($sort) {
            case 'price_asc':
                $order = "price ASC";
                break;
            case 'price_desc':
                $order = "price DESC";
                break;
            case 'name_asc':
                $order = "name ASC";
                break;
            case 'name_desc':
                $order = "name DESC";
                break;
            default:
                $order = "id ASC";
                break;
        }
        $rows = makeQuery($conn, "SELECT * FROM products ORDER BY {$order}");
        break;

    case 'all':
    default:
        $rows = makeQuery($conn, "SELECT * FROM products ORDER BY id ASC");
        break;
}

$conn->close();

if (!is_array($rows)) {
    $rows = [];
}

echo json_encode($rows);