TreasureChest
===========

Idea by b17hata, Inspired by Falkirk's "ChestRefill"

Define chests which auto-refill according to the config.

Define "chestmodes" in treasture.yml with an Item, MaxAmount and Probability for each of the 27 slots, and TreasureChest will refill according to that chestmode every x seconds, defined in config.txt


/tc list : list all configured treasure chestmodes

/tc common : start using the 'common' setting

/tc {chestmode} and start tapping chests...

/tc off to stop making Treasure Chests

Define the refill rate in seconds in the config.txt file

Install the .phar file, restart, then define your own "chestmodes" in treasure.yml (three are predefined to get you started: common, uncommon and rare), restart again and you are ready to go.

Tap chests to enable automatic refill according to the chosen chestmode. The format for each chestmode slot must be ID:AMOUNT:PROBABILITY, for example:

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

RandomizeAmount Setting:

In prefs.yml you can define whether the AMOUNT of an item (the second number) is a fixed amount to be added to chests, or a random number between 1 and the amount.

In the last chestmode example, /tc diamond would make treasure chests that have a 5% chance of containing a random number of diamonds between 1 and 64, unless RandomizeAmount was set to false... in which case there would be a 5% chance that 'diamond' treasure chests would be refilled with (always) 64 Diamonds.

You can define up to 27 slots for each chestmode