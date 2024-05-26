# finder
1. Download the project to include in your localhost server xampp or wamp or any of your prefered choice, if you are using xampp and start your server

2. Linux system using XAMPP Navigate to the project directory on your system terminal or commad prompt i.e cd to the project path /opt/lampp/htdocs/finder
if you are using windows /xampp/htdocs/finder

4. Include the OpenAI api key in the env file inside the project root folder
i.e OPENAI_API_KEY = ,then put the key value in front equal sign

3. Go ahead to use "php artisan serve"  command to start your application

and the application url will be open for testing i.e  http://127.0.0.1:8000

4. Install postman applicaion on your system and signup.

5. Go ahead login and create a collection and in side your collection create a post request using url http://127.0.0.1:8000/api/get-response, but before testing make sure you add the api key to the header by click on the header and then add Bearer in as the key and value as the api key to access the api response

6. Go to the body beside same header you click on to either send the input request as a form input or raw as json format and it will display a json response.

7. lastly you can as well save your collection for the api documentation request if you wish.
