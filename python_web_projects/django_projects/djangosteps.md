

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

