To run this project locally, you will require Python3, Flask and its dependecies.
(Here's a link you may find useful: https://flask.palletsprojects.com/en/stable/installation/)

Clone the project : git clone https://github.com/My-Home-Portfolio-Project/MyHome_V2.git
cd MyHome_V2

To start the app, run:
flask --app myHome run --debug

To initialize the database, run: 
flask --app myHome init-db (PS; I have not shared the ./instance folder that stores the app.sqlite configs)

So, Here are the problems that I haven't fixed yet:
1. Routing: clicking on the either the login/signup buttons is yielding a 404.
I have found a way around, a manual way, localhost/register.html is producing a 404, localhost/auth/register is working just fine.
The same case applies to login button.
3. The dashboard, I haven't managed to write the code for it(noticed it's file is missing) but the routing is already written.
4. Haven't tested whether the app works, as it should.
