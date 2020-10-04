<!DOCTYPE html>
<html>
<head>
    <title>DATA TABLE</title>

    <script type="text/javascript" src="jquery-1.12.4.js"></script>
    <script type="text/javascript" src="jquery.dataTables.min.js"></script>

    <link href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css" rel="stylesheet">
</head>
<body>
<?php
require_once 'koneksi.php'; //include required dbconfig file
?>
<table id="example" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Kode</th>
                <th>Type</th>
                <th>Question</th>
                <th>Answers</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>Kode</th>
                <th>Type</th>
                <th>Question</th>
                <th>Answers</th>
            </tr>
        </tfoot>
        <tbody>
            <tr>
            <?php
                //sanitize post value
                if(isset($_POST["page"])){
                 $page_number = filter_var($_POST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
                 if(!is_numeric($page_number)){die('Invalid page number!');} //incase of invalid page number
                }else{
                 $page_number = 1;
                }

                //get current starting point of records
                $position = (($page_number-1) * $item_per_page);

                $results = $db->prepare("SELECT * FROM tbl_question ORDER BY kode ASC LIMIT $position, $item_per_page");
                $results->execute();

                //getting results from database

                while($row = $results->fetch(PDO::FETCH_ASSOC))
                {
                ?>
                <td><?php echo $row['kode']; ?></td>
                <td><input type="text" id="row-1-age" name="row-1-age" value="<?php echo $row['type']; ?>"></td>
                <td><input type="text" id="row-1-position" name="row-1-position" value="<?php echo $row['question']; ?>"></td>
                <td><input type="text" id="row-1-position" name="row-1-position" value="<?php echo $row['answer']; ?>"></td>
                <?php
                    }
                ?>
            </tr>
        </tbody>
    </table>

    <script type="text/javascript">
        $(document).ready(function() {
    var table = $('#example').DataTable();
 
    $('button').click( function() {
        var data = table.$('input, select').serialize();
        alert(
            "The following data would have been submitted to the server: \n\n"+
            data.substr( 0, 120 )+'...'
        );
        return false;
    } );
} );
    </script>
</body>
</html>