<?php
include('header.php');
?>

<div class="container">
        <main role="main" class="pb-3">
            
<h1>Delete Course</h1>
<p class="text-danger"></p>
<h3>Are you sure you want to delete this?</h3>
<div>
    
    <hr>
    <dl class="row">
        <dt class="col-sm-2">
            Course Title
        </dt>
        <dd class="col-sm-10">
            {{course.course_title}}
        </dd>
        <dt class="col-sm-2">
            Department
        </dt>
        <dd class="col-sm-10">
            {{course.course_department_name }}
        </dd>
    </dl>
    
    <form action="" method="post">
        {% csrf_token %}
        <input type="hidden" data-val="true" data-val-required="The ID field is required." id="ID" name="ID" value="{url 'courses_detail' pk=course.pk %}">
        <input type="submit" value="Delete" class="btn btn-danger"> |
        <a href="{% url 'courses' %}">Back to List</a>
   </form>
</div>

        </main>
    </div>

<?php
include('footer.php');
?>