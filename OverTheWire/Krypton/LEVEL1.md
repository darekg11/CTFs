# URL: https://overthewire.org/wargames/krypton/krypton1.html

# Connection:  
`ssh krypton1@krypton.labs.overthewire.org -p 2222`
`password`: `KRYPTONISGREAT`

# Solution:
`cd /krypton/krypton1`  
Read `README`  
It indicates that password for `krypton2` is encoded in file `krypton2` and that it is using ROT13

## How ROT13 works:  
Each letter is replaced with 13th letter after it.  
So A = N

## Actual Solution
`krypton2` holds following text: `YRIRY GJB CNFFJBEQ EBGGRA`
So after -13 every letter we get:
`Y` - `L`
`R` - `E`
`I` - `V`
`R` - `E`
`Y` - `L`

`G` - `T`
`J` - `W`
`B` - `O`

`C` - `P`
`N` - `A`
`F` - `S`
`F` - `S`
`J` - `W`
`B` - `O`
`E` - `R`
`Q` - `D`

`E` - `R`
`B` - `O`
`G` - `T`
`G` - `T`
`R` - `E`
`A` - `N`

So password is `ROTTEN`