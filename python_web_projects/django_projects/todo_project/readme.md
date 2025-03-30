### Todo App
***


## Summary
The idea of the app that a user can register/login to the App and is able to create new notes and to update/delete previous ToDos. ToDos themselves are simple entity which has a title, description and timestamps.


## Application setup

### Frontend
The screens will be: welcome screen (for guest users), login, register, ToDos list, create new ToDo, view/ update, delete ToDo
Once the user is logged in, they should stay logged in (even if the page is refreshed) 

Register screen :
only accessible to guest users (not logged in)
only 2 fields are required - namely email and password

Login screen :
only accessible to guest users
2 fields - email and password
if credentials are wrong the user should be notified
if credentials are correct the user should be logged in and redirected to '/' (which is now the list of my ToDos screen)

ToDo list :
only accessible for logged in users
the user should see a list of their previously created ToDos
the user should be able to go to the "Create new ToDo" screen from this one
the user should be able to go to the "View, update ToDo" screen by selecting one of the ToDos from the list
the user should be able to delete a particular ToDo from the list

- ToDos should be searchable by title
- Pagination 10 per screen

Create ToDo screen :
only accessible for logged in users
2 fields: title and description of the ToDo
upon successfully creating the ToDo the user should be redirected to the "ToDo list" screen

View/update ToDo screen :
only accessible for logged in users
2 fields: title and description of the ToDo, and these fields should be pre filled with data from the server about this particular ToDo
upon successfully updating the ToDo the user should be redirected to the "ToDo list" screen

### Backend
Register route :
required email and password
route should create a user that is not verified in the database

Login route :
check if email and password are correct and that the user is verified, otherwise reject
if user is verified and email/password are correct

ToDo list route :
only accessible for logged in users
send out a paginated list of ToDos (up to 10 items per page)

Create ToDo route :
only accessible for logged in users
2 fields required: title and description of the ToDo
on success save the item to the database

View/Update ToDo route :
only accessible for logged in users
respond with an object containing the title and description of the requested ToDo
only accessible for logged in users
on success save updated item to the database

Delete ToDo route :
only accessible for logged in users
on success delete the item from the database