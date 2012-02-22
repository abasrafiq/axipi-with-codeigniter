<?php
if($lng) {
?>

<div class="box-breadcrumbs box1">
<div class="display">
<ul>
<li class="first"><a href="<?php echo current_url(); ?>"><?php echo $this->lang->line('languages'); ?></a></li>
<li><?php echo $this->lang->line('update'); ?></li>
</ul>
</div>
</div>

<div class="box1">
<h1><?php echo $lng[0]->lng_code; ?></h1>
<ul>
<li><a href="<?php echo current_url(); ?>?a=read&amp;lng_id=<?php echo $lng[0]->lng_id; ?>"><?php echo $this->lang->line('read'); ?></a></li>
<li><a href="<?php echo current_url(); ?>"><?php echo $this->lang->line('index'); ?></a></li>
</ul>
<div class="display">

<h2><?php echo $this->lang->line('update'); ?></h2>

<?php echo validation_errors(); ?>

<?php echo form_open(current_url().'?a=update&amp;lng_id='.$lng[0]->lng_id); ?>

<div class="column1">
<p><?php echo form_label($this->lang->line('lng_code').' *', 'lng_code'); ?><?php echo form_input('lng_code', set_value('lng_code', $lng[0]->lng_code), 'class="inputtext"'); ?></p>
<p><?php echo form_label($this->lang->line('lng_title').' *', 'lng_title'); ?><?php echo form_input('lng_title', set_value('lng_title', $lng[0]->lng_title), 'class="inputtext"'); ?></p>
</div>

<div class="column1 columnlast">
<p><input class="inputsubmit" type="submit" name="submit" id="submit" value="<?php echo $this->lang->line('validate'); ?>"></p>
</div>

</form>

</div>
</div>

<?php
} else {
?>

<?php
}
?>