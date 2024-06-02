
<?php
// get_choices.php
require_once('.../class.dynamic_forms.php');

// Assuming you have a method to get configuration and parse choices
function getChoices() {
    $config = getConfiguration(); // Your method to get the configuration
    $choices = explode("\n", $config['choices']); // Assuming choices are separated by newline

    $result = [];
    foreach ($choices as $choice) {
        list($key, $val) = explode(':', $choice, 2);
        list($id, $branch, $cluster, $district) = explode(',', $val);
        $result[] = ['id' => $id, 'branch' => $branch, 'cluster' => $cluster, 'district' => $district];
    }

    return $result;
}

header('Content-Type: application/json');
echo json_encode(getChoices());
?>
<!-- should be written in  -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        var branchFieldId = '<?php echo $branchFieldId; ?>';
        var clusterFieldId = '<?php echo $clusterFieldId; ?>';
        var districtFieldId = '<?php echo $districtFieldId; ?>';

        $('#' + branchFieldId).change(function() {
            var selectedBranchId = $(this).val();
            console.log('Branch field changed:', selectedBranchId);
            var clusterField = $('#' + clusterFieldId);
            var districtField = $('#' + districtFieldId);

            if (selectedBranchId) {
                $.ajax({
                    url: 'elsh.php',
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        clusterField.empty();
                        districtField.empty();

                        data.forEach(function(choice) {
                            if (choice.id === selectedBranchId) {
                                clusterField.append($('<option>', { value: choice.cluster, text: choice.cluster }));
                                districtField.append($('<option>', { value: choice.district, text: choice.district }));
                                clusterField.val(choice.cluster);
                                districtField.val(choice.district);
                            }
                        });

                        console.log('Cluster field set to:', clusterField.val());
                        console.log('District field set to:', districtField.val());
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching choices:', error);
                    }
                });
            } else {
                console.log('Branch field value is empty');
            }
        });
    });
</script>