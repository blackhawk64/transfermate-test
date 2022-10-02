<?php
require 'config/Database.php';

class BooksModel
{
    public $db;

    public function __construct()
    {
        $DbInstance = new Database();
        $this->db = $DbInstance->Connect();
    }

    public function CreateAuthor($author)
    {
        try {
            $query = $this->db->prepare("INSERT INTO authors (author) VALUES (:author)");
            $query->bindParam(':author', $author, PDO::PARAM_STR, 50);

            return $query->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    public function CreateBook()
    {
        try {
            $query = $this->db->prepare("INSERT INTO books (title, author_fk) VALUES (:title, :author)");
            $query->bindParam(':title', $author, PDO::PARAM_STR, 100);
            $query->bindParam(':author', $author, PDO::PARAM_INT);

            return $query->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * @param mixed $searchValue Value to search into the records
     * @param int $type 1 to search by ID (integer); 2 to search by author name (string)
     * @return boolean|int If an error occurs, function will return -1; else boolean value is expected
     */
    public function IfAuthorExists($searchValue, $type = 1)
    {
        try {
            $searchType = $type == 1 ? "WHERE id = {$searchValue}" : "WHERE LOWER(author) = LOWER('{$searchValue}')";
            $query = $this->db->prepare("SELECT EXISTS(
                                        SELECT 1
                                        FROM authors
                                        {$searchType}");

            $query->execute();

            return $query->fetch();
        } catch (PDOException $e) {
            return -1;
        }
    }

    /**
     * @param mixed $searchValue Value to search into the records
     * @param int $type 1 to search by ID (integer); 2 to search by author name (string)
     * @return boolean|int If an error occurs, function will return -1; else boolean value is expected
     */
    public function IfBookExists($searchValue, $type = 1)
    {
        try {
            $searchType = $type == 1 ? "WHERE id = {$searchValue}" : "WHERE LOWER(title) = LOWER('{$searchValue}')";
            $query = $this->db->prepare("SELECT EXISTS(
                                        SELECT 1
                                        FROM books
                                        {$searchType}");

            $query->execute();

            return $query->fetch();
        } catch (PDOException $e) {
            return -1;
        }
    }
}