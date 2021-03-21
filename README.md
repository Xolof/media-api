# Backend for media-widget

A script getting data from the 
[Instagram Basic Display API](https://developers.facebook.com/docs/instagram-basic-display-api/)
 through cURL,
sending response as JSON.


## Linting

`php -l FILENAME`


## Config

Put your token in the file "../config/long-lived-token.txt".

Put allowed origin in the file "../config/allowed-origin.txt".


## Run in development

From the same directory as index.php, run `php -S localhost:8000`.


## Run in production

Put `index.php` in the Apache web root.
