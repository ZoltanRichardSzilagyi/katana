<div class="sampleInputElement">
	<div class="title">
		<?php echo LanguageUtils::translate("Currency field") ?>
	</div>
	<div class="descriptionBoxButton"></div>
	<div class="descriptionBox">	
		<div class="inputDescription">
			<?php echo LanguageUtils::translate("Currency field description") ?>
		</div>
		<div class="currencyInputElement">
			<label for="<?php echo $input->getId()?>"><?php echo $input->getLabel() ?></label>	
				<input 
					type="<?php echo $input->getType()?>" 
					name="<?php echo $input->getName()?>"
					class="number currency" 
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
<script type="text/javascript">
jQuery(document).ready(function() {

	function formatMoney(numberValue){
		return accounting.formatMoney(
	    	numberValue, 
	    		{symbol : currencySymbol, 
	    			thousand : "<?php echo $input->getThousand()?>", 
	    			decimal : "<?php echo $input->getDecimal() ?>", 
	    			precision : "<?php echo $input->getPrecision() ?>",
	    			format: "<?php echo $input->getFormat() ?>"
	    		}
		 );		
	}
	
	// TODO refactor number, currency javascript events
	var elementId = "#<?php echo $input->getId()?>";
    jQuery(elementId).keydown(function(event) {
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
    
    var currencySymbol = "<?php echo $input->getSymbol() ?>";
        
    var inputValue = jQuery(elementId).val();
    var formattedValue = formatMoney(inputValue);
    jQuery(elementId).val(formattedValue);
    
    // TODO format safe replace
    jQuery(elementId).click(function(){    	
    	var elementValue = jQuery(this).val();
    	var numberValue = elementValue.replace(" " + currencySymbol, "");
    	jQuery(this).val(numberValue);
    });
    
    jQuery(elementId).blur(function(){
    	var numberValue = jQuery(this).val() + " " + currencySymbol;
		var formattedValue = formatMoney(numberValue);    	
    	jQuery(this).val(formattedValue);
    });    
    
});
</script>