MapTweet
========

This will pull tweets from a given screen name, display the embedded tweets, and make a Google map if any of them have geo-tags

General:
This project utilizes the PHP Twitter library, tmhOAuth, written by @themattharris. I used his tmhOAuthExample class and oauth_authorize_flow class because they were so well formed.

To use this, just copy the repo to your web server folder and visit the index.php.
In my case, I put the folder into /var/www/GetTweet and visited http://localhost/GetTweet

When you first start this, you have to authorize the application. You should be provided with a link which will lead you to the Twitter login page.

Once you login and click "Authorize" you will automatically be redirected to a page where you enter the screen name of a user. Enter the desired username and click the button.

You will then be directed to a page which will display the embedded tweets of that user. You can interact with them in the same way as you would on Twitter's website. If the user was using an older version of the Twitter app, you might get just the text from his or her tweets rather than the attractive embedded tweets.

At the bottom of the page, you will have two options: Restart session and Map tweets.
Restart Session will take you back to the authorization page and will allow you to choose a new user account.
Map Tweets will take you to a page which will get the Geo-tags from that user's tweets and will plot a Google map using those tweets. If the user doesn't include Geo-Tags, the default value is set to (0,0).

From the Map Tweets page, you may click "Back" on your brower to look at the embedded tweets or you may click Restart session to choose a new user.

Thanks!
