#Basics
REMOVE < > around app ID and username etc for API calls!!

# Setup for Evi

You need to go to developer.evi.com and sign up for an account there. Even if you sign up with a regular account, you need to make sure you have a developer account as well.

Also you may need to confirm your email address prior to this working.

You now need to add the domain where you will be hosting the index.php file. Add this at the bottom of https://developer.evi.com/api-details#domain-keys

Open index.php and edit line 4. Replace the username holder with your DEVELOPER username. Usually api_YOUR-USERNAME. The password will be the one automatically generated that you get via email.

You can test if your permissions are working properly by doing a direct query. Put this in your browser (note, replace the username and password)

http://api.trueknowledge.com/direct_answer/?question=List+of+James+Bond+actors&api_account_id=[USERNAME-GOES-HERE]&api_password=[PASSWORD-HERE]

For trouble shooting, add a stylesheet to make the iframe have a width and a height.

# Wolfram 

Sign up for a wolfram dev account

https://developer.wolframalpha.com/

Create a new App ID

Paste the App ID in line 3

# To Do
Add favicon
add launch facebook page
--add typing alternative input--
add display output
add tutorial