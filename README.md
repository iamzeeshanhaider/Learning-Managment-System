## Learning Management System

#### Setup Guide
- Clone this repository
- cp .env.example .env (to create an env file, afterwards update necessary credentials)
- run composer install
- run migration and seeder (if necessary)
- in the .env file queue_connection should be set to database
- run queue listener
  - php artisan queue:work (for default queues)
  - To listen for event notification run php artisan queue:work --queue=event_notifications
- If you are unable to use this method please set queue_connection to sync

##### Scrips (CSS, SCSS & JS)
- npm **install**
- for local development 
  - npm run dev or npm run development
  - npm run watch (to watch and compile scss changes if necessary)
- for production
  - npm run prod or npm run production


###### Broadcasting
- set pusher credentials in .env file

##### Addon
- see changelog.md for list of packages and default user credentials


