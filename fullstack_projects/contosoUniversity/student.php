<?php
include('header.php');
?>

<html>
<div class="container">
        <main role="main" class="pb-3">
<h2>Students</h2>

<p>
    <a href="student_create.php">Create New</a>
</p>
<form method="get" action="/Student">
    <div class="form-actions no-color">
        <p>
            Find by name: <input type="text" id="SearchString" name="SearchString">
            <input type="submit" value="Search" id="SearchButton" class="btn btn-default"> |
            <a href="/Student">Back to Full List</a>
        </p>
    </div>
</form>


<table class="table">
    <thead>
        <tr>
            <th>Student ID</th>
            <th>Last Name</th>
            <th>First Name</th>
            <th>Enrollment Date</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <!----
        {% if students %}
        {% for student in students %}
             <tr> 
                <td> {{ student.id }} </td> 
                <td> {{ student.student_first_name }} </td> 
                <td> {{ student.student_last_name }} </td> 
                <td> {{ student.student_enrollment_date }} </td>  
                <td> 
                    <a href="{% url 'students_edit' pk=student.pk %}">Edit</a> | 
                    <a href="{% url 'students_detail' pk=student.pk %}">Details</a> | 
                    <a href="{% url 'students_delete' pk=student.pk %}">Delete</a> 
                </td>
            </tr> 
     </tbody>
             {% endfor %}
</table> 
</main> 
</div> 
     {% else %}
        <h2>No Student data currently in the system</h2>
     {% endif %}
     !---->
</html>

<?php
include('footer.php');
?>