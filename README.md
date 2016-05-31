TreasureChest
===========

Idea by b17hata
Inspired by Falkirk's "ChestRefill"

Define chests which auto-refill according to the config.

Define "chestmodes" with an Item, Amount and Probability for each of the 27 slots, and TreasureChest will refill according to that chestmode every x seconds, defined in config.txt


/tc list : list all configured treasure chestmodes
/tc common : start using the 'common' setting
/tc {chestmode} and tap a chest

Define the refill rate in seconds in the config.txt file

Install the .phar file, restart, then define your own "chestmodes" in treasure.yml (three are predefined to get you started: common, uncommon and rare), restart again and you are ready to go.

Tap chests to enable automatic refill according to the config in treasure.yml for the chosen chestmode. The format for each chestmode slot must be ID:AMOUNT:PROBABILITY, for example:

```
---
common:
 - "17:64:100"
 - "5:20:80"
 - "100:1:80"
 - "2:64:80"
 - "5:20:90"
 - "100:1:80"
uncommon:
 - "104:1:50"
 - "5:20:30"
 - "100:1:40"
rare:
 - "64:64:1"
 - "276:1:10"
 - "264:1:10"
 - "19:1:10"
 - "25:20:10"
 - "43:1:5"
diamond:
 - "264:64:5"
...
```

You can define up to 27 slots for each chestmode