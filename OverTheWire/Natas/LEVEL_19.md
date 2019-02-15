# URL: http://natas19.natas.labs.overthewire.org/

# Solution:

# Notes so far:

1. well, don't know if this is really random but if it would be why always end it with d777777
2. Maybe it is shifting bits or doing some ROL / LOL hmmm
3. Tried subtracting, adding, division, mulitpling, ROL, LOL, bit shifting on numbers but nothing comes up
4. Not going to lie - had to google a hint on how to approach this - the numbers are actually HEX representation of characters:
   35 37 38 2d 77 77 77 -> 578-www  
   33 36 38 2d 77 77 77 -> 368-www  
   32 2d 77 77 77 -> 2-www  
   33 33 2d 77 77 77 -> 33-wwww  
   31 36 33 2d 77 77 77 -> 163-www  
   31 33 31 2d 77 77 77 -> 131-www

   The actual part `-www` is `-username`

Seems that `-username` part is always there and there are 1-3 digits before `-username` part  
So let's send all combinations starting with `0-admin` up to `999-admin`  
Bingo  
Would now solve this without hints from [here](http://floatingbytes.blogspot.com/2014/10/wargames-natas-19.html)
