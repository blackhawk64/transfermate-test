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

    public function ListOfAuthors()
    {
        try {
            $query = $this->db->prepare("SELECT id, author
	                                    FROM authors");

            $query->execute();

            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return -1;
        }
    }

    public function CreateAuthor($author)
    {
        try {
            $query = $this->db->prepare("INSERT INTO authors (author) VALUES (:author)");
            $query->bindParam(':author', $author, PDO::PARAM_STR, 50);
            $query->execute();

            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function CreateBook($title, $author)
    {
        try {
            $query = $this->db->prepare("INSERT INTO books (title, author_fk) VALUES (:title, :author)");
            $query->bindParam(':title', $title, PDO::PARAM_STR, 100);
            $query->bindParam(':author', $author, PDO::PARAM_INT);

            return $query->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    public function UpdateAuthor($author, $id)
    {
        try {
            $query = $this->db->prepare("UPDATE authors SET
                                                author = :author
                                        WHERE id = :id");
            $query->bindParam(':author', $author, PDO::PARAM_STR, 50);
            $query->bindParam(':id', $id, PDO::PARAM_INT);

            return $query->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    public function UpdateBook($title, $id, $author)
    {
        try {
            $query = $this->db->prepare("UPDATE books SET
                                                title = :title
                                                ,author_fk = :author
                                        WHERE id = :id");
            $query->bindParam(':title', $title, PDO::PARAM_STR, 100);
            $query->bindParam(':author', $author, PDO::PARAM_INT);
            $query->bindParam(':id', $id, PDO::PARAM_INT);

            return $query->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * @param mixed $searchValue Value to search into the records
     * @param int $type 1 to search by ID (integer); 2 to search by author name (string)
     * @return boolean|array If an error occurs, function will return -1; else record (array) is expected
     */
    public function IfAuthorExists($searchValue, $type = 1)
    {
        try {
            $searchType = $type == 1 ? "WHERE id = {$searchValue}" : "WHERE author ILIKE '%{$searchValue}'";
            $query = $this->db->prepare("SELECT id
	                                    FROM authors
                                        {$searchType}
                                        LIMIT 1");

            $query->execute();

            return $query->fetch();
        } catch (PDOException $e) {
            return -1;
        }
    }

    /**
     * @param mixed $searchValue Value to search into the records
     * @param int $type 1 to search by ID (integer); 2 to search by author name (string)
     * @return boolean|array If an error occurs, function will return -1; else record (array) is expected
     */
    public function IfBookExists($searchValue, $type = 1)
    {
        try {
            $searchType = $type == 1 ? "WHERE id = {$searchValue}" : "WHERE title ILIKE '%{$searchValue}'";
            $query = $this->db->prepare("SELECT id, author_fk
                                        FROM books
                                        {$searchType}
                                        LIMIT 1");

            $query->execute();

            return $query->fetch();
        } catch (PDOException $e) {
            return -1;
        }
    }

    public function GetAllRecords()
    {
        try {
            $query = $this->db->prepare("SELECT ath.author, bkk.title
                                        FROM authors ath
                                        LEFT JOIN books bkk ON bkk.author_fk = ath.id");

            $query->execute();

            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return -1;
        }
    }

    /**
     * @param mixed $searchValue Value to search into the records
     * @param int $type 1 to search by ID (integer); 2 to search by author name (string)
     * @return boolean|array If an error occurs, function will return -1; else records (array) are expected
     */
    public function GetAllBooksByAuthor($searchValue, $type = 1)
    {
        try {
            $searchType = $type == 1 ? "WHERE ath.id = {$searchValue}" : "WHERE ath.author ILIKE '%{$searchValue}'";
            $query = $this->db->prepare("SELECT ath.author, bkk.title
                                        FROM authors ath
                                        LEFT JOIN books bkk ON bkk.author_fk = ath.id
                                        {$searchType}");

            $query->execute();

            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return -1;
        }
    }
}