<?php
/**
 * @var NumberInput
 */
$input;
?>
<div class="sampleInputElement">
	<div class="title">
		<?php echo LanguageUtils::translate("Number input") ?>
	</div>	
	<div class="inputDescription">
		<?php echo LanguageUtils::translate("Number input description") ?>
	</div>
	<div class="numbericInputElement">
		<label for="<?php echo $input->getId()?>"><?php echo $input->getLabel() ?></label>	
			<input 
				type="<?php echo $input->getType()?>" 
				name="<?php echo $input->getName()?>"
				class="number" 
				id="<?php echo $input->getId()?>"
				value="<?php echo $input->getValue()?>" 
				placeholder="<?php echo $input->getPlaceHolder()?>" 
				maxlength="<?php echo $input->getMaxLength()?>" 				
				<?php if($input->isReadOnly()){ ?>
				readonly="readonly"
				<?php }?>/>
	</div>
</div>
<script type="text/javascript">
jQuery(document).ready(function() {
    jQuery("input.number").keydown(function(event) {
        // Allow: backspace, delete, tab, escape, and enter
        if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 13 || 
             // Allow: Ctrl+A
            (event.keyCode == 65 && event.ctrlKey === true) || 
             // Allow: home, end, left, right
            (event.keyCode >= 35 && event.keyCode <= 39)) {
                 // let it happen, don't do anything
                 return;
        }
        else {
            // Ensure that it is a number and stop the keypress
            if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
                event.preventDefault(); 
            }   
        }
    });
});
</script>