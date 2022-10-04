<?php
require_once 'config/Controller.php';
require 'Models/BooksModel.php';

class HomeController extends Controller
{
    private $BooksModel;

    public function __construct()
    {
        parent::__construct();
        $this->BooksModel = new BooksModel();
    }

    public function Index()
    {
        $this->View->Render("Home/Index");
    }

    public function Error()
    {
        $this->View->Render("Home/Error");
    }

    public function SearchForm()
    {
        $this->View->Authors = $this->BooksModel->ListOfAuthors();
        $this->View->Render("Home/SearchForm");
    }

    public function SearchBooks()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $FormInfo = json_decode(file_get_contents('php://input'), true);
            $Records = -1;

            if (!isset($FormInfo['Author'])) {
                header("HTTP/1.1 500 Internal Server Error");
                header("Content-Type: application/json");
                echo json_encode(array(
                    "message" => "One or more data expected doesn't exists",
                    "code" => 500
                ), JSON_FORCE_OBJECT);
            }

            if (!isset($FormInfo['AuthorId'])) {
                $Records = $this->BooksModel->GetAllBooksByAuthor($FormInfo['Author'], 2);
            }else{
                $Records = $this->BooksModel->GetAllBooksByAuthor($FormInfo['AuthorId']);
            }

            if ($Records != -1) {
                header("HTTP/1.1 200 OK");
                header("Content-Type: application/json");

                echo json_encode(array(
                    "message" => $Records,
                    "code" => 200
                ), JSON_FORCE_OBJECT);
            }

            if ($Records == -1) {
                header("HTTP/1.1 500 Internal Server Error");
                header("Content-Type: application/json");

                echo json_encode(array(
                    "message" => "Internal Server Error",
                    "code" => 405
                ), JSON_FORCE_OBJECT);
            }
        } else {
            header("HTTP/1.1 405 Method Not Allowed");
            header("Content-Type: application/json");
            echo json_encode(array(
                "message" => "This request isn't a POST one.",
                "code" => 405
            ), JSON_FORCE_OBJECT);
        }
    }

    public function AllRecords()
    {
        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            $Records = $this->BooksModel->GetAllRecords();

            if ($Records != -1) {
                header("HTTP/1.1 200 OK");
                header("Content-Type: application/json");

                echo json_encode(array(
                    "message" => $Records,
                    "code" => 200
                ), JSON_FORCE_OBJECT);
            }

            if ($Records == -1) {
                header("HTTP/1.1 500 Internal Server Error");
                header("Content-Type: application/json");

                echo json_encode(array(
                    "message" => "Internal Server Error",
                    "code" => 405
                ), JSON_FORCE_OBJECT);
            }
        } else {
            header("HTTP/1.1 405 Method Not Allowed");
            header("Content-Type: application/json");

            echo json_encode(array(
                "message" => "This request isn't a GET one.",
                "code" => 405
            ), JSON_FORCE_OBJECT);
        }
    }
}