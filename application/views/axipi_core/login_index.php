<div class="box-breadcrumbs box1">
<div class="display">
<ul>
<li class="first"><a href="<?php echo current_url(); ?>"><?php echo $this->itm[0]->itm_title; ?></a></li>
</ul>
</div>
</div>

<div class="box1">
<h1><?php echo $this->itm[0]->itm_title; ?></h1>
<div class="display">

<?php echo validation_errors(); ?>

<?php echo form_open(current_url()); ?>

<div class="column1">
<p><?php echo form_label($this->lang->line('usr_email').' *', 'email'); ?><?php echo form_input('email', set_value('email'), 'class="inputtext"'); ?></p>
<p><?php echo form_label($this->lang->line('usr_plainpassword').' *', 'password'); ?><?php echo form_password('password', set_value('password'), 'class="inputpassword"'); ?></p>
<p><input class="inputsubmit" type="submit" name="submit" id="submit" value="<?php echo $this->lang->line('validate'); ?>"></p>
</div>

</form>

</div>
</div>