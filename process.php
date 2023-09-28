<!DOCTYPE html>
<html>

<head>
    <title>Passing JS Constant to PHP</title>
</head>

<body>
    <button id="sendConstant">Send Constant to PHP</button>
    <p id="result"></p>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    // Your JavaScript constant
    const MY_CONSTANT = "Hello from JavaScript";

    // AJAX request to send the constant to PHP
    $('#sendConstant').on('click', function() {
        $.ajax({
            url: 'process.php',
            method: 'POST',
            data: {
                constant: MY_CONSTANT
            },
            success: function(response) {
                $('#result').html(response);
            }
        });
    });
    </script>
    <?php
if(isset($_POST['constant'])){
    $receivedConstant = $_POST['constant'];
    echo "Received constant in PHP: " . $receivedConstant;
}
else{
    echo "Constant not received in PHP.";
}
?>

</body>

</html>