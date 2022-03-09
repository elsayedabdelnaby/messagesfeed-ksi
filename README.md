# Messages Feed
We Read get Messages From Json File and Make Processing on them to display every message on the map
dependent on the location mentioned on the message

## Requirements
- [PHP >= 7.4](http://php.net/)

## Setps to install the projects

- clone the project https://github.com/elsayedabdelnaby/messagesfeed-ksi into C:\xampp\htdocs in windows or /var/www/html/ in linux
- move to the repository folder
- run composer install command
```bash
$ composer install
```
- now you can run the project by visit http://localhost/messagesfeed-ksi

- the project fetch the data from the data-feed.json file, 
- if you want to add more messages you can add them in this file or you can open get_locations.php file and pass another url to fetch function which exist at line 39
- after fetch messages, make processing on them to remove special characters and words
- then make process to dedicate the location name which exist on the message and return all locations with lat and lng which exist in every message
- display the messages on the map dependent on the lat and lng of the locations mentioned on them

