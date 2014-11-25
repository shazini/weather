$(document).ready(function()
{
    $("#weatherForm").validate( 
    {
        rules:
        {
            city:
            {
                pattern: /^[^";@\$&\*]+$/,
                
            }
        },
        messages:
        {
            city:
            {
                pattern: "Illegal character detected",
                required: "Please enter a City"
            }
        },
        submitHandler: function(form)
        {
            
            
            $(form).ajaxSubmit(
            {
                    type: "GET",
                    url: "php_api.php",
                    success: function(ajaxOutput)
                    {
                        $("#outputArea").html(ajaxOutput);
                    }
            });
        }
    });
    
    $("#useGps").change(function()
    {
        // always verify if the browser support geolocation
        if(navigator.geolocation)
        {
            navigator.geolocation.getCurrentPosition(getPosition, errorCallback);
        }
        
        // not supported
        else
        {
            $("#outputArea").html("Geolocation not supported");
        }
    });
    
});


/**
 * callback function for a successful attempt at geolocation
 *
 * @param object containing geolocation data
 * */
function getPosition(position)
{
    // set the form values to the location data
    $("#latitude").val(position.coords.latitude);
    $("#longitude").val(position.coords.longitude);
    
    // temporary debug tactic: developers want ti see cooridinates!
    console.log(position.coords.latitude + ", " + position.coords.longitude);
}

/**
 * calback fuction for an successfull attempt at geoloation
 *
 * @param error code describing what went wrong
 * */
function errorCallback(error)
{
    // setup repetitive varibles
    var outputId = "#outputArea";
    var errorCode = error.code;
    
    // go through the diffrent error xonditions
    if(errorCode === error.PERMISSION_DENIED)
    {
        $(outputId).html("User declined geolocation");
    }
    else if(errorCode === error.POSITION_UNAVAILABLE)
    {
        $(outputId).html("Geolocation unavailable");
    }
    else if(errorCode === error.TIMEOUT)
    {
        $(outputId).html("Geolocation request timed out");
    }
}












