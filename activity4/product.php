<?php

require_once "databases.php";

class Product
{
    public $title = "";
    public $author = "";
    public $genre = "";
    public $publication_year = "";
    public $publisher = "";
    public $copies = "";

    protected $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function addbook()
    {
        $sql = "INSERT INTO books (title, author, genre, publication_year, publisher, copies) VALUES (:title, :author, :genre, :publication_year, :publisher, :copies)";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(":title", $this->title);
        $query->bindParam(":author", $this->author);
        $query->bindParam(":genre", $this->genre);
        $query->bindParam(":publication_year", $this->publication_year);
        $query->bindParam(":publisher", $this->publisher);
        $query->bindParam(":copies", $this->copies);

        return $query->execute();
    }

    public function viewbook($q = null, $genre = null)
    {
        $conn = $this->db->connect();

        $where = [];
        $params = [];

        if ($q !== null && $q !== '') {
            $where[] = "(title LIKE :t OR author LIKE :t OR genre LIKE :t)";
            $params[':t'] = '%' . $q . '%';
        }

        if ($genre !== null && $genre !== '') {
            $where[] = "genre = :g";
            $params[':g'] = $genre;
        }

        $sql = "SELECT * FROM books";
        if (!empty($where)) {
            $sql .= ' WHERE ' . implode(' AND ', $where);
        }
        $sql .= " ORDER BY title ASC";

        $query = $conn->prepare($sql);
        foreach ($params as $k => $v) {
            $query->bindValue($k, $v, PDO::PARAM_STR);
        }

        if ($query->execute())
            return $query->fetchAll(PDO::FETCH_ASSOC);
        return null;
    }
}

//$obj = new Product();
//$obj->name = "TV XX1";
//$obj->category = "Home Appliance";
//$obj->price = 1200;
//var_dump($obj->addProduct());