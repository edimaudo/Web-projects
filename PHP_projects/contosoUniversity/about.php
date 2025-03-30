<?php
include('header.php');
?>

<html>
<div class="container">
        <main role="main" class="pb-3">
<h2>Student Body Statistics</h2>
<table class="table">
    <thead>
        <tr>
            <th>Enrollment Date</th>
            <th>Student enrollment Count</th>
        </tr>
    </thead>
    <tbody>
        <!---
        {% if students %}
            {% for student in students %}
             <tr> 
                <td> {{ student.student_enrollment_date }} </td> 
                <td>{{ student.count }}</td>
                
            </tr>
        !--->
    </tbody>
    <!---
        {% endfor %}
    !--->
</table>

</main>
</div>
<!---
     {% else %}
        <h2>No Calculations in system </h2>
     {% endif %}
{% endblock %}
!--->
</html>

<?php
include('footer.php');
?>