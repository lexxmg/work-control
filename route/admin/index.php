<?php

require $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php';

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

if (isset($_POST['editKey'])) {
    $out = $_POST['out'];
    $user = $_POST['user'];
    $admin = isset($_POST['admin']);

    foreach ($arrAccessKey as $key => $value) {
        if ($value['id'] == $_POST['id']) {
            $arrAccessKey[$key]['out'] = $out;
            $arrAccessKey[$key]['user'] = $user;
            $arrAccessKey[$key]['admin'] = $admin;
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

if (isset($_POST['refresh'])) {
    $newKey = explode(':', $_POST['key']);

    foreach ($arrAccessKey as $key => $value) {
        if ($value['id'] == $newKey[0]) {
            $arrAccessKey[$key]['key'] = $newKey[1];
            break;
        }
    }

    file_put_contents( $pathAccessKey, json_encode(array_values($arrAccessKey), JSON_UNESCAPED_UNICODE) );
}

?>
<a href="/" class="admin__link">Главная</a>

<h2 class="admin-subtitle">Название выходов</h2>

<form class="admin__form-out-name admin-form-out-name" method="post">
    <table class="admin-form-out-name__table admin-form-out-name-table">
        <tr class="admin-form-out-name-table__tr">
            <th class="admin-form-out-name-table__th">Выход</th>
            <th class="admin-form-out-name-table__th">Имя кнопки</th>
            <th class="admin-form-out-name-table__th">Реверс</th>
        </tr>

        <?php foreach ($outName as $key => $value): ?>
            <tr class="admin-form-out-name-table__tr">
                <td class="admin-form-out-name-table__td">
                    <label class="admin-form-out-name__label">OUT-<?=$key?>:
                        <input class="admin-form-out-name__input"  type="text" name="<?=$key?>['key']" value="<?=$key?>" hidden>
                    </label>
                </td>

                <td class="admin-form-out-name-table__td">
                    <input class="admin-form-out-name__input"  type="text" name="<?=$key?>['name']" value="<?=$value['name']?>">
                </td>

                <td class="admin-form-out-name-table__td">
                    <input class="admin-form-out-name__input"  type="checkbox" name="<?=$key?>['rev']" <?=$value['rev'] ? 'checked' : ''?>>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <button class="admin-form-out-name__btn" name="editKeyName">Изменить</button>
</form>

<?php if (!empty($reguestArr)): ?>
    <div class="admin-adding-card">
        <div class="admin-adding-card__top">
            <h2 class="admin-adding-card__subtitle">Запрос на добавление</h2>
        </div>

        <div class="admin-adding-card__body">
            <?php foreach ($reguestArr as $key => $value): ?>
                <div class="admin-adding-card__form-container">
                    <form class="admin-adding-card__form admin-adding-card-form" method="post">
                        <time class="admin-adding-card-form__time"><?=$value['date']?></time>

                        <label class="admin-adding-card-form__label">Введите имя:
                            <input class="admin-adding-card-form__input" type="text" name="user">
                        </label>

                        <label class="admin-adding-card-form__label">OUT через запятую:
                            <input class="admin-adding-card-form__input" type="text" name="out">
                        </label>

                        <label  class="admin-adding-card-form__label">key:
                            <input class="admin-adding-card-form__input" type="text" name="key" value="<?=$value['key']?>">
                        </label>

                        <div class="admin-adding-card-form__btn-container">
                            <button class="admin-adding-card-form__btn" name="addKey">добавить</button>

                            <button class="admin-adding-card-form__btn" name="reject">отклонить</button>
                        </div>
                    </form>

                    <form class="admin-adding-card__form admin-adding-card-form-refresh" method="post">
                        <label class="admin-adding-card-form-refresh__label">Обновить ключ у пользователя:
                            <select class="admin-adding-card-form-refresh__select" name="key">
                                <?php foreach ($arrAccessKey as $key => $userRefrech): ?>
                                    <option class="admin-adding-card-form-refresh__option"
                                        value="<?=$userRefrech['id']?>:<?=$value['key']?>"
                                    ><?=$userRefrech['user']?></option>
                                <?php endforeach; ?>
                            </select>
                        </label>

                        <div class="admin-adding-card-form-refresh__btn-container">
                            <button class="admin-adding-card-form-refresh__btn" name="refresh">Обновить</button>
                        </div>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>

<h2 class="admin-subtitle">Доступ разрешон</h2>

<div class="admin-access-card-container">
    <?php foreach ($arrAccessKey as $key => $value): ?>
        <div class="admin-access-card">
            <div class="admin-access-card__top" data-btn="top">
                <h3 class="admin-access-card__title" data-btn="title"><?=$value['user']?></h3>

                <div class="admin-access-card__top-btn-container admin-access-card-top-btn-container">
                    <button class="admin-access-card-top-btn-container__btn"
                      data-btn="btn"
                      aria-label="карточка"
                      aria-expanded="false"
									    aria-controls="card"
                    >></button>
                </div>
            </div>

            <div class="admin-access-card__body admin-access-card__body--hidden" id="card" data-btn="card">
                <form class="form-admin" method="post">
                    <input hidden type="text" name="id" value="<?=$value['id']?>">

                    <label  class="form-admin__label">Имя:
                        <input class="form-admin__input" type="text" name="user" value="<?=$value['user']?>">
                    </label>

                    <label  class="form-admin__label">OUT:
                        <input class="form-admin__input" type="text" name="out" value="<?=$value['out']?>">
                    </label>

                    <label  class="form-admin__label">key:
                        <input class="form-admin__input"
                            disabled
                            type="<?=$first || !$value['first'] ? 'text' : 'password'?>"
                            name="key"
                            value="<?=$value['key']?>
                        ">
                    </label>


                    <?php if ($value['first']): ?>
                        <span class="form-admin__text">master</span>
                    <?php else: ?>
                        <label class="form-admin__label form-admin__label--admin">admin:
                            <input class="form-admin__input"
                                type="checkbox"
                                name="admin"
                                <?=$value['admin'] ? "checked" : ""?>
                            >
                        </label>
                    <?php endif; ?>

                    <div class="form-admin__btn-container">
                        <?php if (!$value['first']): ?>
                            <button class="form-admin__btn" name="deleteKey">удалить</button>
                        <?php endif; ?>

                        <?php if ($first || !$value['first']): ?>
                            <button class="form-admin__btn" name="editKey">изменить</button>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<? require $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php'?>
