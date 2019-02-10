# URL: http://natas16.natas.labs.overthewire.org/

# Solution:

`passthru("grep -i \"$key\" dictionary.txt");`  
The problem is that, that this time `key` is placed inside esacped `"` and `"` is being marked as invalid character.

So, then we will pass `inner` grep that will try to find matching characters in password by checking out the output of the `outer` grep.
Our payload for picking up characters to use during brute force is as follows:
`\$(grep {character} /etc/natas_webpass/natas17)rafters`

`rafters` has single occurence in dictionary, how this is going to work:
This will return `rafters` in response when given character has not beed found in password, that is because
`inner` grep won't append character to `rafters` word so outer grep will be able to correctly find it in dictionary
But if for example character `b` exist in password then it will be added to `rafters` making it `brafters` -> and this does not exist in dictionary so we have a match
