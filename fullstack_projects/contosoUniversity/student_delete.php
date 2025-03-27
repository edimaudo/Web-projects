<?php
include('header.php');
?>

<div class="container">
        <main role="main" class="pb-3">
            

<h1>Delete Student</h1>
<p class="text-danger"></p>
<h3>Are you sure you want to delete this?</h3>
<div>
    
    <hr>
    <dl class="row">
        <dt class="col-sm-2">
            Last Name
        </dt>
        <dd class="col-sm-10">
            {{student.student_last_name}}
        </dd>
        <dt class="col-sm-2">
            First Name
        </dt>
        <dd class="col-sm-10">
            {{student.student_first_name}}
        </dd>
        <dt class="col-sm-2">
            Enrollment Date
        </dt>
        <dd class="col-sm-10">
            {{student.student_enrollment_date}}
        </dd>
    </dl>
    
    <form action="" method="post">
        {% csrf_token %}
        <input type="hidden" data-val="true" data-val-required="The ID field is required." id="ID" name="ID" value="{{student.id}}">
        <input type="submit" value="Delete" class="btn btn-danger"> |
        <a href="{% url 'students' %}">Back to List</a>
   </form>
</div>

        </main>
    </div>

<?php
include('footer.php');
?>