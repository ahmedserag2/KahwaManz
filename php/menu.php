<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
  </head>
  <style media="screen">
    .add{
      background-color: #954B00;
      border-color: #954B00;
      border-radius: 8px;
      padding: 6px;
    }
  </style>
  <body>
    <table>
    <?php
      include_once 'classes.php';
      $drinks = new Drink(0);
      $drinks = $drinks->select_all();
      foreach ($drinks as $drink) {
        $drink->display_menu_item();
      }
    ?>
    </table>

  </body>
</html>
