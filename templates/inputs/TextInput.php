<div class="inputElement">	
	<label for="<?php echo $input->getName()?>"><?php echo $input->getLabel() ?></label>	
	<input 
		type="<?php echo $input->getType()?>" 
		name="<?php echo $input->getName()?>" 
		id="<?php echo $input->getName()?>"
		value="<?php echo $input->getValue()?>" 
		placeholder="<?php echo $input->getPlaceHolder()?>" 
		maxlength="<?php echo $input->getMaxLength()?>" 
		
		<?php if($input->isReadOnly()){ ?>
		readonly="readonly"
		<?php }?>/>
</div>
