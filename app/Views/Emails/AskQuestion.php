<h3>SSO ФГБОУ "МелСУ": Задать вопрос</h3>
<p>
    <b>ФИО:</b>
    <br>
    <?=$form->name??""?>
</p>

<p>
    <b>E-mail:</b>
    <br>
    <?=$form->email??""?>
</p>

<?php if(!empty($form->role)):?>
<p>
    <b>Роль:</b>
    <br>
    <?=$form->role?>
</p>
<?php endif;?>

<p>
    <b>Вопрос:</b>
    <br>
    <?=$form->question??""?>
</p>
