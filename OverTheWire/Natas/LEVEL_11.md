# URL: http://natas11.natas.labs.overthewire.org/

# Solution:

`plaintext XOR cyphertext = key`

```
<?php

// `plaintext XOR cyphertext = key`
function get_key() {
    $cookie = "ClVLIh4ASCsCBE8lAxMacFMZV2hdVVotEhhUJQNVAmhSEV4sFxFeaAw=";
    $plaintext = json_encode(array( "showpassword"=>"no", "bgcolor"=>"#ffffff"));
    $key = base64_decode($cookie);
    $outText = '';

    // Iterate through each character
    for($i=0;$i<strlen($plaintext);$i++) {
    $outText .= $plaintext[$i] ^ $key[$i % strlen($key)];
    }

    return $outText;

}

function encrypt($in, $key) {
    $text = $in;
    $outText = '';

    // Iterate through each character
    for($i=0;$i<strlen($text);$i++) {
    $outText .= $text[$i] ^ $key[$i % strlen($key)];
    }

    return $outText;

}

$key = get_key();
# actual key is a little bit shorter so add repeating characters
$key .= "w8Jqw8Jqw8Jqw8J";
$test_input = json_encode(array( "showpassword"=>"no", "bgcolor"=>"#ffffff"));
# using the retrieved key on the same input data should generate the same cookie value
echo base64_encode(encrypt($test_input, $key));

$actual_input = json_encode(array( "showpassword"=>"yes", "bgcolor"=>"#ffffff"));
# cookie to use:
echo base64_encode(encrypt($actual_input, $key));

```
