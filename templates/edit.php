<?php include INCLUDE_PATH.'/head.inc.php' ?>
    <section id="content">
        <a class="btn" href="/"><i class="icon-arrow-left"></i> Back to list</a>
        <form name="edit" id="edit" method="post" class="form-horizontal">
            <fieldset>
                <legend>Edit '<?php echo $user->name; ?>'</legend>                
                <?php if (isset($errorMsg) && $errorMsg): ?>
                    <div class="alert alert-danger" role="alert"><?php echo $errorMsg ?></div>
                <?php endif ?>
                <div class="control-group">
                    <label class="control-label">ID</label>
                    <div class="controls">
                        <span class="uneditable-input"><?php echo $user->user_id; ?></span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="name">Name</label>
                    <div class="controls">
                        <input type="text" id="name" name="name" value="<?php echo $user->name; ?>">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="address">Address</label>
                    <div class="controls">
                        <textarea id="address" name="address"><?php echo $user->address; ?></textarea>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="mobile">Contact Number</label>
                    <div class="controls">
                        <input type="text" pattern="\d*" maxlength="11" id="mobile" name="mobile" value="<?php echo $user->mobile; ?>">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="email">Email</label>
                    <div class="controls">
                        <input type="text" id="email" name="email" value="<?php echo $user->email ?>">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="birthdate">Date of Birth</label>
                    <div class="controls">
                        <input type="date" id="birthdate" name="birthdate"  value="<?php echo date("Y-m-d", $user->birthdate); ?>">
                    </div>
                </div>
            </fieldset>
            <div class="form-actions">
                <input type="submit" value="Edit" class="btn btn-primary btn-large">
            </div>
        </form>
    </section>
<?php include INCLUDE_PATH.'/footer.inc.php' ?>