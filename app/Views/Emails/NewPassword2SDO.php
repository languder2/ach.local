<div style="background-color: #f5f5f5;padding:2rem;">
    <div style="background-color: #fefefe; margin: 0 auto; padding:1rem 2rem; text-align: center; border-radius: .75rem; max-width: 50rem">
        <h3>
            ФГБОУ "МелГУ"
        </h3>
        <hr>
        <p>
            Приветствуем, <?=$user->name??""?> <?=$user->patronymic??""?>!
        </p>
        <section>
            <p>
                В системе дистанционного обучения Moodle у Вас есть учетная запись.<br>
                Для входа используйте данные:
            </p>
            <p>
                Email:
                <b>
                    <?=$user->email??""?>
                </b>
                <br>
                Ваш пароль:
                <b>
                    <?=$user->pass??""?>
                </b>
            </p>
            <p>
                <a href="https://do.mgu-mlt.ru" style="display: inline-block; padding-right: 10px">СДО Moodle</a> расположена по адресу: https://do.mgu-mlt.ru
            </p>
            <p>
                Данное письмо сформировано автоматически и не требует ответа.
            </p>
        </section>
        <hr>
        <p style="text-align: center">
            &copy; 2024 МелГУ
        </p>
    </div>
</div>