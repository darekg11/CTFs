# URL: http://natas18.natas.labs.overthewire.org/

# Solution:

This is some PHP application with basic session management.  
`LEVEL_18_source_code.php` contains cleaned up, reformatted source code of challenge with some comments.  
The main thing is that session is saved in `Cookies` under `PHPSESSID` name.  
According to the comment at the top:  
`$maxid = 640; // 640 should be enough for everyone` -> there should be 640 sessions in total.  
When `my_session_start` is executed, it will check if there is indeed value under `PHPSESSID` and if this is a number.
`PHPSESSID` is default identifier when creating sessions via `Cookies`:  
https://stackoverflow.com/questions/1370951/what-is-phpsessid

Next, it will call `session_start` function which according to the [docs](http://php.net/manual/en/function.session-start.php):  
`Start new or resume existing session`

To sum up:  
It will take number stored in `PHPSESSID` value in `Cookies` and will either resume or starts new session with this ID, according to comment at the top, we "know" that there are only 640 sessions in total.  
We can create a script that will increment value of `PHPSESSID` from 0 to 640 and send requests until we hit admin match (this is exactly what `LEVEL_18.py` is doing)
