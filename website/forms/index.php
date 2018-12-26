<html>
  <head>
    <title>Guestbook</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="stylesheet" type="text/css" href="../style/table.css">
    <meta charset="UTF-8">
  </head>
  <body>
    <h2>Sign my guestbook</h2>
    <?php
      if (isset($_POST['form_submitted'])){
      include('select.php');
      exit("You have already submitted");
      }
      
      ?>
    <form action="insert.php" method="POST">
      Your name:
      <input type="text" name="vname">
      <br> Company name:
      <input type="text" name="company">
      <input type="hidden" name="form_submitted" value="1" />
      <input type="submit" value="Submit">
    </form>
    <form action="truncate.php" method="POST">
      <input type="submit" value="TRUNCATE TABLE">
    </form>
  </body>
</html>
