<div class="box-breadcrumbs box1">
<div class="display">
<ul>
<li class="first"><a href="<?php echo ci_url(); ?><?php echo $this->itm->itm_code; ?>"><?php echo $this->lang->line('languages'); ?></a></li>
<li><?php echo $lng->lng_code; ?></li>
<li><?php echo $this->lang->line('read'); ?></li>
</ul>
</div>
</div>

<div class="box1">
<h1><?php echo $lng->lng_code; ?></h1>
<ul>
<?php if($lng->lng_islocked == 0) { ?><li><a href="<?php echo ci_url(); ?><?php echo $this->itm->itm_code; ?>/_delete/<?php echo $lng->lng_id; ?>"><?php echo $this->lang->line('delete'); ?></a></li><?php } ?>
<li><a href="<?php echo ci_url(); ?><?php echo $this->itm->itm_code; ?>/_update/<?php echo $lng->lng_id; ?>"><?php echo $this->lang->line('update'); ?></a></li>
<li><a href="<?php echo ci_url(); ?><?php echo $this->itm->itm_code; ?>"><?php echo $this->lang->line('index'); ?></a></li>
</ul>
<div class="display">

<h2><?php echo $this->lang->line('read'); ?></h2>

<div class="column1">
<p><span class="label"><?php echo $this->lang->line('lng_code'); ?></span><?php echo $lng->lng_code; ?></p>
<p><span class="label"><?php echo $this->lang->line('lng_defaultitem'); ?></span><?php echo $lng->lng_defaultitem; ?></p>
</div>

<div class="column1 columnlast">
</div>

</div>
</div>
