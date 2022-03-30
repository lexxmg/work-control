
<?php require($_SERVER['DOCUMENT_ROOT'] . '/templates/header.php') ?>

<?php
if (getallheaders()["Authorization"] != 'Bearer 123') {
    header("Location: /route/auth");
    exit;
}
?>

<div class="content-control">
  <button class="content-control__btn">on/off</button>
</div>

<?php require($_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php') ?>
