<div style="background-color: #f5f5f5;padding:2rem;">
    <div style="background-color: #fefefe; margin: 0 auto; padding:1rem 2rem; text-align: center; border-radius: .75rem; max-width: 50rem">
        <h3>
            ФГБОУ "МелГУ"
        </h3>
        <hr>
        <p>
            Приветствуем, <?=$name??""?> <?=$patronymic??""?>!
        </p>
        <section
        <p>
            Для подтверждения электронной почты и завершения процесса регистрации введите код:
        </p>
        <p>
            <span style="display: inline-block; padding: 1rem 2rem; background-color: #f5f5f5; font-weight: bold;">
                <?=$code??""?>
            </span>
            <br>
        </p>
        <div>
            <p>
                Или пройдите, пожалуйста, по ссылке:
                <br>
                <a href="<?=$link??""?>">
                    <?=$link??""?>
                </a>
            </p>
        </div>
        <p>
            Если вы получили это письмо по ошибке, просто игнорируйте его.
        </p>
        <hr>
        <p style="text-align: center">
            &copy; 2024 МелГУ
        </p>
    </div>
</div>