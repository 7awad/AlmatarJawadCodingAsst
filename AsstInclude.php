<?php

function WriteHeaders($Heading = "Welcome", $TitleBar = "MySite")
{
    echo "
    <!doctype html>
    <html lang=\"en\">
    <head>
        <meta charset=\"UTF-8\">
        <link rel=\"stylesheet\" type=\"text/css\" href=\"AsstStyle.css\" />
        <title>$TitleBar</title>
    </head>
    <body>\n
    <h1 class=\"header-text\">$Heading</h1>
    ";
}


function DisplayLabel($prompt)
{
    echo "<div class=\"DataPair\">";
    echo "<label>$prompt</label>";
    echo "</div>";
}

function DisplayTextbox($inputType, $Name, $Size, $Value = 0, $focus = false)
{
    switch ($inputType) {
        case 'text':
        case 'date':
        case 'time':
        case 'number':
            $inputElementType = $inputType;
            break;
        default:
            $inputElementType = 'text'; 
            break;
    }
    echo "<input type=\"$inputElementType\" name=\"$Name\" size=\"$Size\" value=\"$Value\"";

    if ($focus) {
        echo " autofocus";
    }

    echo ">"; 
    echo "</div>";
}

function DisplayImage($filename, $alt, $height, $width)
{
    echo" <img src=\"./img/$filename\" alt=\"$alt\" height=\"$height\" width=\"$width\" />";

}

function DisplayButton($name, $text, $filename, $alt, $tooltip)
{
    if ($filename)
    {
        echo "<button type=\"submit\" name=\"$name\" title=\"$tooltip\">";
        DisplayImage($filename, $alt, 50, 70);
        echo "</button>";
    }
    else
        echo "<button type=\"submit\" name=\"$name\" title=\"$tooltip\">$text</button>";
}

function DisplayContactInfo()
{
    echo '<footer class="footer">';
    echo '<div class="contact-section">';
    echo '<p class="contact-text">Have Questions or Comments?</p>';
    echo '<p class="contact-text">Feel free to reach out:</p>';
    echo '<a class="contact-email" href="mailto:jawad.almatar@student.sl.on.ca">jawad.almatar@student.sl.on.ca</a>';
    echo '</div>';
    echo '</footer>';
}

function WriteFooters()
{
    echo "</body></html>";
    DisplayContactInfo();
}

function CreateConnectionObject()
{
    $fh = fopen('auth.txt', 'r');
    $Host = trim(fgets($fh));
    $UserName = trim(fgets($fh));
    $Password = trim(fgets($fh));
    $Database = trim(fgets($fh));
    $Port = trim(fgets($fh));
    fclose($fh);
    $mysqlObj = new mysqli($Host, $UserName, $Password, $Database, $Port);

    if ($mysqlObj->connect_errno != 0) {
        echo "<p>Connection failed. Unable to open database $Database. Error: "
            . $mysqlObj->connect_error . "</p>";
        exit;
    }

    return ($mysqlObj);
}

function CloseConnection(&$mysqlObj)
{
    $mysqlObj->close();
}
?>
