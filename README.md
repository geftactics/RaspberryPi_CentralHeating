# Raspberry Pi Central Heating

Simple but effective central heating control for the Raspberry Pi. 



I put this together for my own use, as my heating is rubbish and doesn't have a thermostat or boost function. I didn't have any temperature sensors when I created this, so the system connects regularly to a BBC weather feed (add the URL ID to config.php) to try and get an idea of the temperature in the local area - Works well for me, you might find this concept odd, so can easily modify 'functions.php' to obtain a temperature from wherever! Also can be accessed via smartphone, great if you want to enable a boost on your way home at an unusual time!


We run manager.php every minute or so via a cron job to work out if we should change anything to do with the heating.
You can boost the heating for a certain amount of time (Default 1hr). We define what times heating should come on via the website grid, and set an activation temperature. If it's colder than this temperature and inside a scheduled 'on-time', then a GPIO pin will be turned on (default pin is 4). I then use a cheap relay board to safely act as a switch across  my boilers thermostat input terminals (You might have to get creative with your boiler here - But be careful! (See disclaimer #2).

The web interface:
![Alt text](https://cloud.githubusercontent.com/assets/14201513/12079303/b0451af8-b22b-11e5-952a-d80e6e92f5fd.png "Central heating web admin")

From iPhone:

![Alt text](https://cloud.githubusercontent.com/assets/14201513/12079302/b0426b46-b22b-11e5-9f74-06d7ce5c1acf.png "Central heating smartphone ios admin")



Disclaimers:

 1) I'm not really a coder, so there may be odd, messy, stupid stuff here. It seems to work though! :)
 
 2) Implementing this involves messing with potential high voltage. Make sure you know what you're doing! Don't get dead!



