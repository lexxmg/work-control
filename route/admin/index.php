<?php

require $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php';

if ($_SERVER['REMOTE_ADDR'] == ACCESS_IP) {
    echo 'доступ разрешон';
} else {
    header("Location: /route/auth");
    exit;
}

if (isset($_POST['addKey'])) {
    $arrAccessKey[] = [
        'id' => uniqid($_POST['user']),
        'user' => $_POST['user'],
        'key' => $_POST['key']
    ];

    file_put_contents( $pathAccessKey, json_encode($arrAccessKey) );
    file_put_contents( $pathReguest, null );
    $reguestArr = [];
}

if (isset($_POST['deleteKey'])) {
    foreach ($arrAccessKey as $key => $value) {
        if ($value['id'] == $_POST['id']) {
            unset($arrAccessKey[$key]);
            break;
        }
    }

    file_put_contents( $pathAccessKey, json_encode(array_values($arrAccessKey)) );
}

if (isset($_POST['reject'])) {
    foreach ($reguestArr as $key => $value) {
        if ($value['key'] == $_POST['key']) {
            unset($reguestArr[$key]);
            break;
        }
    }

    file_put_contents( $pathReguest, json_encode(array_values($reguestArr)) );
}

?>

<h2 class="admin-subtitle">Запрос на добавление</h2>

<?php foreach ($reguestArr as $key => $value): ?>
    <form class="form-admin" method="post">
        <label for="" class="form-admin__label">Введите имя:
            <input class="form-admin__input" type="text" name="user">
        </label>

        <label for="" class="form-admin__label">key:
            <input class="form-admin__input" type="text" name="key" value="<?=$value['key']?>">
        </label>

        <button class="form-admin__btn" name="addKey">добавить</button>

        <button class="form-admin__btn" name="reject">отклонить</button>
    </form>
<?php endforeach; ?>

<h2 class="admin-subtitle">Доступ разрешон</h2>

<?php foreach ($arrAccessKey as $key => $value): ?>
    <form class="form-admin" method="post">
        <input hidden type="text" name="id" value="<?=$value['id']?>">

        <label for="" class="form-admin__label">Имя:
            <input class="form-admin__input" type="text" name="user" value="<?=$value['user']?>">
        </label>

        <label for="" class="form-admin__label">key:
            <input class="form-admin__input" type="text" name="key" value="<?=$value['key']?>">
        </label>

        <button class="form-admin__btn" name="deleteKey">удалить</button>
    </form>
<?php endforeach; ?>

<? require $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php'?>
