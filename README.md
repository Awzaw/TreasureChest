TreasureChest
===========

Idea by b17hata

Inspired Falkirk's "ChestRefill"

Define chests which auto-refill according to the config.

Define "chestmodes" with an Item, Amount and Probability for each of the 27 slots, and TreasureChest will refill according to that chestmode every x seconds, defined in config.txt


/tc list : list all configured treasure chestmodes

/tc common : start using the 'common' setting


Run /tc {chestmode} and tap a chest

Define the refill rate in seconds in the config.txt file

Install the .phar file, restart, then define your own "chestmodes" in treasure.yml (three are predefined to get you started: common, uncommon and rare), restart again and you are ready to go.

Type /tc list to list all possible chestmodes, or type /tc common to select the 'common' chestmode.

Tap chests to enable automatic refill according to the config in treasure.yml for the chosen chestmode. The format for each chestmode slot must be ID:AMOUNT:PROBABILITY, for example:

```
---
common:
 - "104:1:20"
 - "5:20:70"
 - "100:1:80"
uncommon:
 - "104:1:50"
 - "5:20:30"
 - "100:1:40"
rare:
 - "64:64:1"
 - "276:20:10"
 - "264:1:10"
 - "19:1:10"
 - "25:20:10"
 - "43:1:5"
...
```

You can define up to 27 slots for each chestmode