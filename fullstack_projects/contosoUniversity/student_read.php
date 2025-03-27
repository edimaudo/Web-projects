<?php
include('header.php');
?>

<div class="container">
        <main role="main" class="pb-3">
<h1>Student Details</h1>

<div>
    <hr>
    <dl class="row">
        <dt class="col-sm-2">
            Last Name
        </dt>
        <dd class="col-sm-10">
            {{student.student_last_name }}
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
            {{student.student.enrollment_date}}
        </dd>
        
            </tbody></table>
        </dd>
    </dl>
</div>
<div>
    <a href="{% url 'students_edit' pk=student.pk %}">Edit</a> |
    <a href="{% url 'students' %}">Back to List</a>
</div>

        </main>
    </div>

<?php
include('footer.php');
?>