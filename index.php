<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<style>
    ul
    {
        list-style-type: none;
    }
    .label
    {
        width:250px; /* or whatever width you want. */
        max-width:250px; /* or whatever width you want. */
        display: inline-block;
    }
</style>
<body>

<form id="response_form" action="./action/response.php" method="POST">
    <span class="label">Will you be having lunch tomorrow?</span>
    <select name="user_response">
        <option value="-1">Select One....</option>
        <option value="yes">Yes</option>
        <option value="no">No</option>
    </select>
    <br/>
    <span class="label">Please enter your name:</span> <input type="text" name="user_name" />
    <br/>
    <span class="label">Special instructions:</span></span> <input type="text" name="user_instructions" />
    <br/>
    <input type="submit" value="Submit">
</form>
<footer>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src= "http://ajax.aspnetcdn.com/ajax/jquery.validate/1.12.0/jquery.validate.min.js"></script>
    <script type="text/javascript">
        $.validator.addMethod("valueNotEquals", function(value, element, arg){
            return arg != value;
        }, "Value must not equal arg.");

        $(document).ready(function () {
            $('#response_form').validate({ // initialize the plugin
                rules: {
                    user_name: {
                        required: true,
                        maxlength: 20
                    },
                    user_response: {
                        valueNotEquals: "-1"
                    }
                },
                messages: {
                    user_response: { valueNotEquals: "Please select from drop down." }
                }
            });
        });
    </script>
</footer>
</body>
</html>