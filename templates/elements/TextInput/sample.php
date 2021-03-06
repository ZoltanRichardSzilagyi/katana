<?php 
use classes\utils\LanguageUtils;
?>
<div class="sampleInputElement">
	<div class="title">
		<?php echo LanguageUtils::translate("Text field") ?>
	</div>	
	<div class="descriptionBoxButton"></div>
	<div class="descriptionBox">
		<div class="inputDescription">
			<?php echo LanguageUtils::translate("Text field description") ?>
		</div>
		<div class="inputElement">
			<label for="<?php echo $input->getId()?>"><?php echo $input->getLabel() ?></label>	
				<input 
					type="<?php echo $input->getType()?>" 
					name="<?php echo $input->getName()?>" 
					id="<?php echo $input->getId()?>"
					value="<?php echo $input->getValue()?>" 
					placeholder="<?php echo $input->getPlaceHolder()?>" 
					maxlength="<?php echo $input->getMaxLength()?>" 
					
					<?php if($input->isReadOnly()){ ?>
					readonly="readonly"
					<?php }?>/>
		</div>
	</div>
</div>