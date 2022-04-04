<div class="content-control"
    data-out="<?=$out?>"
    data-out-name="<?=htmlspecialchars(json_encode($outName, JSON_UNESCAPED_UNICODE))?>"
></div>

<?php if ($first || $admin): ?>
    <a class="content-control__link" href="/route/admin">Администрирование</a>
<?php endif; ?>
