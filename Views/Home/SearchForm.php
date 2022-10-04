<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?php echo constant('BASE_URL'); ?>assets/style.css">
    <title>TransferMate Test</title>
</head>

<body>
    <table border="1">
        <tr>
            <td>
                <form action="<?php echo constant('BASE_URL'); ?>Home/SearchBooks" id="SearchForm">
                    <label for="ListAuthors"><b>Search author: </b></label>
                    <input list="Authors" id="ListAuthors" name="ListAuthors">
                    <datalist id="Authors">
                        <?php foreach ($this->Authors as $author) : ?>
                            <option value="<?php echo $author['author']; ?>" data-id="<?php echo $author['id']; ?>">
                            <?php endforeach ?>
                    </datalist>
                    <button type="submit">Search</button>
                    <button type="button" id="AllRecords">Load all records</button>
                    <br>
                    <div style="padding-top: 25px;">
                        <a href="<?php echo constant('BASE_URL'); ?>" class="btn"><strong>Go Back</strong></a>
                    </div>
                </form>
            </td>
            <td>
                <table id="SearchResults" border="1">
                    <thead>
                        <tr>
                            <td>
                                <center><b>Author</b></center>
                            </td>
                            <td>
                                <center><b>Title</b></center>
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        <!--Content here-->
                    </tbody>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
<script>
    const FormElement = document.getElementById("SearchForm");
    let request = new XMLHttpRequest();

    request.onreadystatechange = function(response) {
        if (request.readyState === 4) {
            try {
                let ResponseFromEndPoint = JSON.parse(request.responseText);
                if (request.status === 200) {
                    let TableResults = document.getElementById('SearchResults').getElementsByTagName('tbody')[0];
                    TableResults.innerHTML = "";
                    for (let item in ResponseFromEndPoint.message) {
                        setTimeout(function() {
                            let NewRow = TableResults.insertRow();
                            let Author = NewRow.insertCell(0);
                            let Title = NewRow.insertCell(1);
                            NewRow.classList.add("NewRecord");

                            Author.innerHTML = ResponseFromEndPoint.message[item].author;
                            Title.innerHTML = ResponseFromEndPoint.message[item].title;
                        }, 1000 * item);
                    }
                }

                if (request.status != 200) {
                    alert("Something went wrong!\nDetails: " + ResponseFromEndPoint.message + "\nError code: " + ResponseFromEndPoint.code);
                }
            } catch (e) {
                alert("Something went wrong!\nReload the page and try again");
            }
        }
    }

    FormElement.onsubmit = function(e) {
        e.preventDefault();
        let DataList = document.getElementById("ListAuthors");

        if (DataList.value.length > 0) {
            let FormData = {
                'Author': DataList.value
            };

            let AuthorId = document.querySelector('option[value="' + DataList.value + '"]');

            if (AuthorId !== null) {
                FormData.AuthorId = AuthorId.getAttribute("data-id");
            }

            request.open('POST', FormElement.getAttribute("action"), true);
            request.setRequestHeader('Content-Type', 'application/json; charset=UTF-8');
            request.send(JSON.stringify(FormData));

            request.onerror = function() {
                alert("Something went wrong!");
            }
        } else {
            alert("You must fill the input");
        }
    };

    const AllRecords = document.getElementById("AllRecords");

    AllRecords.onclick = function(e) {
        request.open('GET', "<?php echo constant('BASE_URL'); ?>Home/AllRecords", true);
        request.send();

        request.onerror = function() {
            alert("Something went wrong!");
        }
    }
</script>