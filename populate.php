<?php require_once('connection.php'); ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Populate Database with gifts</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <style>
        body{
            padding-top: 10px;
        }
        .haha{
            width:50%;
        }


    </style>

</head>
<body>

<form action="database.php" method="post" name="giftinfo" enctype="multipart/form-data">

    <label for="name">GiftName:</label>
    <input class="haha" type="name" name="name" id="name" required><br>

    <label for="price">Price:</label>
    <input class="haha" type="number" name="price" id="price" min="0" step="0.01" required><br>

    <label for="url">link url:</label>
    <input class="haha" type="url" name="url" id="url" required><br>

    <label for="popularity">Popularity:</label>
    <select name="popularity" id="popularity">
        <option value="not popular">not popular</option>
        <option value="soso">soso</option>
        <option value="popular">popular</option>
        <option value="very popular">very popular</option>
    </select><br>

    <label for="age">Age: From </label>
    <input type="number" name="age" id="age" min="0" step="1" value="100" style="width:10%" required>
    <label for="to">To </label>
    <input type="number" name="to" id="to" min="0" step="1" value="100" style="width:10%" required><br>

    <label>Image: </label>
    <input type="file" name="fileToUpload" id="fileToUpload" required><br>

    <label for="tags">Tags: (Add tags if not exist yet:</label>
    <input type="text" id="tags" name="tags" style="width:10%">
    <button type="button" id="addbut">Add</button><br>
    <div id="typesbox">

        <!--need to retrive data from database-->
        <?php


        $query = "SELECT * FROM gifttype;";
        $result = mysqli_query($conn,$query);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<br><input type="checkbox" value=' .   $row['name'] . ' name="type[]" style="width:auto;">' . $row['name'];
            }
        }
        ?>
    </div>

    <button type="submit" name="submit">Submit</button>




</form>



<script>

$('#addbut').click(function () {
    var $tag=$('#tags').val();

    $.ajax({
        url: 'insertgifttype.php',
        type: 'post',
        data: {'tag': $tag},
        success: function(data, status) {
            $( "#typesbox" ).append(data);
        },
        error: function(xhr, desc, err) {
            console.log(xhr);
            console.log("Details: " + desc + "\nError:" + err);
        }
    });
});

</script>

</body>
</html>