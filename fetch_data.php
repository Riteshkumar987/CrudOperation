<?php   
    include("connection.php");
    $resul = array();
    if (isset($_POST['id'])) {
        $editId = $_POST['id'];
        $sql = "SELECT * FROM student WHERE id='$editId'";
        $data = mysqli_query($conn, $sql);
        $resul = mysqli_fetch_assoc($data);    
    }
?>

<form class="rform" method="POST" id="updateForm" enctype="multipart/form-data">
    <div class="modal-body">
        <h2 class="text-center mb-3">Responsive Registration Form</h2>
        <div class="input-group">
            <input type="hidden" name="user_id" id="user_id" class="form-control" value="<?php echo $editId; ?>">
        </div>

        <div class="form-group">
            <label for="fname">First Name <span style="color: red;">*</span>:</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                </div>
                <input type="text" name="firstname" class="form-control" placeholder="First name"
                    value="<?php echo isset($resul['firstname']) ? $resul['firstname'] : ''; ?>">
            </div>
        </div>

        <div class="form-group">
            <label for="lname">Last Name <span style="color: red;">*</span>:</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                </div>
                <input type="text" name="lastname" class="form-control" placeholder="Last name"
                    value="<?php echo isset($resul['lastname']) ? $resul['lastname'] : ''; ?>">
            </div>
        </div>

        <div class="row">
            <div class="col-sm-2">
                <div class="form-group">
                    <label for="gender">Gender<span style="color: red;">*</span>:</label>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gen" id="male" value="Male"
                            <?php echo (isset($resul['gender']) && $resul['gender'] == 'Male') ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="male">Male</label>
                    </div>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gen" id="female" value="Female"
                            <?php echo (isset($resul['gender']) && $resul['gender'] == 'Female') ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="female">Female</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="country">Country<span style="color: red;">*</span>:</label>
            <select name="country" class="form-control" id="country_dropdown" required>
                <option value="">Select-country</option>
                <?php
                   $country_result = mysqli_query($conn, "SELECT * FROM countries");
                  while ($row = mysqli_fetch_assoc($country_result)) {
                           $selected = (isset($resul['country']) && $row['country_id'] == $resul['country']) ? 'selected' : '';
                          echo "<option value='{$row['country_id']}' {$selected}>{$row['country_name']}</option>";
                    }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="state">State<span style="color: red;">*</span>:</label>
            <select name="state" class="form-control" id="state-dropdown">
                <option value="">Select-state</option>
                <?php
                    if (isset($resul['country'])) {
                         $state_result = mysqli_query($conn, "SELECT * FROM states WHERE country_id = {$resul['country']}");
                         while ($row1 = mysqli_fetch_assoc($state_result)) {
                             $selected = (isset($resul['state']) && $row1['state_id'] == $resul['state']) ? 'selected' : '';
                            echo "<option value='{$row1['state_id']}' {$selected}>{$row1['state_name']}</option>";
                        }
                    }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="city">City<span style="color: red;">*</span>:</label>
            <select name="city" class="form-control" id="city-dropdown">
                <option value="">Select-city</option>
                <?php
                    if(isset($resul['state'])){
                         $city_result = mysqli_query($conn, "SELECT * FROM cities WHERE state_id= {$resul['state']}");
                         while ($row2 = mysqli_fetch_assoc($city_result)) {
                             $selected = (isset($resul['city']) && $row2['city_id'] == $resul['city']) ? 'selected' : '';
                             echo "<option value='{$row2['city_id']}' {$selected}>{$row2['city_name']}</option>";
                        }
                    }
                ?>
            </select>
        </div>
        <?php 
                                $hobbies = unserialize($resul['hobbies']);
                            ?>
        <div class="row">
            <div class="col-sm-3">
                <div class="form-group">
                    <label>Hobbies:</label>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-check">
                    <input class="form-check-input" id="reding" type="checkbox"
                        <?php if (in_array("Reading", $hobbies)) echo "checked"; ?> name="hobbies[]" value="Reading">
                    <label class="form-check-label" for="reding">Reading</label>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-check">
                    <input class="form-check-input" id="trave" type="checkbox"
                        <?php if (in_array("Traveling", $hobbies)) echo "checked"; ?> name="hobbies[]"
                        value="Traveling">
                    <label class="form-check-label" for="trave">Traveling</label>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-check">
                    <input class="form-check-input" id="game" type="checkbox"
                        <?php if (in_array("Gaming", $hobbies)) echo "checked"; ?> name="hobbies[]" value="Gaming">
                    <label class="form-check-label" for="game">Gaming</label>
                </div>
            </div>
        </div>
        <div class="mb-3">
            <label for="formFilesm" class="form-label">Upload Image<span style="color: red;">*</span>:</label>
            <input class="form-control" type="file" id="image" name="image">
            <input type="hidden" name="current_image"
                value="<?php echo isset($resul['image']) ? $resul['image'] : ''; ?>">
        </div>
    </div>
</form>

<script>
$(document).ready(function() {
    $('#country_dropdown').on('change', function() {
        var country_id = this.value;
        $.ajax({
            url: "state.php",
            type: "POST",
            data: {
                country_data: country_id
            },
            success: function(result) {
                $("#state-dropdown").html(result);
            }
        });
    });

    $('#state-dropdown').on('change', function() {
        var state_id = this.value;
        $.ajax({
            url: "city.php",
            type: "POST",
            data: {
                state_data: state_id
            },
            success: function(result) {
                $("#city-dropdown").html(result);
            }
        });
    });
});

// function validate(event) {
//     var fname = $('input[name="firstname"]').val().trim();
//     var lname = $('input[name="lastname"]').val().trim();
//     var gender = $('input[name="gen"]:checked').val();
//     var country = $('select[name="country"]').val();
//     var state = $('select[name="state"]').val();
//     var city = $('select[name="city"]').val();

//     if (
//         fname === '' ||
//         lname === '' ||
//         gender === undefined ||
//         country === '' || country === 'Select-country' ||
//         state === '' || state === 'Select-state' ||
//         city === '' || city === 'Select-city'
//     ) {
//         var emptyFields = [];
//         if (fname === '') emptyFields.push('First Name');
//         if (lname === '') emptyFields.push('Last Name');
//         if (gender === undefined) emptyFields.push('Gender');
//         if (country === '' || country === 'Select-country') emptyFields.push('Country');
//         if (state === '' || state === 'Select-state') emptyFields.push('State');
//         if (city === '' || city === 'Select-city') emptyFields.push('City');
//         alert('Please fill out all required fields: ' + emptyFields.join(', '));
//         event.preventDefault();
//     }
// }
</script>