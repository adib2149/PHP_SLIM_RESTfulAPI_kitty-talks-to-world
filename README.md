# kitty-talks-to-world

This is a sample RESTful API, deployed on Heroku on the link, https://kittytalkstoworld.herokuapp.com
This was a testing on how to deploy on Heroku Platform.

There is only two end points.

(valid question about greetings)
1. /greetings 
    -- q = What's up? / How are you? / Good Morning / Hello Dude!!
    -- response: {"answer":"Hello Kitty!"}
    -- if invalid question, it doesn't know the answer
    -- response: {"answer":"I don't know what are you saying."}
    
    sample: https://kittytalkstoworld.herokuapp.com/greetings?q=hello%20dudee

(valid question about today's weather only)
2. /weather
    -- q = q=is there any rain today in dhaka? / Is there any cloud today in Istambul? 
    -- response: {"answer":"Hello Kitty!"}
    -- if invalid question, it doesn't know the answer
    -- response: {"answer":"I don't know what are you saying. [DEBUG]Not in loop[DEBUG]"}
    
    sample: https://kittytalkstoworld.herokuapp.com/weather?q=is%20there%20any%20rain%20today%20in%20dhaka?
    
For weather, we have used Open Weather API. See here: http://openweathermap.org/api
