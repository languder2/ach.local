<h5 class="pe-4 ps-5 pb-2 border-bottom border-1">
    Сменить пароль
</h5>
<div class="px-4 pt-2">
    <form
            id          = "ChangePassword"
            method      = "POST"
            action      = "<?=base_url('account/change-password')?>"
    >
        <div class="s-input-box">
            <input
                    type                ="password"
                    name                ="form[password]"
                    id                  ="cpPass"
                    class               ="form-control"
                    placeholder         =""
                    value               =""
                    data-bs-toggle      ="tooltip"
                    data-bs-placement   ="bottom"
                    title               =""
                    required
                    autocomplete        = "off"
            >
            <label for="cpPass">
                Новый пароль
            </label>
        </div>

        <div class="s-input-box">
            <input
                    type                ="password"
                    name                ="form[retry]"
                    id                  ="cpRetry"
                    class               ="form-control"
                    placeholder         =""
                    value               =""
                    data-bs-toggle      ="tooltip"
                    data-bs-placement   ="bottom"
                    title               =""
                    required
                    autocomplete        = "off"
            >
            <label for="cpRetry">
                Повторить пароль
            </label>
        </div>

        <div class="s-input-box text-center">
            <button class="btn-main w-50 mx-auto">
                Сменить
            </button>
        </div>

    </form>
</div>
