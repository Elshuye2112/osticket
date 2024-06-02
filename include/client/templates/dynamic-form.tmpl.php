

<?php
// require('include/class.forms.php');
// Return if no visible fields
global $thisclient;
if (!$form->hasAnyVisibleFields($thisclient))
    return;

$isCreate = (isset($options['mode']) && $options['mode'] == 'create');
?>
    <tr><td colspan="2"><hr />
    <div class="form-header" style="margin-bottom:0.5em">
    <h3><?php echo Format::htmlchars($form->getTitle()); ?></h3>
    <div><?php echo Format::display($form->getInstructions()); ?></div>
    </div>
    </td></tr>
    <?php
    // Form fields, each with corresponding errors follows. Fields marked
    // 'private' are not included in the output for clients
    foreach ($form->getFields() as $field) {
        try {
            if (!$field->isEnabled())
                continue;
        }
        catch (Exception $e) {
            // Not connected to a DynamicFormField
        }

        if ($isCreate) {
            if (!$field->isVisibleToUsers() && !$field->isRequiredForUsers())
                continue;
        } elseif (!$field->isVisibleToUsers()) {
            continue;
        }
        //Variable declaration
        // $cluster_field_id='';
        // $district_field_id='';
        // $branch_field_id='';
        $disabled="";
        $fieldLabel = $field->getLocal('label');
        $fieldId = $field->getFormName();

        if ($fieldLabel == 'branch') {
            $branchFieldId = '_'.$fieldId;

        } elseif ($fieldLabel == 'cluster') {
            $clusterFieldId = '_'.$fieldId;
        } elseif ($fieldLabel == 'district') {
            $districtFieldId = '_'.$fieldId;
        }
   
        
        // if($field->getLocal('label')=="district"||$field->getLocal('label')=="cluster")
        // {
        //     $disabled='disabled';
          

        // }
        //shorthand representation of the if statement
        $disabled = ($field->getLocal('label') == "district" || $field->getLocal('label') == "cluster") ? 'disabled' : '';

        ?>

        <th>Welcome <?php echo $field->getFormName()." and ".$field->isEnabled()." " .$field->getFormId();?> </th>
       <th> <?php echo "Maru".$field->getLocal('name');?></th>
       <?php

        ?>
       <?php echo"<script type='text/javascript'>
       function getValue(){
        // alert('elshu');
        prompt('Please enter your name','Elshaday ');  
       }

    //    var btn=documentGetElementById('btn');
    //    btn.addEventListener('load',function(){
    //     alert('Desiiiiiiiiiiiiiiiieeeeeeeeee');
    //    });
       </script>"
      
       ?>
       <?php echo" <button type='button' id='btn' onclick='getValue()' >clickme</button>"?>
       <?php
    //    if($field->getLocal('name')=='branch'){
       
    //    }
    //    ?>


        <tr>
            <td colspan="2" style="padding-top:10px;">
            <?php if (!$field->isBlockLevel()) { ?>
                <label for="<?php echo $field->getFormName(); ?>"><span class="<?php
                    if ($field->isRequiredForUsers()) echo 'required'; ?>">
                <?php echo Format::htmlchars($field->getLocal('label')); ?>
            <?php if ($field->isRequiredForUsers() &&
                    ($field->isEditableToUsers() || $isCreate)) { ?>
                <span class="error">*</span>
            <?php }
            ?></span><?php
                if ($field->get('hint')) { ?>
                    <br /><em style="color:gray;display:inline-block"><?php
                        echo Format::viewableImages($field->getLocal('hint')); ?></em>
                <?php
                } ?>
            <br/>
            <?php
            }
            if ($field->isEditableToUsers() || $isCreate) {
                //added for storing on buffer rutther than rendering
                ob_start();

                $field->render(array('client'=>true));
//added for cleaning buffer
                $filed_html = ob_get_clean();
//added for validation
  if($disabled){
   $filed_html=preg_replace('/(<select[^>]*)/','$1 disabled',$filed_html);
  

  }
  //added for display
  echo $filed_html;

                ?></label><?php
                foreach ($field->errors() as $e) { ?>
                    <div class="error"><?php echo $e; ?></div>
                <?php }
                $field->renderExtras(array('client'=>true));
            } else {
                $val = '';
                if ($field->value)
                    $val = $field->display($field->value);
                elseif (($a=$field->getAnswer()))
                    $val = $a->display();

                echo sprintf('%s </label>', $val);
            }
            ?>
            </td>
        </tr>
        <?php
    }
?>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">
    require_once('./class.dynamic_forms.php');
    $(document).ready(function() {
    var branchFieldId = '<?php echo $branchFieldId; ?>';
    var clusterFieldId = '<?php echo $clusterFieldId; ?>';
    var districtFieldId = '<?php echo $districtFieldId; ?>';

    $('#' + branchFieldId).change(function() {
        console.log('Branch field changed:', $(this).val());
        var clusterField = $('#' + clusterFieldId);
        var districtField = $('#' + districtFieldId);

        if ($(this).val()) {
        function getChoices() {
      
            // $this->_choices === null=true
            // Allow choices to be set in this->ht (for configurationOptions)
         
          
                $this->_choices = array();
                $config = $this->getConfiguration();
                // $choices = explode("\n", $config['choices']);
                // $choices = explode(",", $config['choices']);
                //  error_log("Choices: ".json_encode($choices));
                $choices = explode("\n", $config['choices']); // assuming choices are separated by newline

                error_log("Choices: " . json_encode($choices));
                foreach ($choices as $choice) {
                    // Allow choices to be key: value
                    // Allow choices to be key: value1,value2,value3

                    list($key, $val) = explode(':', $choice, 2);
                    list($id, $branch, $cluster, $district) = explode(',', $val);
                    if($(this).val()===$id){
                    clusterField.append($('<option >', { value: $cluster, text: $cluster }));
                    districtField.append($('<option >', { value: $district, text: $district }));
                    districtField.val($district);
                    clusterField.val($cluster);
                            
            }
        }
        }

      //  selected="selected"

    //   clusterField.append($('<option >', { value: $(this).val(), text: $(this).val() }));
    //   districtField.append($('<option >', { value: $(this).val(), text: $(this).val() }));
    //   districtField.val($(this).val());
    //   clusterField.val($(this).val());

        // console.log('Cluster field set to:', clusterField.val());
        // console.log('District field set to:', districtField.val());

        } else {
        console.log('Branch field value is empty');
        }
    });
    });

</script> -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        var branchFieldId = '<?php echo $branchFieldId; ?>';
        var clusterFieldId = '<?php echo $clusterFieldId; ?>';
        var districtFieldId = '<?php echo $districtFieldId; ?>';

        $('#' + branchFieldId).change(function() {
            console.log('Branch field changed:', $(this).val());
            var clusterField = $('#' + clusterFieldId);
            var districtField = $('#' + districtFieldId);

            if ($(this).val()) {
                var selectedValue = $(this).val();
                
                // Append and set the value of clusterField
                clusterField.empty();  // Clear any existing options
                clusterField.append($('<option>', { value: selectedValue, text: selectedValue }));
                clusterField.val(selectedValue);

                // Append and set the value of districtField
                districtField.empty();  // Clear any existing options
                districtField.append($('<option>', { value: selectedValue, text: selectedValue }));
                districtField.val(selectedValue);

                console.log('Cluster field set to:', clusterField.val());
                console.log('District field set to:', districtField.val());
            } else {
                console.log('Branch field value is empty');
            }
        });
    });
</script>
