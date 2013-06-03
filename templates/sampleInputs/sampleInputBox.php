<?php $sampleInputsIterator = $sampleInputs -> getIterator(); ?>                                    
<?php while($sampleInputsIterator->valid()){?>                          
    <?php $input = $sampleInputsIterator->current(); ?>                                         
<li input-type="<?php echo $input::className()?>" simple-name="<?php echo $input::getSimpleName()?>">                           
    <?php $input->render() ?> 
</li>
<?php $sampleInputsIterator->next(); ?>                     
<?php } ?>