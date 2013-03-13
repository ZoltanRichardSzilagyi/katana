<div class="sampleInputElement">
	<div class="title">
		<?php echo LanguageUtils::translate("Date field") ?>
	</div>
	<div class="descriptionBoxButton">show Description</div>
	<div class="descriptionBox">	
		<div class="inputDescription">
			<?php echo LanguageUtils::translate("Date input description") ?>
		</div>
		<div class="dateInputElement">
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
<script type="text/javascript">
jQuery(document).ready(function() {
		$('#<?php echo $input->getId()?>').datepicker(
			{dateFormat: "yy-mm-dd",
			firstDay: 1,
			closeText: 'bezárás',
            prevText: '&laquo;&nbsp;vissza',
            nextText: 'előre&nbsp;&raquo;',
            currentText: 'ma',			
			dayNamesMin: ["V", "H", "K", "Sz", "Cs", "P", "Sz"],
			monthNames: ["Január", "Február", "Március", "Április", "Május", "Június", "Július", "Augusztus", "Szeptember", "Október", "November", "December"]}			
		);		

});
</script>