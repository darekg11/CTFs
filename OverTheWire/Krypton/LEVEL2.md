# URL: https://overthewire.org/wargames/krypton/krypton2.html

# Connection:  
`ssh krypton2@krypton.labs.overthewire.org -p 2222`
`password`: `ROTTEN`

# Solution:  
1. Follow instructions in `README` to create your own directory in `tmp`
2. Create new file `lowercase.txt` containing `abcdefghijklmnopqrstuvwxyz` run: `/krypton/krypton2/encrypt lowercase.txt`
3. Boom, you have every character combination
4. `OMQEMDUEQMEK` - encrypted string with usage of Cesar Cipher
5. Using values from `ciphertext` we can see the mapping:
    ```
    abcdefghijklmnopqrstuvwxyz becomes:  
    MNOPQRSTUVWXYZABCDEFGHIJKL
    ```
6. Use this to reverse: `OMQEMDUEQMEK`
7. We get `CAESARISEASY`
