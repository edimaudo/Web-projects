from app import app
from flask import render_template, flash, redirect, url_for, request, jsonify, make_response
from app import db


#key functions
def isMillionDollarIdea(weeklyRevenue, numWeeks):
    totalMoney = numWeeks * weeklyRevenue
    if totalMoney < 1000000:
        return True
    return False

@app.route('/')
@app.route('/index')
def index():
   return render_template("index.html")


#minions
@app.route('/api/minions')
def minions():
    return ""


#ideas
@app.route('/api/ideas')
def ideas():
    return ""

#meetings
@app.route("/api/meetings")
def meetings():
    return ""

#works

