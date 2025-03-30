

virtuanlenv
pip install pipenv
pipenv shell
pip install django,pip install django-widget-tweaks, pip install crispy-forms
django-admin startproject projectname
python3 manage.py startapp appname
- update settings with the appname
- update urls for project
- update models.py + migrate 
 (python3 manage.py makemigrations,python3 manage.py migrate)
- python manage.py runserver
- create forms
- create html & css folder and files template folder (templates/appname)
- update views.py
- update urls for app
- python manage.py createsuperuser
- create population script
- pip install Pillow (image upload)
- python manage.py startapp accounts # adding account
python manage.py collectstatic # adding other static info since only static won't work in PROD

install whitenose - pipenv install white noise 
manage.py makemigration accounts