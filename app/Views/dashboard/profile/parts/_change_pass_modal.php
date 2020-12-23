<div id="change_password" class="modal" elmid='<?= user_id() ?>'>
    <div class="modal-background"></div>
    <div class="modal-card">
        <header class="modal-card-head">
            <p class="modal-card-title">Change Password</p>
            <button class="delete" aria-label="close"></button>
        </header>
        <section class="has-background-danger-light has-text-weight-medium px-2">
            <label name="message" id="chpasswd_message">
                
            </label>
        </section>
        <section class="modal-card-body">
            <form id="change_password-form">
                <div class="field">
                    <label class="label">New Password</label>
                    <input type="password" class="input" name="password">
                    <label class="label">Re-Enter New Password</label>
                    <input type="password" class="input" name="pass_confirm">
                </div>
            </form>
        </section>
        <footer class="modal-card-foot">
            <button class="button is-success" onclick="changepasswordEntry($('#change_password'), $('#change_password-form'))">Change</button>
            <button class="button" aria-label="close">Cancel</button>
        </footer>
    </div>
</div>