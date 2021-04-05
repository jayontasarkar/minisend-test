# MINISEND TEST
## A simple api, client and seeder for sending transactional email using Laravel, VueJS and PHP.

### Description of folder structure
* minisend-api - backend api for minisend api
* minisend-client - frontend vuejs application for minisend api includes authentication and api key for sending emails
* test - composer install & run index.php file to seed email data with attachment. Don't forget to generate a api key before seeding

### Setup and testing process
```
* setup database in minisend-api env file
* run composer install
* run php artisan horizon
* run npm install in minisend-client & setup env file
* run npm run serve
* register a new user and login to your account
* Go to API Tokens tab & create a new token. This token will require while sending transactional email from any endpoint.
* Copy this token and paste in index.php (x-api-key) file of test folder
* run composer install in test folder and seed email data
* Now have a look at terminal where horizon in running
* when job is completed then go to Activity tab of minisend web/client.
* Here we can search filer activity of an account. Activities can be filtered by sender/recipient/subject or even tags.
* Click on email subject to see the email
* Click on recipient to see all emails of a recipient.
```