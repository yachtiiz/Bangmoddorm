
<?php include 'header.php' ?>

<?php

function upPicture($file, $username) {
    if ($_FILES["$file"]["type"] == "image/jpg" || $_FILES["$file"]["type"] == "image/png" || $_FILES["$file"]["type"] == "image/jpeg" || $_FILES["$file"]["type"] == "image/gif" || $_FILES["$file"]["type"] == "image/pjpeg" || $_FILES["$file"]["type"] == "image/x-png") {
        if (move_uploaded_file($_FILES["$file"]["tmp_name"], "images/picture_profile/user_" . $username)) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function checkUsername($username) {

    include 'connection.php';
    $query = "select username from Members username = '$username'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_array($result);
    if($row != NULL){
        return false;
    }else{
        return true;
    }
}

function insertIntoDatabase() {

    include 'connection.php';

    $username = filter_var($_POST["username"], FILTER_SANITIZE_STRING);
    $password = filter_var($_POST["password"], FILTER_SANITIZE_STRING);
    $firstname = filter_var($_POST["firstname"], FILTER_SANITIZE_STRING);
    $lastname = filter_var($_POST["lastname"], FILTER_SANITIZE_STRING);
    $idcard = filter_var($_POST["idcard"], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $tel = filter_var($_POST["tel"], FILTER_SANITIZE_STRING);
    $type = filter_var($_POST["type"], FILTER_SANITIZE_STRING);
    $address = filter_var($_POST["address"], FILTER_SANITIZE_STRING);
    $city = filter_var($_POST["city"], FILTER_SANITIZE_STRING);
    $province = filter_var($_POST["province"], FILTER_SANITIZE_STRING);
    $zipcode = filter_var($_POST["zipcode"], FILTER_SANITIZE_STRING);
    $country = filter_var($_POST["country"], FILTER_SANITIZE_STRING);
    $memberURL = filter_var($_POST["memberURL"], FILTER_SANITIZE_STRING);
    $displayname = filter_var($_POST["displayname"], FILTER_SANITIZE_STRING);
    $facebook = filter_var($_POST["fbname"], FILTER_SANITIZE_STRING);
    $about = filter_var($_POST["about"], FILTER_SANITIZE_STRING);
    $pic_path = "/images/picture_profile/default_picture.jpg";
//    if (isset($_FILES["pic"])) {
//        if (upPicture("pic", $username)) {
//            $pic_path = "/images/picture_profile/user_" . $username;
//        } else {
//            return false;
//        }
//    }
    
    $password_md5 = md5($password);
    
    
    $query = "INSERT INTO `Members` (`username`, `password`, `firstName`, `lastName`, `idCard`, `email`, `tel`, `type`, `address`, `city`, `province`, `zipcode`, `country`, `regisDate`, `status`, `pic_path`, `memberUrl`, `displayName`, `facebook`, `about`)
VALUES
	('$username', '$password_md5', '$firstname', '$lastname', '$idcard', '$email', '$tel', '$type', '$address', '$city', '$province', '$zipcode', '$country', NOW(), 'Normal', '$pic_path', '$memberURL', '$displayname', '$facebook', '$about'); ";

    if (!mysqli_query($con, $query)) {
        return false;
    } else {
        return true;
    }
}

if (isset($_POST["confirm"])) {

    if (checkUsername($_POST["username"])) {
        if(insertIntoDatabase()){
            echo '<script>alert("Register Complete");window.location = "index.php";</script>';
        }else{
            echo '<script>alert("Register Failed")</script>';
        }
    }else{
        echo '<script>alert("Already username")</script>';
    }
}
?>



<script>

    function function3() {
        type = $("#type").val();

        if (type === "default") {
            alert("Please Select Type");
            $("#type").focus().freeze();
        }

        $("#form").submit();
    }


    $(document).ready(function() {

        $("#form").validate({
            rules: {
                username: {
                    checkSpecial: true,
                    required: true,
                    minlength: 4,
                    maxlength: 256
                },
                password: {
                    checkSpecial: true,
                    required: true,
                    minlength: 8,
                    maxlength: 256
                },
                firstname: {
                    checkSpecial: true,
                    required: true,
                    minlength: 4,
                    maxlength: 256
                },
                lastname: {
                    checkSpecial: true,
                    required: true,
                    minlength: 4,
                    maxlength: 256
                },
                tel: {
                    required: true,
                    minlength: 14
                },
                address: {
                    checkSpecial: true,
                    required: true,
                    minlength: 2,
                    maxlength: 1024
                },
                email: {
                    required: true,
                    email: true
                },
                idcard: {
                    required: true,
                    checkSpecial: true,
                },
                zipcode: {
                    required: true,
                    checkSpecial: true
                },
                about: {
                    required: true,
                    checkSpecial: true
                },
                displayname: {
                    required: true,
                    checkSpecial: true
                },
                memberURL: {
                    required: true,
                    checkSpecial: true
                },
                fbname: {
                    checkSpecial: true
                }

            }

        });
    });

    jQuery(function($) {
        $("#tel").mask("(+99)99-999-9999");
        $("#cpn_tel").mask("(+99)99-999-9999 ext.? 99");
        $("#cpn_fax").mask("(+99)99-999-9999");
        $("#idcard").mask("9-9999-99999-99-9", {placeholder: "_"});
        $("#cpn_elec_regis").mask("9999999999999", {placeholder: ""});
        $("#cpn_tax_number").mask("9999999999999", {placeholder: ""});
    });



</script>

<div class="row booking_summary">
    <div class="span12">
        <div class="row">
            <div class="span9" style="margin-bottom:100px">
                <br />
                <form id="form" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="span9">
                            <legend><span>Your</span> Username And Password</legend>
                        </div>
                        <div class="span3">
                            <input id="username" name="username" type="text" class="form-control" placeholder="Username" value="nussa2007"/>                                      
                        </div>

                        <div class="span3">
                            <input id="password" name="password" type="password" class="form-control" placeholder="Password" value="nussanussa"/>
                        </div>
                        <div class="span2">
                            <select id="type" name="type" class="form-control">
                                <option value="default"/>Type
                                <option selected value="Member"/>Member
                                <option value="Owner"/>Owner
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="span9">
                            <legend><span>Your</span> name</legend>
                        </div>
                        <div class="span2">
                            <select class="form-control">
                                <option />Mr.
                                <option />Mrs.
                                <option />Miss.
                            </select>
                        </div>

                        <div class="span3">
                            <label>
                                <input value="Patawee" id="firstname" name="firstname" type="text" class="form-control" placeholder="First Name..." />
                            </label>
                        </div>	

                        <div class="span3">
                            <label>
                                <input value="Namtewee" id="lastname" name="lastname" type="text" class="form-control" placeholder="Last Name..." />
                            </label>
                        </div>
                    </div>
                    <br />
                    <div class="row">
                        <div class="span9">
                            <legend><span>Your</span> contact details</legend>
                        </div>
                        <div class="span3">
                            <input value="1-1037-00878-21-1" id="idcard" name="idcard" type="text" class="form-control" placeholder="ID Card Number" />
                        </div>

                        <div class="span3">
                            <input value="nussa_s@hotmail.com" id="email" name="email" type="text" class="form-control" placeholder="Email" />
                        </div>	

                        <div class="span3">
                            <input value="+(66)90-971-1786" id="tel" name="tel" type="text" class="form-control" placeholder="Telephone" />
                        </div>
                    </div>
                    <br />
                    <div class="row">
                        <div class="span9">
                            <legend><span>Your</span> address</legend>
                        </div>

                        <div class="span3">
                            <textarea id="address" name="address" class="form-control" rows="4" placeholder="Address">68/50</textarea>
                        </div>				

                        <div class="span3">

                            <input id="province" name="province" type="text" class="form-control" placeholder="State/Province" value="ratburanah"/>
                            <br>
                            <input id="zipcode" name="zipcode" type="text" class="form-control" placeholder="Zip Code" value="10150"/>
                        </div>

                        <div class="span3">
                            <input id="city" name="city" type="text" class="form-control" placeholder="City" value="bangkok" />
                            <br>
                            <select id="country" name="country" class="form-control" name="country"><option value="default">Country</option><option selected value="US" />Thailand<option value="AD" />Andorra<option value="AE" />United Arab Emirates<option value="AF" />Afghanistan<option value="AG" />Antigua and Barbuda<option value="AI" />Anguilla<option value="AL" />Albania<option value="AM" />Armenia<option value="AN" />Netherlands Antilles<option value="AO" />Angola<option value="AQ" />Antarctica<option value="AR" />Argentina<option value="AS" />American Samoa<option value="AT" />Austria<option value="AU" />Australia<option value="AW" />Aruba<option value="AX" />Åland Islands<option value="AZ" />Azerbaijan<option value="BA" />Bosnia and Herzegovina<option value="BB" />Barbados<option value="BD" />Bangladesh<option value="BE" />Belgium<option value="BF" />Burkina Faso<option value="BG" />Bulgaria<option value="BH" />Bahrain<option value="BI" />Burundi<option value="BJ" />Benin<option value="BL" />Saint Barthélemy<option value="BM" />Bermuda<option value="BN" />Brunei<option value="BO" />Bolivia<option value="BQ" />British Antarctic Territory<option value="BR" />Brazil<option value="BS" />Bahamas<option value="BT" />Bhutan<option value="BV" />Bouvet Island<option value="BW" />Botswana<option value="BY" />Belarus<option value="BZ" />Belize<option value="CA" />Canada<option value="CC" />Cocos [Keeling] Islands<option value="CD" />Congo - Kinshasa<option value="CF" />Central African Republic<option value="CG" />Congo - Brazzaville<option value="CH" />Switzerland<option value="CI" />Côte d?Ivoire<option value="CK" />Cook Islands<option value="CL" />Chile<option value="CM" />Cameroon<option value="CN" />China<option value="CO" />Colombia<option value="CR" />Costa Rica<option value="CS" />Serbia and Montenegro<option value="CT" />Canton and Enderbury Islands<option value="CU" />Cuba<option value="CV" />Cape Verde<option value="CX" />Christmas Island<option value="CY" />Cyprus<option value="CZ" />Czech Republic<option value="DD" />East Germany<option value="DE" />Germany<option value="DJ" />Djibouti<option value="DK" />Denmark<option value="DM" />Dominica<option value="DO" />Dominican Republic<option value="DZ" />Algeria<option value="EC" />Ecuador<option value="EE" />Estonia<option value="EG" />Egypt<option value="EH" />Western Sahara<option value="ER" />Eritrea<option value="ES" />Spain<option value="ET" />Ethiopia<option value="FI" />Finland<option value="FJ" />Fiji<option value="FK" />Falkland Islands<option value="FM" />Micronesia<option value="FO" />Faroe Islands<option value="FQ" />French Southern and Antarctic Territories<option value="FR" />France<option value="FX" />Metropolitan France<option value="GA" />Gabon<option value="GB" />United Kingdom<option value="GD" />Grenada<option value="GE" />Georgia<option value="GF" />French Guiana<option value="GG" />Guernsey<option value="GH" />Ghana<option value="GI" />Gibraltar<option value="GL" />Greenland<option value="GM" />Gambia<option value="GN" />Guinea<option value="GP" />Guadeloupe<option value="GQ" />Equatorial Guinea<option value="GR" />Greece<option value="GS" />South Georgia and the South Sandwich Islands<option value="GT" />Guatemala<option value="GU" />Guam<option value="GW" />Guinea-Bissau<option value="GY" />Guyana<option value="HK" />Hong Kong SAR China<option value="HM" />Heard Island and McDonald Islands<option value="HN" />Honduras<option value="HR" />Croatia<option value="HT" />Haiti<option value="HU" />Hungary<option value="ID" />Indonesia<option value="IE" />Ireland<option value="IL" />Israel<option value="IM" />Isle of Man<option value="IN" />India<option value="IO" />British Indian Ocean Territory<option value="IQ" />Iraq<option value="IR" />Iran<option value="IS" />Iceland<option value="IT" />Italy<option value="JE" />Jersey<option value="JM" />Jamaica<option value="JO" />Jordan<option value="JP" />Japan<option value="JT" />Johnston Island<option value="KE" />Kenya<option value="KG" />Kyrgyzstan<option value="KH" />Cambodia<option value="KI" />Kiribati<option value="KM" />Comoros<option value="KN" />Saint Kitts and Nevis<option value="KP" />North Korea<option value="KR" />South Korea<option value="KW" />Kuwait<option value="KY" />Cayman Islands<option value="KZ" />Kazakhstan<option value="LA" />Laos<option value="LB" />Lebanon<option value="LC" />Saint Lucia<option value="LI" />Liechtenstein<option value="LK" />Sri Lanka<option value="LR" />Liberia<option value="LS" />Lesotho<option value="LT" />Lithuania<option value="LU" />Luxembourg<option value="LV" />Latvia<option value="LY" />Libya<option value="MA" />Morocco<option value="MC" />Monaco<option value="MD" />Moldova<option value="ME" />Montenegro<option value="MF" />Saint Martin<option value="MG" />Madagascar<option value="MH" />Marshall Islands<option value="MI" />Midway Islands<option value="MK" />Macedonia<option value="ML" />Mali<option value="MM" />Myanmar [Burma]<option value="MN" />Mongolia<option value="MO" />Macau SAR China<option value="MP" />Northern Mariana Islands<option value="MQ" />Martinique<option value="MR" />Mauritania<option value="MS" />Montserrat<option value="MT" />Malta<option value="MU" />Mauritius<option value="MV" />Maldives<option value="MW" />Malawi<option value="MX" />Mexico<option value="MY" />Malaysia<option value="MZ" />Mozambique<option value="NA" />Namibia<option value="NC" />New Caledonia<option value="NE" />Niger<option value="NF" />Norfolk Island<option value="NG" />Nigeria<option value="NI" />Nicaragua<option value="NL" />Netherlands<option value="NO" />Norway<option value="NP" />Nepal<option value="NQ" />Dronning Maud Land<option value="NR" />Nauru<option value="NT" />Neutral Zone<option value="NU" />Niue<option value="NZ" />New Zealand<option value="OM" />Oman<option value="PA" />Panama<option value="PC" />Pacific Islands Trust Territory<option value="PE" />Peru<option value="PF" />French Polynesia<option value="PG" />Papua New Guinea<option value="PH" />Philippines<option value="PK" />Pakistan<option value="PL" />Poland<option value="PM" />Saint Pierre and Miquelon<option value="PN" />Pitcairn Islands<option value="PR" />Puerto Rico<option value="PS" />Palestinian Territories<option value="PT" />Portugal<option value="PU" />U.S. Miscellaneous Pacific Islands<option value="PW" />Palau<option value="PY" />Paraguay<option value="PZ" />Panama Canal Zone<option value="QA" />Qatar<option value="RE" />Réunion<option value="RO" />Romania<option value="RS" />Serbia<option value="RU" />Russia<option value="RW" />Rwanda<option value="SA" />Saudi Arabia<option value="SB" />Solomon Islands<option value="SC" />Seychelles<option value="SD" />Sudan<option value="SE" />Sweden<option value="SG" />Singapore<option value="SH" />Saint Helena<option value="SI" />Slovenia<option value="SJ" />Svalbard and Jan Mayen<option value="SK" />Slovakia<option value="SL" />Sierra Leone<option value="SM" />San Marino<option value="SN" />Senegal<option value="SO" />Somalia<option value="SR" />Suriname<option value="ST" />São Tomé and Príncipe<option value="SU" />Union of Soviet Socialist Republics<option value="SV" />El Salvador<option value="SY" />Syria<option value="SZ" />Swaziland<option value="TC" />Turks and Caicos Islands<option value="TD" />Chad<option value="TF" />French Southern Territories<option value="TG" />Togo<option value="TH" />United State<option value="TJ" />Tajikistan<option value="TK" />Tokelau<option value="TL" />Timor-Leste<option value="TM" />Turkmenistan<option value="TN" />Tunisia<option value="TO" />Tonga<option value="TR" />Turkey<option value="TT" />Trinidad and Tobago<option value="TV" />Tuvalu<option value="TW" />Taiwan<option value="TZ" />Tanzania<option value="UA" />Ukraine<option value="UG" />Uganda<option value="UM" />U.S. Minor Outlying Islands<option value="US" />United States<option value="UY" />Uruguay<option value="UZ" />Uzbekistan<option value="VA" />Vatican City<option value="VC" />Saint Vincent and the Grenadines<option value="VD" />North Vietnam<option value="VE" />Venezuela<option value="VG" />British Virgin Islands<option value="VI" />U.S. Virgin Islands<option value="VN" />Vietnam<option value="VU" />Vanuatu<option value="WF" />Wallis and Futuna<option value="WK" />Wake Island<option value="WS" />Samoa<option value="YD" />People's Democratic Republic of Yemen<option value="YE" />Yemen<option value="YT" />Mayotte<option value="ZA" />South Africa<option value="ZM" />Zambia<option value="ZW" />Zimbabwe<option value="ZZ" />Unknown or Invalid Region</select>
                        </div>	

                    </div>
                    <br />
                    <div class="row">
                        <div class="span9">
                            <legend><span>Your</span> Information</legend>
                        </div>

                        <div class="span3">
                            <textarea id="about" name="about" class="form-control" rows="4" placeholder="About">My name is arnuz</textarea>
                        </div>				

                        <div class="span3">
                            <input id="displayname" name="displayname" type="text" class="form-control" placeholder="Display Name" value="arnood" />
                            <br>
                            <input id="fbname" name="fbname" type="text" class="form-control" placeholder="Your Facebook" value="www.facebook.com/arnood" />
                        </div>

                        <div class="span3">
                            <input id="memberURL" name="memberURL" type="text" class="form-control" placeholder="Your Member URL" value="arnood" />
                            <br>
                        </div>	
                    </div>
                    <div class="row">
                        <div class="span9">
                            <legend><span>Your</span> Picture</legend>
                        </div>
                        <div class="span3">
                            <img src="/images/picture_profile/default_picture.jpg" style="height:200px" class="img-thumnail">
                        </div>
                        <div class="span6">
                            <input id="pic" name="pic" type="file" class="form-control">
                        </div>
                        <div class="span6" style="margin-top:120px">
                            <button id="confirm" type="submit" name="confirm" class="btn btn-default pull-right">Continue</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="span3">
                <br /><br />
                <h3><span>Owner</span> Hint</h3>
                <p>
                    If you want to be a owner of Dormitory you can chose owner type and add dormitory to be owner but you need to send a real evidence.
                    <br />
                    <br /><br />
                </p>
            </div>
        </div>
    </div>
</div></div> <!-- /container -->
<?php include 'footer.php' ?>
