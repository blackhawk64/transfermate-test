<?php
require_once 'config/Controller.php';
require_once 'Helpers/ReadXml.php';
require_once 'Models/BooksModel.php';

class LoadInformationController extends Controller
{
    private $MainDirectory;

    public function __construct()
    {
        parent::__construct();
        $this->MainDirectory = 'main-dir';
    }

    public function Index()
    {
        $this->View->FinalReport = $this->ReadAndLoadXml();
        $this->View->Render("LoadInformation/Index");
    }

    public function ReadAndLoadXml()
    {
        $Records = array();
        $FinalReport = array("NewAuthors" => 0, "UpdatedAuthors" => 0, "NewBooks" => 0, "UpdatedBooks" => 0
                            ,"ErrorsCreating" => 0, "ErrorsUpdating" => 0);
        $getDirectories = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($this->MainDirectory)
        );

        # Search for the records through XML files
        foreach ($getDirectories as $pathname => $file) {
            $Records = ReadXml::ReadXml($file);
        }

        # Once records were founded, check if the final array is bigger than zero to perform
        # actions on the database
        if (count($Records) > 0 && isset($Records['book'])) {
            $BooksModel = new BooksModel();

            foreach ($Records['book'] as $book) {
                if (isset($book->author)) {
                    # Check for author first
                    $AuthorCreated = -1;
                    $AuthorExists = is_numeric((string)$book->author) ? $BooksModel->IfAuthorExists((int)$book->author) : $BooksModel->IfAuthorExists((string)$book->author, 2);

                    if ($AuthorExists == false && !is_numeric((string)$book->author)) {
                        $AuthorCreated = $BooksModel->CreateAuthor((string)$book->author);
                        # For the log
                        if ($AuthorCreated != -1) {
                            $FinalReport['NewAuthors'] += 1;
                        } else {
                            $FinalReport['ErrorsCreating'] += 1;
                        }
                    } elseif ($AuthorExists != false && !is_numeric((string)$book->author)) {
                        if ($BooksModel->UpdateAuthor((string)$book->author, $AuthorExists['id'])) {
                            $AuthorCreated = $AuthorExists['id'];
                            $FinalReport['UpdatedAuthors'] += 1;
                        } else {
                            $FinalReport['ErrorsUpdating'] += 1;
                        }
                    }

                    if (isset($book->name)) {
                        # Check if a valid author was created or updated
                        if ($AuthorExists != -1) {
                            # Check for book
                            $BookExists = is_numeric((string)$book->name) ? $BooksModel->IfBookExists((int)$book->name) : $BooksModel->IfBookExists((string)$book->name, 2);
                            if ($BookExists == false) {
                                # For the log
                                if ($BooksModel->CreateBook((string)$book->name, $AuthorCreated)) {
                                    $FinalReport['NewBooks'] += 1;
                                } else {
                                    $FinalReport['ErrorsCreating'] += 1;
                                }
                            } elseif ($BookExists != false && !is_numeric((string)$book->name)) {
                                if ($BooksModel->UpdateBook((string)$book->name, $BookExists['id'], $AuthorCreated)) {
                                    $FinalReport['UpdatedBooks'] += 1;
                                } else {
                                    $FinalReport['ErrorsUpdating'] += 1;
                                }
                            }
                        }
                    }
                }
            }
        }

        return $FinalReport;
    }
}