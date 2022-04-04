<?php

require $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php';

var_dump($first);
var_dump($admin);

if ( empty($arrAccessKey) || $first || $admin) {
    //echo 'доступ разрешон';
} else {
    header("Location: /route/auth");
    exit;
}

if (isset($_POST['addKey'])) {
    $arrAccessKey[] = [
        'id' => uniqid($_POST['user']),
        'out' => $_POST['out'],
        'user' => $_POST['user'],
        'key' => $_POST['key'],
        'admin' => false,
        'first' => empty($arrAccessKey)
    ];

    file_put_contents( $pathAccessKey, json_encode($arrAccessKey, JSON_UNESCAPED_UNICODE) );
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

    file_put_contents( $pathAccessKey, json_encode(array_values($arrAccessKey), JSON_UNESCAPED_UNICODE) );
}

if (isset($_POST['reject'])) {
    foreach ($reguestArr as $key => $value) {
        if ($value['key'] == $_POST['key']) {
            unset($reguestArr[$key]);
            break;
        }
    }

    file_put_contents( $pathReguest, json_encode(array_values($reguestArr), JSON_UNESCAPED_UNICODE) );
}

if (isset($_POST['editKeyName'])) {
    $post = $_POST;
    $keyName = [];

    foreach ($post as $key => $value) {
        if (is_array($value)) {
            $arr = array_values($value);
        }

        $keyName[$arr[0]] = [
            'name' => $arr[1],
            'rev' => isset($arr[2])
        ];
    }
    file_put_contents( $pathOutName, json_encode($keyName, JSON_UNESCAPED_UNICODE) );
    $outName = json_decode(file_get_contents($pathOutName), true);
}

?>

<h2 class="admin-subtitle">Название выходов</h2>

<form class="admin__form-out-name admin-form-out-name" method="post">
    <?php foreach ($outName as $key => $value): ?>
        <div class="admin-form-out-name__container">
            <label class="admin-form-out-name__label">OUT-<?=$key?>:
                <input class="admin-form-out-name__input"  type="text" name="<?=$key?>['key']" value="<?=$key?>" hidden>
            </label>

            <label class="admin-form-out-name__label">Название:
                <input class="admin-form-out-name__input"  type="text" name="<?=$key?>['name']" value="<?=$value['name']?>">
            </label>

            <label class="admin-form-out-name__label">Реверс:
                <input class="admin-form-out-name__input"  type="checkbox" name="<?=$key?>['rev']" <?=$value['rev'] ? 'checked' : ''?>>
            </label>
        </div>
    <?php endforeach; ?>

    <button class="admin-form-out-name__btn" name="editKeyName">Изменить</button>
</form>

<h2 class="admin-subtitle">Запрос на добавление</h2>

<?php foreach ($reguestArr as $key => $value): ?>
    <form class="form-admin" method="post">
        <label for="" class="form-admin__label">Введите имя:
            <input class="form-admin__input" type="text" name="user">
        </label>

        <label for="" class="form-admin__label">OUT через запятую:
            <input class="form-admin__input" type="text" name="out">
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

        <label for="" class="form-admin__label">OUT:
            <input class="form-admin__input" type="text" name="user" value="<?=$value['out']?>">
        </label>

        <label for="" class="form-admin__label">key:
            <input class="form-admin__input"
                type="<?=$first || !$value['first'] ? 'text' : 'password'?>"
                name="key"
                value="<?=$value['key']?>
            ">
        </label>

        <?php if ($value['first']): ?>
            <span class="form-admin__text">master</span>
        <?php else: ?>
            <label for="" class="form-admin__label">admin:
                <input class="form-admin__input" type="checkbox" name="admin">
            </label>

            <button class="form-admin__btn" name="deleteKey">удалить</button>
        <?php endif; ?>
    </form>
<?php endforeach; ?>

<? require $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php'?>
