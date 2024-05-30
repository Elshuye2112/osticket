<?php
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
        $disabled="";
        if($field->getLocal('label')=="district"||$field->getLocal('label')=="cluster")
        {
            $disabled='disabled';

        }

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
       if($field->getLocal('name')=='branch'){
       
       }
       ?>


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
//new added for cleaning buffer
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
