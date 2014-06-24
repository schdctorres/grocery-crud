<?php 

	$column_width = (int)(80/count($columns));
	if(!empty($list)){
?><div class="bDiv" >
		<table cellspacing="0" cellpadding="0" border="0" id="flex1">
		<thead>
			<tr class='hDiv'>
                <?php if(!$unset_delete || !$unset_edit || !empty($actions)){?>
                <th style='text-align:left; width:8%;' abbr="tools" axis="col1" class="actionCol">
                    <div class="text-left">
                        <?php echo $this->l('list_actions');?>
                    </div>
                </th>
                <?php }?>
				<?php foreach($columns as $column){?>
				<th width='<?php echo $column_width?>%'>
					<div class="text-left field-sorting <?php if(isset($order_by[0]) &&  $column->field_name == $order_by[0]){?><?php echo $order_by[1]?><?php }?>" 
						rel='<?php echo $column->field_name?>'>
						<?php echo $column->display_as?>
					</div>
				</th>
				<?php }?>
			</tr>
		</thead>		
		<tbody>  
<?php foreach($list as $num_row => $row){ ?>        
		<tr  <?php if($num_row % 2 == 1){?>class="erow"<?php }?>>
            <?php if(!$unset_delete || !$unset_edit || !empty($actions)){?>
            <td style='text-align:left;' class='actionCol'>
                <div class='tools'>                
                    <?php if(!$unset_delete){?>
                    <a class="btn btn-default btn-sm delete-row deleteBtn" role="button" href="<?php echo $row->delete_url?>" title="Delete Record">
                    <span class="glyphicon glyphicon-trash"></span>
                    </a>
                    <?php }?>
                    <?php if(!$unset_edit){?>
                        <a class="btn btn-default btn-sm edit_button" role="button" href="<?php echo $row->edit_url?>" title="<?php echo $this->l('list_edit')?> <?php echo $subject?>">
                        <span class="glyphicon glyphicon-pencil"></span>
                        </a>
                    <?php }?>
                    
                    <?php 
                    if(!empty($row->action_urls)){
                        foreach($row->action_urls as $action_unique_id => $action_url):?>
                        <? $attributes = "class=".$actions[$action_unique_id]->css_class; ?>
                        <?=isset($action_url) ? anchor($action_url, $actions[$action_unique_id]->label, $attributes) : '';?>    
                    <? endforeach;?>
                    <? } ?>                    
                    <div class='clear'></div>
                </div>
            </td>
            <?php }?>        
			<?php foreach($columns as $column){?>
			<td width='<?php echo $column_width?>%' class='<?php if(isset($order_by[0]) &&  $column->field_name == $order_by[0]){?>sorted<?php }?>'>
				<div class='text-left'><?php echo $row->{$column->field_name} != '' ? $row->{$column->field_name} : '&nbsp;' ; ?></div>
			</td>
			<?php }?>
		</tr>
<?php } ?>        
		</tbody>
		</table>
<div style=" width:100%;border:1px solid #CCCCCC;text-align:center; font-weight:bold;"><?=$total_results?> RECORDS FOUND</div>        
	</div>
<?php }else{?>
	<br/>
	&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $this->l('list_no_items'); ?>
	<br/>
	<br/>
<?php }?>	