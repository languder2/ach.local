<section class="w-30rem mx-auto bg-white px-3 py-2 rounded-4 mt-5">
    <h3 class="page-title text-center my-2">
        Смена пароля
    </h3>
    <hr class="mt-0 p-0">
    <form
            id          = "ChangePassword"
            method      = "POST"
            action      = ""
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
            >
            <label for="cpRetry">
                Повторить пароль
            </label>
        </div>

        <div class="s-input-box text-center">
            <button class="btn-main w-100">
                Сменить
            </button>
        </div>

    </form>
</section>
