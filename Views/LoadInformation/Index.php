<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?php echo constant('BASE_URL'); ?>assets/style.css">
    <title>TransferMate Test - Load Information</title>
</head>

<body>
    <div class="center-div">
        <h3 class="center">Final Report:</h3>
        <div class="center">
            <table border="1" class="bordered-table">
                <thead>
                    <tr>
                        <td>
                            <center><b>Action</b></center>
                        </td>
                        <td>
                            <center><b>Total</b></center>
                        </td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>New Authors Created</td>
                        <td><?php echo $this->FinalReport['NewAuthors']; ?></td>
                    </tr>
                    <tr>
                        <td>Updated Authors</td>
                        <td><?php echo $this->FinalReport['UpdatedAuthors']; ?></td>
                    </tr>
                    <tr>
                        <td>New Books Created</td>
                        <td><?php echo $this->FinalReport['NewBooks']; ?></td>
                    </tr>
                    <tr>
                        <td>Updated Books</td>
                        <td><?php echo $this->FinalReport['UpdatedBooks']; ?></td>
                    </tr>
                    <tr>
                        <td>Errors while creating new records</td>
                        <td><?php echo $this->FinalReport['ErrorsCreating']; ?></td>
                    </tr>
                    <tr>
                        <td>Errors while updating records</td>
                        <td><?php echo $this->FinalReport['ErrorsUpdating']; ?></td>
                    </tr>
                </tbody>
            </table>

            <div style="padding-top: 20px;">
                <a href="<?php echo constant('BASE_URL'); ?>" class="btn"><strong>Go back</strong></a>
            </div>
        </div>
    </div>
</body>

</html>